<?php

namespace App\Http\Controllers;

use App\Models\BagiHasilLog;
use App\Models\CatatanKeuangan;
use App\Models\InfluencerOrder;
use App\Models\InfluencerProfile;
use App\Models\Investasi;
use App\Models\KlarifikasiDividen;
use App\Models\PesanInvestasi;
use App\Models\Produk;
use App\Models\RekomendasiRuko;
use App\Models\Ruko;
use App\Models\TeguranDividenLog;
use App\Models\TransaksiSewa;
use App\Models\UlasanUmkm;
use App\Models\Umkm;
use App\Models\User;
use App\Services\ExcelFinancialParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Tampilkan Halaman Dashboard Berdasarkan Peran Pengguna
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Khusus Super Admin & Admin Sistem
        if (in_array($user->role, ['admin', 'super_admin'])) {
            return redirect()->route('superadmin.dashboard');
        }

        // 2. Jika pendaftar investor baru belum mengisi preferensi, arahkan ke Formulir Investor
        if ($user->role === 'investor' && empty($user->kategori_diminati)) {
            return redirect()->route('formulir.investor')->with('info', 'Selamat datang! Silakan lengkapi Formulir Pendaftaran Investor Anda di bawah ini.');
        }

        // 2.5. Khusus Role Influencer / Kreator
        if ($user->role === 'influencer') {
            $profile = InfluencerProfile::where('user_id', $user->id)->first();
            if (! $profile || empty($profile->rate_story) || empty($profile->bio)) {
                return redirect()->route('formulir.influencer')->with('info', 'Selamat datang! Silakan lengkapi Formulir Pendaftaran Mitra Influencer Anda di bawah ini.');
            }

            // JIKA AKUN INFLUENCER BELUM DI-ACC / BELUM AKTIF OLEH ADMIN:
            if ($user->status !== 'aktif' || $profile->status_verifikasi !== 'terverifikasi') {
                return view('dashboard.influencer-pending', compact('user', 'profile'));
            }

            return app(InfluencerController::class)->dashboard($request);
        }

        // 3. DASHBOARD PELAKU UMKM (Sesuai Gambar 2 Mockup)
        if ($user->role === 'umkm') {
            $umkm = Umkm::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_usaha' => 'Usaha '.$user->name,
                    'jenis_usaha' => 'Makanan',
                    'pemilik' => $user->name,
                    'nomor_whatsapp' => $user->phone_number,
                    'provinsi_kota' => $user->provinsi_kota,
                    'kecamatan' => $user->kecamatan,
                    'kelurahan' => $user->kelurahan,
                    'status_pengajuan' => 'draf',
                ]
            );

            // Jika masih draf kosong awal dan tidak sedang membuka tab profil di dashboard, arahkan ke formulir
            if ($request->query('tab') !== 'profil' && $umkm->status_pengajuan === 'draf' && empty($umkm->deskripsi) && empty($umkm->foto_produk) && empty($umkm->modal_dibutuhkan)) {
                return redirect()->route('formulir.umkm')->with('info', 'Selamat datang! Silakan lengkapi formulir pendaftaran profil usaha UMKM Anda.');
            }

            $activeTab = $request->query('tab', 'beranda');
            if ($activeTab === 'produk') {
                $activeTab = 'beranda';
            }

            // Metrik KPI Dashboard UMKM (Sesuai Gambar 2)
            $salesToday = 200000;
            $totalOrders = 80;
            $produksCount = $umkm->produks()->count();
            $totalRevenue = 1930000;

            // Data grafik 7 hari
            $days = [
                'Sen' => 45, 'Sel' => 65, 'Rab' => 30, 'Kam' => 75, 'Jum' => 20, 'Sab' => 90, 'Min' => 55,
            ];

            // Produk Terlaris
            $topProducts = $umkm->produks()->orderByDesc('terjual')->take(3)->get();

            // Produk untuk Tab Produk (dengan filter & search)
            $queryProduk = $umkm->produks();
            if ($request->query('status') && $request->query('status') !== 'semua') {
                $queryProduk->where('status', $request->query('status'));
            }
            if ($request->filled('q')) {
                $queryProduk->where('nama_produk', 'like', '%'.$request->q.'%');
            }
            $allProduks = $queryProduk->latest('id_produk')->get();

            // NOTIFIKASI MINAT INVESTASI MASUK DARI INVESTOR
            $notifikasiInvestasi = Investasi::with('pengguna')
                ->where('id_umkm', $umkm->id_umkm)
                ->latest('tanggal_investasi')
                ->get();
            $unreadInvestasiCount = $notifikasiInvestasi->where('dibaca', false)->count();

            // CATATAN & ANALISIS KEUANGAN (Form Input, Perhitungan Laba/Rugi, Upload Gambar)
            $catatanKeuangan = $umkm->catatanKeuangan()->latest('id_keuangan')->get();
            $latestKeuangan = $catatanKeuangan->first();

            // Total Akumulasi Finansial (Periode Aktif & Keseluruhan Catatan)
            $bulanAktif = $latestKeuangan ? $latestKeuangan->bulan_tahun : date('F Y');
            $catatanBulanAktif = $catatanKeuangan->where('bulan_tahun', $bulanAktif);
            $jumlahCatatanBulanAktif = $catatanBulanAktif->count();

            $totalOmzetBulanAktif = (float) $catatanBulanAktif->sum('pendapatan');
            $totalHppBulanAktif = (float) $catatanBulanAktif->sum('hpp');
            $totalOpsBulanAktif = (float) $catatanBulanAktif->sum('beban_operasional');
            $totalLainBulanAktif = (float) $catatanBulanAktif->sum('beban_lain');
            $totalBebanBulanAktif = $totalHppBulanAktif + $totalOpsBulanAktif + $totalLainBulanAktif;
            $totalLabaBersihBulanAktif = $totalOmzetBulanAktif - $totalBebanBulanAktif;
            $marginLabaBulanAktif = $totalOmzetBulanAktif > 0 ? round(($totalLabaBersihBulanAktif / $totalOmzetBulanAktif) * 100, 2) : 0;
            $statusLabaBulanAktif = $totalLabaBersihBulanAktif > 0 ? 'untung' : ($totalLabaBersihBulanAktif < 0 ? 'rugi' : 'impas');

            $rukoStatusFilter = $request->query('ruko_status', 'semua');
            $rukoQuery = Ruko::with(['penyedia', 'transaksiSewa.umkm']);
            if ($rukoStatusFilter === 'kosong') {
                $rukoQuery->where('status_ketersediaan', 'tersedia')
                    ->whereRaw('(total_unit - unit_terisi) > 0');
            } elseif ($rukoStatusFilter === 'terisi') {
                $rukoQuery->where(function ($q) {
                    $q->where('status_ketersediaan', 'tersewa')
                        ->orWhereRaw('unit_terisi >= total_unit');
                });
            }
            $rukos = $rukoQuery->latest('id_ruko')->get();

            // SINERGI INVESTASI DENGAN INVESTOR (Investasi Aktif & Riwayat Setoran Dividen)
            $investasiAktif = Investasi::with(['pengguna', 'bagiHasilLog', 'klarifikasiDividen', 'teguranDividen'])
                ->where('id_umkm', $umkm->id_umkm)
                ->where('status', 'aktif')
                ->latest('tanggal_investasi')
                ->get();
            $totalModalTerkumpul = (float) $investasiAktif->sum('jumlah_modal');

            // Metrik Milestone Pendanaan & Komunitas Investor UMKM
            $targetModalUmkm = (float) ($umkm->modal_dibutuhkan ?: ($umkm->target_pendanaan ?? 25000000));
            $persentaseMilestone = $targetModalUmkm > 0 ? min(100, round(($totalModalTerkumpul / $targetModalUmkm) * 100, 1)) : ($totalModalTerkumpul > 0 ? 100 : 0);
            $sisaModalDibutuhkan = max(0, $targetModalUmkm - $totalModalTerkumpul);
            $jumlahInvestorAktif = $investasiAktif->pluck('id_pengguna')->unique()->count();
            $totalModalPending = (float) Investasi::where('id_umkm', $umkm->id_umkm)->where('status', 'pending')->sum('jumlah_modal');
            $jumlahInvestorPending = Investasi::where('id_umkm', $umkm->id_umkm)->where('status', 'pending')->distinct('id_pengguna')->count('id_pengguna');

            // Cek apakah ada kewajiban bagi hasil yang memasuki masa tenggang atau menunggak
            $adaDividenTenggangAtauNunggak = $investasiAktif->contains(function ($inv) {
                $statusCode = $inv->status_dividen_bulan_ini['code'] ?? '';

                return in_array($statusCode, ['masa_tenggang', 'menunggak']);
            });

            $semuaInvestasiIds = $umkm->investasi()->pluck('id_investasi');
            $riwayatSetorDividen = BagiHasilLog::with('investasi.pengguna')
                ->whereIn('id_investasi', $semuaInvestasiIds)
                ->latest('tanggal_distribusi')
                ->get();
            $totalDividenDisetor = (float) $riwayatSetorDividen->sum('nominal_diterima');

            // Sewa Ruko yang Disponsori oleh Investor
            $sewaDisponsori = TransaksiSewa::with(['ruko', 'investor'])
                ->where('id_umkm', $umkm->id_umkm)
                ->latest('id_sewa')
                ->get();

            // INBOX & PERCAKAPAN INVESTASI
            $selectedInvestasiId = $request->query('investasi_id');
            $selectedInvestasi = null;
            if ($notifikasiInvestasi->isNotEmpty()) {
                $targetId = $selectedInvestasiId ?: $notifikasiInvestasi->first()->id_investasi;
                $selectedInvestasi = Investasi::with(['pengguna', 'pesanInvestasi.pengirim'])->find($targetId);

                // Jika belum punya pesan, masukkan catatan awal sebagai pesan pertama
                if ($selectedInvestasi && $selectedInvestasi->pesanInvestasi->isEmpty() && ! empty($selectedInvestasi->catatan)) {
                    PesanInvestasi::create([
                        'id_investasi' => $selectedInvestasi->id_investasi,
                        'id_pengirim' => $selectedInvestasi->id_pengguna,
                        'pesan' => $selectedInvestasi->catatan,
                        'created_at' => $selectedInvestasi->tanggal_investasi ?? now(),
                    ]);
                    $selectedInvestasi->load('pesanInvestasi.pengirim');
                }

                if ($activeTab === 'inbox' && $selectedInvestasi && ! $selectedInvestasi->dibaca) {
                    $selectedInvestasi->update(['dibaca' => true]);
                }
            }

            // Ulasan & Rating Kredibilitas dari Mitra Investor
            $ulasanDiterima = UlasanUmkm::with('investor')
                ->where('id_umkm', $umkm->id_umkm)
                ->where('status', 'tayang')
                ->latest('created_at')
                ->get();
            $ratingRataRata = $umkm->rating_rata_rata;
            $totalUlasan = $umkm->total_ulasan;

            // Riwayat & Surat Peringatan (SP) Kepatuhan Dividen untuk UMKM
            $daftarTeguranSp = TeguranDividenLog::with(['investasi.pengguna', 'admin'])
                ->where('id_umkm', $umkm->id_umkm)
                ->latest()
                ->get();
            $teguranSpTerbaru = $daftarTeguranSp->where('status', 'aktif')->first();

            // Laporan Klarifikasi Kendala yang Telah Di-ACC / Disetujui Admin
            $klarifikasiDisetujuiTerbaru = KlarifikasiDividen::with(['investasi.pengguna'])
                ->where('id_umkm', $umkm->id_umkm)
                ->where('status', 'diverifikasi_admin')
                ->latest('updated_at')
                ->first();

            // Marketplace Influencer & Kolaborasi Promosi untuk UMKM
            $influencerList = InfluencerProfile::with(['user', 'reviewedOrders.umkm', 'reviewedOrders.pemesan', 'reviewedOrders.investor'])
                ->where('status_verifikasi', 'terverifikasi')
                ->get();
            $influencerOrdersUmkm = InfluencerOrder::with(['influencer.user', 'investor', 'produk'])
                ->where('umkm_id', $umkm->id_umkm)
                ->latest()
                ->get();
            $investorMitraUmkm = User::whereIn('id', function ($query) use ($umkm) {
                $query->select('id_pengguna')->from('investasi')->where('id_umkm', $umkm->id_umkm)->whereIn('status', ['aktif', 'pending']);
            })->get();

            return view('dashboard.umkm', compact(
                'user',
                'umkm',
                'activeTab',
                'salesToday',
                'totalOrders',
                'produksCount',
                'totalRevenue',
                'days',
                'topProducts',
                'allProduks',
                'notifikasiInvestasi',
                'unreadInvestasiCount',
                'selectedInvestasi',
                'investasiAktif',
                'totalModalTerkumpul',
                'targetModalUmkm',
                'persentaseMilestone',
                'sisaModalDibutuhkan',
                'jumlahInvestorAktif',
                'totalModalPending',
                'jumlahInvestorPending',
                'riwayatSetorDividen',
                'totalDividenDisetor',
                'sewaDisponsori',
                'catatanKeuangan',
                'latestKeuangan',
                'bulanAktif',
                'jumlahCatatanBulanAktif',
                'totalOmzetBulanAktif',
                'totalHppBulanAktif',
                'totalOpsBulanAktif',
                'totalBebanBulanAktif',
                'totalLabaBersihBulanAktif',
                'marginLabaBulanAktif',
                'statusLabaBulanAktif',
                'rukos',
                'rukoStatusFilter',
                'ulasanDiterima',
                'ratingRataRata',
                'totalUlasan',
                'adaDividenTenggangAtauNunggak',
                'daftarTeguranSp',
                'teguranSpTerbaru',
                'klarifikasiDisetujuiTerbaru',
                'influencerList',
                'influencerOrdersUmkm',
                'investorMitraUmkm'
            ));
        }

        // 4. DASHBOARD MITRA INVESTOR (Sesuai Gambar 3 Mockup)
        if ($user->role === 'investor') {
            // JIKA AKUN BELUM DI-ACC / BELUM AKTIF OLEH ADMIN:
            // Tampilkan halaman antrean verifikasi admin (pending)
            if ($user->status !== 'aktif') {
                return view('dashboard.investor-pending', compact('user'));
            }

            $activeTab = $request->query('tab', 'beranda');
            $statusFilter = $request->query('status', 'semua');

            // Riwayat investasi investor saat ini (dengan relasi lengkap)
            $investasiQuery = Investasi::with(['umkm.user', 'umkm.ruko', 'umkm.produks', 'umkm.ulasanUmkm.investor', 'ulasan'])
                ->where('id_pengguna', $user->id);

            // Filter status untuk tab portofolio
            if ($statusFilter !== 'semua' && in_array($statusFilter, ['aktif', 'pending', 'selesai'])) {
                if ($statusFilter === 'aktif') {
                    $investasiQuery->whereIn('status', ['aktif', 'disetujui']);
                } else {
                    $investasiQuery->where('status', $statusFilter);
                }
            }

            $investasiSaya = $investasiQuery->latest('tanggal_investasi')->get();

            // Seluruh investasi modal usaha UMKM
            $semuaInvestasiSaya = Investasi::with(['umkm.user', 'umkm.ruko', 'bagiHasilLog', 'klarifikasiDividen', 'teguranDividen'])
                ->where('id_pengguna', $user->id)
                ->latest('tanggal_investasi')
                ->get();

            // Seluruh komitmen sewa ruko yang disponsori/didanai oleh investor ini
            $sewaDisponsoriSaya = TransaksiSewa::with(['umkm', 'ruko'])
                ->where('id_investor', $user->id)
                ->latest('id_sewa')
                ->get();

            $realTotalModalUsaha = (float) $semuaInvestasiSaya->sum('jumlah_modal');
            $realTotalModalSewa = (float) $sewaDisponsoriSaya->sum('total_harga');
            $totalModalDiinvestasikan = $realTotalModalUsaha + $realTotalModalSewa;
            $realInvestasiCount = $semuaInvestasiSaya->count() + $sewaDisponsoriSaya->count();
            $hasRealInvestments = $totalModalDiinvestasikan > 0;

            // Gabungan mitra UMKM unik yang didanai (baik modal kerja maupun sewa ruko komersial)
            $umkmModalIds = $semuaInvestasiSaya->pluck('id_umkm')->filter()->toArray();
            $umkmSewaIds = $sewaDisponsoriSaya->pluck('id_umkm')->filter()->toArray();
            $allUmkmDidanaiIds = array_unique(array_merge($umkmModalIds, $umkmSewaIds));
            $umkmDidanaiCount = count($allUmkmDidanaiIds);

            $rataRataBagiHasil = $semuaInvestasiSaya->count() > 0
                ? round((float) $semuaInvestasiSaya->avg('persentase_bagi_hasil'), 1)
                : 0.0;

            // Proyeksi dividen bulanan riil (berdasarkan modal usaha aktif)
            $proyeksiDividenBulanIni = ($realTotalModalUsaha > 0 && $rataRataBagiHasil > 0)
                ? round(($realTotalModalUsaha * ($rataRataBagiHasil / 100)) / 12)
                : 0;

            // Perhitungan Alokasi Sektor Riil (Dihitung dari modal usaha + sewa ruko komersial)
            $alokasiSektor = [];
            if ($totalModalDiinvestasikan > 0) {
                $sektorGroups = $semuaInvestasiSaya->groupBy(function ($inv) {
                    return $inv->umkm->jenis_usaha ?? 'Lainnya';
                });

                $colors = ['#0F433C', '#20675D', '#6B9E8A', '#E69F24', '#4F73D9', '#E74C3C'];
                $colorIndex = 0;
                foreach ($sektorGroups as $namaSektor => $groupItems) {
                    $nominalSektor = (float) $groupItems->sum('jumlah_modal');
                    $persenSektor = round(($nominalSektor / $totalModalDiinvestasikan) * 100, 1);
                    $alokasiSektor[] = [
                        'nama' => $namaSektor,
                        'nominal' => $nominalSektor,
                        'persentase' => $persenSektor,
                        'jumlah_proyek' => $groupItems->count(),
                        'color' => $colors[$colorIndex % count($colors)],
                    ];
                    $colorIndex++;
                }

                // Tambahkan sektor Sewa Ruko Komersial jika investor mendanai sewa ruko
                if ($realTotalModalSewa > 0) {
                    $persenSewa = round(($realTotalModalSewa / $totalModalDiinvestasikan) * 100, 1);
                    $alokasiSektor[] = [
                        'nama' => 'Sewa Ruko & Properti',
                        'nominal' => $realTotalModalSewa,
                        'persentase' => $persenSewa,
                        'jumlah_proyek' => $sewaDisponsoriSaya->count(),
                        'color' => '#14B8A6',
                    ];
                }

                usort($alokasiSektor, fn ($a, $b) => $b['persentase'] <=> $a['persentase']);
            }

            // Real Riwayat Bagi Hasil dari Database (Tabel bagi_hasil_log)
            $riwayatBagiHasil = BagiHasilLog::with(['investasi.umkm'])
                ->whereHas('investasi', function ($q) use ($user) {
                    $q->where('id_pengguna', $user->id);
                })->latest('tanggal_distribusi')->get();

            $totalDividenDiterima = (float) $riwayatBagiHasil->sum('nominal_diterima');
            $persentasePengembalianModal = $totalModalDiinvestasikan > 0
                ? min(100, round(($totalDividenDiterima / $totalModalDiinvestasikan) * 100, 1))
                : 0.0;

            // DAFTAR PROPOSAL UMKM (PROPOSAL LIST)
            $queryProposal = Umkm::with(['user', 'ruko', 'produks', 'ulasanUmkm.investor'])
                ->whereIn('status_pengajuan', ['terverifikasi', 'menunggu_verifikasi']);

            if ($request->filled('q')) {
                $search = '%'.$request->q.'%';
                $queryProposal->where(function ($q) use ($search) {
                    $q->where('nama_usaha', 'like', $search)
                        ->orWhere('jenis_usaha', 'like', $search)
                        ->orWhere('pemilik', 'like', $search);
                });
            }

            if ($request->filled('kategori') && $request->kategori !== 'semua') {
                $queryProposal->where('jenis_usaha', $request->kategori);
            }

            $availableProposals = $queryProposal->latest('updated_at')->get();
            $availableProposalsCount = $availableProposals->count();

            // KATALOG RUKO STRATEGIS (Pilar Sewa Komersial UMKM)
            $rukoFilter = $request->query('ruko_status', 'semua');
            $rukoQuery = Ruko::with('penyedia');

            if ($rukoFilter !== 'semua' && in_array($rukoFilter, ['tersedia', 'tersewa'])) {
                $rukoQuery->where('status_ketersediaan', $rukoFilter);
            }

            if ($request->filled('ruko_q')) {
                $rSearch = '%'.$request->ruko_q.'%';
                $rukoQuery->where(function ($rq) use ($rSearch) {
                    $rq->where('nama_ruko', 'like', $rSearch)
                        ->orWhere('lokasi', 'like', $rSearch);
                });
            }

            $semuaRukos = $rukoQuery->latest('id_ruko')->get();
            $rukos = $semuaRukos->where('status_ketersediaan', 'tersedia')->take(6);

            // Rekomendasi Ruko yang diajukan oleh investor ini
            $rekomendasiSaya = RekomendasiRuko::where('id_pengguna', $user->id)
                ->latest('id_rekomendasi')
                ->get();

            // Mitra UMKM terverifikasi untuk tujuan sponsor sewa ruko
            $mitraUmkmTersedia = Umkm::whereIn('status_pengajuan', ['terverifikasi', 'menunggu_verifikasi'])->get();

            // PERCAKAPAN & OBROLAN KEMITRAAN DENGAN UMKM (IN-APP CHAT INVESTOR)
            $investasiSayaWithChat = Investasi::with(['umkm.user', 'pesanInvestasi.pengirim'])
                ->where('id_pengguna', $user->id)
                ->latest('tanggal_investasi')
                ->get();

            $unreadInvestorChatCount = PesanInvestasi::whereHas('investasi', function ($q) use ($user) {
                $q->where('id_pengguna', $user->id);
            })
                ->where('id_pengirim', '!=', $user->id)
                ->where('dibaca', false)
                ->count();

            $selectedChatInvestasiId = $request->query('investasi_id');
            $selectedChatInvestasi = null;
            if ($investasiSayaWithChat->isNotEmpty()) {
                $targetId = $selectedChatInvestasiId ?: $investasiSayaWithChat->first()->id_investasi;
                $selectedChatInvestasi = Investasi::with(['umkm.user', 'pesanInvestasi.pengirim'])->find($targetId);

                // Pastikan catatan awal investor saat mengajukan investasi muncul sebagai pesan pembuka jika belum ada
                if ($selectedChatInvestasi && $selectedChatInvestasi->pesanInvestasi->isEmpty() && ! empty($selectedChatInvestasi->catatan)) {
                    PesanInvestasi::create([
                        'id_investasi' => $selectedChatInvestasi->id_investasi,
                        'id_pengirim' => $selectedChatInvestasi->id_pengguna,
                        'pesan' => $selectedChatInvestasi->catatan,
                        'created_at' => $selectedChatInvestasi->tanggal_investasi ?? now(),
                    ]);
                    $selectedChatInvestasi->load('pesanInvestasi.pengirim');
                }

                // Tandai pesan dari UMKM sebagai dibaca saat investor membuka tab pesan
                if (in_array($activeTab, ['pesan', 'inbox']) && $selectedChatInvestasi) {
                    PesanInvestasi::where('id_investasi', $selectedChatInvestasi->id_investasi)
                        ->where('id_pengirim', '!=', $user->id)
                        ->where('dibaca', false)
                        ->update(['dibaca' => true]);
                }
            }

            // Marketplace Influencer & Program Sponsor Promosi untuk Investor
            $influencerList = InfluencerProfile::with(['user', 'reviewedOrders.umkm', 'reviewedOrders.pemesan', 'reviewedOrders.investor'])
                ->where('status_verifikasi', 'terverifikasi')
                ->get();
            $pengajuanSponsorMasuk = InfluencerOrder::with(['influencer.user', 'umkm', 'produk'])
                ->where('investor_id', $user->id)
                ->where('status', 'menunggu_persetujuan_investor')
                ->latest()
                ->get();
            $sponsorPromosiSaya = InfluencerOrder::with(['influencer.user', 'umkm', 'produk'])
                ->where('investor_id', $user->id)
                ->latest()
                ->get();

            return view('dashboard.investor', compact(
                'user',
                'activeTab',
                'statusFilter',
                'investasiSaya',
                'semuaInvestasiSaya',
                'realInvestasiCount',
                'hasRealInvestments',
                'totalModalDiinvestasikan',
                'realTotalModalUsaha',
                'realTotalModalSewa',
                'umkmDidanaiCount',
                'rataRataBagiHasil',
                'proyeksiDividenBulanIni',
                'alokasiSektor',
                'riwayatBagiHasil',
                'totalDividenDiterima',
                'persentasePengembalianModal',
                'availableProposals',
                'availableProposalsCount',
                'rukos',
                'semuaRukos',
                'rukoFilter',
                'rekomendasiSaya',
                'sewaDisponsoriSaya',
                'mitraUmkmTersedia',
                'investasiSayaWithChat',
                'selectedChatInvestasi',
                'unreadInvestorChatCount',
                'influencerList',
                'pengajuanSponsorMasuk',
                'sponsorPromosiSaya'
            ));
        }

        // Fallback
        return view('dashboard', compact('user'));
    }

    /**
     * Tambah Produk Baru oleh Pelaku UMKM
     */
    public function storeProduk(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,habis',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $validated['id_umkm'] = $umkm->id_umkm;
        $validated['terjual'] = 0;

        Produk::create($validated);

        return redirect()->route('dashboard', ['tab' => 'produk'])->with('success', 'Produk "'.$validated['nama_produk'].'" berhasil ditambahkan!');
    }

    /**
     * Update Produk oleh Pelaku UMKM
     */
    public function updateProduk(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();
        $produk = Produk::where('id_produk', $id)->where('id_umkm', $umkm->id_umkm)->firstOrFail();

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,habis',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk->update($validated);

        return redirect()->route('dashboard', ['tab' => 'produk'])->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Hapus Produk oleh Pelaku UMKM
     */
    public function deleteProduk($id)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();
        $produk = Produk::where('id_produk', $id)->where('id_umkm', $umkm->id_umkm)->firstOrFail();

        $produk->delete();

        return redirect()->route('dashboard', ['tab' => 'produk'])->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Simpan Catatan Keuangan Bulanan UMKM & Hitung Analisis Laba/Rugi Otomatis
     */
    public function storeKeuangan(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'bulan_tahun' => 'required|string|max:50',
            'pendapatan' => 'nullable|numeric|min:0',
            'hpp' => 'nullable|numeric|min:0',
            'beban_operasional' => 'nullable|numeric|min:0',
            'beban_lain' => 'nullable|numeric|min:0',
            'foto_bukti' => 'nullable|file|mimes:xlsx,xls,csv,pdf,doc,docx,jpg,jpeg,png,webp|max:10240',
            'catatan' => 'nullable|string|max:1000',
        ], [
            'bulan_tahun.required' => 'Pilih periode bulan dan tahun pelaporan.',
            'foto_bukti.file' => 'File lampiran harus berupa berkas yang valid.',
            'foto_bukti.mimes' => 'Format file yang didukung: Excel (.xlsx, .xls, .csv), PDF (.pdf), Word (.doc, .docx), atau Gambar (JPG, PNG, WEBP).',
            'foto_bukti.max' => 'Ukuran file lampiran maksimal 10MB.',
        ]);

        $pendapatan = ! empty($validated['pendapatan']) ? (float) $validated['pendapatan'] : 0.0;
        $hpp = (float) ($validated['hpp'] ?? 0);
        $bebanOperasional = (float) ($validated['beban_operasional'] ?? 0);
        $bebanLain = (float) ($validated['beban_lain'] ?? 0);

        $fotoBuktiPath = null;
        $excelDetectionNote = '';

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $ext = strtolower($file->getClientOriginalExtension());
            $fotoBuktiPath = $file->store('keuangan', 'public');

            // DETEKSI OTOMATIS PEMASUKAN & PENGELUARAN DARI EXCEL / CSV
            if (in_array($ext, ['xlsx', 'xls', 'csv'])) {
                $fullPath = Storage::disk('public')->path($fotoBuktiPath);
                if (! file_exists($fullPath) && $file->getRealPath() && file_exists($file->getRealPath())) {
                    $fullPath = $file->getRealPath();
                }
                $parseResult = ExcelFinancialParser::parse($fullPath, $ext);

                if ($parseResult['success']) {
                    if ($pendapatan <= 0 && $parseResult['pendapatan'] > 0) {
                        $pendapatan = $parseResult['pendapatan'];
                    }
                    if ($hpp <= 0 && $parseResult['hpp'] > 0) {
                        $hpp = $parseResult['hpp'];
                    }
                    if ($bebanOperasional <= 0 && $parseResult['beban_operasional'] > 0) {
                        $bebanOperasional = $parseResult['beban_operasional'];
                    }
                    if ($bebanLain <= 0 && $parseResult['beban_lain'] > 0) {
                        $bebanLain = $parseResult['beban_lain'];
                    }

                    $excelDetectionNote = ' (Terdeteksi Otomatis dari Excel: '.$parseResult['message'].')';
                }
            }
        }

        if ($pendapatan <= 0 && ! $request->hasFile('foto_bukti')) {
            return back()->withInput()->withErrors([
                'pendapatan' => 'Nominal pendapatan / omzet wajib diisi, atau lampirkan berkas Excel (.xlsx / .csv) untuk dianalisis otomatis.',
            ]);
        }

        $totalBeban = $hpp + $bebanOperasional + $bebanLain;
        $labaBersih = $pendapatan - $totalBeban;
        $marginLaba = $pendapatan > 0 ? round(($labaBersih / $pendapatan) * 100, 2) : 0;

        if ($labaBersih > 0) {
            $statusLaba = 'untung';
        } elseif ($labaBersih < 0) {
            $statusLaba = 'rugi';
        } else {
            $statusLaba = 'impas';
        }

        // KASUS 1: Edit Catatan Keuangan Spesifik (Jika ada id_keuangan)
        if ($request->filled('id_keuangan')) {
            $keuangan = CatatanKeuangan::where('id_keuangan', $request->id_keuangan)
                ->where('id_umkm', $umkm->id_umkm)
                ->firstOrFail();

            $keuangan->bulan_tahun = $validated['bulan_tahun'];
            $keuangan->pendapatan = $pendapatan;
            $keuangan->hpp = $hpp;
            $keuangan->beban_operasional = $bebanOperasional;
            $keuangan->beban_lain = $bebanLain;
            $keuangan->laba_bersih = $labaBersih;
            $keuangan->margin_laba = $marginLaba;
            $keuangan->status_laba = $statusLaba;
            if ($fotoBuktiPath) {
                $keuangan->foto_bukti = $fotoBuktiPath;
            }
            $keuangan->catatan = ($validated['catatan'] ?? '').$excelDetectionNote;
            $keuangan->save();

            return redirect()->route('dashboard', ['tab' => 'keuangan'])->with('success', 'Catatan keuangan periode '.$validated['bulan_tahun'].' berhasil diperbarui!');
        }

        // KASUS 2: Cek apakah periode bulan ini sudah pernah diinput sebelumnya
        $existing = CatatanKeuangan::where('id_umkm', $umkm->id_umkm)
            ->where('bulan_tahun', $validated['bulan_tahun'])
            ->latest('id_keuangan')
            ->first();

        $modeAksi = $request->input('mode_aksi') ?? $request->input('penanganan_input') ?? 'akumulasi'; // Default: akumulasikan / totalkan

        // Jika data sebelumnya sudah ada dan mode aksi adalah 'akumulasi' (Menotalkan)
        if ($existing && $modeAksi === 'akumulasi') {
            $existing->pendapatan += $pendapatan;
            $existing->hpp += $hpp;
            $existing->beban_operasional += $bebanOperasional;
            $existing->beban_lain += $bebanLain;

            $newTotalBeban = $existing->hpp + $existing->beban_operasional + $existing->beban_lain;
            $newLabaBersih = $existing->pendapatan - $newTotalBeban;
            $newMarginLaba = $existing->pendapatan > 0 ? round(($newLabaBersih / $existing->pendapatan) * 100, 2) : 0;

            $existing->laba_bersih = $newLabaBersih;
            $existing->margin_laba = $newMarginLaba;
            $existing->status_laba = $newLabaBersih > 0 ? 'untung' : ($newLabaBersih < 0 ? 'rugi' : 'impas');

            if ($fotoBuktiPath) {
                $existing->foto_bukti = $fotoBuktiPath;
            }
            $additionalNote = ($validated['catatan'] ?? '').$excelDetectionNote;
            if (! empty($additionalNote)) {
                $existing->catatan = trim(($existing->catatan ? $existing->catatan.' | ' : '').$additionalNote);
            }
            $existing->save();

            return redirect()->route('dashboard', ['tab' => 'keuangan'])->with('success', 'Transaksi baru berhasil ditotalkan & diakumulasikan ke periode '.$validated['bulan_tahun'].'! Total Omzet saat ini: Rp '.number_format($existing->pendapatan, 0, ',', '.').' (Laba Bersih: Rp '.number_format($existing->laba_bersih, 0, ',', '.').').');
        }

        // Jika data sebelumnya ada dan mode aksi adalah 'ganti' / 'ganti_total' (Menimpa total periode)
        if ($existing && ($modeAksi === 'ganti' || $modeAksi === 'ganti_total')) {
            $existing->pendapatan = $pendapatan;
            $existing->hpp = $hpp;
            $existing->beban_operasional = $bebanOperasional;
            $existing->beban_lain = $bebanLain;
            $existing->laba_bersih = $labaBersih;
            $existing->margin_laba = $marginLaba;
            $existing->status_laba = $statusLaba;
            if ($fotoBuktiPath) {
                $existing->foto_bukti = $fotoBuktiPath;
            }
            $existing->catatan = ($validated['catatan'] ?? '').$excelDetectionNote;
            $existing->save();

            return redirect()->route('dashboard', ['tab' => 'keuangan'])->with('success', 'Catatan keuangan periode '.$validated['bulan_tahun'].' berhasil diperbarui (diganti)!');
        }

        // KASUS 3: Buat Catatan Baru
        CatatanKeuangan::create([
            'id_umkm' => $umkm->id_umkm,
            'bulan_tahun' => $validated['bulan_tahun'],
            'pendapatan' => $pendapatan,
            'hpp' => $hpp,
            'beban_operasional' => $bebanOperasional,
            'beban_lain' => $bebanLain,
            'laba_bersih' => $labaBersih,
            'margin_laba' => $marginLaba,
            'status_laba' => $statusLaba,
            'foto_bukti' => $fotoBuktiPath,
            'catatan' => ($validated['catatan'] ?? '').$excelDetectionNote,
        ]);

        $statusMsg = $statusLaba === 'untung'
            ? 'Hasil Analisis: USAHA MENGALAMI KEUNTUNGAN (Laba Bersih Rp '.number_format($labaBersih, 0, ',', '.').' / Margin +'.$marginLaba.'%).'
            : ($statusLaba === 'rugi' ? 'Hasil Analisis: USAHA MENGALAMI DEFISIT/RUGI (Rugi Rp '.number_format(abs($labaBersih), 0, ',', '.').'). Evaluasi pengeluaran operasional Anda.' : 'Hasil Analisis: IMPAS (Break Even Point).');

        return redirect()->route('dashboard', ['tab' => 'keuangan'])->with('success', 'Catatan keuangan periode '.$validated['bulan_tahun'].' berhasil disimpan! '.$statusMsg);
    }

    /**
     * Menggabungkan seluruh catatan transaksi dalam satu periode menjadi 1 total kumulatif
     */
    public function gabungKeuanganPeriode(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }
        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();
        $bulanTahun = $request->input('bulan_tahun');

        $records = CatatanKeuangan::where('id_umkm', $umkm->id_umkm)
            ->where('bulan_tahun', $bulanTahun)
            ->get();

        if ($records->count() > 1) {
            $first = $records->first();
            $totalPendapatan = (float) $records->sum('pendapatan');
            $totalHpp = (float) $records->sum('hpp');
            $totalOps = (float) $records->sum('beban_operasional');
            $totalLain = (float) $records->sum('beban_lain');
            $totalBeban = $totalHpp + $totalOps + $totalLain;
            $labaBersih = $totalPendapatan - $totalBeban;
            $margin = $totalPendapatan > 0 ? round(($labaBersih / $totalPendapatan) * 100, 2) : 0;
            $statusLaba = $labaBersih > 0 ? 'untung' : ($labaBersih < 0 ? 'rugi' : 'impas');

            $fileBukti = $records->pluck('foto_bukti')->filter()->first();

            $first->update([
                'pendapatan' => $totalPendapatan,
                'hpp' => $totalHpp,
                'beban_operasional' => $totalOps,
                'beban_lain' => $totalLain,
                'laba_bersih' => $labaBersih,
                'margin_laba' => $margin,
                'status_laba' => $statusLaba,
                'foto_bukti' => $fileBukti,
                'catatan' => 'Hasil penggabungan total akumulasi dari '.$records->count().' catatan transaksi.',
            ]);

            CatatanKeuangan::where('id_umkm', $umkm->id_umkm)
                ->where('bulan_tahun', $bulanTahun)
                ->where('id_keuangan', '!=', $first->id_keuangan)
                ->delete();

            return redirect()->route('dashboard', ['tab' => 'keuangan'])->with('success', 'Berhasil menggabungkan dan menotalkan seluruh '.$records->count().' catatan transaksi periode '.$bulanTahun.' menjadi satu akumulasi total!');
        }

        return redirect()->route('dashboard', ['tab' => 'keuangan'])->with('info', 'Catatan periode ini sudah menjadi satu.');
    }

    /**
     * Hapus Catatan Keuangan UMKM
     */
    public function deleteKeuangan($id)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();
        $keuangan = CatatanKeuangan::where('id_keuangan', $id)->where('id_umkm', $umkm->id_umkm)->firstOrFail();

        $keuangan->delete();

        return redirect()->route('dashboard', ['tab' => 'keuangan'])->with('success', 'Data catatan keuangan berhasil dihapus.');
    }

    /**
     * Investor mengajukan Minat Investasi pada Proposal UMKM
     * Menghasilkan Notifikasi untuk Pelaku UMKM
     */
    public function investProposal(Request $request, $id_umkm)
    {
        $user = Auth::user();
        if ($user->role !== 'investor') {
            abort(403, 'Hanya mitra investor yang dapat mengajukan investasi.');
        }

        $umkm = Umkm::with('user')->findOrFail($id_umkm);

        $validated = $request->validate([
            'jumlah_modal' => 'required|numeric|min:100000',
            'periode_pembagian' => 'required|string|max:30',
            'persentase_bagi_hasil' => 'nullable|numeric|min:1|max:99',
            'catatan' => 'nullable|string|max:500',
        ]);

        $inv = Investasi::create([
            'id_pengguna' => $user->id,
            'id_umkm' => $umkm->id_umkm,
            'jumlah_modal' => $validated['jumlah_modal'],
            'persentase_bagi_hasil' => $validated['persentase_bagi_hasil'] ?? ($umkm->persentase_bagi_hasil ?: 15.00),
            'periode_pembagian' => $validated['periode_pembagian'],
            'status' => 'pending',
            'catatan' => $validated['catatan'] ?? 'Saya sangat tertarik dengan proposal usaha Anda dan siap berdiskusi untuk menyalurkan modal pendanaan.',
            'dibaca' => false,
            'tanggal_investasi' => now(),
        ]);

        PesanInvestasi::create([
            'id_investasi' => $inv->id_investasi,
            'id_pengirim' => $user->id,
            'pesan' => $inv->catatan,
        ]);

        return back()->with('success', 'Selamat! Pengajuan minat investasi sebesar Rp '.number_format($validated['jumlah_modal'], 0, ',', '.').' pada usaha "'.$umkm->nama_usaha.'" BERHASIL DIKIRIMKAN! Pelaku UMKM telah menerima notifikasi resmi Anda.');
    }

    /**
     * Tandai Notifikasi Minat Investasi telah dibaca oleh Pelaku UMKM
     */
    public function markInvestasiRead($id_investasi)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();
        $inv = Investasi::where('id_investasi', $id_investasi)->where('id_umkm', $umkm->id_umkm)->firstOrFail();

        $inv->update(['dibaca' => true]);

        return back()->with('success', 'Notifikasi telah ditandai dibaca.');
    }

    /**
     * Tampilkan Formulir Pendaftaran Investor (Tahap 2)
     */
    public function showInvestorForm(Request $request)
    {
        $user = Auth::user();
        $umkms = Umkm::latest('id_umkm')->take(8)->get();

        return view('auth.formulir-investor', compact('user', 'umkms'));
    }

    /**
     * Simpan Formulir Pendaftaran Investor (Harus Menunggu ACC Admin)
     */
    public function saveInvestorForm(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'nomor_telepon' => ['required', 'string', 'max:25'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'kota' => ['nullable', 'string', 'max:100'],
            'provinsi_kota' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'kelurahan' => ['nullable', 'string', 'max:100'],
            'rt' => ['nullable', 'string', 'max:10'],
            'rw' => ['nullable', 'string', 'max:10'],
            'kategori_diminati' => ['nullable', 'string', 'max:100'],
            'umkm_diminati' => ['nullable', 'array'],
            'umkm_diminati.*' => ['integer'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $avatarPath = $user->avatar_url;
        if ($request->hasFile('foto_profil')) {
            $avatarPath = $request->file('foto_profil')->store('avatars', 'public');
        }

        $provinsi = $validated['provinsi'] ?? null;
        $kota = $validated['kota'] ?? null;
        $provinsiKota = $validated['provinsi_kota'] ?? (($provinsi && $kota) ? "{$provinsi}, {$kota}" : ($kota ?: ($provinsi ?: $user->provinsi_kota)));

        $user->update([
            'name' => $validated['nama'],
            'phone_number' => $validated['nomor_telepon'],
            'provinsi' => $provinsi ?? $user->provinsi,
            'kota' => $kota ?? $user->kota,
            'provinsi_kota' => $provinsiKota,
            'kecamatan' => $validated['kecamatan'] ?? $user->kecamatan,
            'kelurahan' => $validated['kelurahan'] ?? $user->kelurahan,
            'rt' => $validated['rt'] ?? $user->rt,
            'rw' => $validated['rw'] ?? $user->rw,
            'kategori_diminati' => $validated['kategori_diminati'] ?? 'Semua',
            'avatar_url' => $avatarPath,
            'status' => 'menunggu_verifikasi',
        ]);

        return redirect()->route('dashboard')->with('success', 'Formulir preferensi investor berhasil disimpan! Akun Anda sedang dalam antrean verifikasi & persetujuan (ACC) dari Admin.');
    }

    /**
     * Tampilkan Formulir Pendaftaran Mitra Influencer (Tahap 2)
     */
    public function showInfluencerForm(Request $request)
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
                'rate_story' => 75000,
                'rate_reels_tiktok' => 200000,
                'rate_visit_store' => 350000,
                'status_verifikasi' => 'menunggu_verifikasi',
                'is_available' => false,
                'saldo' => 0,
            ]
        );

        return view('auth.formulir-influencer', compact('user', 'profile'));
    }

    /**
     * Simpan Formulir Pendaftaran Mitra Influencer (Tahap 2)
     */
    public function saveInfluencerForm(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'influencer') {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'nama_panggung' => ['required', 'string', 'max:150'],
            'kategori' => ['required', 'string', 'max:50'],
            'kota' => ['required', 'string', 'max:100'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'instagram_handle' => ['nullable', 'string', 'max:100'],
            'tiktok_handle' => ['nullable', 'string', 'max:100'],
            'jumlah_followers' => ['required', 'numeric', 'min:100'],
            'rate_story' => ['required', 'numeric', 'min:10000'],
            'rate_reels_tiktok' => ['required', 'numeric', 'min:20000'],
            'rate_visit_store' => ['required', 'numeric', 'min:50000'],
            'bio' => ['required', 'string', 'max:1000'],
            'link_portofolio' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:50'],
            'nomor_rekening' => ['nullable', 'string', 'max:50'],
            'nama_rekening' => ['nullable', 'string', 'max:100'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('avatars', 'public');
            $user->update(['avatar_url' => $path]);
        }

        $profile = InfluencerProfile::firstOrCreate(['user_id' => $user->id]);
        $profile->update([
            'nama_panggung' => $validated['nama_panggung'],
            'kategori' => $validated['kategori'],
            'kota' => $validated['kota'],
            'provinsi' => $validated['provinsi'] ?? ($user->provinsi ?? 'Indonesia'),
            'username_instagram' => $validated['instagram_handle'] ?? null,
            'username_tiktok' => $validated['tiktok_handle'] ?? null,
            'followers_count' => $validated['jumlah_followers'],
            'rate_story' => $validated['rate_story'],
            'rate_reels_tiktok' => $validated['rate_reels_tiktok'],
            'rate_visit_store' => $validated['rate_visit_store'],
            'bio' => $validated['bio'],
            'sample_video_url_1' => $validated['link_portofolio'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'nomor_rekening' => $validated['nomor_rekening'] ?? null,
            'nama_rekening' => $validated['nama_rekening'] ?? null,
            'status_verifikasi' => 'menunggu_verifikasi',
            'is_available' => false,
        ]);

        $user->update([
            'status' => 'menunggu_verifikasi',
        ]);

        return redirect()->route('dashboard')->with('success', 'Formulir pendaftaran mitra influencer berhasil disimpan! Akun Anda sedang dalam antrean verifikasi & persetujuan (ACC) dari Admin.');
    }

    /**
     * Tampilkan Formulir Pendaftaran UMKM (Tahap 2)
     */
    public function showUmkmForm(Request $request)
    {
        $user = Auth::user();
        $umkm = Umkm::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nama_usaha' => 'Usaha '.$user->name,
                'jenis_usaha' => 'Makanan',
                'pemilik' => $user->name,
                'nomor_whatsapp' => $user->phone_number,
                'provinsi' => $user->provinsi,
                'kota' => $user->kota,
                'provinsi_kota' => $user->provinsi_kota,
                'kecamatan' => $user->kecamatan,
                'kelurahan' => $user->kelurahan,
                'rt' => $user->rt,
                'rw' => $user->rw,
                'status_pengajuan' => 'draf',
            ]
        );

        $rukos = Ruko::where('status_ketersediaan', 'tersedia')
            ->latest('id_ruko')
            ->get();

        return view('auth.formulir-umkm', compact('user', 'umkm', 'rukos'));
    }

    /**
     * Simpan Draf atau Kirim Pengajuan Usaha UMKM
     */
    public function updatePengajuanUmkm(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'umkm') {
            abort(403, 'Akses khusus pelaku UMKM.');
        }

        $aksi = $request->input('aksi', 'simpan_draf');

        $rules = [
            'nama_usaha' => [$aksi === 'kirim_pengajuan' ? 'required' : 'nullable', 'string', 'max:150'],
            'jenis_usaha' => [$aksi === 'kirim_pengajuan' ? 'required' : 'nullable', 'string', 'max:100'],
            'pemilik' => ['required', 'string', 'max:100'],
            'nik_penanggung_jawab' => ['nullable', 'string', 'max:30'],
            'nomor_whatsapp' => ['required', 'string', 'max:25'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'kota' => ['nullable', 'string', 'max:100'],
            'provinsi_kota' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'kelurahan' => ['nullable', 'string', 'max:100'],
            'rt' => ['nullable', 'string', 'max:10'],
            'rw' => ['nullable', 'string', 'max:10'],
            'modal_dibutuhkan' => ['nullable', 'numeric', 'min:0'],
            'estimasi_bagi_hasil' => ['nullable', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
            'foto_produk' => ['nullable', 'file', 'image', 'max:5120'],
            'file_proposal' => ['nullable', 'file', 'mimes:pdf,doc,docx,zip', 'max:10240'],
            'foto_profil' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'id_ruko_diminati' => ['nullable', 'exists:ruko,id_ruko'],
        ];

        if ($request->has('modal_dibutuhkan') && $request->input('modal_dibutuhkan') !== null) {
            $rawModal = preg_replace('/\D/', '', (string) $request->input('modal_dibutuhkan'));
            $request->merge([
                'modal_dibutuhkan' => $rawModal !== '' ? (int) $rawModal : null,
            ]);
        }

        $validated = $request->validate($rules, [
            'nama_usaha.required' => 'Nama usaha wajib diisi sebelum mengirimkan pengajuan.',
            'jenis_usaha.required' => 'Kategori usaha wajib dipilih.',
            'pemilik.required' => 'Nama pemilik usaha wajib diisi.',
            'nomor_whatsapp.required' => 'Nomor kontak WhatsApp wajib diisi.',
            'foto_produk.image' => 'Foto produk harus berupa file gambar (JPG, PNG, WEBP).',
            'foto_produk.max' => 'Ukuran foto produk maksimal 5MB.',
            'file_proposal.mimes' => 'File proposal harus berformat PDF, DOC, DOCX, atau ZIP.',
            'file_proposal.max' => 'Ukuran file proposal maksimal 10MB.',
            'foto_profil.image' => 'Foto profil harus berupa file gambar (JPG, PNG, WEBP).',
            'foto_profil.max' => 'Ukuran foto profil maksimal 3MB.',
        ]);

        $avatarPath = $user->avatar_url;
        if ($request->hasFile('foto_profil')) {
            $avatarPath = $request->file('foto_profil')->store('avatars', 'public');
        }

        $provinsi = $validated['provinsi'] ?? null;
        $kota = $validated['kota'] ?? null;
        $provinsiKota = $validated['provinsi_kota'] ?? (($provinsi && $kota) ? "{$provinsi}, {$kota}" : ($kota ?: ($provinsi ?: $user->provinsi_kota)));
        $validated['provinsi'] = $provinsi ?? $user->provinsi;
        $validated['kota'] = $kota ?? $user->kota;
        $validated['provinsi_kota'] = $provinsiKota;

        $umkm = Umkm::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nama_usaha' => $validated['nama_usaha'] ?? ('Usaha '.$user->name),
                'jenis_usaha' => $validated['jenis_usaha'] ?? 'Makanan',
                'pemilik' => $validated['pemilik'] ?? $user->name,
                'nomor_whatsapp' => $validated['nomor_whatsapp'] ?? $user->phone_number,
                'provinsi' => $validated['provinsi'],
                'kota' => $validated['kota'],
                'provinsi_kota' => $validated['provinsi_kota'],
                'kecamatan' => $validated['kecamatan'] ?? $user->kecamatan,
                'kelurahan' => $validated['kelurahan'] ?? $user->kelurahan,
                'rt' => $validated['rt'] ?? $user->rt,
                'rw' => $validated['rw'] ?? $user->rw,
                'status_pengajuan' => 'draf',
            ]
        );

        if ($request->hasFile('foto_produk')) {
            $validated['foto_produk'] = $request->file('foto_produk')->store('umkm/produk', 'public');
        }

        if ($request->hasFile('file_proposal')) {
            $validated['file_proposal'] = $request->file('file_proposal')->store('umkm/proposal', 'public');
        }

        if ($aksi === 'kirim_pengajuan') {
            $validated['status_pengajuan'] = 'menunggu_verifikasi';
            $message = 'Pengajuan usaha Anda berhasil dikirimkan! Tim Admin DAYA UMKM akan meninjau berkas Anda dalam 1x24 jam.';
        } else {
            $validated['status_pengajuan'] = 'draf';
            $message = 'Draf formulir usaha Anda berhasil disimpan. Anda dapat melanjutkannya kapan saja.';
        }

        $umkm->update($validated);

        $user->update([
            'name' => $validated['pemilik'],
            'phone_number' => $validated['nomor_whatsapp'],
            'provinsi' => $validated['provinsi'] ?? $user->provinsi,
            'kota' => $validated['kota'] ?? $user->kota,
            'provinsi_kota' => $validated['provinsi_kota'] ?? $user->provinsi_kota,
            'kecamatan' => $validated['kecamatan'] ?? $user->kecamatan,
            'kelurahan' => $validated['kelurahan'] ?? $user->kelurahan,
            'rt' => $validated['rt'] ?? $user->rt,
            'rw' => $validated['rw'] ?? $user->rw,
            'avatar_url' => $avatarPath,
        ]);

        return redirect()->route('dashboard', ['tab' => 'profil'])->with('success', $message);
    }

    /**
     * Memperbarui Data Rekening Bank Mitra Investor untuk Penyaluran Dividen
     */
    public function updateRekeningBank(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'investor') {
            abort(403);
        }

        $validated = $request->validate([
            'bank_name' => 'required|string|max:50',
            'nomor_rekening' => 'required|string|max:50',
            'nama_pemilik_rekening' => 'required|string|max:100',
        ]);

        $user->update($validated);

        return redirect()->route('dashboard', ['tab' => 'keuangan'])
            ->with('success', 'Rekening bank pencairan dividen berhasil disimpan! Dividen bagi hasil Anda berikutnya akan ditransfer ke rekening ini.');
    }

    /**
     * Investor Mengajukan Rekomendasi Ruko Strategis Baru
     */
    public function storeRekomendasiRuko(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'investor') {
            abort(403);
        }

        if ($request->has('harga_sewa_per_bulan')) {
            $rawHarga = preg_replace('/\D/', '', (string) $request->input('harga_sewa_per_bulan'));
            $request->merge([
                'harga_sewa_per_bulan' => $rawHarga !== '' ? (int) $rawHarga : null,
            ]);
        }

        $validated = $request->validate([
            'nama_ruko' => 'required|string|max:100',
            'lokasi' => 'required|string|max:500',
            'harga_sewa_per_bulan' => 'required|numeric|min:100000',
            'total_unit' => 'nullable|integer|min:1|max:50',
            'potensi_usaha' => 'nullable|string|max:500',
            'kontak_pemilik' => 'nullable|string|max:50',
            'siap_danai' => 'nullable|boolean',
            'foto_ruko' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('foto_ruko')) {
            $file = $request->file('foto_ruko');
            $fileName = 'ruko_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/ruko');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $fileName);
            $validated['foto_ruko'] = '/uploads/ruko/'.$fileName;
        }

        $validated['total_unit'] = (int) ($request->input('total_unit', 1) ?: 1);
        $validated['id_pengguna'] = $user->id;
        $validated['nama_pengusul'] = $user->name;
        $validated['kontak_pengusul'] = $user->phone_number ?: $user->email;
        $validated['tipe_pengusul'] = 'investor';
        $validated['siap_danai'] = $request->has('siap_danai');
        $validated['status'] = 'menunggu_verifikasi';

        RekomendasiRuko::create($validated);

        return redirect()->route('dashboard', ['tab' => 'ruko'])
            ->with('success', 'Rekomendasi ruko strategis "'.$validated['nama_ruko'].'" berhasil diajukan! Tim kurator TIKUM akan meninjau lokasi tersebut.');
    }

    /**
     * Pelaku UMKM Mengajukan Rekomendasi Ruko Strategis
     */
    public function storeRekomendasiRukoUmkm(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        if ($request->has('harga_sewa_per_bulan')) {
            $rawHarga = preg_replace('/\D/', '', (string) $request->input('harga_sewa_per_bulan'));
            $request->merge([
                'harga_sewa_per_bulan' => $rawHarga !== '' ? (int) $rawHarga : null,
            ]);
        }

        $validated = $request->validate([
            'nama_ruko' => 'required|string|max:100',
            'lokasi' => 'required|string|max:500',
            'harga_sewa_per_bulan' => 'required|numeric|min:100000',
            'total_unit' => 'nullable|integer|min:1|max:50',
            'potensi_usaha' => 'nullable|string|max:500',
            'kontak_pemilik' => 'nullable|string|max:50',
            'foto_ruko' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('foto_ruko')) {
            $file = $request->file('foto_ruko');
            $fileName = 'ruko_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/ruko');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $fileName);
            $validated['foto_ruko'] = '/uploads/ruko/'.$fileName;
        }

        $validated['total_unit'] = (int) ($request->input('total_unit', 1) ?: 1);
        $validated['id_pengguna'] = $user->id;
        $validated['nama_pengusul'] = $user->name;
        $validated['kontak_pengusul'] = $user->phone_number ?: $user->email;
        $validated['tipe_pengusul'] = 'umkm';
        $validated['siap_danai'] = false;
        $validated['status'] = 'menunggu_verifikasi';

        RekomendasiRuko::create($validated);

        return redirect()->route('dashboard', ['tab' => 'ruko'])
            ->with('success', 'Rekomendasi ruko "'.$validated['nama_ruko'].'" berhasil diajukan! Tim kurator TIKUM akan meninjau kelayakannya untuk katalog UMKM.');
    }

    /**
     * Halaman Publik Pengusulan Ruko (Masyarakat Luar & Pemilik Ruko)
     */
    public function showPublicUsulkanRuko()
    {
        $user = Auth::user();

        return view('pages.usulkan-ruko', compact('user'));
    }

    /**
     * Simpan Pengusulan Ruko dari Halaman Publik (Crowdsourcing Umum)
     */
    public function storePublicUsulkanRuko(Request $request)
    {
        $user = Auth::user();

        if ($request->has('harga_sewa_per_bulan')) {
            $rawHarga = preg_replace('/\D/', '', (string) $request->input('harga_sewa_per_bulan'));
            $request->merge([
                'harga_sewa_per_bulan' => $rawHarga !== '' ? (int) $rawHarga : null,
            ]);
        }

        $validated = $request->validate([
            'nama_pengusul' => 'required|string|max:100',
            'kontak_pengusul' => 'required|string|max:50',
            'nama_ruko' => 'required|string|max:100',
            'lokasi' => 'required|string|max:500',
            'harga_sewa_per_bulan' => 'required|numeric|min:100000',
            'total_unit' => 'nullable|integer|min:1|max:50',
            'potensi_usaha' => 'nullable|string|max:500',
            'kontak_pemilik' => 'nullable|string|max:50',
            'foto_ruko' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('foto_ruko')) {
            $file = $request->file('foto_ruko');
            $fileName = 'ruko_public_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/ruko');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $fileName);
            $validated['foto_ruko'] = '/uploads/ruko/'.$fileName;
        }

        $validated['total_unit'] = (int) ($request->input('total_unit', 1) ?: 1);
        $validated['id_pengguna'] = $user ? $user->id : null;
        $validated['tipe_pengusul'] = $user ? ($user->role === 'investor' ? 'investor' : ($user->role === 'umkm' ? 'umkm' : 'publik')) : 'publik';
        $validated['siap_danai'] = false;
        $validated['status'] = 'menunggu_verifikasi';

        RekomendasiRuko::create($validated);

        return redirect()->route('ruko.usulkan.public')
            ->with('success', 'Terima kasih banyak! Usulan ruko "'.$validated['nama_ruko'].'" telah berhasil diterima. Tim kurator TIKUM akan meninjau kelayakan lokasi tersebut untuk membantu tempat usaha UMKM.');
    }

    /**
     * Investor Mendanai / Mensponsori Biaya Sewa Ruko untuk Mitra UMKM
     */
    public function sponsorSewaRuko(Request $request, $id_ruko)
    {
        $user = Auth::user();
        if ($user->role !== 'investor') {
            abort(403);
        }

        $ruko = Ruko::findOrFail($id_ruko);

        if ($ruko->is_penuh) {
            return back()->with('error', 'Maaf, ruko "'.$ruko->nama_ruko.'" sudah terisi penuh.');
        }

        $validated = $request->validate([
            'id_umkm' => 'required|exists:umkm,id_umkm',
            'durasi_bulan' => 'required|integer|min:1|max:36',
            'catatan_sponsor' => 'nullable|string|max:500',
        ]);

        $durasi = (int) $validated['durasi_bulan'];
        $totalHarga = $ruko->harga_sewa_per_bulan * $durasi;
        $tanggalMulai = now()->toDateString();
        $tanggalSelesai = now()->addMonths($durasi)->toDateString();

        TransaksiSewa::create([
            'id_umkm' => $validated['id_umkm'],
            'id_investor' => $user->id,
            'id_ruko' => $ruko->id_ruko,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'total_harga' => $totalHarga,
            'status_pembayaran' => 'menunggu_konfirmasi',
            'catatan_sponsor' => $validated['catatan_sponsor'] ?? 'Sponsor dana sewa ruko komersial dari mitra investor.',
        ]);

        // Tambah unit terisi dan perbarui status ketersediaan
        $newUnitTerisi = min($ruko->total_unit ?? 1, ($ruko->unit_terisi ?? 0) + 1);
        $newStatus = ($newUnitTerisi >= ($ruko->total_unit ?? 1)) ? 'tersewa' : 'tersedia';
        $ruko->update([
            'unit_terisi' => $newUnitTerisi,
            'status_ketersediaan' => $newStatus,
        ]);

        $umkm = Umkm::find($validated['id_umkm']);

        return redirect()->route('dashboard', ['tab' => 'ruko'])
            ->with('success', 'Komitmen pendanaan sewa ruko "'.$ruko->nama_ruko.'" untuk UMKM "'.($umkm->nama_usaha ?? 'Mitra').'" senilai Rp '.number_format($totalHarga, 0, ',', '.').' berhasil diajukan! Admin akan memfasilitasi serah terima ruko.');
    }

    /**
     * Pelaku UMKM Menyewa Ruko Secara Mandiri (Beli Sewa Langsung)
     */
    public function sewaRukoMandiri(Request $request, $id_ruko)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();
        $ruko = Ruko::findOrFail($id_ruko);

        if ($ruko->is_penuh) {
            return back()->with('error', 'Maaf, ruko "'.$ruko->nama_ruko.'" sudah terisi penuh.');
        }

        $validated = $request->validate([
            'durasi_bulan' => 'required|integer|min:1|max:36',
            'catatan_sewa' => 'nullable|string|max:500',
        ]);

        $durasi = (int) $validated['durasi_bulan'];
        $totalHarga = $ruko->harga_sewa_per_bulan * $durasi;
        $tanggalMulai = now()->toDateString();
        $tanggalSelesai = now()->addMonths($durasi)->toDateString();

        TransaksiSewa::create([
            'id_umkm' => $umkm->id_umkm,
            'id_investor' => null, // Sewa mandiri tanpa investor
            'id_ruko' => $ruko->id_ruko,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'total_harga' => $totalHarga,
            'status_pembayaran' => 'menunggu_konfirmasi',
            'catatan_sponsor' => $validated['catatan_sewa'] ? ('Sewa Mandiri: '.$validated['catatan_sewa']) : 'Sewa mandiri oleh mitra UMKM untuk ekspansi operasional usaha.',
        ]);

        // Tambah unit terisi dan perbarui status ketersediaan
        $newUnitTerisi = min($ruko->total_unit ?? 1, ($ruko->unit_terisi ?? 0) + 1);
        $newStatus = ($newUnitTerisi >= ($ruko->total_unit ?? 1)) ? 'tersewa' : 'tersedia';
        $ruko->update([
            'unit_terisi' => $newUnitTerisi,
            'status_ketersediaan' => $newStatus,
        ]);

        $umkm->update([
            'id_ruko_diminati' => $ruko->id_ruko,
        ]);

        return redirect()->route('dashboard', ['tab' => 'ruko'])
            ->with('success', 'Pengajuan sewa mandiri ruko "'.$ruko->nama_ruko.'" untuk durasi '.$durasi.' bulan senilai Rp '.number_format($totalHarga, 0, ',', '.').' BERHASIL DIAJUKAN! Admin akan memverifikasi dan memfasilitasi serah terima ruko.');
    }

    /**
     * UMKM Menerima Komitmen Investasi dari Calon Investor
     */
    public function terimaInvestasi($id)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();
        $investasi = Investasi::with('pengguna')->where('id_umkm', $umkm->id_umkm)->findOrFail($id);

        $investasi->status = 'aktif';
        $investasi->dibaca = true;
        $investasi->save();

        return back()->with('success', 'Komitmen investasi modal sebesar Rp '.number_format($investasi->jumlah_modal, 0, ',', '.').' dari '.($investasi->pengguna->name ?? 'Investor').' BERHASIL DITERIMA! Kemitraan kini resmi berjalan (Status: Aktif).');
    }

    /**
     * UMKM Menolak Komitmen Investasi
     */
    public function tolakInvestasi($id)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();
        $investasi = Investasi::where('id_umkm', $umkm->id_umkm)->findOrFail($id);

        $investasi->status = 'ditolak';
        $investasi->dibaca = true;
        $investasi->save();

        return back()->with('info', 'Pengajuan minat investasi telah ditolak.');
    }

    /**
     * UMKM Menyetorkan Dividen Bagi Hasil Riil ke Rekening Investor
     */
    public function storeSetorDividen(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'id_investasi' => 'required|exists:investasi,id_investasi',
            'nominal_diterima' => 'required|numeric|min:10000',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tanggal_distribusi' => 'nullable|date',
        ]);

        $investasi = Investasi::with('pengguna')->where('id_umkm', $umkm->id_umkm)->findOrFail($validated['id_investasi']);

        // Upload bukti transfer
        $file = $request->file('bukti_transfer');
        $fileName = 'struk_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $destinationPath = public_path('uploads/bukti_transfer');
        if (! file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $file->move($destinationPath, $fileName);
        $filePath = '/uploads/bukti_transfer/'.$fileName;

        BagiHasilLog::create([
            'id_investasi' => $investasi->id_investasi,
            'tanggal_distribusi' => $validated['tanggal_distribusi'] ? $validated['tanggal_distribusi'] : now(),
            'nominal_diterima' => $validated['nominal_diterima'],
            'bukti_transfer' => $filePath,
        ]);

        // Otomatis selesaikan Surat Peringatan (SP) aktif jika ada untuk kemitraan ini
        if (Schema::hasColumn('teguran_dividen_log', 'status')) {
            $activeSps = TeguranDividenLog::where('id_investasi', $investasi->id_investasi)
                ->where('status', 'aktif')
                ->get();

            foreach ($activeSps as $sp) {
                $sp->update([
                    'status' => 'selesai',
                    'catatan_penyelesaian' => 'Kewajiban dividen bagi hasil telah disetorkan oleh UMKM sebesar Rp '.number_format($validated['nominal_diterima'], 0, ',', '.').' pada '.now()->translatedFormat('d F Y, H:i').' WIB.',
                    'diselesaikan_pada' => now(),
                ]);
            }

            $sisaAktif = TeguranDividenLog::where('id_umkm', $umkm->id_umkm)
                ->where('status', 'aktif')
                ->count();

            $umkm->jumlah_teguran_sp = $sisaAktif;
            if ($sisaAktif === 0) {
                $umkm->status_kepatuhan_dividen = 'lancar';
            }
            $umkm->save();
        } else {
            $umkm->status_kepatuhan_dividen = 'lancar';
            $umkm->save();
        }

        $investorName = $investasi->pengguna->name ?? 'Investor';
        $bankName = $investasi->pengguna->bank_name ?? 'Bank Tujuan';
        $rek = $investasi->pengguna->nomor_rekening ?? '-';

        return back()->with('success', 'Bagi hasil dividen sebesar Rp '.number_format($validated['nominal_diterima'], 0, ',', '.').' berhasil disetorkan ke rekening '.$bankName.' ('.$rek.') milik '.$investorName.'! Struk transfer otomatis tercatat dan Surat Peringatan (jika ada) otomatis terselesaikan.');
    }

    /**
     * Ajukan Klarifikasi Penundaan Dividen Akibat Kendala Usaha oleh Pelaku UMKM
     */
    public function storeKlarifikasiDividen(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'id_investasi' => 'required|exists:investasi,id_investasi',
            'bulan_periode' => 'required|string|max:50',
            'kategori_kendala' => 'required|string|in:omzet_menurun,beban_operasional,piutang_tertunda,force_majeure,lainnya',
            'alasan' => 'required|string|min:10|max:3000',
            'komitmen_solusi' => 'required|string|min:10|max:2000',
            'lampiran_bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf,xlsx,csv|max:5120',
        ]);

        $investasi = Investasi::with('pengguna')->where('id_umkm', $umkm->id_umkm)->findOrFail($validated['id_investasi']);

        $filePath = null;
        if ($request->hasFile('lampiran_bukti')) {
            $file = $request->file('lampiran_bukti');
            $fileName = 'klarifikasi_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $dest = public_path('uploads/klarifikasi_dividen');
            if (! file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file->move($dest, $fileName);
            $filePath = '/uploads/klarifikasi_dividen/'.$fileName;
        }

        $klarifikasi = KlarifikasiDividen::create([
            'id_investasi' => $investasi->id_investasi,
            'id_umkm' => $umkm->id_umkm,
            'bulan_periode' => $validated['bulan_periode'],
            'kategori_kendala' => $validated['kategori_kendala'],
            'alasan' => $validated['alasan'],
            'komitmen_solusi' => $validated['komitmen_solusi'],
            'lampiran_bukti' => $filePath,
            'status' => 'menunggu_tinjauan',
        ]);

        // Kirim otomatis notifikasi klarifikasi resmi ke percakapan investor
        $investorName = $investasi->pengguna->name ?? 'Mitra Investor';
        PesanInvestasi::create([
            'id_investasi' => $investasi->id_investasi,
            'id_pengirim' => $user->id,
            'pesan' => "📢 [Pemberitahuan Resmi Penundaan Bagi Hasil - {$validated['bulan_periode']}]\n"
                ."Halo {$investorName}, kami mengajukan klarifikasi resmi penundaan bagi hasil dividen untuk periode {$validated['bulan_periode']} dikarenakan kendala: {$klarifikasi->kategori_label}.\n\n"
                ."Detail Kendala: {$validated['alasan']}\n\n"
                ."Komitmen & Rencana Pemulihan: {$validated['komitmen_solusi']}\n\n"
                .'Status penundaan ini tercatat transparan di platform DAYA-UMKM untuk ditinjau bersama.',
            'dibaca' => false,
        ]);

        return back()->with('success', 'Klarifikasi kendala usaha periode '.$validated['bulan_periode'].' berhasil dikirim dan dicatat transparan ke Mitra Investor.');
    }

    /**
     * Kirim Pesan Diskusi Langsung (In-App Chat) Antara Investor dan UMKM
     */
    public function kirimPesanInvestasi(Request $request, $id)
    {
        $user = Auth::user();
        $investasi = Investasi::with('umkm')->findOrFail($id);

        $isInvestor = ($investasi->id_pengguna === $user->id);
        $isUmkmOwner = ($investasi->umkm && $investasi->umkm->user_id === $user->id);

        if (! $isInvestor && ! $isUmkmOwner) {
            abort(403, 'Anda tidak memiliki hak akses percakapan ini.');
        }

        $validated = $request->validate([
            'pesan' => 'required|string|max:2000',
        ]);

        PesanInvestasi::create([
            'id_investasi' => $investasi->id_investasi,
            'id_pengirim' => $user->id,
            'pesan' => $validated['pesan'],
            'dibaca' => false,
        ]);

        return back()->with('success', 'Pesan diskusi berhasil dikirim!');
    }

    /**
     * Investor Menyimpan Rating & Ulasan Kredibilitas untuk Mitra UMKM
     */
    public function storeUlasanUmkm(Request $request, $id_investasi)
    {
        $user = Auth::user();
        if ($user->role !== 'investor') {
            abort(403);
        }

        $investasi = Investasi::with('umkm')->where('id_pengguna', $user->id)->findOrFail($id_investasi);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'rating_transparansi' => 'nullable|integer|min:1|max:5',
            'rating_dividen' => 'nullable|integer|min:1|max:5',
            'ulasan' => 'required|string|min:5|max:1000',
        ]);

        UlasanUmkm::updateOrCreate(
            ['id_investasi' => $investasi->id_investasi],
            [
                'id_umkm' => $investasi->id_umkm,
                'id_investor' => $user->id,
                'rating' => (int) $validated['rating'],
                'rating_transparansi' => (int) ($validated['rating_transparansi'] ?? $validated['rating']),
                'rating_dividen' => (int) ($validated['rating_dividen'] ?? $validated['rating']),
                'ulasan' => $validated['ulasan'],
                'status' => 'tayang',
            ]
        );

        return back()->with('success', 'Terima kasih! Ulasan & rating kepuasan Anda untuk mitra UMKM "'.($investasi->umkm->nama_usaha ?? 'Mitra').'" berhasil disimpan dan kini tayang membantu sesama investor.');
    }

    /**
     * Pelaku UMKM Memberi Balasan / Apresiasi atas Ulasan Investor
     */
    public function storeBalasanUlasanUmkm(Request $request, $id_ulasan)
    {
        $user = Auth::user();
        if ($user->role !== 'umkm') {
            abort(403);
        }

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();
        $ulasan = UlasanUmkm::where('id_umkm', $umkm->id_umkm)->findOrFail($id_ulasan);

        $validated = $request->validate([
            'balasan_umkm' => 'required|string|min:3|max:1000',
        ]);

        $ulasan->update([
            'balasan_umkm' => $validated['balasan_umkm'],
            'tanggal_balasan' => now(),
        ]);

        return back()->with('success', 'Balasan apresiasi/tanggapan Anda atas ulasan investor berhasil dipublikasikan!');
    }

    /**
     * Memperbarui Foto Profil Pengguna dari Dashboard
     */
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'foto_profil' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'foto_profil.required' => 'Silakan pilih file foto profil terlebih dahulu.',
            'foto_profil.image' => 'File harus berupa gambar (JPG, PNG, WEBP).',
            'foto_profil.mimes' => 'Format file yang didukung: JPG, JPEG, PNG, WEBP.',
            'foto_profil.max' => 'Ukuran foto maksimal 5MB.',
        ]);

        $user = User::findOrFail(Auth::id());

        if ($request->hasFile('foto_profil')) {
            if ($user->avatar_url && ! str_starts_with($user->avatar_url, 'http') && Storage::disk('public')->exists($user->avatar_url)) {
                Storage::disk('public')->delete($user->avatar_url);
            }

            $path = $request->file('foto_profil')->store('avatars', 'public');
            $user->avatar_url = $path;
            $user->save();
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diperbarui!',
                'avatar_url' => $user->avatar,
            ]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Unduh / Akses Berkas Proposal UMKM dengan Penanganan Error Aman
     */
    public function downloadProposal($id)
    {
        $umkm = Umkm::findOrFail($id);
        $path = $umkm->file_proposal;

        if (! $path || ! Storage::disk('public')->exists($path)) {
            return back()->with('error', 'Berkas fisik proposal belum diunggah atau tidak ditemukan di penyimpanan server.');
        }

        return Storage::disk('public')->response($path, basename($path));
    }
}
