<?php

namespace Tests\Feature;

use App\Models\Investasi;
use App\Models\PenyediaRuko;
use App\Models\Ruko;
use App\Models\UlasanUmkm;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProposalAndRukoRatingTest extends TestCase
{
    use RefreshDatabase;

    public function test_investor_dashboard_displays_ratings_for_proposals_and_rukos(): void
    {
        $investor = User::factory()->create([
            'role' => 'investor',
            'status' => 'aktif',
            'kategori_diminati' => 'Kuliner',
        ]);

        $umkmUser = User::factory()->create(['role' => 'umkm', 'status' => 'aktif']);

        $umkmWithReview = Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_usaha' => 'Kopi Mantap Jiwa',
            'jenis_usaha' => 'Kuliner',
            'pemilik' => 'Pak Budi',
            'status_pengajuan' => 'terverifikasi',
            'modal_dibutuhkan' => 20000000,
        ]);

        $umkmNew = Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_usaha' => 'Batik Asri Mulia',
            'jenis_usaha' => 'Fashion',
            'pemilik' => 'Bu Asri',
            'status_pengajuan' => 'terverifikasi',
            'modal_dibutuhkan' => 15000000,
        ]);

        $investasi = Investasi::create([
            'id_umkm' => $umkmWithReview->id_umkm,
            'id_pengguna' => $investor->id,
            'jumlah_modal' => 5000000,
            'persentase_bagi_hasil' => 15,
            'periode_pembagian' => 'Bulanan',
            'status' => 'selesai',
            'tanggal_investasi' => now(),
        ]);

        UlasanUmkm::create([
            'id_umkm' => $umkmWithReview->id_umkm,
            'id_investasi' => $investasi->id_investasi,
            'id_investor' => $investor->id,
            'rating' => 5,
            'rating_transparansi' => 5,
            'rating_dividen' => 5,
            'ulasan' => 'Usaha sangat transparan dan amanah.',
            'status' => 'tayang',
        ]);

        $penyedia = PenyediaRuko::create([
            'nama_perusahaan' => 'PT Properti Mandiri',
            'kontak' => '08123456789',
            'alamat' => 'Jl. Margonda Raya No. 1, Depok',
        ]);

        $ruko = Ruko::create([
            'id_penyedia' => $penyedia->id_penyedia,
            'nama_ruko' => 'Ruko Margonda Raya No. 1',
            'lokasi' => 'Depok, Jawa Barat',
            'harga_sewa_per_bulan' => 3500000,
            'total_unit' => 2,
            'unit_terisi' => 0,
            'status_ketersediaan' => 'tersedia',
        ]);

        $response = $this->actingAs($investor)->get('/dashboard');

        $response->assertStatus(200);
        // Rating proposal with reviews
        $response->assertSee('5.0');
        $response->assertSee('1 ulasan');
        $response->assertSee('openReviewsModal');
        // Proposal without reviews shows clear badge
        $response->assertSee('Mitra Baru (Belum ada ulasan)');
        // Ruko card shows Skor Lokasi / Rating
        $response->assertSee('Skor Lokasi');
        $response->assertSee('Terkurasi TIKUM');
        $response->assertSee(number_format($ruko->rating_lokasi, 1));
    }
}
