<?php

namespace Database\Seeders;

use App\Models\PenyediaRuko;
use App\Models\Ruko;
use App\Models\Umkm;
use Illuminate\Database\Seeder;

class SampleCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $penyedia = PenyediaRuko::firstOrCreate(
            ['nama_perusahaan' => 'PT Sarana Properti Komersial Nusantara'],
            [
                'kontak' => '081299887766',
                'alamat' => 'Jl. Boulevard Raya No. 45, Jakarta',
            ]
        );

        $rukoList = [
            [
                'nama_ruko' => 'Ruko Pasar Rebo Hub A1',
                'lokasi' => 'Jl. Raya Bogor No. 12, Pasar Rebo, Jakarta Timur',
                'harga_sewa_per_bulan' => 3500000,
                'status_ketersediaan' => 'tersedia',
            ],
            [
                'nama_ruko' => 'Ruko Cijantung Square B3',
                'lokasi' => 'Jl. Pendidikan No. 8, Cijantung, Jakarta Timur',
                'harga_sewa_per_bulan' => 4200000,
                'status_ketersediaan' => 'tersedia',
            ],
            [
                'nama_ruko' => 'Ruko Tebet Promenade C5',
                'lokasi' => 'Jl. Tebet Barat Dalam No. 20, Tebet, Jakarta Selatan',
                'harga_sewa_per_bulan' => 5500000,
                'status_ketersediaan' => 'tersedia',
            ],
            [
                'nama_ruko' => 'Ruko Margonda Point D2',
                'lokasi' => 'Jl. Margonda Raya No. 110, Beji, Depok',
                'harga_sewa_per_bulan' => 3800000,
                'status_ketersediaan' => 'tersedia',
            ],
        ];

        foreach ($rukoList as $r) {
            Ruko::firstOrCreate(
                ['nama_ruko' => $r['nama_ruko']],
                array_merge($r, ['id_penyedia' => $penyedia->id_penyedia])
            );
        }

        $umkmList = [
            [
                'nama_usaha' => 'Kopi Selaras Nusantara',
                'jenis_usaha' => 'Makanan',
                'pemilik' => 'Rian Hidayat',
                'deskripsi' => 'Kedai kopi kekinian menyajikan racikan biji kopi arabika lokal dan camilan tradisional.',
            ],
            [
                'nama_usaha' => 'Klinik Sepatu & Laundry CleanPro',
                'jenis_usaha' => 'Jasa',
                'pemilik' => 'Siti Nurhaliza',
                'deskripsi' => 'Jasa deep cleaning sepatu premium dan laundry ekspres higienis berstandar tinggi.',
            ],
            [
                'nama_usaha' => 'Batik Tenun Cantik Mandiri',
                'jenis_usaha' => 'Fashion',
                'pemilik' => 'Dewi Sartika',
                'deskripsi' => 'Produksi busana batik modern dan tenun lurik lokal dengan pasar nasional.',
            ],
            [
                'nama_usaha' => 'Sayur Organik Hidroponik Makmur',
                'jenis_usaha' => 'Agribisnis',
                'pemilik' => 'Ahmad Fauzi',
                'deskripsi' => 'Budidaya sayuran hidroponik segar tanpa pestisida untuk suplai pasar ritel modern.',
            ],
        ];

        foreach ($umkmList as $u) {
            Umkm::firstOrCreate(
                ['nama_usaha' => $u['nama_usaha']],
                $u
            );
        }
    }
}
