<?php

namespace Tests\Feature;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticatedPartnerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_umkm_cannot_switch_to_investor_registration_and_gets_status_notice(): void
    {
        $user = User::factory()->create(['role' => 'umkm', 'status' => 'aktif']);
        Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Usaha Draf',
            'jenis_usaha' => 'Makanan',
            'pemilik' => $user->name,
            'nomor_whatsapp' => '081234567890',
            'status_pengajuan' => 'draf',
        ]);

        $response = $this->actingAs($user)->get(route('register.investor'));

        $response->assertRedirect(route('gabung.umkm'));
        $response->assertSessionHas('error');
        $this->get(route('gabung.umkm'))->assertSee('Akun Anda terdaftar sebagai pelaku UMKM');
    }

    public function test_umkm_registration_page_reports_draft_pending_rejected_and_approved_statuses(): void
    {
        $user = User::factory()->create(['role' => 'umkm', 'status' => 'aktif']);
        $umkm = Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Usaha Mitra',
            'jenis_usaha' => 'Makanan',
            'pemilik' => $user->name,
            'nomor_whatsapp' => '081234567890',
            'status_pengajuan' => 'draf',
        ]);

        foreach ([
            'draf' => 'Lengkapi dan ajukan formulir pendaftaran UMKM Anda.',
            'menunggu_verifikasi' => 'Pengajuan UMKM Anda sedang menunggu verifikasi admin.',
            'ditolak' => 'Pengajuan UMKM Anda belum diterima. Perbarui formulir sebelum mengajukan kembali.',
            'terverifikasi' => 'Akun Anda sudah terdaftar sebagai pelaku UMKM.',
        ] as $status => $message) {
            $umkm->update(['status_pengajuan' => $status]);

            $response = $this->actingAs($user)->get(route('register.umkm'));

            $response->assertRedirect(route($status === 'terverifikasi' ? 'dashboard' : 'formulir.umkm'));
            $response->assertSessionHas('info', $message);
        }
    }

    public function test_unsubmitted_umkm_form_keeps_user_on_form_with_notification(): void
    {
        $user = User::factory()->create(['role' => 'umkm', 'status' => 'aktif']);
        Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Usaha Draf',
            'jenis_usaha' => 'Makanan',
            'pemilik' => $user->name,
            'nomor_whatsapp' => '081234567890',
            'status_pengajuan' => 'draf',
        ]);

        $this->actingAs($user)->get(route('gabung.umkm'));
        $this->get(route('register.umkm'))->assertRedirect(route('formulir.umkm'));
        $this->get(route('formulir.umkm'))->assertSessionHas('info');
    }
}
