<?php

namespace Tests\Feature;

use App\Models\LogAktivitasAdmin;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuperAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_super_admin_dashboard()
    {
        $response = $this->get('/super-admin');
        $response->assertRedirect('/login');
    }

    public function test_admin_url_redirects_to_super_admin_dashboard()
    {
        $admin = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertRedirect('/super-admin');
    }

    public function test_regular_user_cannot_access_super_admin_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->get('/super-admin');
        $response->assertStatus(403);
    }

    public function test_super_admin_can_view_dashboard()
    {
        $admin = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($admin)->get('/super-admin');
        $response->assertStatus(200);
        $response->assertSee('BERANDA');
        $response->assertSee('Grafik Penjualan 7 Hari');
    }

    public function test_super_admin_can_approve_proposal()
    {
        $admin = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'aktif',
        ]);

        $umkmUser = User::factory()->create(['role' => 'umkm']);
        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_usaha' => 'Keripik Tempe Juara',
            'jenis_usaha' => 'Makanan',
            'pemilik' => 'Pak Budi',
            'status_pengajuan' => 'menunggu_verifikasi',
        ]);

        $response = $this->actingAs($admin)->post("/super-admin/pengajuan/{$umkm->id_umkm}/approve");

        $response->assertSessionHas('success');
        $this->assertEquals('terverifikasi', $umkm->fresh()->status_pengajuan);

        // Pastikan log aktivitas tercatat
        $this->assertDatabaseHas('log_aktivitas_admin', [
            'id_pengguna' => $admin->id,
            'aksi' => 'Persetujuan Proposal UMKM',
        ]);
    }

    public function test_super_admin_can_reject_proposal()
    {
        $admin = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'aktif',
        ]);

        $umkmUser = User::factory()->create(['role' => 'umkm']);
        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_usaha' => 'Batik Tulis Eksotik',
            'jenis_usaha' => 'Fashion',
            'pemilik' => 'Ibu Siti',
            'status_pengajuan' => 'menunggu_verifikasi',
        ]);

        $response = $this->actingAs($admin)->post("/super-admin/pengajuan/{$umkm->id_umkm}/reject", [
            'alasan' => 'Dokumen NIB belum terlampir.',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('ditolak', $umkm->fresh()->status_pengajuan);

        // Pastikan log aktivitas tercatat
        $this->assertDatabaseHas('log_aktivitas_admin', [
            'id_pengguna' => $admin->id,
            'aksi' => 'Penolakan Proposal UMKM',
        ]);
    }

    public function test_super_admin_can_toggle_user_status()
    {
        $admin = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'aktif',
        ]);

        $targetUser = User::factory()->create([
            'status' => 'aktif',
            'role' => 'investor',
        ]);

        $response = $this->actingAs($admin)->post("/super-admin/users/{$targetUser->id}/toggle-status");

        $response->assertSessionHas('success');
        $this->assertEquals('ditangguhkan', $targetUser->fresh()->status);

        // Toggle back to aktif
        $response2 = $this->actingAs($admin)->post("/super-admin/users/{$targetUser->id}/toggle-status");
        $this->assertEquals('aktif', $targetUser->fresh()->status);
    }

    public function test_super_admin_can_view_activity_logs()
    {
        $admin = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'aktif',
        ]);

        LogAktivitasAdmin::create([
            'id_pengguna' => $admin->id,
            'aksi' => 'Uji Coba Audit Trail',
            'detail_perubahan' => ['test' => true],
            'ip_address' => '127.0.0.1',
        ]);

        $response = $this->actingAs($admin)->get('/super-admin/log-aktivitas');
        $response->assertStatus(200);
        $response->assertSee('LOG AKTIVITAS & SESI ONLINE', false);
        $response->assertSee('Uji Coba Audit Trail');
    }

    public function test_regular_admin_can_handle_proposals_and_acc_users()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $investor = User::factory()->create([
            'role' => 'investor',
            'status' => 'menunggu_verifikasi',
        ]);

        // Regular admin can approve investor user
        $accResponse = $this->actingAs($admin)->post("/super-admin/users/{$investor->id}/approve");
        $accResponse->assertSessionHas('success');
        $this->assertEquals('aktif', $investor->fresh()->status);

        // Regular admin can view and approve proposal
        $umkmUser = User::factory()->create(['role' => 'umkm']);
        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_usaha' => 'Warung Kopi Senja',
            'jenis_usaha' => 'Makanan',
            'pemilik' => 'Pak Senja',
            'status_pengajuan' => 'menunggu_verifikasi',
        ]);

        $approveResponse = $this->actingAs($admin)->post("/super-admin/pengajuan/{$umkm->id_umkm}/approve");
        $approveResponse->assertSessionHas('success');
        $this->assertEquals('terverifikasi', $umkm->fresh()->status_pengajuan);
    }

    public function test_regular_admin_cannot_access_sensitive_actions()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $targetUser = User::factory()->create([
            'role' => 'investor',
            'status' => 'aktif',
        ]);

        // 1. Regular admin CANNOT toggle user status (suspend)
        $toggleResponse = $this->actingAs($admin)->post("/super-admin/users/{$targetUser->id}/toggle-status");
        $toggleResponse->assertStatus(403);

        // 2. Regular admin CANNOT change user roles
        $roleResponse = $this->actingAs($admin)->post("/super-admin/users/{$targetUser->id}/change-role", [
            'role' => 'admin',
        ]);
        $roleResponse->assertStatus(403);

        // 3. Regular admin CANNOT view forensic audit logs
        $logsResponse = $this->actingAs($admin)->get('/super-admin/log-aktivitas');
        $logsResponse->assertStatus(403);
    }

    public function test_super_admin_can_change_user_role()
    {
        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'aktif',
        ]);

        $user = User::factory()->create([
            'role' => 'investor',
            'status' => 'aktif',
        ]);

        // Change investor to umkm
        $response = $this->actingAs($superAdmin)->post("/super-admin/users/{$user->id}/change-role", [
            'role' => 'umkm',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('umkm', $user->fresh()->role);
        $this->assertDatabaseHas('umkm', ['user_id' => $user->id]);

        // Change to regular admin
        $response2 = $this->actingAs($superAdmin)->post("/super-admin/users/{$user->id}/change-role", [
            'role' => 'admin',
        ]);
        $response2->assertSessionHas('success');
        $this->assertEquals('admin', $user->fresh()->role);

        // Cannot change own role
        $selfResponse = $this->actingAs($superAdmin)->post("/super-admin/users/{$superAdmin->id}/change-role", [
            'role' => 'investor',
        ]);
        $selfResponse->assertSessionHas('error');
        $this->assertEquals('super_admin', $superAdmin->fresh()->role);
    }

    public function test_super_admin_can_view_ruko_transaksi_and_confirm_sewa()
    {
        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'aktif',
        ]);

        $investor = User::factory()->create([
            'role' => 'investor',
            'status' => 'aktif',
        ]);

        $umkmUser = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
        ]);

        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_usaha' => 'Usaha Test',
            'jenis_usaha' => 'Kuliner',
            'deskripsi' => 'Deskripsi test',
            'pemilik' => 'Pemilik Test',
            'nik_penanggung_jawab' => '1234567890123456',
            'nomor_whatsapp' => '08123456789',
            'status_pengajuan' => 'terverifikasi',
        ]);

        $penyedia = \App\Models\PenyediaRuko::create([
            'nama_perusahaan' => 'Penyedia Test',
            'kontak' => '08123456789',
            'alamat' => 'Jl. Test',
        ]);

        $ruko = \App\Models\Ruko::create([
            'id_penyedia' => $penyedia->id_penyedia,
            'nama_ruko' => 'Ruko Test',
            'lokasi' => 'Jl. Test',
            'harga_sewa_per_bulan' => 1000000,
            'total_unit' => 2,
            'unit_terisi' => 1,
            'status_ketersediaan' => 'tersedia',
        ]);

        $sewa = \App\Models\TransaksiSewa::create([
            'id_umkm' => $umkm->id_umkm,
            'id_investor' => $investor->id,
            'id_ruko' => $ruko->id_ruko,
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addMonths(3)->toDateString(),
            'total_harga' => 3000000,
            'status_pembayaran' => 'menunggu_konfirmasi',
            'catatan_sponsor' => 'Sponsor sewa ruko',
        ]);

        // 1. Super admin can view transaksi tab
        $response = $this->actingAs($superAdmin)->get('/super-admin/ruko?tab=transaksi');
        $response->assertStatus(200);
        $response->assertSee('Ruko Test');
        $response->assertSee('Usaha Test');
        $response->assertSee('MENUNGGU KONFIRMASI');

        // 2. Super admin can confirm sewa
        $confirmResponse = $this->actingAs($superAdmin)->post("/super-admin/ruko/sewa/{$sewa->id_sewa}/confirm");
        $confirmResponse->assertSessionHas('success');
        $this->assertEquals('dibayar', $sewa->fresh()->status_pembayaran);

        // 3. Super admin can reject/cancel sewa
        $rejectResponse = $this->actingAs($superAdmin)->post("/super-admin/ruko/sewa/{$sewa->id_sewa}/reject");
        $rejectResponse->assertSessionHas('success');
        $this->assertEquals('dibatalkan', $sewa->fresh()->status_pembayaran);
    }

    public function test_umkm_can_rent_ruko_mandiri_and_admin_can_view_and_confirm()
    {
        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'aktif',
        ]);

        $umkmUser = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
        ]);

        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_usaha' => 'Kedai Kopi Mandiri',
            'jenis_usaha' => 'F&B',
            'deskripsi' => 'Usaha kopi kekinian',
            'pemilik' => 'Budi Sudarsono',
            'nik_penanggung_jawab' => '3201234567890001',
            'nomor_whatsapp' => '081299887766',
            'status_pengajuan' => 'terverifikasi',
        ]);

        $penyedia = \App\Models\PenyediaRuko::create([
            'nama_perusahaan' => 'Properti Jaya',
            'kontak' => '081300001111',
            'alamat' => 'Jl. Sudirman No. 1',
        ]);

        $ruko = \App\Models\Ruko::create([
            'id_penyedia' => $penyedia->id_penyedia,
            'nama_ruko' => 'Ruko Sentra Mandiri',
            'lokasi' => 'Jl. Sudirman',
            'harga_sewa_per_bulan' => 2000000,
            'total_unit' => 3,
            'unit_terisi' => 0,
            'status_ketersediaan' => 'tersedia',
        ]);

        // 1. UMKM sends POST to rent ruko directly
        $rentResponse = $this->actingAs($umkmUser)->post("/dashboard/umkm/sewa-ruko/{$ruko->id_ruko}", [
            'durasi_bulan' => 6,
            'catatan_sewa' => 'Pemesanan gerai mandiri untuk ekspansi bisnis',
        ]);

        $rentResponse->assertRedirect('/dashboard?tab=ruko');
        $rentResponse->assertSessionHas('success');

        // Verify TransaksiSewa created with id_investor = null
        $sewaMandiri = \App\Models\TransaksiSewa::where('id_ruko', $ruko->id_ruko)
            ->where('id_umkm', $umkm->id_umkm)
            ->first();

        $this->assertNotNull($sewaMandiri);
        $this->assertNull($sewaMandiri->id_investor);
        $this->assertEquals(12000000, $sewaMandiri->total_harga);
        $this->assertEquals('menunggu_konfirmasi', $sewaMandiri->status_pembayaran);
        $this->assertEquals(1, $ruko->fresh()->unit_terisi);

        // 2. Super admin views transaksi tab and confirms the sewa mandiri
        $viewResponse = $this->actingAs($superAdmin)->get('/super-admin/ruko?tab=transaksi');
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Kedai Kopi Mandiri');
        $viewResponse->assertSee('Ruko Sentra Mandiri');
        $viewResponse->assertSee('Sewa Mandiri oleh Pelaku UMKM');

        $confirmResponse = $this->actingAs($superAdmin)->post("/super-admin/ruko/sewa/{$sewaMandiri->id_sewa}/confirm");
        $confirmResponse->assertSessionHas('success');
        $this->assertEquals('dibayar', $sewaMandiri->fresh()->status_pembayaran);
    }
}
