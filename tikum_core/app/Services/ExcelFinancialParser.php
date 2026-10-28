<?php

namespace App\Services;

use Exception;
use ZipArchive;

class ExcelFinancialParser
{
    /**
     * Parse file Excel (.xlsx) atau CSV (.csv) untuk mendeteksi pemasukan dan pengeluaran secara otomatis.
     *
     * @param  string  $filePath  Path fisik berkas
     * @param  string|null  $extension  Ekstensi berkas ('xlsx', 'csv', dsb)
     * @return array [
     *               'success' => bool,
     *               'pendapatan' => float,
     *               'hpp' => float,
     *               'beban_operasional' => float,
     *               'beban_lain' => float,
     *               'total_beban' => float,
     *               'detected_items' => int,
     *               'message' => string
     *               ]
     */
    public static function parse(string $filePath, ?string $extension = null): array
    {
        if (! file_exists($filePath)) {
            return [
                'success' => false,
                'pendapatan' => 0,
                'hpp' => 0,
                'beban_operasional' => 0,
                'beban_lain' => 0,
                'total_beban' => 0,
                'detected_items' => 0,
                'message' => 'Berkas tidak ditemukan.',
            ];
        }

        $ext = strtolower($extension ?: pathinfo($filePath, PATHINFO_EXTENSION));

        try {
            $rows = [];
            if ($ext === 'csv') {
                $rows = self::readCsv($filePath);
            } elseif (in_array($ext, ['xlsx', 'xlsm'])) {
                $rows = self::readXlsx($filePath);
            }

            if (empty($rows)) {
                return [
                    'success' => false,
                    'pendapatan' => 0,
                    'hpp' => 0,
                    'beban_operasional' => 0,
                    'beban_lain' => 0,
                    'total_beban' => 0,
                    'detected_items' => 0,
                    'message' => 'Tidak ada data tabel yang terbaca di berkas spreadsheet.',
                ];
            }

            return self::analyzeFinancialRows($rows);
        } catch (Exception $e) {
            return [
                'success' => false,
                'pendapatan' => 0,
                'hpp' => 0,
                'beban_operasional' => 0,
                'beban_lain' => 0,
                'total_beban' => 0,
                'detected_items' => 0,
                'message' => 'Gagal membaca isi berkas Excel: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Membaca berkas CSV
     */
    private static function readCsv(string $filePath): array
    {
        $rows = [];
        $handle = fopen($filePath, 'r');
        if (! $handle) {
            return $rows;
        }

        // Deteksi delimiter: koma, titik koma, atau tab
        $firstLine = fgets($handle);
        rewind($handle);
        $delimiter = ',';
        if (substr_count($firstLine, ';') > substr_count($firstLine, ',')) {
            $delimiter = ';';
        } elseif (substr_count($firstLine, "\t") > substr_count($firstLine, ',')) {
            $delimiter = "\t";
        }

        while (($data = fgetcsv($handle, 2048, $delimiter)) !== false) {
            // Trim values
            $cleanRow = array_map(function ($val) {
                return trim((string) $val);
            }, $data);

            // Lewati baris kosong
            if (count(array_filter($cleanRow)) > 0) {
                $rows[] = array_values($cleanRow);
            }
        }

        fclose($handle);

        return $rows;
    }

    /**
     * Membaca berkas .xlsx menggunakan native ZipArchive & SimpleXML
     */
    private static function readXlsx(string $filePath): array
    {
        $rows = [];
        $zip = new ZipArchive;
        if ($zip->open($filePath) !== true) {
            return $rows;
        }

        // 1. Baca sharedStrings.xml jika ada
        $sharedStrings = [];
        $stringsXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($stringsXml) {
            $xml = simplexml_load_string($stringsXml);
            if ($xml && isset($xml->si)) {
                foreach ($xml->si as $si) {
                    if (isset($si->t)) {
                        $sharedStrings[] = (string) $si->t;
                    } elseif (isset($si->r)) {
                        $text = '';
                        foreach ($si->r as $r) {
                            $text .= (string) $r->t;
                        }
                        $sharedStrings[] = $text;
                    } else {
                        $sharedStrings[] = '';
                    }
                }
            }
        }

        // 2. Baca worksheet pertama (sheet1.xml)
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        if (! $sheetXml) {
            // Fallback coba worksheet lain
            for ($i = 1; $i <= 5; $i++) {
                $candidate = $zip->getFromName("xl/worksheets/sheet{$i}.xml");
                if ($candidate) {
                    $sheetXml = $candidate;
                    break;
                }
            }
        }

        $zip->close();

        if (! $sheetXml) {
            return $rows;
        }

        $sheet = simplexml_load_string($sheetXml);
        if (! $sheet || ! isset($sheet->sheetData->row)) {
            return $rows;
        }

        foreach ($sheet->sheetData->row as $r) {
            $rowCells = [];
            $maxColIdx = 0;

            foreach ($r->c as $c) {
                $cellRef = (string) $c['r']; // Misal 'A1', 'B2'
                preg_match('/([A-Z]+)(\d+)/', $cellRef, $matches);
                $colLetter = $matches[1] ?? 'A';
                $colIdx = self::letterToColumnIndex($colLetter);
                $maxColIdx = max($maxColIdx, $colIdx);

                $cellType = (string) $c['t'];
                $val = isset($c->v) ? (string) $c->v : '';

                if ($cellType === 's' && isset($sharedStrings[(int) $val])) {
                    $val = $sharedStrings[(int) $val];
                }

                $rowCells[$colIdx] = trim((string) $val);
            }

            // Normalisasi baris menjadi array berurutan
            if (! empty($rowCells)) {
                $normalizedRow = [];
                for ($i = 0; $i <= $maxColIdx; $i++) {
                    $normalizedRow[$i] = $rowCells[$i] ?? '';
                }
                if (count(array_filter($normalizedRow)) > 0) {
                    $rows[] = $normalizedRow;
                }
            }
        }

        return $rows;
    }

    /**
     * Konversi huruf kolom Excel (A, B, C, ... AA) ke index numerik 0, 1, 2...
     */
    private static function letterToColumnIndex(string $letter): int
    {
        $index = 0;
        $len = strlen($letter);
        for ($i = 0; $i < $len; $i++) {
            $index = $index * 26 + (ord($letter[$i]) - 64);
        }

        return max(0, $index - 1);
    }

    /**
     * Menganalisis baris-baris data untuk menemukan nominal Pemasukan & Pengeluaran
     */
    private static function analyzeFinancialRows(array $rows): array
    {
        $pendapatan = 0.0;
        $hpp = 0.0;
        $bebanOperasional = 0.0;
        $bebanLain = 0.0;
        $detectedCount = 0;

        // METODE 1: Cek apakah ada format Summary Baris Per Baris (TOTAL, GRAND TOTAL, SUBTOTAL, TOTAL PENJUALAN, dsb.)
        $grandTotal = 0.0;
        $totalFound = 0.0;
        $subtotal = 0.0;

        foreach ($rows as $row) {
            $textCombined = '';
            $numbers = [];
            foreach ($row as $cell) {
                $str = trim((string) $cell);
                $num = self::extractNumber($str);
                if ($num > 0) {
                    $numbers[] = $num;
                } elseif (preg_match('/[a-zA-Z]/', $str)) {
                    $textCombined .= ' '.strtolower($str);
                }
            }
            $textCombined = trim($textCombined);

            if (! empty($numbers)) {
                $lastNumber = end($numbers); // Di baris summary seperti [TOTAL, "", "", 329300], angka terakhir adalah totalnya

                if (self::containsAny($textCombined, ['grand total', 'total tagihan', 'sisa tagihan', 'total bayar', 'total penjualan', 'total omzet', 'total pendapatan', 'total pemasukan', 'jumlah total'])) {
                    $grandTotal = $lastNumber;
                } elseif (preg_match('/\b(total)\b/i', $textCombined) && ! self::containsAny($textCombined, ['pengeluaran', 'beban', 'biaya'])) {
                    $totalFound = $lastNumber;
                } elseif (self::containsAny($textCombined, ['subtotal', 'sub total'])) {
                    $subtotal = $lastNumber;
                } elseif (self::containsAny($textCombined, ['total hpp', 'harga pokok', 'bahan baku', 'hpp'])) {
                    $hpp = $lastNumber;
                } elseif (self::containsAny($textCombined, ['biaya operasional', 'beban operasional', 'total pengeluaran', 'total beban', 'total biaya', 'total operasional', 'jumlah pengeluaran', 'jumlah beban'])) {
                    $bebanOperasional = $lastNumber;
                }
            }
        }

        if ($grandTotal > 0) {
            $pendapatan = $grandTotal;
            $detectedCount++;
        } elseif ($totalFound > 0) {
            $pendapatan = $totalFound;
            $detectedCount++;
        } elseif ($subtotal > 0) {
            $pendapatan = $subtotal;
            $detectedCount++;
        }

        // METODE 2: Cek apakah format Kolom Tabel (Header: No | Nama Barang | Qty | Harga | Jumlah / Pemasukan / Pengeluaran)
        $ignoreColHeaders = ['no', 'no.', 'nomor', 'kode', 'id', 'item', 'nama barang', 'nama jasa', 'barang', 'deskripsi', 'qty', 'kuantitas', 'satuan', 'unit', 'harga satuan', 'diskon', 'diskon (%)', 'tanggal', 'tgl', 'keterangan'];

        $colIncome = null;
        $colExpense = null;
        $colHpp = null;
        $headerRowIdx = null;

        // Cari baris header (hanya periksa baris yang memiliki minimal 3 kolom terisi agar tidak tertipu judul banner "NOTA PENJUALAN")
        for ($r = 0; $r < min(15, count($rows)); $r++) {
            $row = $rows[$r];
            $nonEmptyCount = 0;
            foreach ($row as $cell) {
                if (trim((string) $cell) !== '') {
                    $nonEmptyCount++;
                }
            }
            if ($nonEmptyCount < 3) {
                continue;
            }

            foreach ($row as $cIdx => $cell) {
                $txt = trim(strtolower((string) $cell));
                if ($txt === '') {
                    continue;
                }

                // Abaikan kolom non-nominal seperti No, Qty, Satuan, Diskon
                if (in_array($txt, $ignoreColHeaders) || preg_match('/^(no|nomor|kode|qty|satuan|diskon)\b/', $txt)) {
                    continue;
                }

                if ($colIncome === null && self::containsAny($txt, ['jumlah (rp)', 'jumlah rp', 'total (rp)', 'total rp', 'subtotal', 'total harga', 'harga total', 'pemasukan', 'pendapatan', 'omzet', 'penjualan', 'kredit', 'masuk', 'nominal'])) {
                    $colIncome = $cIdx;
                    $headerRowIdx = $r;
                }
                if ($colExpense === null && self::containsAny($txt, ['pengeluaran', 'beban', 'biaya', 'operasional', 'debit', 'keluar', 'belanja', 'pembelian'])) {
                    $colExpense = $cIdx;
                    $headerRowIdx = $r;
                }
                if ($colHpp === null && self::containsAny($txt, ['hpp', 'harga pokok', 'bahan baku', 'modal', 'kulakan'])) {
                    $colHpp = $cIdx;
                    $headerRowIdx = $r;
                }
            }

            if ($colIncome !== null || $colExpense !== null) {
                break;
            }
        }

        // Jika kolom ditemukan, jumlahkan item baris di bawah header
        if ($colIncome !== null || $colExpense !== null || $colHpp !== null) {
            $startRow = ($headerRowIdx !== null) ? $headerRowIdx + 1 : 0;
            $itemPendapatan = 0.0;
            $itemHpp = 0.0;
            $itemExpense = 0.0;

            for ($i = $startRow; $i < count($rows); $i++) {
                $row = $rows[$i];

                // Abaikan baris total bawaan spreadsheet agar tidak dihitung ganda
                $rowText = strtolower(implode(' ', $row));
                if (self::containsAny($rowText, ['total', 'subtotal', 'grand total', 'sisa', 'catatan', 'penerima', 'hormat', 'petunjuk'])) {
                    continue;
                }

                if ($colIncome !== null && isset($row[$colIncome])) {
                    $val = self::extractNumber($row[$colIncome]);
                    if ($val > 0) {
                        $itemPendapatan += $val;
                        $detectedCount++;
                    }
                }

                if ($colHpp !== null && isset($row[$colHpp])) {
                    $val = self::extractNumber($row[$colHpp]);
                    if ($val > 0) {
                        $itemHpp += $val;
                    }
                }

                if ($colExpense !== null && isset($row[$colExpense])) {
                    $val = self::extractNumber($row[$colExpense]);
                    if ($val > 0) {
                        $itemExpense += $val;
                        $detectedCount++;
                    }
                }
            }

            if ($pendapatan === 0.0 && $itemPendapatan > 0) {
                $pendapatan = $itemPendapatan;
            }
            if ($hpp === 0.0 && $itemHpp > 0) {
                $hpp = $itemHpp;
            }
            if ($bebanOperasional === 0.0 && $itemExpense > 0) {
                $bebanOperasional = $itemExpense;
            }
        }

        // METODE 3: Jika belum menemukan kolom bernama spesifik, ambil semua angka positif terbesar sebagai omzet
        if ($pendapatan == 0 && empty($summaryFound)) {
            $allNumbers = [];
            foreach ($rows as $row) {
                foreach ($row as $cell) {
                    $num = self::extractNumber($cell);
                    if ($num > 1000) { // Abaikan nomor urut kecil atau tanggal
                        $allNumbers[] = $num;
                    }
                }
            }

            if (! empty($allNumbers)) {
                // Ambil nilai terbesar sebagai estimasi omzet jika ada
                rsort($allNumbers);
                $pendapatan = $allNumbers[0];
                if (isset($allNumbers[1])) {
                    $bebanOperasional = $allNumbers[1];
                }
                $detectedCount = count($allNumbers);
            }
        }

        $totalBeban = $hpp + $bebanOperasional + $bebanLain;

        return [
            'success' => ($pendapatan > 0 || $totalBeban > 0),
            'pendapatan' => $pendapatan,
            'hpp' => $hpp,
            'beban_operasional' => $bebanOperasional,
            'beban_lain' => $bebanLain,
            'total_beban' => $totalBeban,
            'detected_items' => $detectedCount,
            'message' => ($pendapatan > 0 || $totalBeban > 0)
                ? 'Berhasil mendeteksi Pemasukan Rp '.number_format($pendapatan, 0, ',', '.').' dan Pengeluaran Rp '.number_format($totalBeban, 0, ',', '.')
                : 'Tidak dapat menemukan angka pemasukan atau pengeluaran yang jelas di dalam berkas Excel.',
        ];
    }

    /**
     * Bersihkan teks mata uang dan format angka ke tipe float
     * Contoh: "Rp 15.000.000", "15,000,000", "15000000.00", "Rp 15.000.000,00"
     */
    public static function extractNumber($raw): float
    {
        if (is_numeric($raw)) {
            return (float) $raw;
        }

        if (empty($raw) || ! is_string($raw)) {
            return 0.0;
        }

        $str = trim($raw);

        // Hapus simbol mata uang dan spasi
        $str = preg_replace('/[^\d,\.\-]/', '', $str);
        if ($str === '' || $str === '-') {
            return 0.0;
        }

        // Tangani format Indonesia "15.000.000,00" -> titik adalah ribuan, koma adalah desimal
        if (str_contains($str, '.') && str_contains($str, ',')) {
            if (strrpos($str, ',') > strrpos($str, '.')) {
                // 15.000.000,50
                $str = str_replace('.', '', $str);
                $str = str_replace(',', '.', $str);
            } else {
                // 15,000,000.50
                $str = str_replace(',', '', $str);
            }
        } elseif (str_contains($str, '.') && ! str_contains($str, ',')) {
            // Cek apakah titik dipakai sebagai pemisah ribuan "15.000.000"
            if (preg_match('/\.\d{3}/', $str)) {
                $str = str_replace('.', '', $str);
            }
        } elseif (str_contains($str, ',') && ! str_contains($str, '.')) {
            // Cek apakah koma dipakai sebagai pemisah ribuan "15,000,000"
            if (preg_match('/,\d{3}/', $str)) {
                $str = str_replace(',', '', $str);
            } else {
                // Desimal koma "5000,5"
                $str = str_replace(',', '.', $str);
            }
        }

        return is_numeric($str) ? (float) $str : 0.0;
    }

    /**
     * Helper untuk cek substring
     */
    private static function containsAny(string $haystack, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (str_contains($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }
}
