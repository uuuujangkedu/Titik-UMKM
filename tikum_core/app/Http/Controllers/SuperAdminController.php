<?php

namespace App\Http\Controllers;

use App\Models\Investasi;
use App\Models\KlarifikasiDividen;
use App\Models\LogAktivitasAdmin;
use App\Models\PenyediaRuko;
use App\Models\PesanInvestasi;
use App\Models\RekomendasiRuko;
use App\Models\Ruko;
use App\Models\TeguranDividenLog;
use App\Models\TransaksiSewa;
use App\Models\Umkm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SuperAdminController extends Controller
{
    /**
     * Pastikan pengguna memiliki role admin atau super_admin
     */
    private function checkAdminAccess()
    {
        $user = Auth::user();
        if (! $user || ! in_array($user->role, ['admin', 'super_admin'])) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Administrator.');
        }
    }

    /**
     * Pastikan HANYA role super_admin yang dapat mengakses fitur ini
     */
    private function checkSuperAdminOnly()
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'super_admin') {
            abort(403, 'Akses ditolak. Fitur ini merupakan hak khusus Super Administrator.');
        }
    }

    private function checkSuperAdmin()
    {
        $this->checkAdminAccess();
    }

    /**
     * Helper untuk mengambil data sesi pengguna yang sedang aktif (Online)
     */
    private function getOnlineUsersData()
    {
        $onlineThreshold = Carbon::now()->subMinutes(15)->timestamp;

        if (! Schema::hasTable('sessions')) {
            return collect();
        }

        $sessions = DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('last_activity', '>=', $onlineThreshold)
            ->get();

        $userIds = $sessions->pluck('user_id')->unique();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        return $sessions->map(function ($s) use ($users) {
            $u = $users->get($s->user_id);

            return [
                'session_id' => $s->id,
                'user_id' => $s->user_id,
                'name' => $u ? $u->name : 'Pengguna #'.$s->user_id,
                'email' => $u ? $u->email : '-',
                'role' => $u ? $u->role : 'unknown',
                'ip_address' => $s->ip_address ?? '127.0.0.1',
                'user_agent' => $s->user_agent ?? 'Unknown Browser',
                'last_activity' => Carbon::createFromTimestamp($s->last_activity),
            ];
        });
    }

    /**
     * 1. Halaman Beranda / Overview Dashboard Super Admin
     */
    public function dashboard()
    {
        $this->checkSuperAdmin();
        $user = Auth::user();

        // 1. Metrik Akun & Pengguna
        $totalUsers = User::count();
        $totalInvestors = User::where('role', 'investor')->count();
        $totalUmkmUsers = User::where('role', 'umkm')->count();
        $totalAdmins = User::whereIn('role', ['admin', 'super_admin'])->count();

        // 2. Metrik Pengajuan UMKM & Proposal
        $pendingProposalsCount = Umkm::where('status_pengajuan', 'menunggu_verifikasi')->count();
        $verifiedUmkmCount = Umkm::where('status_pengajuan', 'terverifikasi')->count();
        $rejectedUmkmCount = Umkm::where('status_pengajuan', 'ditolak')->count();

        // 3. Metrik Sesi Online Realtime
        $onlineUsers = $this->getOnlineUsersData();
        $onlineUsersCount = $onlineUsers->pluck('user_id')->unique()->count();
        if ($onlineUsersCount === 0 && Auth::check()) {
            $onlineUsersCount = 1; // Minimal user yang sedang melihat dashboard
        }

        // 4. Data 7 Hari Terakhir untuk Grafik Batang (Sesuai Mockup Sen - Min)
        $days = [
            'Sen' => 0, 'Sel' => 0, 'Rab' => 0, 'Kam' => 0, 'Jum' => 0, 'Sab' => 0, 'Min' => 0,
        ];

        $dayMap = [
            1 => 'Sen', 2 => 'Sel', 3 => 'Rab', 4 => 'Kam', 5 => 'Jum', 6 => 'Sab', 0 => 'Min',
        ];

        // Hitung registrasi / aktivitas dalam 7 hari terakhir
        $recentUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))->get();
        foreach ($recentUsers as $ru) {
            $dow = $ru->created_at->dayOfWeek;
            $name = $dayMap[$dow] ?? 'Sen';
            $days[$name] = ($days[$name] ?? 0) + 1;
        }

        // Jika data baru sedikit, beri baseline visual agar chart tampak hidup sesuai mockup
        $sampleHeights = ['Sen' => 45, 'Sel' => 65, 'Rab' => 30, 'Kam' => 75, 'Jum' => 20, 'Sab' => 90, 'Min' => 55];
        foreach ($days as $k => $v) {
            if ($v === 0) {
                $days[$k] = $sampleHeights[$k];
            } else {
                $days[$k] = min(100, $v * 25 + 20);
            }
        }

        // 5. 5 Pengajuan Proposal Terbaru
        $recentPengajuan = Umkm::with('user', 'ruko')
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('super-admin.dashboard', compact(
            'user',
            'totalUsers',
            'totalInvestors',
            'totalUmkmUsers',
            'totalAdmins',
            'pendingProposalsCount',
            'verifiedUmkmCount',
            'rejectedUmkmCount',
            'onlineUsersCount',
            'days',
            'recentPengajuan',
            'onlineUsers'
        ));
    }

    /**
     * 2. Halaman Persetujuan Pengajuan UMKM (Proposal)
     */
    public function pengajuan(Request $request)
    {
        $this->checkSuperAdmin();
        $user = Auth::user();

        $statusFilter = $request->query('status', 'semua');
        $query = Umkm::with('user', 'ruko');

        if ($statusFilter !== 'semua') {
            $query->where('status_pengajuan', $statusFilter);
        }

        if ($request->filled('q')) {
            $search = '%'.$request->q.'%';
            $query->where(function ($q) use ($search) {
                $q->where('nama_usaha', 'like', $search)
                    ->orWhere('pemilik', 'like', $search)
                    ->orWhere('nomor_whatsapp', 'like', $search);
            });
        }

        $pengajuanList = $query->latest('updated_at')->paginate(12)->withQueryString();

        // Hitung counter untuk tabs
        $countSemua = Umkm::count();
        $countMenunggu = Umkm::where('status_pengajuan', 'menunggu_verifikasi')->count();
        $countTerverifikasi = Umkm::where('status_pengajuan', 'terverifikasi')->count();
        $countDitolak = Umkm::where('status_pengajuan', 'ditolak')->count();
        $countDraf = Umkm::where('status_pengajuan', 'draf')->count();

        return view('super-admin.pengajuan', compact(
            'user',
            'pengajuanList',
            'statusFilter',
            'countSemua',
            'countMenunggu',
            'countTerverifikasi',
            'countDitolak',
            'countDraf'
        ));
    }

    /**
     * Setujui Proposal / Pengajuan UMKM
     */
    public function approvePengajuan(Request $request, $id)
    {
        $this->checkSuperAdmin();
        $umkm = Umkm::findOrFail($id);
        $statusLama = $umkm->status_pengajuan;

        $umkm->update([
            'status_pengajuan' => 'terverifikasi',
        ]);

        // Catat log aktivitas admin
        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Persetujuan Proposal UMKM',
            'detail_perubahan' => [
                'id_umkm' => $umkm->id_umkm,
                'nama_usaha' => $umkm->nama_usaha,
                'pemilik' => $umkm->pemilik,
                'status_sebelumnya' => $statusLama,
                'status_baru' => 'terverifikasi',
                'catatan' => $request->input('catatan', 'Proposal disetujui & tayang di katalog investor.'),
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        return back()->with('success', 'Proposal usaha "'.$umkm->nama_usaha.'" BERHASIL DISETUJUI! Usaha kini resmi terverifikasi dan tayang di katalog investor.');
    }

    /**
     * Tolak Proposal / Pengajuan UMKM
     */
    public function rejectPengajuan(Request $request, $id)
    {
        $this->checkSuperAdmin();
        $umkm = Umkm::findOrFail($id);
        $statusLama = $umkm->status_pengajuan;
        $alasan = $request->input('alasan', 'Data atau dokumen belum memenuhi kriteria kelayakan.');

        $umkm->update([
            'status_pengajuan' => 'ditolak',
        ]);

        // Catat log aktivitas admin
        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Penolakan Proposal UMKM',
            'detail_perubahan' => [
                'id_umkm' => $umkm->id_umkm,
                'nama_usaha' => $umkm->nama_usaha,
                'pemilik' => $umkm->pemilik,
                'status_sebelumnya' => $statusLama,
                'status_baru' => 'ditolak',
                'alasan_penolakan' => $alasan,
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        return back()->with('success', 'Proposal usaha "'.$umkm->nama_usaha.'" telah DITOLAK. Status telah diperbarui.');
    }

    /**
     * 3. Halaman Manajemen Akun Pengguna
     */
    public function users(Request $request)
    {
        $this->checkSuperAdmin();
        $user = Auth::user();

        $roleFilter = $request->query('role', 'semua');
        $query = User::query();

        if ($roleFilter !== 'semua') {
            $query->where('role', $roleFilter);
        }

        if ($request->filled('q')) {
            $search = '%'.$request->q.'%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                    ->orWhere('email', 'like', $search)
                    ->orWhere('phone_number', 'like', $search);
            });
        }

        $users = $query->latest('id')->paginate(15)->withQueryString();

        // Counter statistik akun
        $totalAll = User::count();
        $totalInvestors = User::where('role', 'investor')->count();
        $totalUmkm = User::where('role', 'umkm')->count();
        $totalSuperAdmin = User::where('role', 'super_admin')->count();
        $totalStaffAdmin = User::where('role', 'admin')->count();
        $totalAdmin = $totalSuperAdmin + $totalStaffAdmin;
        $totalAktif = User::where('status', 'aktif')->count();
        $totalPending = User::where('status', 'menunggu_verifikasi')->count();
        $totalDitangguhkan = User::where('status', 'ditangguhkan')->count();

        return view('super-admin.users', compact(
            'user',
            'users',
            'roleFilter',
            'totalAll',
            'totalInvestors',
            'totalUmkm',
            'totalAdmin',
            'totalSuperAdmin',
            'totalStaffAdmin',
            'totalAktif',
            'totalPending',
            'totalDitangguhkan'
        ));
    }

    /**
     * Ubah Status Pengguna (Aktif / Ditangguhkan) - Khusus Super Admin
     */
    public function toggleUserStatus(Request $request, $id)
    {
        $this->checkSuperAdminOnly();
        $targetUser = User::findOrFail($id);

        if ($targetUser->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menangguhkan akun Anda sendiri!');
        }

        $statusLama = $targetUser->status;
        $statusBaru = ($statusLama === 'aktif') ? 'ditangguhkan' : 'aktif';

        $targetUser->status = $statusBaru;
        $targetUser->save();

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Ubah Status Akun: '.$statusBaru,
            'detail_perubahan' => [
                'target_id' => $targetUser->id,
                'target_email' => $targetUser->email,
                'status_lama' => $statusLama,
                'status_baru' => $statusBaru,
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        return back()->with('success', 'Status akun '.$targetUser->name.' berhasil diubah menjadi: '.strtoupper($statusBaru));
    }

    /**
     * Ganti / Ubah Role Pengguna - Khusus Super Admin
     */
    public function changeRole(Request $request, $id)
    {
        $this->checkSuperAdminOnly();
        $targetUser = User::findOrFail($id);

        if ($targetUser->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri demi menjaga integritas akses sistem!');
        }

        $validated = $request->validate([
            'role' => 'required|in:investor,umkm,admin,super_admin',
        ], [
            'role.required' => 'Pilih role tujuan yang valid.',
            'role.in' => 'Role yang dipilih tidak valid.',
        ]);

        $roleLama = $targetUser->role;
        $roleBaru = $validated['role'];

        if ($roleLama === $roleBaru) {
            return back()->with('info', 'Role pengguna '.$targetUser->name.' sudah merupakan '.strtoupper($roleBaru).'. Tidak ada perubahan dilakukan.');
        }

        // Jika menurunkan status super_admin, pastikan masih ada super_admin lain di sistem
        if ($roleLama === 'super_admin') {
            $otherSuperAdminsCount = User::where('role', 'super_admin')
                ->where('id', '!=', $targetUser->id)
                ->where('status', 'aktif')
                ->count();

            if ($otherSuperAdminsCount < 1) {
                return back()->with('error', 'Gagal mengubah role! Sistem harus menyisakan minimal satu akun Super Admin aktif.');
            }
        }

        $targetUser->role = $roleBaru;
        $targetUser->save();

        // Jika diubah menjadi UMKM dan belum ada record profil usahanya, buatkan profil dasar
        if ($roleBaru === 'umkm') {
            Umkm::firstOrCreate(
                ['user_id' => $targetUser->id],
                [
                    'nama_usaha' => 'Usaha '.$targetUser->name,
                    'jenis_usaha' => 'Makanan',
                    'pemilik' => $targetUser->name,
                    'nomor_whatsapp' => $targetUser->phone_number,
                    'status_pengajuan' => 'draf',
                ]
            );
        }

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Ubah Role Pengguna: '.strtoupper($roleLama).' -> '.strtoupper($roleBaru),
            'detail_perubahan' => [
                'target_id' => $targetUser->id,
                'target_name' => $targetUser->name,
                'target_email' => $targetUser->email,
                'role_lama' => $roleLama,
                'role_baru' => $roleBaru,
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        $roleLabels = [
            'super_admin' => 'Super Administrator',
            'admin' => 'Admin Biasa (Operasional)',
            'investor' => 'Mitra Investor',
            'umkm' => 'Pelaku UMKM',
        ];

        return back()->with('success', 'Role pengguna "'.$targetUser->name.'" BERHASIL DIUBAH menjadi '.($roleLabels[$roleBaru] ?? ucfirst($roleBaru)).'!');
    }

    /**
     * Setujui / ACC Akun Pengguna (Khususnya Mitra Investor yang berstatus menunggu_verifikasi)
     */
    public function approveUser(Request $request, $id)
    {
        $this->checkAdminAccess();
        $targetUser = User::findOrFail($id);

        $statusLama = $targetUser->status;
        $targetUser->status = 'aktif';
        $targetUser->save();

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Persetujuan (ACC) Akun '.ucfirst($targetUser->role),
            'detail_perubahan' => [
                'target_id' => $targetUser->id,
                'target_name' => $targetUser->name,
                'target_email' => $targetUser->email,
                'role' => $targetUser->role,
                'status_lama' => $statusLama,
                'status_baru' => 'aktif',
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        return back()->with('success', 'Akun '.ucfirst($targetUser->role).' "'.$targetUser->name.'" BERHASIL DISETUJUI (ACC)! Pengguna kini dapat mengakses dashboard sepenuhnya.');
    }

    /**
     * 4. Halaman Log Aktivitas & Pelacak User yang Sedang Login (Khusus Super Admin)
     */
    public function logAktivitas(Request $request)
    {
        $this->checkSuperAdminOnly();
        $user = Auth::user();

        // 1. Data User Online Saat Ini
        $onlineUsers = $this->getOnlineUsersData();

        // 2. Data Riwayat Log Aktivitas Admin & Sistem
        $logs = LogAktivitasAdmin::with('pengguna')
            ->latest('id_log_admin')
            ->paginate(20);

        return view('super-admin.log-aktivitas', compact('user', 'onlineUsers', 'logs'));
    }

    /**
     * 5. Halaman Informasi & Kurasi Ruko
     */
    public function ruko(Request $request)
    {
        $this->checkSuperAdmin();
        $user = Auth::user();

        $activeTab = $request->query('tab', 'kurasi');

        // Data 1: Katalog Ruko Resmi
        $rukos = Ruko::with('penyedia')->latest('id_ruko')->paginate(12);

        // Data 2: Daftar Usulan Ruko Masuk (Crowdsourcing)
        $rekomendasiRukos = RekomendasiRuko::with('pengguna')->latest('id_rekomendasi')->get();
        $pendingRukoCount = $rekomendasiRukos->where('status', 'menunggu_verifikasi')->count();

        // Data 3: Transaksi Sponsor Sewa Ruko dari Investor
        $transaksiSewas = TransaksiSewa::with(['umkm', 'investor', 'ruko'])->latest('id_sewa')->get();
        $pendingSewaCount = $transaksiSewas->where('status_pembayaran', 'menunggu_konfirmasi')->count();

        return view('super-admin.ruko', compact('user', 'rukos', 'rekomendasiRukos', 'pendingRukoCount', 'transaksiSewas', 'pendingSewaCount', 'activeTab'));
    }

    /**
     * Setujui (ACC) Usulan Ruko & Terbitkan ke Katalog Resmi
     */
    public function approveRekomendasiRuko(Request $request, $id)
    {
        $this->checkAdminAccess();
        $rekomendasi = RekomendasiRuko::findOrFail($id);

        // Cari atau buat entitas penyedia fallback untuk ruko dari rekomendasi warga/komunitas
        $penyedia = PenyediaRuko::firstOrCreate(
            ['nama_perusahaan' => 'Mitra Komunitas / Warga'],
            [
                'kontak' => $rekomendasi->kontak_pemilik ?: ($rekomendasi->kontak_pengusul ?: '08123456789'),
                'alamat' => $rekomendasi->lokasi,
            ]
        );

        // Terbitkan langsung ke tabel ruko resmi
        $rukoBaru = Ruko::create([
            'id_penyedia' => $penyedia->id_penyedia,
            'nama_ruko' => $rekomendasi->nama_ruko,
            'lokasi' => $rekomendasi->lokasi,
            'foto_ruko' => $rekomendasi->foto_ruko,
            'deskripsi_potensi' => $rekomendasi->potensi_usaha,
            'kontak_pemilik' => $rekomendasi->kontak_pemilik ?: $rekomendasi->kontak_pengusul,
            'harga_sewa_per_bulan' => $rekomendasi->harga_sewa_per_bulan,
            'total_unit' => $rekomendasi->total_unit ?: 1,
            'unit_terisi' => 0,
            'status_ketersediaan' => 'tersedia',
        ]);

        $rekomendasi->update([
            'status' => 'disetujui',
            'catatan_admin' => $request->input('catatan_admin', 'Usulan ruko disetujui (ACC) oleh Admin dan telah resmi diterbitkan ke Katalog Ruko.'),
        ]);

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'ACC & Terbitkan Ruko Baru',
            'detail_perubahan' => [
                'id_rekomendasi' => $rekomendasi->id_rekomendasi,
                'id_ruko_terbit' => $rukoBaru->id_ruko,
                'nama_ruko' => $rekomendasi->nama_ruko,
                'lokasi' => $rekomendasi->lokasi,
                'pengusul' => $rekomendasi->label_pengusul,
                'harga_sewa' => $rekomendasi->harga_sewa_per_bulan,
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        return back()->with('success', 'Ruko "'.$rekomendasi->nama_ruko.'" BERHASIL DI-ACC & DITERBITKAN ke Katalog Ruko Resmi! Mitra UMKM kini dapat memilih ruko ini untuk tempat usahanya.');
    }

    /**
     * Tolak Usulan Ruko (Tidak Layak)
     */
    public function rejectRekomendasiRuko(Request $request, $id)
    {
        $this->checkAdminAccess();
        $rekomendasi = RekomendasiRuko::findOrFail($id);

        $catatan = $request->input('catatan_admin', 'Lokasi ruko dinilai belum memenuhi kriteria kelayakan komersial untuk UMKM.');

        $rekomendasi->update([
            'status' => 'ditolak',
            'catatan_admin' => $catatan,
        ]);

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Tolak Usulan Ruko',
            'detail_perubahan' => [
                'id_rekomendasi' => $rekomendasi->id_rekomendasi,
                'nama_ruko' => $rekomendasi->nama_ruko,
                'pengusul' => $rekomendasi->label_pengusul,
                'alasan_penolakan' => $catatan,
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        return back()->with('success', 'Usulan ruko "'.$rekomendasi->nama_ruko.'" ditandai TIDAK LAYAK (Ditolak) dengan catatan kurasi.');
    }

    /**
     * Perbarui Kapasitas dan Ketersediaan Unit Ruko Resmi
     */
    public function updateRukoKetersediaan(Request $request, $id)
    {
        $this->checkAdminAccess();
        $ruko = Ruko::findOrFail($id);

        $validated = $request->validate([
            'total_unit' => 'required|integer|min:1|max:100',
            'unit_terisi' => 'required|integer|min:0',
        ]);

        $totalUnit = (int) $validated['total_unit'];
        $unitTerisi = min($totalUnit, (int) $validated['unit_terisi']);
        $status = ($unitTerisi >= $totalUnit) ? 'tersewa' : 'tersedia';

        $ruko->update([
            'total_unit' => $totalUnit,
            'unit_terisi' => $unitTerisi,
            'status_ketersediaan' => $status,
        ]);

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Update Ketersediaan Unit Ruko',
            'detail_perubahan' => [
                'id_ruko' => $ruko->id_ruko,
                'nama_ruko' => $ruko->nama_ruko,
                'total_unit' => $totalUnit,
                'unit_terisi' => $unitTerisi,
                'sisa_unit' => $totalUnit - $unitTerisi,
                'status' => $status,
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        return back()->with('success', 'Kapasitas dan ketersediaan ruko "'.$ruko->nama_ruko.'" berhasil diperbarui (Sisa: '.($totalUnit - $unitTerisi).' dari '.$totalUnit.' unit).');
    }

    /**
     * Konfirmasi Pembayaran Sponsor Sewa Ruko dari Investor
     */
    public function confirmTransaksiSewa(Request $request, $id)
    {
        $this->checkAdminAccess();
        $sewa = TransaksiSewa::with(['umkm', 'investor', 'ruko'])->findOrFail($id);

        $sewa->update([
            'status_pembayaran' => 'dibayar',
        ]);

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Konfirmasi Pembayaran Sewa Ruko',
            'detail_perubahan' => [
                'id_sewa' => $sewa->id_sewa,
                'ruko' => $sewa->ruko->nama_ruko ?? '-',
                'investor' => $sewa->investor->name ?? '-',
                'umkm' => $sewa->umkm->nama_usaha ?? '-',
                'total_dana' => $sewa->total_harga,
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        return back()->with('success', 'Pembayaran dana sponsor sewa ruko "'.($sewa->ruko->nama_ruko ?? 'Ruko').'" dari '.($sewa->investor->name ?? 'Investor').' senilai Rp '.number_format($sewa->total_harga, 0, ',', '.').' BERHASIL DIKONFIRMASI! Status sewa kini telah aktif.');
    }

    /**
     * Tolak / Batalkan Transaksi Sponsor Sewa Ruko
     */
    public function rejectTransaksiSewa(Request $request, $id)
    {
        $this->checkAdminAccess();
        $sewa = TransaksiSewa::with(['ruko', 'investor', 'umkm'])->findOrFail($id);

        $sewa->update([
            'status_pembayaran' => 'dibatalkan',
        ]);

        // Kembalikan ketersediaan unit ruko
        if ($sewa->ruko) {
            $ruko = $sewa->ruko;
            $newUnitTerisi = max(0, ($ruko->unit_terisi ?? 1) - 1);
            $newStatus = ($newUnitTerisi >= ($ruko->total_unit ?? 1)) ? 'tersewa' : 'tersedia';
            $ruko->update([
                'unit_terisi' => $newUnitTerisi,
                'status_ketersediaan' => $newStatus,
            ]);
        }

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Tolak / Batalkan Sponsor Sewa Ruko',
            'detail_perubahan' => [
                'id_sewa' => $sewa->id_sewa,
                'ruko' => $sewa->ruko->nama_ruko ?? '-',
                'investor' => $sewa->investor->name ?? '-',
                'umkm' => $sewa->umkm->nama_usaha ?? '-',
                'total_dana' => $sewa->total_harga,
                'alasan' => $request->input('catatan_admin', 'Dibatalkan oleh Admin'),
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        return back()->with('success', 'Transaksi sponsor sewa ruko berhasil dibatalkan dan kuota unit ruko telah dikembalikan.');
    }

    /**
     * Dashboard Monitoring Kepatuhan Dividen & Kemitraan UMKM
     */
    public function dividen(Request $request)
    {
        $this->checkAdminAccess();
        $user = Auth::user();

        $filter = $request->query('status', 'semua');

        $investasis = Investasi::whereIn('status', ['aktif', 'diterima'])
            ->with(['umkm.user', 'pengguna', 'bagiHasilLog', 'klarifikasiDividen', 'teguranDividen'])
            ->latest('tanggal_investasi')
            ->get();

        // Statistik kepatuhan bulan berjalan
        $stats = [
            'total_kemitraan' => $investasis->count(),
            'lancar' => 0,
            'menjelang_jatuh_tempo' => 0,
            'masa_tenggang' => 0,
            'menunggak' => 0,
            'klarifikasi' => 0,
            'dibekukan' => Umkm::where('status_kepatuhan_dividen', 'dibekukan')->count(),
        ];

        foreach ($investasis as $inv) {
            $code = $inv->status_dividen_bulan_ini['code'] ?? 'lancar';
            if (isset($stats[$code])) {
                $stats[$code]++;
            }
        }

        // Terapkan filter jika ada
        if ($filter !== 'semua') {
            $investasis = $investasis->filter(function ($inv) use ($filter) {
                return ($inv->status_dividen_bulan_ini['code'] ?? '') === $filter;
            });
        }

        // Daftar klarifikasi kendala yang membutuhkan tinjauan admin
        $klarifikasisPending = KlarifikasiDividen::with(['investasi.umkm', 'investasi.pengguna'])
            ->where('status', 'menunggu_tinjauan')
            ->latest()
            ->get();

        // Riwayat teguran resmi yang telah diterbitkan
        $riwayatTeguran = TeguranDividenLog::with(['investasi.umkm', 'investasi.pengguna', 'admin'])
            ->latest()
            ->take(25)
            ->get();

        return view('super-admin.dividen', compact('user', 'investasis', 'stats', 'filter', 'klarifikasisPending', 'riwayatTeguran'));
    }

    /**
     * Menerbitkan Surat Peringatan (SP-1, SP-2, SP-3) atas tunggakan dividen
     */
    public function kirimTeguranDividen(Request $request, $id)
    {
        $this->checkAdminAccess();
        $investasi = Investasi::with('umkm.user', 'pengguna')->findOrFail($id);

        $validated = $request->validate([
            'tingkat_sp' => 'required|in:SP-1,SP-2,SP-3',
            'pesan_teguran' => 'required|string|min:10',
            'tenggat_penyelesaian' => 'nullable|date',
        ]);

        $tenggat = ! empty($validated['tenggat_penyelesaian'])
            ? Carbon::parse($validated['tenggat_penyelesaian'])
            : Carbon::now()->addDays(3);

        $log = TeguranDividenLog::create([
            'id_investasi' => $investasi->id_investasi,
            'id_umkm' => $investasi->id_umkm,
            'dikirim_oleh' => Auth::id(),
            'tingkat_sp' => $validated['tingkat_sp'],
            'pesan_teguran' => $validated['pesan_teguran'],
        ]);

        // Perbarui data kepatuhan di UMKM
        $umkm = $investasi->umkm;
        if ($umkm) {
            $umkm->increment('jumlah_teguran_sp');
            $umkm->teguran_sp_terakhir = Carbon::now();
            if ($validated['tingkat_sp'] === 'SP-3') {
                $umkm->status_kepatuhan_dividen = 'teguran_keras';
            }
            $umkm->save();
        }

        // Kirimkan notifikasi ke pesan internal kemitraan (PesanInvestasi)
        PesanInvestasi::create([
            'id_investasi' => $investasi->id_investasi,
            'id_pengirim' => Auth::id(),
            'pesan' => "⚠️ [SURAT PERINGATAN RESMI TIM COMPLIANCE DAYA UMKM - {$validated['tingkat_sp']}]\n\n".
                       "Kepada Yth. Mitra {$umkm->nama_usaha},\n\n".
                       "{$validated['pesan_teguran']}\n\n".
                       'Tenggat batas penyelesaian: '.$tenggat->translatedFormat('d F Y').".\n".
                       'Mohon segera lakukan penyetoran bagi hasil dividen atau ajukan klarifikasi resmi melalui menu dashboard kemitraan Anda.',
        ]);

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Menerbitkan '.$validated['tingkat_sp'].' Dividen UMKM',
            'detail_perubahan' => [
                'id_investasi' => $investasi->id_investasi,
                'umkm' => $umkm->nama_usaha ?? '-',
                'tingkat_sp' => $validated['tingkat_sp'],
                'tenggat' => $tenggat->toDateString(),
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        // Tautan WhatsApp langsung ke nomor telepon pemilik UMKM
        $phone = $umkm->nomor_whatsapp ?? ($umkm->user->phone_number ?? null);
        $waUrl = null;
        if ($phone) {
            $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
            if (str_starts_with($cleanPhone, '0')) {
                $cleanPhone = '62'.substr($cleanPhone, 1);
            }
            $waMsg = urlencode("Halo {$umkm->nama_usaha}, ini Tim Kepatuhan DAYA UMKM. Kami telah menerbitkan surat peringatan resmi ({$validated['tingkat_sp']}) terkait keterlambatan penyetoran dividen bagi hasil. Mohon segera cek dashboard kemitraan Anda. Terima kasih.");
            $waUrl = "https://wa.me/{$cleanPhone}?text={$waMsg}";
        }

        return back()->with('success', "Surat Peringatan {$validated['tingkat_sp']} berhasil diterbitkan dan dicatat dalam audit kepatuhan.")
            ->with('wa_url', $waUrl)
            ->with('wa_target', $umkm->nama_usaha);
    }

    /**
     * Verifikasi laporan klarifikasi kendala usaha dari UMKM
     */
    public function verifikasiKlarifikasiDividen(Request $request, $id)
    {
        $this->checkAdminAccess();
        $klarifikasi = KlarifikasiDividen::with(['investasi.umkm', 'investasi.pengguna'])->findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:diverifikasi_admin,ditolak',
            'catatan_admin' => 'required|string|min:5',
        ]);

        $klarifikasi->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        $statusLabel = $validated['status'] === 'diverifikasi_admin' ? 'DISETUJUI & DIVERIFIKASI' : 'DITOLAK';

        $namaUsaha = $klarifikasi->investasi && $klarifikasi->investasi->umkm ? $klarifikasi->investasi->umkm->nama_usaha : 'Mitra UMKM';

        $pesanNotif = $validated['status'] === 'diverifikasi_admin'
            ? "✅ [DISPENSASI DISETUJUI - PENYELESAIAN BULAN DEPAN]\n\n".
              "Kepada Yth. {$namaUsaha},\n\n".
              "Klarifikasi laporan kendala usaha Anda untuk periode {$klarifikasi->bulan_periode} telah DISETUJUI & DIVERIFIKASI oleh Tim Compliance Platform.\n\n".
              "STATUS DISPENSASI: Anda resmi diberikan toleransi untuk menyelesaikan kewajiban bagi hasil dividen pada periode BULAN DEPAN tanpa sanksi Surat Peringatan (SP).\n\n".
              "Catatan Verifikator Admin: {$validated['catatan_admin']}\n\n".
              "Terima kasih atas transparansi dan itikad baik Anda dalam menjaga kemitraan sehat bersama mitra investor."
            : "❌ [KLARIFIKASI DIVIDEN TIDAK DAPAT DISETUJUI]\n\n".
              "Kepada Yth. {$namaUsaha},\n\n".
              "Laporan klarifikasi penundaan dividen periode {$klarifikasi->bulan_periode} TIDAK DAPAT DISETUJUI oleh Tim Compliance Platform.\n\n".
              "Alasan / Catatan Admin: {$validated['catatan_admin']}\n\n".
              "Mohon segera lakukan penyetoran dividen bagi hasil untuk menghindari penerbitan Surat Peringatan (SP).";

        PesanInvestasi::create([
            'id_investasi' => $klarifikasi->id_investasi,
            'id_pengirim' => Auth::id(),
            'pesan' => $pesanNotif,
        ]);

        if ($validated['status'] === 'diverifikasi_admin') {
            $umkm = $klarifikasi->investasi ? $klarifikasi->investasi->umkm : null;
            if ($umkm) {
                $umkm->status_kepatuhan_dividen = 'lancar';
                if ($umkm->jumlah_teguran_sp > 0) {
                    $umkm->jumlah_teguran_sp = max(0, $umkm->jumlah_teguran_sp - 1);
                }
                $umkm->save();
            }
        }

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Verifikasi Klarifikasi Dividen',
            'detail_perubahan' => [
                'id_klarifikasi' => $klarifikasi->id_klarifikasi,
                'status' => $validated['status'],
                'catatan' => $validated['catatan_admin'],
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        return back()->with('success', "Laporan klarifikasi dividen periode {$klarifikasi->bulan_periode} berhasil {$statusLabel}.");
    }

    /**
     * Bekukan atau pulihkan hak pendanaan UMKM
     */
    public function toggleFreezeUmkm(Request $request, $id)
    {
        $this->checkAdminAccess();
        $umkm = Umkm::findOrFail($id);

        $isCurrentlyFrozen = $umkm->status_kepatuhan_dividen === 'dibekukan';
        $newStatus = $isCurrentlyFrozen ? 'lancar' : 'dibekukan';

        $catatan = $request->input('catatan_pembekuan', $isCurrentlyFrozen ? 'Pembekuan dicabut oleh Tim Admin.' : 'Akun dibekukan sementara karena keterlambatan dividen berulang / wanprestasi.');

        $umkm->update([
            'status_kepatuhan_dividen' => $newStatus,
            'catatan_pembekuan' => $catatan,
        ]);

        $aksiText = $newStatus === 'dibekukan' ? 'Membekukan Fasilitas Pendanaan UMKM' : 'Mencabut Pembekuan Hak Pendanaan UMKM';

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => $aksiText,
            'detail_perubahan' => [
                'umkm_id' => $umkm->id_umkm,
                'nama_usaha' => $umkm->nama_usaha,
                'status_baru' => $newStatus,
                'catatan' => $catatan,
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        $msg = $newStatus === 'dibekukan'
            ? "Fasilitas pengajuan pendanaan & listing UMKM \"{$umkm->nama_usaha}\" berhasil DIBEKUKAN sementara."
            : "Status pembekuan UMKM \"{$umkm->nama_usaha}\" berhasil DICABUT. Status kini kembali normal.";

        return back()->with('success', $msg);
    }

    /**
     * Menyelesaikan / Mencabut Surat Peringatan (SP) karena UMKM sudah membayar dividen
     */
    public function selesaikanTeguranDividen(Request $request, $id)
    {
        $this->checkAdminAccess();
        $teguran = TeguranDividenLog::with(['umkm', 'investasi.pengguna'])->findOrFail($id);

        $catatan = $request->input('catatan', 'Kewajiban dividen bagi hasil telah disetorkan dan diverifikasi lunas.');

        $teguran->update([
            'status' => 'selesai',
            'catatan_penyelesaian' => $catatan,
            'diselesaikan_pada' => Carbon::now(),
            'diselesaikan_oleh' => Auth::id(),
        ]);

        $umkm = $teguran->umkm;
        if ($umkm) {
            $sisaAktif = TeguranDividenLog::where('id_umkm', $umkm->id_umkm)
                ->where('status', 'aktif')
                ->count();

            $umkm->jumlah_teguran_sp = $sisaAktif;
            if ($sisaAktif === 0) {
                $umkm->status_kepatuhan_dividen = 'lancar';
            }
            $umkm->save();
        }

        if ($teguran->id_investasi) {
            PesanInvestasi::create([
                'id_investasi' => $teguran->id_investasi,
                'id_pengirim' => Auth::id(),
                'pesan' => "✅ [SURAT PERINGATAN RESMI DICABUT / DIRESOLUSI - {$teguran->tingkat_sp}]\n\n".
                           "Kepada Yth. Mitra {$umkm->nama_usaha},\n\n".
                           "Surat Peringatan ({$teguran->tingkat_sp}) yang diterbitkan pada {$teguran->created_at->translatedFormat('d F Y')} dinyatakan RESMI DICABUT / DISELESAIKAN.\n\n".
                           "Catatan Verifikasi: {$catatan}\n\n".
                           "Status kepatuhan dividen bagi hasil kemitraan Anda telah dipulihkan menjadi lancar.",
            ]);
        }

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Mencabut / Menyelesaikan ' . $teguran->tingkat_sp . ' UMKM',
            'detail_perubahan' => [
                'id_teguran' => $teguran->id_teguran,
                'umkm' => $umkm->nama_usaha ?? '-',
                'tingkat_sp' => $teguran->tingkat_sp,
                'catatan' => $catatan,
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        return back()->with('success', "Surat Peringatan ({$teguran->tingkat_sp}) untuk \"{$umkm->nama_usaha}\" berhasil dicabut / diselesaikan karena dividen telah dibayar.");
    }

    /**
     * Menghapus Surat Peringatan (SP) dari log riwayat
     */
    public function hapusTeguranDividen(Request $request, $id)
    {
        $this->checkAdminAccess();
        $teguran = TeguranDividenLog::with('umkm')->findOrFail($id);
        $tingkatSp = $teguran->tingkat_sp;
        $umkm = $teguran->umkm;

        $teguran->delete();

        if ($umkm) {
            $sisaAktif = TeguranDividenLog::where('id_umkm', $umkm->id_umkm)
                ->where('status', 'aktif')
                ->count();

            $umkm->jumlah_teguran_sp = $sisaAktif;
            if ($sisaAktif === 0) {
                $umkm->status_kepatuhan_dividen = 'lancar';
            }
            $umkm->save();
        }

        LogAktivitasAdmin::create([
            'id_pengguna' => Auth::id(),
            'aksi' => 'Menghapus Record ' . $tingkatSp . ' dari Log Kepatuhan',
            'detail_perubahan' => [
                'id_teguran' => $id,
                'umkm' => $umkm->nama_usaha ?? '-',
                'tingkat_sp' => $tingkatSp,
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
        ]);

        return back()->with('success', "Surat Peringatan ({$tingkatSp}) untuk \"{$umkm->nama_usaha}\" berhasil dihapus dari log kepatuhan.");
    }
}
