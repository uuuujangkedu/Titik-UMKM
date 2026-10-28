<?php

namespace Database\Seeders;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@dayaumkm.id'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('Admin123!'),
                'role' => 'super_admin',
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@tikum.id'],
            [
                'name' => 'Super Admin TIKUM',
                'password' => Hash::make('Admin123!'),
                'role' => 'super_admin',
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staf.admin@dayaumkm.id'],
            [
                'name' => 'Staf Admin Operasional',
                'phone_number' => '081234567891',
                'password' => Hash::make('Admin123!'),
                'role' => 'admin',
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'investor@tikum.id'],
            [
                'name' => 'Mitra Investor Demo',
                'phone_number' => '081298765432',
                'password' => Hash::make('Investor123!'),
                'role' => 'investor',
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        $umkmUser = User::updateOrCreate(
            ['email' => 'umkm@tikum.id'],
            [
                'name' => 'Pelaku UMKM Demo',
                'phone_number' => '081234567890',
                'password' => Hash::make('Umkm123!'),
                'role' => 'umkm',
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        Umkm::firstOrCreate(
            ['user_id' => $umkmUser->id],
            [
                'nama_usaha' => 'Kopi Titik Nusantara',
                'jenis_usaha' => 'Makanan',
                'pemilik' => 'Pelaku UMKM Demo',
                'nomor_whatsapp' => '081234567890',
                'status_pengajuan' => 'disetujui',
            ]
        );
    }
}
