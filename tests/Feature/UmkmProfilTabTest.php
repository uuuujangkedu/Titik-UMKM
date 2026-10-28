<?php

namespace Tests\Feature;

use App\Models\PenyediaRuko;
use App\Models\Ruko;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UmkmProfilTabTest extends TestCase
{
    use RefreshDatabase;

    public function test_umkm_can_access_edit_profil_tab_in_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Usaha Test UMKM',
            'jenis_usaha' => 'Makanan',
            'pemilik' => 'Test Owner',
            'nomor_whatsapp' => '08123456789',
            'status_pengajuan' => 'draf',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard', ['tab' => 'profil']));

        $response->assertStatus(200);
        $response->assertSee('Edit Profil & Proposal Usaha', false);
        $response->assertSee('Identitas Pemilik Usaha');
        $response->assertSee('Kebutuhan Modal Kerja (Rp)');
        $response->assertSee('Preferensi Lokasi Ruko Komersial');
    }

    public function test_umkm_can_update_profile_and_proposal_from_dashboard_tab(): void
    {
        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Usaha Lama',
            'jenis_usaha' => 'Makanan',
            'pemilik' => 'Nama Lama',
            'nomor_whatsapp' => '08123456789',
        ]);

        $penyedia = PenyediaRuko::create([
            'nama_perusahaan' => 'PT Sentra Ruko Nusantara',
            'kontak' => '081299998888',
            'alamat' => 'Jl. Lingkar Kudus No. 1',
        ]);

        $ruko = Ruko::create([
            'id_penyedia' => $penyedia->id_penyedia,
            'nama_ruko' => 'Ruko Sentra Bisnis',
            'lokasi' => 'Jl. Sudirman No. 10',
            'harga_sewa_per_bulan' => 2500000,
            'total_unit' => 5,
            'unit_terisi' => 1,
            'status_ketersediaan' => 'tersedia',
        ]);

        $response = $this->actingAs($user)->post(route('dashboard.umkm.pengajuan'), [
            'aksi' => 'simpan_draf',
            'nama_usaha' => 'Usaha Maju Berkah',
            'jenis_usaha' => 'Jasa',
            'pemilik' => 'Ahmad Santoso',
            'nomor_whatsapp' => '08987654321',
            'modal_dibutuhkan' => '50.000.000',
            'estimasi_bagi_hasil' => '20% per bulan',
            'deskripsi' => 'Rencana ekspansi layanan jasa digital.',
            'id_ruko_diminati' => $ruko->id_ruko,
        ]);

        $response->assertRedirect(route('dashboard', ['tab' => 'profil']));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('umkm', [
            'user_id' => $user->id,
            'nama_usaha' => 'Usaha Maju Berkah',
            'pemilik' => 'Ahmad Santoso',
            'nomor_whatsapp' => '08987654321',
            'modal_dibutuhkan' => 50000000,
            'id_ruko_diminati' => $ruko->id_ruko,
        ]);

        $this->assertSame('Ahmad Santoso', $user->fresh()->name);
    }
}
