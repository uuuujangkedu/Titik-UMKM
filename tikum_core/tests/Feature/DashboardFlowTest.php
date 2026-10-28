<?php

namespace Tests\Feature;

use App\Models\CatatanKeuangan;
use App\Models\Investasi;
use App\Models\Produk;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DashboardFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_umkm_can_view_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
            'name' => 'Pak Budi Usaha',
        ]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Budi Jaya Snack',
            'jenis_usaha' => 'Makanan',
            'pemilik' => 'Pak Budi',
            'nomor_whatsapp' => '08123456789',
            'status_pengajuan' => 'terverifikasi',
        ]);

        // 1. Akses Beranda UMKM
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('BERANDA');
        $response->assertSee('Grafik Penjualan 7 Hari');
    }

    public function test_investor_can_view_proposal_list_and_invest()
    {
        // Setup UMKM dengan proposal terverifikasi
        $umkmUser = User::factory()->create(['role' => 'umkm', 'name' => 'Ibu Siti']);
        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_usaha' => 'Batik Tulis Madura',
            'jenis_usaha' => 'Fashion',
            'pemilik' => 'Ibu Siti',
            'nomor_whatsapp' => '08198765432',
            'modal_dibutuhkan' => 15000000,
            'estimasi_bagi_hasil' => '18%',
            'status_pengajuan' => 'terverifikasi',
        ]);

        // Setup Investor
        $investor = User::factory()->create([
            'role' => 'investor',
            'status' => 'aktif',
            'name' => 'Hartono Investor',
            'kategori_diminati' => 'Semua',
        ]);

        // 1. Investor membuka dashboard
        $response = $this->actingAs($investor)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('BERANDA');

        // 2. Investor membuka PROPOSAL LIST
        $responseProposal = $this->actingAs($investor)->get('/dashboard?tab=proposal');
        $responseProposal->assertStatus(200);
        $responseProposal->assertSee('PROPOSAL LIST');
        $responseProposal->assertSee('Batik Tulis Madura');
        $responseProposal->assertSee('Investasi Sekarang');

        // 3. Investor klik Investasi pada proposal UMKM
        $investResponse = $this->actingAs($investor)->post("/dashboard/investor/invest/{$umkm->id_umkm}", [
            'jumlah_modal' => 5000000,
            'periode_pembagian' => 'Bulanan',
            'persentase_bagi_hasil' => 18,
            'catatan' => 'Tertarik bermitra untuk ekspansi produksi batik.',
        ]);

        $investResponse->assertSessionHas('success');
        $this->assertDatabaseHas('investasi', [
            'id_pengguna' => $investor->id,
            'id_umkm' => $umkm->id_umkm,
            'jumlah_modal' => 5000000,
            'dibaca' => false,
        ]);

        // 4. Pelaku UMKM membuka Dashboard dan melihat NOTIFIKASI investor yang tertarik!
        $responseUmkm = $this->actingAs($umkmUser)->get('/dashboard');
        $responseUmkm->assertStatus(200);
        $responseUmkm->assertSee('Kabar Baik! Ada Investor Tertarik Mendanai Usaha Anda');
        $responseUmkm->assertSee('Hartono Investor');
        $responseUmkm->assertSee('5.000.000');
        $responseUmkm->assertSee('Tertarik bermitra untuk ekspansi produksi batik.');
    }

    public function test_investor_must_wait_for_admin_approval_before_accessing_dashboard()
    {
        // 1. Investor baru selesai mengisi preferensi (status: menunggu_verifikasi)
        $investor = User::factory()->create([
            'role' => 'investor',
            'status' => 'menunggu_verifikasi',
            'name' => 'Calon Investor Baru',
            'kategori_diminati' => 'Makanan',
        ]);

        // 2. Saat mengakses dashboard, dialihkan ke halaman antrean verifikasi
        $response = $this->actingAs($investor)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Akun Mitra Investor Anda Sedang Menunggu Verifikasi & Persetujuan (ACC) Admin', false);
        $response->assertSee('Tahapan Akses Pendanaan Investor');

        // 3. Super Admin menyetujui (ACC) akun investor
        $admin = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'aktif',
        ]);

        $approveResponse = $this->actingAs($admin)->post("/super-admin/users/{$investor->id}/approve");
        $approveResponse->assertSessionHas('success');
        $this->assertEquals('aktif', $investor->fresh()->status);

        // 4. Setelah di-ACC, investor membuka dashboard dan melihat katalog PROPOSAL LIST
        $activeResponse = $this->actingAs($investor->fresh())->get('/dashboard');
        $activeResponse->assertStatus(200);
        $activeResponse->assertSee('BERANDA', false);
        $activeResponse->assertSee('Peluang Investasi Pilihan', false);
    }

    public function test_umkm_can_input_financial_analysis_and_view_profit_loss()
    {
        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
        ]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Kedai Kopi Berkah',
            'jenis_usaha' => 'Makanan',
            'pemilik' => 'Pak Kopi',
            'nomor_whatsapp' => '081233445566',
            'status_pengajuan' => 'terverifikasi',
        ]);

        // Simpan catatan keuangan dengan omzet 20jt, HPP 8jt, Operasional 4jt -> Laba Bersih 8jt (Untung)
        $response = $this->actingAs($user)->post('/dashboard/umkm/keuangan', [
            'bulan_tahun' => 'Oktober 2026',
            'pendapatan' => 20000000,
            'hpp' => 8000000,
            'beban_operasional' => 4000000,
            'beban_lain' => 500000,
            'catatan' => 'Bulan ramai pengunjung bazar.',
        ]);

        $response->assertRedirect('/dashboard?tab=keuangan');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('catatan_keuangan', [
            'id_umkm' => $umkm->id_umkm,
            'bulan_tahun' => 'Oktober 2026',
            'pendapatan' => 20000000,
            'laba_bersih' => 7500000,
            'status_laba' => 'untung',
        ]);

        // Buka tab keuangan
        $viewResponse = $this->actingAs($user)->get('/dashboard?tab=keuangan');
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Analisis Keuangan');
        $viewResponse->assertSee('7.500.000');
        $viewResponse->assertSee('UNTUNG');
    }

    public function test_umkm_can_upload_excel_and_csv_for_financial_analysis()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
        ]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Toko Kelontong Berkah',
            'jenis_usaha' => 'Ritel',
            'pemilik' => 'Pak Ahmad',
            'nomor_whatsapp' => '081233448899',
            'status_pengajuan' => 'terverifikasi',
        ]);

        $excelFile = UploadedFile::fake()->create('laporan_kas_september.xlsx', 150, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $response = $this->actingAs($user)->post('/dashboard/umkm/keuangan', [
            'bulan_tahun' => 'September 2026',
            'pendapatan' => 30000000,
            'hpp' => 18000000,
            'beban_operasional' => 5000000,
            'foto_bukti' => $excelFile,
            'catatan' => 'Laporan lengkap ada di sheet Excel terlampir.',
        ]);

        $response->assertRedirect('/dashboard?tab=keuangan');
        $response->assertSessionHas('success');

        $ck = CatatanKeuangan::where('id_umkm', $umkm->id_umkm)->first();
        $this->assertNotNull($ck);
        $this->assertStringEndsWith('.xlsx', $ck->foto_bukti);

        // Akses view dan pastikan tombol download Excel muncul
        $viewResponse = $this->actingAs($user)->get('/dashboard?tab=keuangan');
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Unduh Excel (.XLSX)');
    }

    public function test_csv_or_excel_auto_detects_income_and_expenses_when_nominal_not_filled()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
        ]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Resto Sedap Rasa',
            'jenis_usaha' => 'Makanan',
            'pemilik' => 'Bu Lina',
            'nomor_whatsapp' => '081299112233',
            'status_pengajuan' => 'terverifikasi',
        ]);

        // Buat file CSV kas dengan kolom Pemasukan & Pengeluaran
        $csvContent = "Tanggal,Keterangan,Pemasukan,Pengeluaran\n".
                      "01/10/2026,Omzet Penjualan Harian,25000000,0\n".
                      "02/10/2026,Belanja Daging & Sayur,0,10000000\n".
                      "03/10/2026,Biaya Listrik & Sewa,0,5000000\n";

        $csvFile = UploadedFile::fake()->createWithContent('buku_kas_oktober.csv', $csvContent);

        // Submit form TANPA mengisi pendapatan secara manual (hanya lampirkan berkas kas)
        $response = $this->actingAs($user)->post('/dashboard/umkm/keuangan', [
            'bulan_tahun' => 'Oktober 2026',
            'foto_bukti' => $csvFile,
            'catatan' => 'Laporan pembukuan kas bulanan.',
        ]);

        $response->assertRedirect('/dashboard?tab=keuangan');
        $response->assertSessionHas('success');

        // Pastikan sistem berhasil mendeteksi pemasukan 25jt dan total beban 15jt -> Laba 10jt (Untung)
        $ck = CatatanKeuangan::where('id_umkm', $umkm->id_umkm)->first();
        $this->assertNotNull($ck);
        $this->assertEquals(25000000, (float) $ck->pendapatan);
        $this->assertEquals(15000000, (float) ($ck->hpp + $ck->beban_operasional + $ck->beban_lain));
        $this->assertEquals(10000000, (float) $ck->laba_bersih);
        $this->assertEquals('untung', $ck->status_laba);
    }

    public function test_sales_receipt_nota_spreadsheet_detects_income_and_computes_profit()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
        ]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Kedai Kopi Senja',
            'jenis_usaha' => 'Minuman',
            'pemilik' => 'Zidan',
            'nomor_whatsapp' => '081234567890',
            'status_pengajuan' => 'terverifikasi',
        ]);

        // Format CSV menyerupai Nota Penjualan kasir
        $notaContent = "No,Nama Barang,Qty,Harga,Subtotal\n".
                       "1,Kopi Arabika Gayo,200,30000,6000000\n".
                       "2,Kopi Robusta Lampung,250,20000,5000000\n".
                       "3,Pastry Croissant,100,40000,4000000\n".
                       "Total,,,,15000000\n";

        $notaFile = UploadedFile::fake()->createWithContent('Nota_Penjualan.csv', $notaContent);

        // User mengisi HPP 6jt, Beban Ops 3.5jt, Beban Lain 500rb, melampirkan Nota_Penjualan.csv tanpa mengisi omzet secara manual
        $response = $this->actingAs($user)->post('/dashboard/umkm/keuangan', [
            'bulan_tahun' => 'Oktober 2026',
            'hpp' => 6000000,
            'beban_operasional' => 3500000,
            'beban_lain' => 500000,
            'foto_bukti' => $notaFile,
            'catatan' => 'Lampiran nota rekapitulasi penjualan.',
        ]);

        $response->assertRedirect('/dashboard?tab=keuangan');
        $response->assertSessionHas('success');

        $ck = CatatanKeuangan::where('id_umkm', $umkm->id_umkm)->first();
        $this->assertNotNull($ck);
        // Pendapatan terdeteksi otomatis 15.000.000 dari nota
        $this->assertEquals(15000000, (float) $ck->pendapatan);
        // Total beban 6jt + 3.5jt + 500rb = 10jt
        $this->assertEquals(10000000, (float) ($ck->hpp + $ck->beban_operasional + $ck->beban_lain));
        // Laba bersih 15jt - 10jt = 5jt (Untung)
        $this->assertEquals(5000000, (float) $ck->laba_bersih);
        $this->assertEquals('untung', $ck->status_laba);
    }

    public function test_actual_nota_penjualan_layout_with_title_and_numbered_items_does_not_sum_no_column()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
        ]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Toko Sembako Berkah',
            'jenis_usaha' => 'Ritel',
            'pemilik' => 'Pak Budi',
            'nomor_whatsapp' => '081299887766',
            'status_pengajuan' => 'terverifikasi',
        ]);

        // Layout persis seperti Nota_Penjualan.xlsx pengguna
        $notaContent = "NAMA USAHA ANDA,,,,,\n".
                       "Alamat usaha · Telp/WA: 08xx-xxxx-xxxx,,,,,\n".
                       "NOTA PENJUALAN,,,,,\n".
                       "No. Nota,,NP-2026-001,,Tanggal,15/10/2026\n".
                       "Pelanggan,,Budi Santoso,,Jatuh Tempo,15/10/2026\n".
                       "No,Nama Barang / Jasa,Qty,Satuan,Harga Satuan (Rp),Diskon (%),Jumlah (Rp)\n".
                       "1,Beras premium 5 kg,2,karung,68000,0,136000\n".
                       "2,Minyak goreng 2 L,3,botol,38000,0.05,108300\n".
                       "3,Gula pasir 1 kg,5,kg,17000,0,85000\n".
                       "Subtotal,,,,,,329300\n".
                       "TOTAL,,,,,,329300\n";

        $file = UploadedFile::fake()->createWithContent('Nota_Penjualan.csv', $notaContent);

        $response = $this->actingAs($user)->post('/dashboard/umkm/keuangan', [
            'bulan_tahun' => 'Oktober 2026',
            'hpp' => 200000,
            'beban_operasional' => 50000,
            'foto_bukti' => $file,
            'catatan' => 'Uji deteksi nota penjualan riil.',
        ]);

        $response->assertRedirect('/dashboard?tab=keuangan');
        $response->assertSessionHas('success');

        $ck = CatatanKeuangan::where('id_umkm', $umkm->id_umkm)->first();
        $this->assertNotNull($ck);
        // Pastikan pendapatan terdeteksi 329.300 (BUKAN 6 dari penjumlahan nomor urut 1+2+3)
        $this->assertEquals(329300, (float) $ck->pendapatan);
        $this->assertNotEquals(6, (float) $ck->pendapatan);
        $this->assertEquals(250000, (float) ($ck->hpp + $ck->beban_operasional));
        $this->assertEquals(79300, (float) $ck->laba_bersih);
        $this->assertEquals('untung', $ck->status_laba);
    }

    public function test_financial_records_in_same_month_can_accumulate_and_total_up()
    {
        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
        ]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Warung Kopi Jaya',
            'jenis_usaha' => 'Minuman',
            'pemilik' => 'Zidan',
            'nomor_whatsapp' => '081234567899',
            'status_pengajuan' => 'terverifikasi',
        ]);

        // Input 1: Omzet 10jt, HPP 2jt, Ops 1jt -> Laba 7jt
        $this->actingAs($user)->post('/dashboard/umkm/keuangan', [
            'bulan_tahun' => 'Oktober 2026',
            'pendapatan' => 10000000,
            'hpp' => 2000000,
            'beban_operasional' => 1000000,
            'mode_aksi' => 'baru',
        ]);

        // Input 2: Transaksi kedua di bulan yang sama dengan mode default 'akumulasi' (Menotalkan)
        // Tambahan omzet 5jt, HPP 1jt, Ops 500rb
        $this->actingAs($user)->post('/dashboard/umkm/keuangan', [
            'bulan_tahun' => 'Oktober 2026',
            'pendapatan' => 5000000,
            'hpp' => 1000000,
            'beban_operasional' => 500000,
            'mode_aksi' => 'akumulasi',
        ]);

        $ck = CatatanKeuangan::where('id_umkm', $umkm->id_umkm)->where('bulan_tahun', 'Oktober 2026')->first();
        $this->assertNotNull($ck);
        // Total omzet tertotalkan: 10jt + 5jt = 15jt
        $this->assertEquals(15000000, (float) $ck->pendapatan);
        // Total HPP tertotalkan: 2jt + 1jt = 3jt
        $this->assertEquals(3000000, (float) $ck->hpp);
        // Total beban tertotalkan: 1jt + 500rb = 1.5jt
        $this->assertEquals(1500000, (float) $ck->beban_operasional);
        // Laba bersih tertotalkan: 15jt - 4.5jt = 10.5jt
        $this->assertEquals(10500000, (float) $ck->laba_bersih);
    }

    public function test_financial_record_can_be_edited_directly()
    {
        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
        ]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Catering Berkah',
            'jenis_usaha' => 'Kuliner',
            'pemilik' => 'Ibu Siti',
            'nomor_whatsapp' => '081234567888',
            'status_pengajuan' => 'terverifikasi',
        ]);

        $ck = CatatanKeuangan::create([
            'id_umkm' => $umkm->id_umkm,
            'bulan_tahun' => 'Oktober 2026',
            'pendapatan' => 8000000,
            'hpp' => 3000000,
            'beban_operasional' => 1000000,
            'beban_lain' => 0,
            'laba_bersih' => 4000000,
            'margin_laba' => 50.0,
            'status_laba' => 'untung',
        ]);

        // Edit catatan ini menggunakan id_keuangan
        $this->actingAs($user)->post('/dashboard/umkm/keuangan', [
            'id_keuangan' => $ck->id_keuangan,
            'bulan_tahun' => 'Oktober 2026',
            'pendapatan' => 12000000,
            'hpp' => 4000000,
            'beban_operasional' => 2000000,
        ]);

        $updated = CatatanKeuangan::find($ck->id_keuangan);
        $this->assertEquals(12000000, (float) $updated->pendapatan);
        $this->assertEquals(6000000, (float) $updated->laba_bersih);
    }

    public function test_multiple_financial_records_in_same_period_can_be_merged()
    {
        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
        ]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Kedai Rasa',
            'jenis_usaha' => 'Kuliner',
            'pemilik' => 'Zidan',
            'nomor_whatsapp' => '081234567877',
            'status_pengajuan' => 'terverifikasi',
        ]);

        // Buat 2 catatan terpisah di bulan Oktober 2026
        CatatanKeuangan::create([
            'id_umkm' => $umkm->id_umkm,
            'bulan_tahun' => 'Oktober 2026',
            'pendapatan' => 10000000,
            'hpp' => 2000000,
            'beban_operasional' => 1000000,
            'beban_lain' => 0,
            'laba_bersih' => 7000000,
            'margin_laba' => 70.0,
            'status_laba' => 'untung',
        ]);

        CatatanKeuangan::create([
            'id_umkm' => $umkm->id_umkm,
            'bulan_tahun' => 'Oktober 2026',
            'pendapatan' => 5000000,
            'hpp' => 1000000,
            'beban_operasional' => 1000000,
            'beban_lain' => 0,
            'laba_bersih' => 3000000,
            'margin_laba' => 60.0,
            'status_laba' => 'untung',
        ]);

        $this->assertEquals(2, CatatanKeuangan::where('id_umkm', $umkm->id_umkm)->where('bulan_tahun', 'Oktober 2026')->count());

        // Jalankan aksi penggabungan
        $response = $this->actingAs($user)->post('/dashboard/umkm/keuangan/gabung', [
            'bulan_tahun' => 'Oktober 2026',
        ]);

        $response->assertRedirect('/dashboard?tab=keuangan');
        $this->assertEquals(1, CatatanKeuangan::where('id_umkm', $umkm->id_umkm)->where('bulan_tahun', 'Oktober 2026')->count());

        $merged = CatatanKeuangan::where('id_umkm', $umkm->id_umkm)->where('bulan_tahun', 'Oktober 2026')->first();
        // Total pendapatan gabungan: 10jt + 5jt = 15jt
        $this->assertEquals(15000000, (float) $merged->pendapatan);
        // Total laba gabungan: 7jt + 3jt = 10jt
        $this->assertEquals(10000000, (float) $merged->laba_bersih);
    }

    public function test_onboarding_pages_are_accessible_and_link_to_registration()
    {
        $responseInvestor = $this->get('/gabung/investor');
        $responseInvestor->assertStatus(200);
        $responseInvestor->assertSee('Gabung Jadi Investor');
        $responseInvestor->assertSee(route('register.investor'));

        $responseUmkm = $this->get('/gabung/umkm');
        $responseUmkm->assertStatus(200);
        $responseUmkm->assertSee('Gabung Jadi Pelaku UMKM');
        $responseUmkm->assertSee(route('register.umkm'));

        // Pastikan halaman Beranda dan navbar mengarah ke halaman edukasi gabung ini
        $responseHome = $this->get('/');
        $responseHome->assertStatus(200);
        $responseHome->assertSee(route('gabung.investor'));
        $responseHome->assertSee(route('gabung.umkm'));
    }
}
