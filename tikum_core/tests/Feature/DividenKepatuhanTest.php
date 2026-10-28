<?php

namespace Tests\Feature;

use App\Models\BagiHasilLog;
use App\Models\Investasi;
use App\Models\KlarifikasiDividen;
use App\Models\PesanInvestasi;
use App\Models\TeguranDividenLog;
use App\Models\Umkm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DividenKepatuhanTest extends TestCase
{
    use RefreshDatabase;

    private function setupKemitraan()
    {
        $umkmUser = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
            'phone_number' => '081234567890',
        ]);

        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_usaha' => 'Warung Berkah Jaya',
            'jenis_usaha' => 'Makanan',
            'pemilik' => 'Pak Budi',
            'nomor_whatsapp' => '081234567890',
            'status_pengajuan' => 'terverifikasi',
            'status_kepatuhan_dividen' => 'lancar',
            'jumlah_teguran_sp' => 0,
            'modal_dibutuhkan' => 50000000,
            'deskripsi' => 'Kuliner Nusantara Sehat',
        ]);

        $investor = User::factory()->create([
            'role' => 'investor',
            'status' => 'aktif',
            'kategori_diminati' => json_encode(['Makanan']),
            'bank_name' => 'BCA',
            'nomor_rekening' => '1234567890',
            'nama_pemilik_rekening' => 'Investor Hebat',
        ]);

        $investasi = Investasi::create([
            'id_pengguna' => $investor->id,
            'id_umkm' => $umkm->id_umkm,
            'jumlah_modal' => 25000000,
            'persentase_bagi_hasil' => 15.0,
            'periode_pembagian' => 'Bulanan',
            'status' => 'aktif',
            'tanggal_investasi' => Carbon::now()->subMonths(2),
        ]);

        $admin = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'aktif',
        ]);

        return compact('umkmUser', 'umkm', 'investor', 'investasi', 'admin');
    }

    public function test_status_dividen_calculation_accessor()
    {
        $data = $this->setupKemitraan();
        $investasi = $data['investasi'];

        // 1. Tanpa setoran bulan ini
        $status = $investasi->status_dividen_bulan_ini;
        $this->assertIsArray($status);
        $this->assertArrayHasKey('code', $status);
        $this->assertArrayHasKey('due_date', $status);
        $this->assertEquals(25, $status['jatuh_tempo_hari']);

        // 2. Dengan setoran di bulan berjalan
        BagiHasilLog::create([
            'id_investasi' => $investasi->id_investasi,
            'tanggal_distribusi' => Carbon::now(),
            'nominal_diterima' => 500000,
            'bukti_transfer' => 'bukti.jpg',
        ]);

        $investasi->refresh();
        $statusLancar = $investasi->status_dividen_bulan_ini;
        $this->assertEquals('lancar', $statusLancar['code']);
        $this->assertEquals('Bulan Ini Sudah Disetor', $statusLancar['badge_label']);
    }

    public function test_umkm_can_submit_klarifikasi_penundaan_dividen()
    {
        $data = $this->setupKemitraan();
        $umkmUser = $data['umkmUser'];
        $investasi = $data['investasi'];

        $bulanSekarang = Carbon::now()->translatedFormat('F Y');

        $response = $this->actingAs($umkmUser)->post('/dashboard/umkm/dividen/klarifikasi', [
            'id_investasi' => $investasi->id_investasi,
            'bulan_periode' => $bulanSekarang,
            'kategori_kendala' => 'omzet_menurun',
            'alasan' => 'Terjadi renovasi saluran air di depan ruko sehingga akses pelanggan sempat tertutup selama 10 hari.',
            'komitmen_solusi' => 'Renovasi selesai, promo diskon bundling akhir pekan disiapkan, setoran diakumulasi tanggal 10 bulan depan.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('klarifikasi_dividen', [
            'id_investasi' => $investasi->id_investasi,
            'bulan_periode' => $bulanSekarang,
            'kategori_kendala' => 'omzet_menurun',
            'status' => 'menunggu_tinjauan',
        ]);

        // Cek bahwa pesan otomatis masuk ke percakapan kemitraan (PesanInvestasi)
        $this->assertDatabaseHas('pesan_investasi', [
            'id_investasi' => $investasi->id_investasi,
            'id_pengirim' => $umkmUser->id,
        ]);
    }

    public function test_super_admin_can_access_monitoring_dividen()
    {
        $data = $this->setupKemitraan();
        $admin = $data['admin'];

        $response = $this->actingAs($admin)->get('/super-admin/dividen');
        $response->assertStatus(200);
        $response->assertSee('MONITORING DIVIDEN');
        $response->assertSee('Kemitraan Aktif');
        $response->assertSee('Warung Berkah Jaya');
    }

    public function test_super_admin_can_issue_surat_peringatan_sp()
    {
        $data = $this->setupKemitraan();
        $admin = $data['admin'];
        $investasi = $data['investasi'];
        $umkm = $data['umkm'];

        $response = $this->actingAs($admin)->post("/super-admin/dividen/{$investasi->id_investasi}/teguran", [
            'tingkat_sp' => 'SP-1',
            'pesan_teguran' => 'Berdasarkan catatan sistem, setoran dividen periode ini belum tercatat disetorkan. Harap segera lakukan penyetoran atau sampaikan klarifikasi resmi.',
            'tenggat_penyelesaian' => Carbon::now()->addDays(3)->toDateString(),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionHas('wa_url');

        $this->assertDatabaseHas('teguran_dividen_log', [
            'id_investasi' => $investasi->id_investasi,
            'id_umkm' => $umkm->id_umkm,
            'tingkat_sp' => 'SP-1',
            'dikirim_oleh' => $admin->id,
        ]);

        $umkm->refresh();
        $this->assertEquals(1, $umkm->jumlah_teguran_sp);
        $this->assertNotNull($umkm->teguran_sp_terakhir);

        // Notifikasi SP resmi di percakapan internal
        $this->assertDatabaseHas('pesan_investasi', [
            'id_investasi' => $investasi->id_investasi,
            'id_pengirim' => $admin->id,
        ]);
    }

    public function test_super_admin_can_verify_klarifikasi_dividen()
    {
        $data = $this->setupKemitraan();
        $admin = $data['admin'];
        $investasi = $data['investasi'];
        $umkm = $data['umkm'];

        $klarifikasi = KlarifikasiDividen::create([
            'id_investasi' => $investasi->id_investasi,
            'id_umkm' => $umkm->id_umkm,
            'bulan_periode' => Carbon::now()->translatedFormat('F Y'),
            'kategori_kendala' => 'omzet_menurun',
            'alasan' => 'Kendala pasokan bahan baku lokal.',
            'komitmen_solusi' => 'Mencari vendor alternatif dan menyetor tanggal 5 depan.',
            'status' => 'menunggu_tinjauan',
        ]);

        $response = $this->actingAs($admin)->post("/super-admin/dividen/klarifikasi/{$klarifikasi->id_klarifikasi}/verifikasi", [
            'status' => 'diverifikasi_admin',
            'catatan_admin' => 'Disetujui. Toleransi diberikan hingga tanggal 5 bulan berikutnya.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $klarifikasi->refresh();
        $this->assertEquals('diverifikasi_admin', $klarifikasi->status);
        $this->assertEquals('Disetujui. Toleransi diberikan hingga tanggal 5 bulan berikutnya.', $klarifikasi->catatan_admin);
    }

    public function test_super_admin_can_toggle_freeze_umkm()
    {
        $data = $this->setupKemitraan();
        $admin = $data['admin'];
        $umkm = $data['umkm'];

        // 1. Bekukan UMKM
        $response = $this->actingAs($admin)->post("/super-admin/dividen/umkm/{$umkm->id_umkm}/toggle-bekukan", [
            'catatan_pembekuan' => 'Keterlambatan berulang tanpa itikad penyelesaian.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $umkm->refresh();
        $this->assertEquals('dibekukan', $umkm->status_kepatuhan_dividen);

        // 2. Pulihkan UMKM
        $response2 = $this->actingAs($admin)->post("/super-admin/dividen/umkm/{$umkm->id_umkm}/toggle-bekukan", [
            'catatan_pembekuan' => 'Penyelesaian komitmen telah disetujui.',
        ]);

        $response2->assertRedirect();
        $umkm->refresh();
        $this->assertEquals('lancar', $umkm->status_kepatuhan_dividen);
    }

    public function test_umkm_dashboard_displays_sp_banner_and_official_warning_details()
    {
        $data = $this->setupKemitraan();
        $umkmUser = $data['umkmUser'];
        $umkm = $data['umkm'];
        $admin = $data['admin'];
        $investasi = $data['investasi'];

        // Terbitkan SP-1 untuk UMKM
        TeguranDividenLog::create([
            'id_investasi' => $investasi->id_investasi,
            'id_umkm' => $umkm->id_umkm,
            'dikirim_oleh' => $admin->id,
            'tingkat_sp' => 'SP-1',
            'pesan_teguran' => 'Bagi hasil dividen bulan ini belum disetorkan tepat waktu.',
        ]);

        $umkm->update([
            'jumlah_teguran_sp' => 1,
            'teguran_sp_terakhir' => Carbon::now(),
        ]);

        // UMKM mengakses dashboard
        $response = $this->actingAs($umkmUser)->get('/dashboard?tab=beranda');
        $response->assertStatus(200);

        // Verifikasi bahwa Banner SP, Modal Surat Peringatan Resmi, dan Log Kepatuhan muncul
        $response->assertSee('SURAT PERINGATAN RESMI: SP-1');
        $response->assertSee('Buka Dokumen Surat Peringatan (SP)');
        $response->assertSee('Riwayat Penerbitan Surat Peringatan (Log Kepatuhan Usaha)');
        $response->assertSee('modal-surat-peringatan-resmi');
    }

    public function test_umkm_dashboard_displays_approved_clarification_banner_and_next_month_dispensasi()
    {
        $data = $this->setupKemitraan();
        $umkmUser = $data['umkmUser'];
        $umkm = $data['umkm'];
        $admin = $data['admin'];
        $investasi = $data['investasi'];

        // Buat klarifikasi yang disetujui admin
        KlarifikasiDividen::create([
            'id_investasi' => $investasi->id_investasi,
            'id_umkm' => $umkm->id_umkm,
            'bulan_periode' => Carbon::now()->translatedFormat('F Y'),
            'kategori_kendala' => 'omzet_menurun',
            'alasan' => 'Ada penundaan pembayaran dari konsumen besar.',
            'komitmen_solusi' => 'Akan disetor penuh pada bulan berikutnya.',
            'status' => 'diverifikasi_admin',
            'catatan_admin' => 'Disetujui. Dispensasi diberikan untuk diselesaikan bulan depan.',
        ]);

        $response = $this->actingAs($umkmUser)->get('/dashboard?tab=beranda');
        $response->assertStatus(200);

        // Verifikasi banner dispensasi disetujui admin tampil
        $response->assertSee('Dispensasi Disetujui Admin');
        $response->assertSee('Kewajiban Dapat Diselesaikan Bulan Depan');
        $response->assertSee('Dispensasi Disetujui (Setor Bulan Depan)');
    }

    public function test_super_admin_can_resolve_and_delete_sp_and_umkm_payment_auto_resolves_sp()
    {
        $data = $this->setupKemitraan();
        $umkmUser = $data['umkmUser'];
        $umkm = $data['umkm'];
        $admin = $data['admin'];
        $investasi = $data['investasi'];

        // 1. Terbitkan SP untuk UMKM
        $sp = TeguranDividenLog::create([
            'id_investasi' => $investasi->id_investasi,
            'id_umkm' => $umkm->id_umkm,
            'dikirim_oleh' => $admin->id,
            'tingkat_sp' => 'SP-1',
            'pesan_teguran' => 'Bagi hasil dividen belum disetorkan.',
            'status' => 'aktif',
        ]);

        $umkm->update([
            'jumlah_teguran_sp' => 1,
            'status_kepatuhan_dividen' => 'peringatan',
        ]);

        // Super Admin melihat SP di halaman dividen
        $viewRes = $this->actingAs($admin)->get('/super-admin/dividen');
        $viewRes->assertStatus(200);
        $viewRes->assertSee('SP-1');
        $viewRes->assertSee('Selesaikan (Lunas)');
        $viewRes->assertSee('Hapus');

        // Super Admin menyelesaikan SP (karena UMKM sudah melunasi)
        $resolveRes = $this->actingAs($admin)->post("/super-admin/dividen/sp/{$sp->id_teguran}/selesai", [
            'catatan' => 'Dividen telah disetorkan dan diverifikasi lunas.',
        ]);
        $resolveRes->assertSessionHas('success');

        $sp->refresh();
        $umkm->refresh();
        $this->assertEquals('selesai', $sp->status);
        $this->assertEquals(0, $umkm->jumlah_teguran_sp);
        $this->assertEquals('lancar', $umkm->status_kepatuhan_dividen);

        // Super Admin menghapus record log SP
        $deleteRes = $this->actingAs($admin)->post("/super-admin/dividen/sp/{$sp->id_teguran}/delete");
        $deleteRes->assertSessionHas('success');
        $this->assertDatabaseMissing('teguran_dividen_log', [
            'id_teguran' => $sp->id_teguran,
        ]);

        // 2. Test Otomatisasi saat UMKM menyetor dividen (storeSetorDividen)
        $sp2 = TeguranDividenLog::create([
            'id_investasi' => $investasi->id_investasi,
            'id_umkm' => $umkm->id_umkm,
            'dikirim_oleh' => $admin->id,
            'tingkat_sp' => 'SP-2',
            'pesan_teguran' => 'Teguran kedua keterlambatan dividen.',
            'status' => 'aktif',
        ]);

        $umkm->update([
            'jumlah_teguran_sp' => 1,
            'status_kepatuhan_dividen' => 'peringatan',
        ]);

        \Illuminate\Support\Facades\Storage::fake('public');
        $file = \Illuminate\Http\UploadedFile::fake()->image('bukti_transfer.jpg');

        $payRes = $this->actingAs($umkmUser)->post('/dashboard/umkm/setor-dividen', [
            'id_investasi' => $investasi->id_investasi,
            'nominal_diterima' => 500000,
            'bukti_transfer' => $file,
            'tanggal_distribusi' => now()->toDateString(),
        ]);

        $payRes->assertSessionHas('success');

        $sp2->refresh();
        $umkm->refresh();
        $this->assertEquals('selesai', $sp2->status);
        $this->assertEquals(0, $umkm->jumlah_teguran_sp);
        $this->assertEquals('lancar', $umkm->status_kepatuhan_dividen);
    }
}

