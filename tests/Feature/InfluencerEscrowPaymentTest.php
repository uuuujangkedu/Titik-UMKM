<?php

namespace Tests\Feature;

use App\Models\InfluencerOrder;
use App\Models\InfluencerProfile;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InfluencerEscrowPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_influencer_escrow_payment_and_completion_flow(): void
    {
        Storage::fake('public');

        // Setup UMKM
        $umkmUser = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
            'name' => 'Owner UMKM Mandiri',
        ]);
        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_usaha' => 'Warung Sambal Mantap',
            'jenis_usaha' => 'Kuliner',
            'pemilik' => 'Pak Bambang',
            'nomor_whatsapp' => '081234567890',
            'status_pengajuan' => 'terverifikasi',
        ]);

        // Setup Influencer
        $infUser = User::factory()->create([
            'role' => 'influencer',
            'status' => 'aktif',
            'name' => 'Rina Foodie',
        ]);
        $profile = InfluencerProfile::create([
            'user_id' => $infUser->id,
            'nama_panggung' => 'Rina Food Vlogger',
            'kategori' => 'Kuliner',
            'kota' => 'Surabaya',
            'rate_story' => 200000,
            'rate_reels_tiktok' => 1000000,
            'rate_visit_store' => 2000000,
            'status_verifikasi' => 'terverifikasi',
            'saldo' => 0,
            'bank_name' => 'BCA',
            'nomor_rekening' => '873918231',
            'nama_rekening' => 'Rina Foodie',
        ]);

        // Buat Order Promosi
        $order = InfluencerOrder::create([
            'kode_order' => 'INF-TEST-20261028',
            'influencer_id' => $profile->id,
            'umkm_id' => $umkm->id_umkm,
            'pemesan_user_id' => $umkmUser->id,
            'tipe_inisiatif' => 'mandiri_umkm',
            'paket_konten' => 'reels_tiktok',
            'biaya' => 1000000,
            'nama_campaign' => 'Review Menu Baru Sambal Mantap',
            'catatan_brief' => 'Video review durasi 60 detik di TikTok.',
            'status' => 'menunggu_respon_influencer',
            'status_pembayaran' => 'belum_bayar',
        ]);

        // 1. Influencer menerima pesanan -> status berubah menjadi menunggu_pembayaran_escrow
        $responseTerima = $this->actingAs($infUser)->post("/dashboard/influencer/order/{$order->id}/terima");
        $responseTerima->assertSessionHas('success');

        $order->refresh();
        $this->assertEquals('menunggu_pembayaran_escrow', $order->status);

        // 2. UMKM mengunggah bukti transfer deposit ke Rekber Escrow
        $fakeStruk = UploadedFile::fake()->image('struk_bca.jpg', 600, 800);
        $responseBayar = $this->actingAs($umkmUser)->post("/dashboard/influencer/order/{$order->id}/bayar-escrow", [
            'bank_pengirim' => 'BCA',
            'nama_pengirim' => 'Bambang Sudirjo',
            'nomor_rekening_pengirim' => '123890123',
            'bukti_transfer' => $fakeStruk,
            'catatan_pembayaran' => 'Transfer deposit rekber Titik-UMKM.',
        ]);
        $responseBayar->assertSessionHas('success');

        $order->refresh();
        $this->assertEquals('lunas_escrow', $order->status_pembayaran);
        $this->assertEquals('sedang_dikerjakan', $order->status);
        $this->assertNotNull($order->bukti_transfer_pemesan);
        $this->assertEquals('BCA', $order->bank_pengirim);

        // 3. Influencer mengunggah bukti konten video
        $responseBukti = $this->actingAs($infUser)->post("/dashboard/influencer/order/{$order->id}/bukti", [
            'link_bukti_konten' => 'https://www.tiktok.com/@rinafoodie/video/1234567890',
            'catatan_influencer' => 'Video telah tayang dan mendapat engagement baik!',
        ]);
        $responseBukti->assertSessionHas('success');

        $order->refresh();
        $this->assertEquals('menunggu_verifikasi', $order->status);

        // 4. UMKM memverifikasi konten & memberikan rating bintang 5
        $responseSelesai = $this->actingAs($umkmUser)->post("/dashboard/influencer/order/{$order->id}/selesai", [
            'rating' => 5,
            'ulasan' => 'Hasil video luar biasa dan pelanggan ramai datang!',
        ]);
        $responseSelesai->assertSessionHas('success');

        $order->refresh();
        $profile->refresh();
        $this->assertEquals('selesai', $order->status);
        $this->assertEquals(5, $order->rating);
        $this->assertEquals(1000000, $profile->saldo);
        $this->assertEquals(1, $profile->total_selesai);
    }

    public function test_investor_direct_sponsor_and_escrow_workflow(): void
    {
        // 1. Setup Investor, UMKM, Influencer
        $investor = User::factory()->create(['role' => 'investor', 'status' => 'aktif', 'name' => 'Investor Sultan']);
        $umkmUser = User::factory()->create(['role' => 'umkm', 'status' => 'aktif', 'name' => 'Pemilik Kedai']);
        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_usaha' => 'Kedai Kopi Mantap',
            'jenis_usaha' => 'Minuman',
            'pemilik' => 'Pak Kopi',
            'nomor_whatsapp' => '081299998888',
            'status_pengajuan' => 'terverifikasi',
        ]);
        $infUser = User::factory()->create(['role' => 'influencer', 'status' => 'aktif', 'name' => 'Dimas Arya']);
        $profile = InfluencerProfile::create([
            'user_id' => $infUser->id,
            'nama_panggung' => 'Dimas Kulineran',
            'kategori' => 'Kuliner',
            'kota' => 'Surabaya',
            'rate_story' => 75000,
            'rate_reels_tiktok' => 200000,
            'rate_visit_store' => 350000,
            'bio' => 'Food Vlogger spesialis UMKM',
            'status_verifikasi' => 'terverifikasi',
            'saldo' => 0,
        ]);

        // 2. Investor mensponsori langsung influencer untuk UMKM
        $responseSponsor = $this->actingAs($investor)->post('/dashboard/investor/influencer/sponsor-langsung', [
            'umkm_id' => $umkm->id_umkm,
            'influencer_id' => $profile->id,
            'paket_konten' => 'visit_store',
            'nama_campaign' => 'Sponsor Liputan Ruko Kopi',
            'catatan_brief' => 'Review menu andalan dan suasana ruko.',
        ]);
        $responseSponsor->assertSessionHas('success');

        $order = InfluencerOrder::where('investor_id', $investor->id)->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('menunggu_respon_influencer', $order->status);
        $this->assertEquals(350000, $order->biaya);

        // 3. Influencer melihat pesanan di dashboardnya dan menerima pesanan
        $infDashboard = $this->actingAs($infUser)->get('/dashboard');
        $infDashboard->assertStatus(200);
        $infDashboard->assertSee('Sponsor Liputan Ruko Kopi');

        $responseTerima = $this->actingAs($infUser)->post("/dashboard/influencer/order/{$order->id}/terima");
        $responseTerima->assertSessionHas('success');

        $order->refresh();
        $this->assertEquals('menunggu_pembayaran_escrow', $order->status);

        // 4. Pastikan pesanan TETAP terlihat di dashboard influencer saat menunggu_pembayaran_escrow
        $infDashboardAfter = $this->actingAs($infUser)->get('/dashboard');
        $infDashboardAfter->assertStatus(200);
        $infDashboardAfter->assertSee('Sponsor Liputan Ruko Kopi');

        // 5. Investor mengunggah bukti transfer escrow
        $file = UploadedFile::fake()->create('struk_investor.png', 300, 'image/png');
        $responseBayar = $this->actingAs($investor)->post("/dashboard/influencer/order/{$order->id}/bayar-escrow", [
            'bank_pengirim' => 'Mandiri',
            'nama_pengirim' => 'Investor Sultan',
            'nomor_rekening_pengirim' => '142001928374',
            'bukti_transfer' => $file,
        ]);
        $responseBayar->assertSessionHas('success');

        $order->refresh();
        $this->assertEquals('lunas_escrow', $order->status_pembayaran);
        $this->assertEquals('sedang_dikerjakan', $order->status);
    }

    public function test_influencer_reviews_modal_and_ratings_are_visible_in_dashboard(): void
    {
        $investor = User::factory()->create([
            'role' => 'investor',
            'status' => 'aktif',
            'kategori_diminati' => 'Kuliner',
            'name' => 'Investor Sultan Test',
        ]);
        $umkmUser = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
            'name' => 'Pemilik Mantap',
        ]);
        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_usaha' => 'Kopi Mantap Jiwa',
            'jenis_usaha' => 'Kuliner',
            'deskripsi' => 'Kedai Kopi Hits',
            'pemilik' => 'Pak Mantap',
            'nomor_whatsapp' => '081234567891',
            'status' => 'diverifikasi_admin',
            'status_pengajuan' => 'terverifikasi',
        ]);

        $infUser = User::factory()->create(['role' => 'influencer']);
        $profile = InfluencerProfile::create([
            'user_id' => $infUser->id,
            'nama_panggung' => 'Zidan Foodie',
            'kategori' => 'Kuliner',
            'kota' => 'Surabaya',
            'provinsi' => 'Jawa Timur',
            'followers_count' => 500000,
            'rate_story' => 100000,
            'rate_reels_tiktok' => 200000,
            'rate_visit_store' => 350000,
            'status_verifikasi' => 'terverifikasi',
            'is_available' => true,
            'saldo' => 0,
            'bio' => 'Food Vlogger Terpercaya',
        ]);

        InfluencerOrder::create([
            'kode_order' => 'INF-REV-001',
            'influencer_id' => $profile->id,
            'umkm_id' => $umkm->id_umkm,
            'pemesan_user_id' => $umkmUser->id,
            'tipe_inisiatif' => 'mandiri_umkm',
            'paket_konten' => 'reels_tiktok',
            'biaya' => 200000,
            'nama_campaign' => 'Review Kopi Mantap',
            'catatan_brief' => 'Brief konten kopi hits',
            'status' => 'selesai',
            'status_pembayaran' => 'lunas_escrow',
            'rating' => 5,
            'ulasan' => 'Pelayanan ramah dan video endorse sangat estetik!',
        ]);

        // Investor melihat ulasan di tab influencer
        $responseInvestor = $this->actingAs($investor)->get('/dashboard?tab=influencer');
        $responseInvestor->assertStatus(200);
        $responseInvestor->assertSee('Zidan Foodie');
        $responseInvestor->assertSee('Review (1)');
        $responseInvestor->assertSee('Pelayanan ramah dan video endorse sangat estetik!');
        $responseInvestor->assertSee('modal-influencer-reviews-list');

        // UMKM melihat ulasan di tab influencer
        $responseUmkm = $this->actingAs($umkmUser)->get('/dashboard?tab=influencer');
        $responseUmkm->assertStatus(200);
        $responseUmkm->assertSee('Zidan Foodie');
        $responseUmkm->assertSee('Review (1)');
        $responseUmkm->assertSee('Pelayanan ramah dan video endorse sangat estetik!');
        $responseUmkm->assertSee('modal-influencer-reviews-list');
    }
}
