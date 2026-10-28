<?php

namespace App\Http\Controllers;

use App\Models\InfluencerOrder;
use App\Models\InfluencerProfile;
use App\Models\Investasi;
use App\Models\Produk;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InfluencerController extends Controller
{
    /**
     * Dashboard khusus untuk Role Influencer
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'influencer') {
            return redirect()->route('dashboard');
        }

        $profile = InfluencerProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nama_panggung' => $user->name,
                'kategori' => 'Kuliner',
                'kota' => $user->kota ?? 'Surabaya',
                'provinsi' => $user->provinsi ?? 'Jawa Timur',
                'rate_story' => 50000,
                'rate_reels_tiktok' => 150000,
                'rate_visit_store' => 300000,
                'status_verifikasi' => 'terverifikasi',
                'is_available' => true,
                'saldo' => 0,
            ]
        );

        // Ambil pesanan yang aktif / sedang berjalan
        $activeOrders = InfluencerOrder::with(['umkm', 'investor', 'pemesan', 'produk'])
            ->where('influencer_id', $profile->id)
            ->whereIn('status', ['menunggu_respon_influencer', 'sedang_dikerjakan', 'menunggu_verifikasi'])
            ->latest()
            ->get();

        // Ambil riwayat pesanan selesai / ditolak
        $historyOrders = InfluencerOrder::with(['umkm', 'investor', 'pemesan', 'produk'])
            ->where('influencer_id', $profile->id)
            ->whereIn('status', ['selesai', 'ditolak_influencer', 'dibatalkan'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total_pendapatan' => $profile->saldo,
            'total_selesai' => $profile->total_selesai,
            'pesanan_aktif' => $activeOrders->count(),
            'rating' => $profile->average_rating,
            'total_ulasan' => $profile->total_reviews,
        ];

        return view('dashboard.influencer', compact('user', 'profile', 'activeOrders', 'historyOrders', 'stats'));
    }

    /**
     * Update Profil & Rate Card Influencer
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $profile = InfluencerProfile::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'nama_panggung' => ['required', 'string', 'max:150'],
            'kategori' => ['required', 'string', 'max:50'],
            'kota' => ['required', 'string', 'max:100'],
            'username_instagram' => ['nullable', 'string', 'max:100'],
            'username_tiktok' => ['nullable', 'string', 'max:100'],
            'username_youtube' => ['nullable', 'string', 'max:100'],
            'followers_count' => ['required', 'integer', 'min:0'],
            'rate_story' => ['required', 'numeric', 'min:0'],
            'rate_reels_tiktok' => ['required', 'numeric', 'min:0'],
            'rate_visit_store' => ['required', 'numeric', 'min:0'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'sample_video_url_1' => ['nullable', 'url', 'max:255'],
            'sample_video_url_2' => ['nullable', 'url', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:50'],
            'nomor_rekening' => ['nullable', 'string', 'max:50'],
            'nama_rekening' => ['nullable', 'string', 'max:100'],
            'is_available' => ['nullable'],
        ]);

        $validated['is_available'] = $request->has('is_available');

        $profile->update($validated);

        return back()->with('success', 'Profil dan Rate Card promosi Anda berhasil diperbarui!');
    }

    /**
     * UMKM Menyewa Influencer Secara Mandiri (Bayar Sendiri)
     */
    public function orderMandiriUmkm(Request $request)
    {
        $user = Auth::user();
        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'influencer_id' => ['required', 'exists:influencer_profiles,id'],
            'paket_konten' => ['required', 'in:story,reels_tiktok,visit_store,paket_komplit'],
            'produk_id' => ['nullable', 'exists:produk,id_produk'],
            'nama_campaign' => ['required', 'string', 'max:200'],
            'catatan_brief' => ['required', 'string', 'max:2000'],
            'target_selesai' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $influencer = InfluencerProfile::findOrFail($validated['influencer_id']);

        $biaya = match ($validated['paket_konten']) {
            'story' => $influencer->rate_story,
            'reels_tiktok' => $influencer->rate_reels_tiktok,
            'visit_store' => $influencer->rate_visit_store,
            'paket_komplit' => $influencer->rate_reels_tiktok + $influencer->rate_visit_store,
            default => $influencer->rate_reels_tiktok,
        };

        $kodeOrder = 'INF-' . strtoupper(Str::random(4)) . '-' . date('Ymd');

        InfluencerOrder::create([
            'kode_order' => $kodeOrder,
            'influencer_id' => $influencer->id,
            'umkm_id' => $umkm->id_umkm,
            'investor_id' => null,
            'pemesan_user_id' => $user->id,
            'tipe_inisiatif' => 'mandiri_umkm',
            'paket_konten' => $validated['paket_konten'],
            'biaya' => $biaya,
            'produk_id' => $validated['produk_id'] ?? null,
            'nama_campaign' => $validated['nama_campaign'],
            'catatan_brief' => $validated['catatan_brief'],
            'target_selesai' => $validated['target_selesai'] ?? now()->addDays(7),
            'status' => 'menunggu_respon_influencer',
        ]);

        return back()->with('success', 'Pesanan promosi #' . $kodeOrder . ' senilai Rp ' . number_format($biaya, 0, ',', '.') . ' berhasil diajukan dan sedang menunggu konfirmasi kreator!');
    }

    /**
     * Investor Mensponsori / Mendanai Influencer Langsung untuk UMKM Binaan
     */
    public function sponsorInvestorLangsung(Request $request)
    {
        $investor = Auth::user();

        $validated = $request->validate([
            'umkm_id' => ['required', 'exists:umkm,id_umkm'],
            'influencer_id' => ['required', 'exists:influencer_profiles,id'],
            'paket_konten' => ['required', 'in:story,reels_tiktok,visit_store,paket_komplit'],
            'produk_id' => ['nullable', 'exists:produk,id_produk'],
            'nama_campaign' => ['required', 'string', 'max:200'],
            'catatan_brief' => ['required', 'string', 'max:2000'],
            'target_selesai' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $influencer = InfluencerProfile::findOrFail($validated['influencer_id']);
        $umkm = Umkm::findOrFail($validated['umkm_id']);

        $biaya = match ($validated['paket_konten']) {
            'story' => $influencer->rate_story,
            'reels_tiktok' => $influencer->rate_reels_tiktok,
            'visit_store' => $influencer->rate_visit_store,
            'paket_komplit' => $influencer->rate_reels_tiktok + $influencer->rate_visit_store,
            default => $influencer->rate_reels_tiktok,
        };

        $kodeOrder = 'SPO-' . strtoupper(Str::random(4)) . '-' . date('Ymd');

        InfluencerOrder::create([
            'kode_order' => $kodeOrder,
            'influencer_id' => $influencer->id,
            'umkm_id' => $umkm->id_umkm,
            'investor_id' => $investor->id,
            'pemesan_user_id' => $investor->id,
            'tipe_inisiatif' => 'sponsor_investor_langsung',
            'paket_konten' => $validated['paket_konten'],
            'biaya' => $biaya,
            'produk_id' => $validated['produk_id'] ?? null,
            'nama_campaign' => $validated['nama_campaign'],
            'catatan_brief' => $validated['catatan_brief'] . "\n[Catatan Sponsor Investor: Didanai penuh oleh Mitra Investor " . $investor->name . "]",
            'target_selesai' => $validated['target_selesai'] ?? now()->addDays(7),
            'status' => 'menunggu_respon_influencer',
        ]);

        return back()->with('success', 'Sponsor promosi #' . $kodeOrder . ' senilai Rp ' . number_format($biaya, 0, ',', '.') . ' untuk UMKM ' . $umkm->nama_usaha . ' berhasil disalurkan ke kreator!');
    }

    /**
     * UMKM Mengajukan Permintaan Sponsor Promosi ke Investor Pendana
     */
    public function ajukanSponsorKeInvestor(Request $request)
    {
        $user = Auth::user();
        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'influencer_id' => ['required', 'exists:influencer_profiles,id'],
            'investor_id' => ['required', 'exists:users,id'],
            'paket_konten' => ['required', 'in:story,reels_tiktok,visit_store,paket_komplit'],
            'produk_id' => ['nullable', 'exists:produk,id_produk'],
            'nama_campaign' => ['required', 'string', 'max:200'],
            'catatan_brief' => ['required', 'string', 'max:2000'],
            'target_selesai' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $influencer = InfluencerProfile::findOrFail($validated['influencer_id']);

        $biaya = match ($validated['paket_konten']) {
            'story' => $influencer->rate_story,
            'reels_tiktok' => $influencer->rate_reels_tiktok,
            'visit_store' => $influencer->rate_visit_store,
            'paket_komplit' => $influencer->rate_reels_tiktok + $influencer->rate_visit_store,
            default => $influencer->rate_reels_tiktok,
        };

        $kodeOrder = 'REQ-' . strtoupper(Str::random(4)) . '-' . date('Ymd');

        InfluencerOrder::create([
            'kode_order' => $kodeOrder,
            'influencer_id' => $influencer->id,
            'umkm_id' => $umkm->id_umkm,
            'investor_id' => $validated['investor_id'],
            'pemesan_user_id' => $user->id,
            'tipe_inisiatif' => 'pengajuan_sponsor_umkm',
            'paket_konten' => $validated['paket_konten'],
            'biaya' => $biaya,
            'produk_id' => $validated['produk_id'] ?? null,
            'nama_campaign' => $validated['nama_campaign'],
            'catatan_brief' => $validated['catatan_brief'],
            'target_selesai' => $validated['target_selesai'] ?? now()->addDays(7),
            'status' => 'menunggu_persetujuan_investor',
        ]);

        return back()->with('success', 'Pengajuan sponsor promosi #' . $kodeOrder . ' senilai Rp ' . number_format($biaya, 0, ',', '.') . ' telah dikirim ke Investor Anda untuk disetujui!');
    }

    /**
     * Investor Menyetujui & Mendanai Pengajuan Promosi dari UMKM
     */
    public function setujuiPengajuanInvestor($id)
    {
        $investor = Auth::user();
        $order = InfluencerOrder::where('id', $id)
            ->where('investor_id', $investor->id)
            ->where('status', 'menunggu_persetujuan_investor')
            ->firstOrFail();

        $order->update([
            'status' => 'menunggu_respon_influencer',
        ]);

        return back()->with('success', 'Pengajuan sponsor #' . $order->kode_order . ' senilai Rp ' . number_format($order->biaya, 0, ',', '.') . ' berhasil disetujui dan diteruskan ke kreator!');
    }

    /**
     * Investor Menolak Pengajuan Promosi dari UMKM
     */
    public function tolakPengajuanInvestor(Request $request, $id)
    {
        $investor = Auth::user();
        $order = InfluencerOrder::where('id', $id)
            ->where('investor_id', $investor->id)
            ->where('status', 'menunggu_persetujuan_investor')
            ->firstOrFail();

        $validated = $request->validate([
            'alasan_penolakan' => ['nullable', 'string', 'max:500'],
        ]);

        $order->update([
            'status' => 'ditolak_investor',
            'alasan_penolakan' => $validated['alasan_penolakan'] ?? 'Investor saat ini belum dapat menyetujui pengajuan promosi ini.',
        ]);

        return back()->with('info', 'Pengajuan sponsor promosi #' . $order->kode_order . ' telah ditolak.');
    }

    /**
     * Influencer Menerima Pesanan
     */
    public function terimaOrder($id)
    {
        $user = Auth::user();
        $profile = InfluencerProfile::where('user_id', $user->id)->firstOrFail();

        $order = InfluencerOrder::where('id', $id)
            ->where('influencer_id', $profile->id)
            ->where('status', 'menunggu_respon_influencer')
            ->firstOrFail();

        $order->update([
            'status' => 'sedang_dikerjakan',
        ]);

        return back()->with('success', 'Pesanan #' . $order->kode_order . ' berhasil diterima! Silakan mulai produksi konten sesuai brief.');
    }

    /**
     * Influencer Menolak Pesanan
     */
    public function tolakOrder(Request $request, $id)
    {
        $user = Auth::user();
        $profile = InfluencerProfile::where('user_id', $user->id)->firstOrFail();

        $order = InfluencerOrder::where('id', $id)
            ->where('influencer_id', $profile->id)
            ->where('status', 'menunggu_respon_influencer')
            ->firstOrFail();

        $validated = $request->validate([
            'alasan_penolakan' => ['nullable', 'string', 'max:500'],
        ]);

        $order->update([
            'status' => 'ditolak_influencer',
            'alasan_penolakan' => $validated['alasan_penolakan'] ?? 'Jadwal kreator sedang padat.',
        ]);

        return back()->with('info', 'Pesanan #' . $order->kode_order . ' telah ditolak.');
    }

    /**
     * Influencer Mengunggah Bukti Konten (Link Video & Screenshot Insight)
     */
    public function submitBuktiKonten(Request $request, $id)
    {
        $user = Auth::user();
        $profile = InfluencerProfile::where('user_id', $user->id)->firstOrFail();

        $order = InfluencerOrder::where('id', $id)
            ->where('influencer_id', $profile->id)
            ->whereIn('status', ['sedang_dikerjakan', 'menunggu_verifikasi'])
            ->firstOrFail();

        $validated = $request->validate([
            'link_bukti_konten' => ['required', 'url', 'max:255'],
            'screenshot_insight' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'catatan_influencer' => ['nullable', 'string', 'max:1000'],
        ]);

        $screenshotPath = $order->screenshot_insight;
        if ($request->hasFile('screenshot_insight')) {
            $screenshotPath = $request->file('screenshot_insight')->store('influencer_insights', 'public');
        }

        $order->update([
            'link_bukti_konten' => $validated['link_bukti_konten'],
            'screenshot_insight' => $screenshotPath,
            'catatan_influencer' => $validated['catatan_influencer'] ?? null,
            'status' => 'menunggu_verifikasi',
        ]);

        return back()->with('success', 'Bukti postingan konten berhasil dikirim! Menunggu konfirmasi verifikasi dari pihak pemesan.');
    }

    /**
     * Pemesan (UMKM atau Investor) Menyetujui Konten & Memberi Ulasan/Rating
     */
    public function selesaikanDanBeriUlasan(Request $request, $id)
    {
        $user = Auth::user();

        $order = InfluencerOrder::where('id', $id)
            ->where(function ($q) use ($user) {
                $q->where('pemesan_user_id', $user->id)
                    ->orWhere('investor_id', $user->id);
            })
            ->where('status', 'menunggu_verifikasi')
            ->firstOrFail();

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'ulasan' => ['nullable', 'string', 'max:1000'],
        ]);

        $order->update([
            'status' => 'selesai',
            'rating' => $validated['rating'],
            'ulasan' => $validated['ulasan'] ?? null,
        ]);

        // Cairkan honor ke saldo influencer & tambah counter total selesai
        $influencer = $order->influencer;
        if ($influencer) {
            $influencer->increment('saldo', $order->biaya);
            $influencer->increment('total_selesai');
        }

        return back()->with('success', 'Kampanye promosi #' . $order->kode_order . ' berhasil diselesaikan! Dana Rp ' . number_format($order->biaya, 0, ',', '.') . ' telah dicairkan ke saldo kreator.');
    }

    /**
     * Halaman Publik Pendaftaran Mitra Influencer
     */
    public function showRegistrationForm()
    {
        return view('pages.gabung-influencer');
    }

    /**
     * Proses Pendaftaran Menjadi Mitra Influencer
     */
    public function daftar(Request $request)
    {
        $validated = $request->validate([
            'nama_panggung' => ['required', 'string', 'max:150'],
            'kategori' => ['required', 'string'],
            'instagram_handle' => ['nullable', 'string', 'max:100'],
            'tiktok_handle' => ['nullable', 'string', 'max:100'],
            'jumlah_followers' => ['nullable', 'numeric'],
            'kota' => ['required', 'string', 'max:100'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'rate_story' => ['required', 'numeric', 'min:10000'],
            'rate_reels_tiktok' => ['required', 'numeric', 'min:20000'],
            'rate_visit_store' => ['required', 'numeric', 'min:50000'],
            'bio' => ['required', 'string', 'max:1000'],
            'link_portofolio' => ['nullable', 'string', 'max:255'],
            'foto_profil' => ['nullable', 'image', 'max:4096'],
        ]);

        $user = Auth::user();

        // Jika belum login, buat user baru atau minta login
        if (!$user) {
            $request->validate([
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:6'],
            ]);

            $user = User::create([
                'name' => $validated['nama_panggung'],
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'influencer',
            ]);

            Auth::login($user);
        } else {
            // Ubah role user jadi influencer jika bukan admin
            if ($user->role !== 'admin' && $user->role !== 'super_admin') {
                $user->role = 'influencer';
                $user->save();
            }
        }

        $fotoUrl = null;
        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('influencers', 'public');
            $fotoUrl = '/storage/' . $path;
        }

        $profile = InfluencerProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_panggung' => $validated['nama_panggung'],
                'kategori' => $validated['kategori'],
                'instagram_handle' => $validated['instagram_handle'] ?? null,
                'tiktok_handle' => $validated['tiktok_handle'] ?? null,
                'jumlah_followers' => $validated['jumlah_followers'] ?? 10000,
                'kota' => $validated['kota'],
                'provinsi' => $validated['provinsi'] ?? 'Indonesia',
                'rate_story' => $validated['rate_story'],
                'rate_reels_tiktok' => $validated['rate_reels_tiktok'],
                'rate_visit_store' => $validated['rate_visit_store'],
                'bio' => $validated['bio'],
                'link_portofolio' => $validated['link_portofolio'] ?? null,
                'foto_profil' => $fotoUrl ?? null,
                'status_verifikasi' => 'terverifikasi',
                'is_available' => true,
            ]
        );

        return redirect()->route('dashboard.influencer')->with('success', 'Selamat ' . $profile->nama_panggung . '! Pendaftaran Mitra Influencer Anda telah aktif dan profil Anda langsung tayang di katalog UMKM.');
    }
}
