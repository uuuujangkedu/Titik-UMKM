<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Investasi;
use App\Models\Umkm;
use App\Models\User;
use App\Models\KontrakInvestasi;
use Illuminate\Support\Str;

class SindikasiCrowdfundingSeeder extends Seeder
{
    public function run(): void
    {
        $investor1 = User::firstOrCreate(
            ['email' => 'thezidan162@gmail.com'],
            ['name' => 'Zidan Investor', 'role' => 'investor', 'password' => bcrypt('Password123!')]
        );

        $investor2 = User::firstOrCreate(
            ['email' => 'investor@tikum.id'],
            ['name' => 'Mitra Investor Demo', 'role' => 'investor', 'password' => bcrypt('Password123!')]
        );

        $investor3 = User::firstOrCreate(
            ['email' => 'baimkiyowo@gmail.com'],
            ['name' => 'Baim Co-Investor', 'role' => 'investor', 'password' => bcrypt('Password123!')]
        );

        $investor4 = User::firstOrCreate(
            ['email' => 'rilah2203@gmail.com'],
            ['name' => 'Riszki Fadhillah', 'role' => 'investor', 'password' => bcrypt('Password123!')]
        );

        // UMKM 1: Kopi Selaras Nusantara (id_umkm: 1) -> 3 Co-Investors (Total 16.250.000 / 25.000.000 = 65%)
        $umkm1 = Umkm::find(1);
        if ($umkm1) {
            $inv1 = Investasi::updateOrCreate(
                ['id_umkm' => 1, 'id_pengguna' => $investor1->id],
                [
                    'jumlah_modal' => 7500000,
                    'persentase_bagi_hasil' => 15,
                    'periode_pembagian' => 'Bulanan',
                    'status' => 'aktif',
                    'tanggal_investasi' => now()->subDays(14),
                    'catatan' => 'Komitmen sindikasi slot 1 untuk perluasan kedai cold brew.',
                ]
            );

            $inv2 = Investasi::updateOrCreate(
                ['id_umkm' => 1, 'id_pengguna' => $investor2->id],
                [
                    'jumlah_modal' => 5000000,
                    'persentase_bagi_hasil' => 15,
                    'periode_pembagian' => 'Bulanan',
                    'status' => 'aktif',
                    'tanggal_investasi' => now()->subDays(10),
                    'catatan' => 'Komitmen sindikasi slot 2 peremajaan mesin espresso.',
                ]
            );

            $inv3 = Investasi::updateOrCreate(
                ['id_umkm' => 1, 'id_pengguna' => $investor3->id],
                [
                    'jumlah_modal' => 3750000,
                    'persentase_bagi_hasil' => 15,
                    'periode_pembagian' => 'Bulanan',
                    'status' => 'aktif',
                    'tanggal_investasi' => now()->subDays(5),
                    'catatan' => 'Komitmen sindikasi slot 3 persediaan biji kopi robusta.',
                ]
            );

            // Create Kontrak for Investor 1 & UMKM 1
            $this->seedKontrak($inv1, $umkm1, $investor1);
            $this->seedKontrak($inv2, $umkm1, $investor2);
        }

        // UMKM 2: Klinik Sepatu (id_umkm: 2) -> 2 Co-Investors (Total 11.000.000 / 25.000.000 = 44%)
        $umkm2 = Umkm::find(2);
        if ($umkm2) {
            $inv4 = Investasi::updateOrCreate(
                ['id_umkm' => 2, 'id_pengguna' => $investor2->id],
                [
                    'jumlah_modal' => 6000000,
                    'persentase_bagi_hasil' => 18,
                    'periode_pembagian' => 'Bulanan',
                    'status' => 'aktif',
                    'tanggal_investasi' => now()->subDays(8),
                    'catatan' => 'Sindikasi pengadaan mesin dryer ozon dan cat sepatu.',
                ]
            );

            $inv5 = Investasi::updateOrCreate(
                ['id_umkm' => 2, 'id_pengguna' => $investor4->id],
                [
                    'jumlah_modal' => 5000000,
                    'persentase_bagi_hasil' => 18,
                    'periode_pembagian' => 'Bulanan',
                    'status' => 'aktif',
                    'tanggal_investasi' => now()->subDays(4),
                    'catatan' => 'Sindikasi slot kedua.',
                ]
            );

            $this->seedKontrak($inv4, $umkm2, $investor2);
        }

        // UMKM 3: Batik Tenun Cantik (id_umkm: 3) -> Total 20.000.000 / 25.000.000 = 80%
        $umkm3 = Umkm::find(3);
        if ($umkm3) {
            $inv6 = Investasi::updateOrCreate(
                ['id_umkm' => 3, 'id_pengguna' => $investor1->id],
                [
                    'jumlah_modal' => 10000000,
                    'persentase_bagi_hasil' => 16,
                    'periode_pembagian' => 'Bulanan',
                    'status' => 'aktif',
                    'tanggal_investasi' => now()->subDays(20),
                    'catatan' => 'Penyertaan modal pengadaan bahan sutra & canting.',
                ]
            );

            $inv7 = Investasi::updateOrCreate(
                ['id_umkm' => 3, 'id_pengguna' => $investor3->id],
                [
                    'jumlah_modal' => 10000000,
                    'persentase_bagi_hasil' => 16,
                    'periode_pembagian' => 'Bulanan',
                    'status' => 'aktif',
                    'tanggal_investasi' => now()->subDays(12),
                    'catatan' => 'Sindikasi modal ekspor batik ke pameran nasional.',
                ]
            );

            $this->seedKontrak($inv6, $umkm3, $investor1);
        }
    }

    private function seedKontrak($investasi, $umkm, $investor): void
    {
        $nomor = 'TIKUM/AKAD/' . date('Y') . '/' . strtoupper(Str::random(3)) . '/' . sprintf('%04d', $investasi->id_investasi);
        $qrCode = hash('sha256', $investasi->id_investasi . '_' . $investor->id . '_' . $umkm->id_umkm);

        // Pre-create realistic digital contract with simulated clean e-signature data
        $dummySig = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="200" height="70"><path d="M 10 40 Q 30 10, 60 30 T 110 25 T 150 45 T 190 35" stroke="#0F433C" stroke-width="3" fill="none" stroke-linecap="round"/></svg>');

        KontrakInvestasi::updateOrCreate(
            ['id_investasi' => $investasi->id_investasi],
            [
                'nomor_kontrak' => $nomor,
                'id_umkm' => $umkm->id_umkm,
                'id_investor' => $investor->id,
                'judul_kontrak' => 'Perjanjian Kemitraan Modal & Bagi Hasil Usaha Sektor Riil',
                'skema_akad' => 'Musyarakah (Bagi Hasil Sektor Riil)',
                'nominal_modal' => $investasi->jumlah_modal,
                'persentase_bagi_hasil' => $investasi->persentase_bagi_hasil,
                'tenor_bulan' => 12,
                'periode_dividen' => $investasi->periode_pembagian ?? 'Bulanan',
                'signature_investor' => $dummySig,
                'signed_at_investor' => now()->subDays(rand(1, 10)),
                'signature_umkm' => $dummySig,
                'signed_at_umkm' => now()->subDays(rand(1, 10)),
                'status' => 'aktif_sah',
                'kode_keabsahan_qr' => $qrCode,
            ]
        );
    }
}
