@extends('layouts.super-admin')

@section('title', 'Beranda Super Admin')

@section('content')
<div class="space-y-8">

    <!-- PAGE HEADER (Sesuai Mockup) -->
    <div>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">BERANDA</h1>
        <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
            Halo, <span class="font-bold text-[#0F433C]">{{ $user->name }}</span>. Ini ringkasan usahamu dan sistem platform.
        </p>
    </div>

    <!-- 4 KARTU METRIK KPI (Presisi sesuai warna & posisi mockup) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
        
        <!-- KARTU 1: Cyan/Teal (Penjualan / Total Pengguna) -->
        <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-2xl bg-[#E0F7F6] text-[#00A389] flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <p class="text-xs font-bold text-gray-500">Total Pengguna Terdaftar</p>
            <h3 class="text-2xl sm:text-3xl font-black text-[#1A202C] mt-1 tracking-tight">
                {{ number_format($totalUsers, 0, ',', '.') }}
            </h3>
            <p class="text-[11px] text-gray-400 mt-1 font-medium">
                {{ $totalInvestors }} Investor &bull; {{ $totalUmkmUsers }} UMKM
            </p>
        </div>

        <!-- KARTU 2: Yellow/Gold (Proposal Menunggu) -->
        <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-2xl bg-[#FEF9E7] text-[#F1C40F] flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <p class="text-xs font-bold text-gray-500">Proposal Menunggu Verifikasi</p>
            <h3 class="text-2xl sm:text-3xl font-black text-[#1A202C] mt-1 tracking-tight">
                {{ $pendingProposalsCount }}
            </h3>
            <a href="{{ route('superadmin.pengajuan', ['status' => 'menunggu_verifikasi']) }}" class="text-[11px] font-bold text-amber-600 hover:text-amber-700 mt-1 inline-flex items-center gap-1">
                <span>Perlu tindakan admin</span> &rarr;
            </a>
        </div>

        <!-- KARTU 3: Blue/Purple (UMKM Terverifikasi) -->
        <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-2xl bg-[#EDF2FE] text-[#4F73D9] flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <p class="text-xs font-bold text-gray-500">UMKM Terverifikasi</p>
            <h3 class="text-2xl sm:text-3xl font-black text-[#1A202C] mt-1 tracking-tight">
                {{ $verifiedUmkmCount }}
            </h3>
            <p class="text-[11px] text-gray-400 mt-1 font-medium">
                Tayang & dapat didanai
            </p>
        </div>

        <!-- KARTU 4: Red/Coral (Pengguna Sedang Login / Online) -->
        <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-2xl bg-[#FDECEB] text-[#E74C3C] flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <p class="text-xs font-bold text-gray-500">User Sedang Login (Online)</p>
            <div class="flex items-center gap-2 mt-1">
                <h3 class="text-2xl sm:text-3xl font-black text-[#1A202C] tracking-tight">
                    {{ $onlineUsersCount }}
                </h3>
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
            </div>
            <a href="{{ route('superadmin.logs') }}" class="text-[11px] font-bold text-emerald-700 hover:text-emerald-800 mt-1 inline-flex items-center gap-1">
                <span>Lihat sesi realtime</span> &rarr;
            </a>
        </div>

    </div>

    <!-- BAGIAN TENGAH: GRAFIK 7 HARI & PENGAJUAN TERBARU (Sesuai Mockup) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-start">
        
        <!-- KOLOM KIRI: Grafik Penjualan / Aktivitas 7 Hari -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-black text-[#1A202C] tracking-tight">Grafik Penjualan 7 Hari</h2>
                    <p class="text-xs text-gray-400 font-medium">Tren aktivitas pendaftaran & transaksi mingguan</p>
                </div>
                <span class="text-xs font-bold px-3 py-1 bg-gray-100 rounded-full text-gray-600">
                    Minggu Ini
                </span>
            </div>

            <!-- Visual Bar Chart Presisi Sesuai Mockup -->
            <div class="h-64 sm:h-72 flex items-end justify-between gap-3 sm:gap-6 pt-6 px-2 sm:px-6 border-b border-gray-100 pb-2">
                @foreach($days as $label => $height)
                    <div class="flex-1 flex flex-col items-center h-full justify-end group">
                        <!-- Bar Value Tag Always Visible -->
                        <div class="mb-2 px-2 py-0.5 rounded-lg bg-[#0F433C] text-white text-[10px] sm:text-[11px] font-bold shadow-xs">
                            {{ $height }}%
                        </div>
                        
                        <!-- Track & Solid Bar -->
                        <div class="w-full max-w-[42px] h-full flex items-end justify-center bg-gray-100 rounded-xl p-1">
                            <div class="w-full bg-[#0F433C] hover:bg-[#1A5C52] transition-all rounded-lg shadow-sm border-t-2 border-emerald-400"
                                 style="height: {{ max(15, $height) }}%;">
                            </div>
                        </div>

                        <!-- Hari Label -->
                        <span class="text-xs font-bold text-gray-700 mt-3 group-hover:text-[#0F433C] transition-colors">
                            {{ $label }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 flex items-center justify-between text-xs text-gray-500 font-medium px-2">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded bg-[#0F433C]"></span>
                    <span>Volume Aktivitas Berhasil</span>
                </div>
                <span class="font-bold text-emerald-700">● 100% Sistem Stabil</span>
            </div>
        </div>

        <!-- KOLOM KANAN: Produk Terlaris / Pengajuan Terbaru (Sesuai Mockup) -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-black text-[#1A202C] tracking-tight">Pengajuan Usaha Terbaru</h2>
                    <p class="text-xs text-gray-400 font-medium">Proposal masuk dari pelaku UMKM</p>
                </div>
                <a href="{{ route('superadmin.pengajuan') }}" class="text-xs font-bold text-[#0F433C] hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="space-y-4">
                @forelse($recentPengajuan as $p)
                    <div class="p-3.5 rounded-2xl bg-[#F9F8F3] hover:bg-[#F2EFE8] transition border border-[#E8E6DF] flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <!-- Thumbnail Hijau Mockup -->
                            <div class="w-12 h-12 rounded-xl bg-[#6B9E8A] text-white flex items-center justify-center shrink-0 font-bold text-sm shadow-sm overflow-hidden">
                                @if(!empty($p->foto_produk))
                                    <img src="{{ asset('storage/' . $p->foto_produk) }}" alt="{{ $p->nama_usaha }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($p->nama_usaha, 0, 2)) }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs sm:text-sm font-extrabold text-[#1A202C] truncate">
                                    {{ $p->nama_usaha }}
                                </h4>
                                <p class="text-[11px] text-gray-500 truncate mt-0.5">
                                    {{ $p->pemilik }} &bull; {{ $p->jenis_usaha }}
                                </p>
                                <div class="mt-1">
                                    @if($p->status_pengajuan === 'terverifikasi')
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-800">Terverifikasi</span>
                                    @elseif($p->status_pengajuan === 'menunggu_verifikasi')
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-100 text-amber-800 animate-pulse">Menunggu Verifikasi</span>
                                    @elseif($p->status_pengajuan === 'ditolak')
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-100 text-rose-800">Ditolak</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-gray-200 text-gray-700">Draf</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Cepat Aksi -->
                        <div class="shrink-0 flex items-center gap-1.5">
                            @if($p->status_pengajuan === 'menunggu_verifikasi')
                                <form action="{{ route('superadmin.pengajuan.approve', $p->id_umkm) }}" method="POST">
                                    @csrf
                                    <button type="submit" title="Setujui Cepat" class="p-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('superadmin.pengajuan', ['q' => $p->nama_usaha]) }}" class="px-2.5 py-1.5 rounded-xl border border-gray-300 hover:bg-white text-[11px] font-bold text-gray-700 transition">
                                Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 mx-auto flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <p class="text-xs font-bold text-gray-500">Belum ada pengajuan UMKM terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- SEKSI USER ONLINE REALTIME DI BAGIAN BAWAH -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                    <h2 class="text-lg font-black text-[#1A202C] tracking-tight">Pengguna Sedang Login Saat Ini</h2>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-0.5">Sesi aktif terdeteksi dalam 15 menit terakhir</p>
            </div>
            <a href="{{ route('superadmin.logs') }}" class="text-xs font-bold text-[#0F433C] hover:underline">
                Buka Log Aktivitas Lengkap &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-[11px] font-extrabold uppercase tracking-wider text-gray-400">
                        <th class="py-3 px-4">Pengguna</th>
                        <th class="py-3 px-4">Peran (Role)</th>
                        <th class="py-3 px-4">IP Address</th>
                        <th class="py-3 px-4">Perangkat / Browser</th>
                        <th class="py-3 px-4">Aktivitas Terakhir</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs font-medium">
                    @forelse($onlineUsers as $sess)
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-extrabold text-[#1A202C]">{{ $sess['name'] }}</div>
                                <div class="text-[11px] text-gray-400">{{ $sess['email'] }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $sess['role'] === 'super_admin' ? 'bg-purple-100 text-purple-800' : ($sess['role'] === 'investor' ? 'bg-blue-100 text-blue-800' : 'bg-teal-100 text-teal-800') }}">
                                    {{ $sess['role'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-gray-600">
                                {{ $sess['ip_address'] }}
                            </td>
                            <td class="py-3.5 px-4 text-gray-500 max-w-[200px] truncate" title="{{ $sess['user_agent'] }}">
                                {{ \Illuminate\Support\Str::limit($sess['user_agent'], 35) }}
                            </td>
                            <td class="py-3.5 px-4 text-gray-600">
                                {{ $sess['last_activity']->diffForHumans() }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Online
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400 text-xs">
                                Saat ini hanya sesi Anda yang aktif.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
