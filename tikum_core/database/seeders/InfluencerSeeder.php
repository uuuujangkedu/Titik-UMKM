<?php

namespace Database\Seeders;

use App\Models\InfluencerProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InfluencerSeeder extends Seeder
{
    public function run(): void
    {
        $influencers = [
            [
                'name' => 'Dimas Arya (FoodVlog Sby)',
                'email' => 'dimas.food@gmail.com',
                'phone' => '081234567890',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
                'panggung' => 'Dimas Kulineran',
                'kategori' => 'Kuliner',
                'kota' => 'Surabaya',
                'provinsi' => 'Jawa Timur',
                'ig' => '@dimas_kulineransby',
                'tiktok' => '@dimasfoodhunter',
                'followers' => 24500,
                'rate_story' => 75000,
                'rate_reels' => 200000,
                'rate_visit' => 350000,
                'bio' => 'Food Vlogger spesialis UMKM kaki lima dan kuliner legendaris Surabaya & Sidoarjo. Video engaging, honest review, dan jago bikin penonton ngiler!',
            ],
            [
                'name' => 'Siti Nurhaliza (Nisa Style)',
                'email' => 'nisa.hijab@gmail.com',
                'phone' => '081398765432',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&q=80',
                'panggung' => 'Nisa OOTD Malang',
                'kategori' => 'Fashion',
                'kota' => 'Malang',
                'provinsi' => 'Jawa Timur',
                'ig' => '@nisaootd_malang',
                'tiktok' => '@nisafashionstyle',
                'followers' => 18200,
                'rate_story' => 60000,
                'rate_reels' => 175000,
                'rate_visit' => 300000,
                'bio' => 'Fashion & Hijab stylist ramah UMKM. Siap bantu review produk fashion lokal, tas, sepatu, dan aksesoris dengan konsep estetik kekinian.',
            ],
            [
                'name' => 'Bima Prasetya (Explore Jkt)',
                'email' => 'bima.explore@gmail.com',
                'phone' => '081912345678',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
                'panggung' => 'Bima Tempat Asik',
                'kategori' => 'Lifestyle',
                'kota' => 'Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'ig' => '@bima_ngopi',
                'tiktok' => '@tempatngopiasik',
                'followers' => 45000,
                'rate_story' => 120000,
                'rate_reels' => 350000,
                'rate_visit' => 600000,
                'bio' => 'Spesialis tempat nongkrong, kedai kopi UMKM, dan hidden gem Jakarta. Engagement rate tinggi dengan audiens Gen-Z dan milenial.',
            ],
            [
                'name' => 'Rina Cantika Beauty',
                'email' => 'rina.beauty@gmail.com',
                'phone' => '081298127364',
                'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=400&q=80',
                'panggung' => 'Rina Glowing Tips',
                'kategori' => 'Kecantikan',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'ig' => '@rinaglowing_bdg',
                'tiktok' => '@rinacantikaofficial',
                'followers' => 31000,
                'rate_story' => 90000,
                'rate_reels' => 250000,
                'rate_visit' => 450000,
                'bio' => 'Reviewer skincare, bodycare, dan produk kecantikan lokal ramah BPOM. Ulasan mendalam, edukatif, dan bikin audiens percaya.',
            ],
            [
                'name' => 'Eko Prabowo (Kreator Bisnis)',
                'email' => 'influencer@tikum.id', // akun utama untuk demo testing login user
                'phone' => '082188990011',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80',
                'panggung' => 'Eko UMKM Reviewer',
                'kategori' => 'UMKM & Bisnis',
                'kota' => 'Yogyakarta',
                'provinsi' => 'DI Yogyakarta',
                'ig' => '@ekobisnisjogja',
                'tiktok' => '@ekoumkmmaju',
                'followers' => 38900,
                'rate_story' => 80000,
                'rate_reels' => 220000,
                'rate_visit' => 400000,
                'bio' => 'Misi saya membantu UMKM lokal naik kelas lewat digital storytelling. Pengalaman review 100+ UMKM di pulau Jawa!',
            ],
        ];

        foreach ($influencers as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'phone_number' => $data['phone'],
                    'avatar_url' => $data['avatar'],
                    'password' => Hash::make('Password123!'),
                    'role' => 'influencer',
                    'status' => 'aktif',
                    'provinsi' => $data['provinsi'],
                    'kota' => $data['kota'],
                    'provinsi_kota' => $data['provinsi'] . ', ' . $data['kota'],
                    'bank_name' => 'BCA',
                    'nomor_rekening' => '8720192837',
                    'nama_pemilik_rekening' => $data['name'],
                    'email_verified_at' => now(),
                    'phone_verified_at' => now(),
                ]
            );

            InfluencerProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_panggung' => $data['panggung'],
                    'kategori' => $data['kategori'],
                    'kota' => $data['kota'],
                    'provinsi' => $data['provinsi'],
                    'username_instagram' => $data['ig'],
                    'username_tiktok' => $data['tiktok'],
                    'followers_count' => $data['followers'],
                    'rate_story' => $data['rate_story'],
                    'rate_reels_tiktok' => $data['rate_reels'],
                    'rate_visit_store' => $data['rate_visit'],
                    'bio' => $data['bio'],
                    'status_verifikasi' => 'terverifikasi',
                    'is_available' => true,
                    'total_selesai' => rand(5, 24),
                    'saldo' => rand(500000, 2500000),
                    'bank_name' => 'BCA',
                    'nomor_rekening' => '8720192837',
                    'nama_rekening' => $data['name'],
                ]
            );
        }
    }
}
