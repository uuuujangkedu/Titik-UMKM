<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    /**
     * Membersihkan nama wilayah dari prefiks umum untuk pencocokan akurat.
     */
    private function cleanName(?string $str): string
    {
        $cleaned = mb_strtolower(trim($str ?? ''), 'UTF-8');
        $cleaned = preg_replace('/^(provinsi|prov\.|daerah khusus ibukota|dki|daerah istimewa|d\.i\.|kota administrasi|kota|kabupaten|kab\.)\s+/iu', '', $cleaned);
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);

        return trim($cleaned);
    }

    /**
     * Konversi teks nama kelurahan ke format Title Case yang rapi.
     */
    private function formatTitleCase(string $name): string
    {
        return mb_convert_case(mb_strtolower($name, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Cocokkan Kota / Kabupaten secara cerdas, membedakan Kota vs Kabupaten.
     *
     * @param  array<int, array<string, mixed>>  $regencies
     * @return array<string, mixed>|null
     */
    private function matchRegency(array $regencies, string $kota): ?array
    {
        $isKota = str_contains(mb_strtolower($kota), 'kota');
        $isKab = str_contains(mb_strtolower($kota), 'kab');

        // 1. Coba pencocokan tepat setelah standarisasi prefiks
        $normalizedInput = mb_strtoupper(trim($kota));
        $normalizedInput = preg_replace('/^KAB\.\s+/iu', 'KABUPATEN ', $normalizedInput);
        $exact = collect($regencies)->first(function ($r) use ($normalizedInput) {
            return mb_strtoupper(trim($r['name'])) === $normalizedInput;
        });

        if ($exact) {
            return $exact;
        }

        // 2. Filter berdasarkan tipe (Kota vs Kabupaten) jika spesifik
        $cleanInput = $this->cleanName($kota);
        $filtered = collect($regencies)->filter(function ($r) use ($isKota, $isKab) {
            $rName = mb_strtolower($r['name']);
            if ($isKota) {
                return str_contains($rName, 'kota');
            }
            if ($isKab) {
                return str_contains($rName, 'kabupaten');
            }

            return true;
        });

        // 3. Pencocokan dengan nama bersih
        $matched = $filtered->first(function ($r) use ($cleanInput) {
            return $this->cleanName($r['name']) === $cleanInput;
        });

        if ($matched) {
            return $matched;
        }

        // 4. Fallback ke seluruh regencies tanpa filter tipe jika belum ditemukan
        return collect($regencies)->first(function ($r) use ($cleanInput) {
            $rClean = $this->cleanName($r['name']);

            return $rClean === $cleanInput || str_contains($rClean, $cleanInput) || str_contains($cleanInput, $rClean);
        });
    }

    /**
     * Cocokkan Kecamatan dari daftar distrik.
     *
     * @param  array<int, array<string, mixed>>  $districts
     * @return array<string, mixed>|null
     */
    private function matchDistrict(array $districts, string $kecamatan): ?array
    {
        $cleanKec = $this->cleanName($kecamatan);

        // 1. Exact match
        $exact = collect($districts)->first(function ($d) use ($cleanKec) {
            return $this->cleanName($d['name']) === $cleanKec;
        });

        if ($exact) {
            return $exact;
        }

        // 2. Substring match
        return collect($districts)->first(function ($d) use ($cleanKec) {
            $dClean = $this->cleanName($d['name']);

            return str_contains($dClean, $cleanKec) || str_contains($cleanKec, $dClean);
        });
    }

    /**
     * Ambil daftar Kelurahan / Desa berdasarkan hierarki Provinsi, Kota/Kabupaten, dan Kecamatan.
     */
    public function getKelurahan(Request $request): JsonResponse
    {
        $provinsi = $request->query('provinsi');
        $kota = $request->query('kota');
        $kecamatan = $request->query('kecamatan');

        if (empty($provinsi) || empty($kota) || empty($kecamatan)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Parameter provinsi, kota, dan kecamatan diperlukan.',
            ]);
        }

        $cacheKey = 'wilayah_kel_'.md5("{$provinsi}_{$kota}_{$kecamatan}");

        try {
            $villages = Cache::remember($cacheKey, 86400 * 30, function () use ($provinsi, $kota, $kecamatan) {
                // 1. Ambil daftar Provinsi
                $provinces = Cache::remember('wilayah_master_provinces', 86400 * 30, function () {
                    $response = Http::timeout(6)->get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');

                    return $response->successful() ? $response->json() : [];
                });

                if (empty($provinces)) {
                    return [];
                }

                $provClean = $this->cleanName($provinsi);
                $matchedProv = collect($provinces)->first(function ($p) use ($provClean) {
                    $nameClean = $this->cleanName($p['name']);

                    return $nameClean === $provClean || str_contains($nameClean, $provClean) || str_contains($provClean, $nameClean);
                });

                if (! $matchedProv) {
                    return [];
                }

                $provId = $matchedProv['id'];

                // 2. Ambil daftar Kota / Kabupaten
                $regencies = Cache::remember("wilayah_master_regencies_{$provId}", 86400 * 30, function () use ($provId) {
                    $response = Http::timeout(6)->get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provId}.json");

                    return $response->successful() ? $response->json() : [];
                });

                if (empty($regencies)) {
                    return [];
                }

                $matchedKota = $this->matchRegency($regencies, $kota);

                if (! $matchedKota) {
                    return [];
                }

                $regencyId = $matchedKota['id'];

                // 3. Ambil daftar Kecamatan
                $districts = Cache::remember("wilayah_master_districts_{$regencyId}", 86400 * 30, function () use ($regencyId) {
                    $response = Http::timeout(6)->get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$regencyId}.json");

                    return $response->successful() ? $response->json() : [];
                });

                if (empty($districts)) {
                    return [];
                }

                $matchedKec = $this->matchDistrict($districts, $kecamatan);

                if (! $matchedKec) {
                    return [];
                }

                $districtId = $matchedKec['id'];

                // 4. Ambil daftar Kelurahan / Desa
                $villagesRaw = Cache::remember("wilayah_master_villages_{$districtId}", 86400 * 30, function () use ($districtId) {
                    $response = Http::timeout(6)->get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$districtId}.json");

                    return $response->successful() ? $response->json() : [];
                });

                if (empty($villagesRaw)) {
                    return [];
                }

                return collect($villagesRaw)
                    ->map(fn ($v) => $this->formatTitleCase($v['name']))
                    ->unique()
                    ->sort()
                    ->values()
                    ->all();
            });

            return response()->json([
                'success' => true,
                'data' => $villages,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'data' => [],
                'error' => $e->getMessage(),
            ], 200);
        }
    }
}
