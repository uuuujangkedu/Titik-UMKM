@extends('layouts.influencer')

@section('title', 'Dashboard Kreator & Influencer - DAYA UMKM')

@section('content')
<div class="space-y-8">
    @php
        $activeTab = request('tab', 'beranda');
    @endphp

    <!-- PAGE HEADER (Sesuai Standar Mockup Dashboard TIKUM) -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#1A202C]">
            @if($activeTab === 'beranda') BERANDA KREATOR
            @elseif($activeTab === 'pesanan') PESANAN PROMOSI
            @elseif($activeTab === 'riwayat') RIWAYAT & ULASAN
            @elseif($activeTab === 'profil') PROFIL & RATE CARD
            @endif
        </h1>
        <p class="text-sm sm:text-base text-[#555555] mt-1.5 font-medium">
            Halo, <span class="font-bold text-[#20675D]">{{ $profile->nama_panggung ?? $user->name }}</span>. Ini ringkasan performa dan pesanan promosi Anda.
        </p>
    </div>

    <!-- HEADER PROFIL & STATUS (Sesuai Desain Banner Platform TIKUM) -->
    <div class="rounded-3xl p-6 sm:p-7 shadow-lg relative overflow-hidden"
         style="background: linear-gradient(135deg, #0F433C 0%, #20675D 100%) !important; color: #ffffff !important;">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
            <div class="flex items-center gap-4 sm:gap-5">
                <div class="relative">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white/10 border-2 border-white/30 flex items-center justify-center font-bold text-2xl text-white overflow-hidden shadow-md">
                        @if(!empty($user->avatar))
                            <img src="{{ $user->avatar }}" alt="{{ $profile->nama_panggung }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($profile->nama_panggung ?? 'K', 0, 2)) }}
                        @endif
                    </div>
                    <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-400 border-2 border-[#0F433C] rounded-full flex items-center justify-center text-[10px] text-teal-950 font-bold" title="Kreator Aktif">✓</span>
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-xl sm:text-2xl font-black tracking-tight text-white">{{ $profile->nama_panggung }}</h2>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/20 text-teal-100 border border-white/25 flex items-center gap-1">
                            ✓ Kreator Terverifikasi
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/10 text-white/90">
                            {{ $profile->kategori }} &bull; {{ $profile->kota }}
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-teal-100/90 mt-1 max-w-2xl line-clamp-2 font-medium">
                        {{ $profile->bio ?? 'Belum ada deskripsi profil. Lengkapi bio Anda di tab Profil & Rate Card.' }}
                    </p>
                    <div class="flex flex-wrap items-center gap-4 mt-2.5 text-xs text-teal-100/80">
                        @if($profile->username_instagram)
                            <span class="flex items-center gap-1 font-medium"><span class="font-bold text-pink-300">IG:</span> {{ $profile->username_instagram }}</span>
                        @endif
                        @if($profile->username_tiktok)
                            <span class="flex items-center gap-1 font-medium"><span class="font-bold text-cyan-300">TikTok:</span> {{ $profile->username_tiktok }}</span>
                        @endif
                        <span class="flex items-center gap-1 text-amber-300 font-bold">
                            ★ {{ number_format($stats['rating'], 1) }} ({{ $stats['total_ulasan'] }} ulasan mitra)
                        </span>
                    </div>
                </div>
            </div>

            <!-- Ketersediaan & Link Cepat -->
            <div class="flex items-center gap-3 self-start md:self-auto shrink-0">
                <a href="{{ route('dashboard', ['tab' => 'profil']) }}" 
                   class="px-5 py-2.5 rounded-xl bg-white text-[#0F433C] hover:bg-teal-50 text-xs font-bold transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#0F433C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Atur Tarif & Bio</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 KARTU STATISTIK KPI KREATOR (Sesuai Class card-soft Dashboard TIKUM) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Saldo Siap Tarik -->
        <div class="card-soft p-6">
            <div class="w-12 h-12 rounded-2xl bg-[#EFF5F1] text-[#20675D] flex items-center justify-center mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-xs font-bold text-gray-500">Saldo Penghasilan</p>
            <h3 class="text-2xl font-black text-[#1A202C] mt-1 tracking-tight">
                Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}
            </h3>
            <p class="text-[11px] text-[#20675D] font-semibold mt-1">● Masuk otomatis saat konten disetujui</p>
        </div>

        <!-- Pesanan Masuk / Aktif -->
        <div class="card-soft p-6">
            <div class="w-12 h-12 rounded-2xl bg-[#FBF6EA] text-amber-800 flex items-center justify-center mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-xs font-bold text-gray-500">Pesanan Aktif</p>
            <h3 class="text-2xl font-black text-[#1A202C] mt-1 tracking-tight">
                {{ $stats['pesanan_aktif'] }} <span class="text-sm font-normal text-gray-400">proyek</span>
            </h3>
            <p class="text-[11px] text-amber-700 font-semibold mt-1">● Menunggu respon & sedang dibuat</p>
        </div>

        <!-- Pekerjaan Selesai -->
        <div class="card-soft p-6">
            <div class="w-12 h-12 rounded-2xl bg-[#EBF3FB] text-blue-800 flex items-center justify-center mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-xs font-bold text-gray-500">Total Kampanye Selesai</p>
            <h3 class="text-2xl font-black text-[#1A202C] mt-1 tracking-tight">
                {{ $stats['total_selesai'] }} <span class="text-sm font-normal text-gray-400">video</span>
            </h3>
            <p class="text-[11px] text-blue-700 font-semibold mt-1">● Tersebar di UMKM terverifikasi</p>
        </div>

        <!-- Rating & Reputasi -->
        <div class="card-soft p-6">
            <div class="w-12 h-12 rounded-2xl bg-[#F4EFFB] text-purple-800 flex items-center justify-center mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <p class="text-xs font-bold text-gray-500">Rating Performa</p>
            <h3 class="text-2xl font-black text-[#1A202C] mt-1 tracking-tight">
                ★ {{ number_format($stats['rating'], 1) }} <span class="text-sm font-normal text-gray-400">/ 5.0</span>
            </h3>
            <p class="text-[11px] text-purple-700 font-semibold mt-1">● Berdasarkan {{ $stats['total_ulasan'] }} ulasan mitra</p>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- TAB 1: BERANDA / QUICK OVERVIEW                                           --}}
    {{-- ========================================================================= --}}
    @if($activeTab === 'beranda')
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-[#1A202C]">Pesanan Promosi Berjalan</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Tawaran endorse dari UMKM atau disponsori oleh Investor yang butuh respon dan pengerjaan Anda.</p>
                </div>
                <a href="{{ route('dashboard', ['tab' => 'pesanan']) }}" class="text-xs font-bold text-[#0F433C] hover:underline flex items-center gap-1">
                    Lihat Semua ({{ $activeOrders->count() }}) &rarr;
                </a>
            </div>

            @if($activeOrders->isEmpty())
                <div class="card-soft p-12 text-center">
                    <div class="w-16 h-16 bg-[#EFF5F1] text-[#20675D] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-[#1A202C]">Belum Ada Pesanan Masuk Saat Ini</h3>
                    <p class="text-xs text-gray-500 max-w-md mx-auto mt-1">
                        Profil Anda sudah aktif dan terdaftar di Katalog Influencer TIKUM. Pastikan rate card dan deskripsi Anda menarik agar UMKM dan Investor memilih Anda!
                    </p>
                    <a href="{{ route('dashboard', ['tab' => 'profil']) }}" class="mt-4 inline-block px-5 py-2.5 bg-[#0F433C] text-white rounded-xl text-xs font-bold hover:bg-[#19584F] transition shadow-sm">
                        Perbarui Rate Card & Profil
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($activeOrders as $order)
                        <div class="card-soft p-6 flex flex-col justify-between">
                            <div>
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div>
                                        <span class="text-[11px] font-mono font-bold text-gray-400">#{{ $order->kode_order }}</span>
                                        <h3 class="text-base font-bold text-[#1A202C] mt-0.5">{{ $order->nama_campaign }}</h3>
                                    </div>
                                    @php $badge = $order->status_badge; @endphp
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold 
                                        {{ $order->status === 'menunggu_respon_influencer' ? 'bg-amber-100 text-amber-800 border border-amber-200' : '' }}
                                        {{ $order->status === 'sedang_dikerjakan' ? 'bg-purple-100 text-purple-800 border border-purple-200' : '' }}
                                        {{ $order->status === 'menunggu_verifikasi' ? 'bg-blue-100 text-blue-800 border border-blue-200' : '' }}">
                                        {{ $badge['label'] }}
                                    </span>
                                </div>

                                <!-- Detail UMKM & Biaya -->
                                <div class="p-4 bg-[#F9F8F3] rounded-2xl space-y-2 mb-4 text-xs border border-[#E8E6DF]">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-500">UMKM:</span>
                                        <span class="font-bold text-[#1A202C]">{{ $order->umkm->nama_usaha ?? 'UMKM' }} ({{ $order->umkm->kota ?? 'Lokal' }})</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-500">Paket Konten:</span>
                                        <span class="font-bold text-[#0F433C] bg-[#EFF5F1] px-2 py-0.5 rounded-lg">{{ $order->paket_label }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-500">Honor / Biaya:</span>
                                        <span class="font-black text-sm text-[#0F433C]">Rp {{ number_format($order->biaya, 0, ',', '.') }}</span>
                                    </div>
                                    @if($order->investor)
                                        <div class="flex items-center justify-between text-amber-900 bg-amber-50 p-2 rounded-xl border border-amber-200">
                                            <span class="font-semibold">Sponsor Investor:</span>
                                            <span class="font-bold">{{ $order->investor->name }}</span>
                                        </div>
                                    @endif
                                    @if($order->produk)
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-500">Produk Dipromosikan:</span>
                                            <span class="font-semibold text-gray-800">{{ $order->produk->nama_produk }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Brief Singkat -->
                                <div class="mb-4">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Brief Singkat:</p>
                                    <p class="text-xs text-gray-700 bg-[#f7f6f1] p-3 rounded-xl border border-[#e2e1d8] italic">
                                        "{{ Str::limit($order->catatan_brief, 140) }}"
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol Aksi Sesuai Status -->
                            <div class="pt-3 border-t border-gray-100">
                                @if($order->status === 'menunggu_respon_influencer')
                                    <div class="grid grid-cols-2 gap-2">
                                        <form action="{{ route('dashboard.influencer.order.terima', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full py-2.5 bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold rounded-xl transition shadow-sm">
                                                ✓ Terima Tawaran
                                            </button>
                                        </form>
                                        <button type="button" onclick="document.getElementById('modal-tolak-{{ $order->id }}').classList.remove('hidden')" 
                                                class="w-full py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-xl border border-rose-200 transition">
                                            ✕ Tolak
                                        </button>
                                    </div>
                                @elseif($order->status === 'sedang_dikerjakan')
                                    <button type="button" onclick="document.getElementById('modal-bukti-{{ $order->id }}').classList.remove('hidden')"
                                            class="w-full py-2.5 bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                        <span>Unggah Bukti Video / Postingan</span>
                                    </button>
                                @elseif($order->status === 'menunggu_verifikasi')
                                    <div class="p-2.5 bg-blue-50 text-blue-800 rounded-xl text-center text-xs font-semibold border border-blue-200">
                                        ⏳ Bukti konten telah dikirim. Menunggu verifikasi penyelesaian dari pemesan.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- MODAL TOLAK PESANAN -->
                        <div id="modal-tolak-{{ $order->id }}" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
                            <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-xl border border-[#E8E6DF]">
                                <h3 class="text-base font-bold text-rose-700 mb-1">Tolak Tawaran Promosi</h3>
                                <p class="text-xs text-gray-500 mb-4">Berikan alasan penolakan untuk pesanan #{{ $order->kode_order }}.</p>
                                <form action="{{ route('dashboard.influencer.order.tolak', $order->id) }}" method="POST">
                                    @csrf
                                    <textarea name="alasan_penolakan" rows="3" required placeholder="Contoh: Jadwal endorse minggu ini sedang penuh atau produk di luar niche saya..."
                                              class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] p-3 focus:border-rose-500 focus:ring-1 focus:ring-rose-500"></textarea>
                                    <div class="flex items-center justify-end gap-2 mt-4">
                                        <button type="button" onclick="document.getElementById('modal-tolak-{{ $order->id }}').classList.add('hidden')" 
                                                class="px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                                        <button type="submit" class="px-5 py-2 text-xs font-bold bg-rose-600 text-white rounded-xl hover:bg-rose-700 shadow-sm">Konfirmasi Tolak</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- MODAL SUBMIT BUKTI KONTEN -->
                        <div id="modal-bukti-{{ $order->id }}" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
                            <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-xl border border-[#E8E6DF]">
                                <div class="flex items-center justify-between pb-3 border-b border-[#E8E6DF] mb-4">
                                    <div>
                                        <h3 class="text-base font-bold text-[#1A202C]">Unggah Bukti Publikasi</h3>
                                        <p class="text-xs text-gray-500">Order #{{ $order->kode_order }} &bull; {{ $order->umkm->nama_usaha ?? '' }}</p>
                                    </div>
                                    <button type="button" onclick="document.getElementById('modal-bukti-{{ $order->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">✕</button>
                                </div>
                                <form action="{{ route('dashboard.influencer.order.bukti', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-[13px] font-semibold text-[#161d1a] mb-1">Tautan / Link Video Konten (TikTok / Reels / YouTube) *</label>
                                        <input type="url" name="link_bukti_konten" required placeholder="https://www.tiktok.com/@username/video/..." 
                                               value="{{ old('link_bukti_konten', $order->link_bukti_konten) }}"
                                               class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-[13px] font-semibold text-[#161d1a] mb-1">Screenshot Statistik / Insight Views (Opsional)</label>
                                        <input type="file" name="screenshot_insight" accept="image/*"
                                               class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-[4px] file:border-0 file:text-[11px] file:font-semibold file:bg-[#d8ebe5] file:text-[#0b5a4a]">
                                    </div>

                                    <div>
                                        <label class="block text-[13px] font-semibold text-[#161d1a] mb-1">Catatan Tambahan untuk Pemesan</label>
                                        <textarea name="catatan_influencer" rows="2" placeholder="Catatan pesan untuk UMKM atau Investor pemesan..." 
                                                  class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] p-3 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white">{{ old('catatan_influencer', $order->catatan_influencer) }}</textarea>
                                    </div>

                                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#E8E6DF]">
                                        <button type="button" onclick="document.getElementById('modal-bukti-{{ $order->id }}').classList.add('hidden')" class="px-4 py-2.5 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                                        <button type="submit" class="px-5 py-2.5 text-xs font-bold bg-[#0F433C] text-white rounded-xl hover:bg-[#19584F] shadow-sm">Kirim Bukti Konten</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    {{-- ========================================================================= --}}
    {{-- TAB 2: PESANAN MASUK & DETAIL LENGKAP                                      --}}
    {{-- ========================================================================= --}}
    @if($activeTab === 'pesanan')
        <div class="space-y-6">
            <div>
                <h2 class="text-xl font-bold text-[#1A202C]">Semua Pesanan & Tugas Konten</h2>
                <p class="text-xs text-gray-500 mt-0.5">Kelola seluruh tawaran endorsement dari UMKM dan sponsor investor binaan.</p>
            </div>

            @if($activeOrders->isEmpty())
                <div class="card-soft p-12 text-center">
                    <p class="text-sm font-bold text-gray-600">Tidak ada pesanan aktif saat ini.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($activeOrders as $order)
                        <div class="card-soft p-6">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-[#E8E6DF]">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-mono font-bold text-gray-400">#{{ $order->kode_order }}</span>
                                        @php $badge = $order->status_badge; @endphp
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">{{ $badge['label'] }}</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-[#1A202C] mt-1">{{ $order->nama_campaign }}</h3>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400 font-medium">Honor Kreator</p>
                                    <p class="text-xl font-black text-[#0F433C]">Rp {{ number_format($order->biaya, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-4 text-xs">
                                <div class="p-4 bg-[#F9F8F3] rounded-2xl border border-[#E8E6DF]">
                                    <span class="text-gray-400 font-semibold block mb-0.5">Mitra UMKM</span>
                                    <span class="font-bold text-[#1A202C] text-sm">{{ $order->umkm->nama_usaha ?? 'UMKM' }}</span>
                                    <span class="text-gray-500 block mt-0.5">Kota: {{ $order->umkm->kota ?? 'Lokal' }} &bull; WA: {{ $order->umkm->nomor_whatsapp ?? '-' }}</span>
                                </div>
                                <div class="p-4 bg-[#F9F8F3] rounded-2xl border border-[#E8E6DF]">
                                    <span class="text-gray-400 font-semibold block mb-0.5">Paket Promosi</span>
                                    <span class="font-bold text-[#0F433C] text-sm">{{ $order->paket_label }}</span>
                                    <span class="text-gray-500 block mt-0.5">Target: {{ $order->target_selesai ? $order->target_selesai->format('d M Y') : '1 Minggu' }}</span>
                                </div>
                                <div class="p-4 bg-[#F9F8F3] rounded-2xl border border-[#E8E6DF]">
                                    <span class="text-gray-400 font-semibold block mb-0.5">Didanai Oleh</span>
                                    @if($order->investor)
                                        <span class="font-bold text-amber-800 text-sm">Sponsor: {{ $order->investor->name }}</span>
                                        <span class="text-gray-500 block mt-0.5">(Investor Mitra)</span>
                                    @else
                                        <span class="font-bold text-[#0F433C] text-sm">Mandiri oleh UMKM</span>
                                        <span class="text-gray-500 block mt-0.5">(Dana promosi UMKM)</span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-4 bg-[#f7f6f1] rounded-2xl border border-[#e2e1d8] mb-4">
                                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block mb-1">Brief & Instruksi Konten:</span>
                                <p class="text-xs text-gray-700 whitespace-pre-line leading-relaxed">{{ $order->catatan_brief }}</p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#E8E6DF]">
                                @if($order->status === 'menunggu_respon_influencer')
                                    <form action="{{ route('dashboard.influencer.order.terima', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-5 py-2.5 bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold rounded-xl transition shadow-sm">
                                            ✓ Terima & Kerjakan Pesanan
                                        </button>
                                    </form>
                                @elseif($order->status === 'sedang_dikerjakan')
                                    <button type="button" onclick="document.getElementById('modal-bukti-{{ $order->id }}').classList.remove('hidden')"
                                            class="px-5 py-2.5 bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                        <span>Unggah Link Bukti Konten</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    {{-- ========================================================================= --}}
    {{-- TAB 3: RIWAYAT SELESAI & ULASAN                                           --}}
    {{-- ========================================================================= --}}
    @if($activeTab === 'riwayat')
        <div class="space-y-6">
            <div>
                <h2 class="text-xl font-bold text-[#1A202C]">Riwayat Kampanye Selesai & Ulasan</h2>
                <p class="text-xs text-gray-500 mt-0.5">Daftar pekerjaan yang telah diselesaikan beserta rating dan testimoni dari UMKM dan Investor.</p>
            </div>

            @if($historyOrders->isEmpty())
                <div class="card-soft p-12 text-center">
                    <p class="text-sm font-bold text-gray-600">Belum ada riwayat pesanan selesai.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($historyOrders as $item)
                        <div class="card-soft p-6 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-3 mb-2">
                                    <span class="text-xs font-mono font-bold text-gray-400">#{{ $item->kode_order }}</span>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $item->status === 'selesai' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </div>
                                <h3 class="text-base font-bold text-[#1A202C]">{{ $item->nama_campaign }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $item->umkm->nama_usaha ?? 'UMKM' }} &bull; {{ $item->paket_label }}</p>

                                @if($item->link_bukti_konten)
                                    <div class="mt-3">
                                        <a href="{{ $item->link_bukti_konten }}" target="_blank" rel="noopener noreferrer" 
                                           class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0F433C] hover:underline bg-[#EFF5F1] px-3 py-1.5 rounded-xl border border-[#b2d5cc]">
                                            <span>▶ Lihat Konten yang Diposting</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    </div>
                                @endif

                                @if($item->rating)
                                    <div class="mt-4 p-3.5 bg-amber-50/70 border border-amber-200/60 rounded-2xl">
                                        <div class="flex items-center gap-1 text-amber-500 text-sm font-black">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span>{{ $i <= $item->rating ? '★' : '☆' }}</span>
                                            @endfor
                                            <span class="text-xs text-gray-700 ml-1.5 font-bold">{{ $item->rating }}.0</span>
                                        </div>
                                        @if($item->ulasan)
                                            <p class="text-xs text-gray-700 italic mt-1.5">"{{ $item->ulasan }}"</p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4 pt-3 border-t border-[#E8E6DF] flex items-center justify-between text-xs">
                                <span class="text-gray-400">{{ $item->updated_at->format('d M Y') }}</span>
                                <span class="font-black text-sm text-[#0F433C]">+ Rp {{ number_format($item->biaya, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $historyOrders->links() }}
                </div>
            @endif
        </div>
    @endif

    {{-- ========================================================================= --}}
    {{-- TAB 4: PROFIL & RATE CARD                                                 --}}
    {{-- ========================================================================= --}}
    @if($activeTab === 'profil')
        <div class="card-soft p-6 sm:p-8 max-w-4xl">
            <div class="mb-6 pb-4 border-b border-[#E8E6DF]">
                <h2 class="text-xl font-bold text-[#1A202C]">Pengaturan Profil & Rate Card</h2>
                <p class="text-xs text-gray-500 mt-0.5">Tentukan tarif endorsement Anda dan informasi rekening untuk penarikan saldo pendapatan.</p>
            </div>

            <form action="{{ route('dashboard.influencer.profil.update') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Informasi Dasar -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Nama Panggung / Display Name *</label>
                        <input type="text" name="nama_panggung" required value="{{ old('nama_panggung', $profile->nama_panggung) }}"
                               class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Kategori / Niche Konten *</label>
                        <select name="kategori" required class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                            @foreach(['Kuliner', 'Fashion', 'Kecantikan', 'Lifestyle', 'Jasa', 'Teknologi', 'UMKM & Bisnis'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori', $profile->kategori) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Kota / Domisili Utama *</label>
                        <input type="text" name="kota" required value="{{ old('kota', $profile->kota) }}" placeholder="Contoh: Surabaya, Malang, Jakarta Selatan..."
                               class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Estimasi Total Followers / Jangkauan *</label>
                        <input type="number" name="followers_count" required value="{{ old('followers_count', $profile->followers_count) }}"
                               class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                    </div>
                </div>

                <!-- Tautan Sosial Media -->
                <div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Akun Media Sosial</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[13px] font-semibold text-[#161d1a] mb-1">Username Instagram</label>
                            <input type="text" name="username_instagram" value="{{ old('username_instagram', $profile->username_instagram) }}" placeholder="@namaakun"
                                   class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-[#161d1a] mb-1">Username TikTok</label>
                            <input type="text" name="username_tiktok" value="{{ old('username_tiktok', $profile->username_tiktok) }}" placeholder="@namaakun"
                                   class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-[#161d1a] mb-1">Channel YouTube (Opsional)</label>
                            <input type="text" name="username_youtube" value="{{ old('username_youtube', $profile->username_youtube) }}" placeholder="@channel"
                                   class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                        </div>
                    </div>
                </div>

                <!-- Rate Card Promosi -->
                <div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Rate Card Promosi (Tarif Jasa)</h3>
                    <p class="text-[11px] text-gray-500 mb-3">Harga yang Anda pasang akan dilihat oleh UMKM dan Investor saat menyewa Anda.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="p-4 bg-[#f7f6f1] rounded-[8px] border border-[#e2e1d8]">
                            <label class="block text-[12px] font-bold text-[#161d1a] mb-1">Tarif IG Story (Rp)</label>
                            <input type="number" name="rate_story" required value="{{ old('rate_story', $profile->rate_story) }}"
                                   class="w-full bg-white border border-[#e2e1d8] rounded-[6px] text-[13px] font-bold text-[#0b5a4a] px-3.5 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                            <span class="text-[10px] text-gray-500 mt-1 block">1x Story 24 Jam</span>
                        </div>
                        <div class="p-4 bg-[#f7f6f1] rounded-[8px] border border-[#e2e1d8]">
                            <label class="block text-[12px] font-bold text-[#161d1a] mb-1">Tarif TikTok / Reels (Rp)</label>
                            <input type="number" name="rate_reels_tiktok" required value="{{ old('rate_reels_tiktok', $profile->rate_reels_tiktok) }}"
                                   class="w-full bg-white border border-[#e2e1d8] rounded-[6px] text-[13px] font-bold text-[#0b5a4a] px-3.5 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                            <span class="text-[10px] text-gray-500 mt-1 block">1x Video Feed / TikTok</span>
                        </div>
                        <div class="p-4 bg-[#f7f6f1] rounded-[8px] border border-[#e2e1d8]">
                            <label class="block text-[12px] font-bold text-[#161d1a] mb-1">Tarif Visit Toko / Ruko (Rp)</label>
                            <input type="number" name="rate_visit_store" required value="{{ old('rate_visit_store', $profile->rate_visit_store) }}"
                                   class="w-full bg-white border border-[#e2e1d8] rounded-[6px] text-[13px] font-bold text-[#0b5a4a] px-3.5 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                            <span class="text-[10px] text-gray-500 mt-1 block">Datang ke lokasi toko fisik</span>
                        </div>
                    </div>
                </div>

                <!-- Bio & Deskripsi -->
                <div>
                    <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Deskripsi Singkat / Keunggulan Anda</label>
                    <textarea name="bio" rows="3" placeholder="Ceritakan gaya konten Anda, siapa audiens Anda, dan apa yang membuat Anda cocok mempromosikan UMKM..."
                              class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] p-3.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">{{ old('bio', $profile->bio) }}</textarea>
                </div>

                <!-- Rekening Pencairan Saldo -->
                <div class="p-5 bg-[#EFF5F1] rounded-[8px] border border-[#b2d5cc] space-y-3">
                    <h3 class="text-xs font-bold text-[#084539] uppercase tracking-wider">Rekening Bank Pencairan Honor</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-700 mb-1">Nama Bank</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name', $profile->bank_name) }}" placeholder="BCA / Mandiri / BNI / BRI"
                                   class="w-full bg-white border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-700 mb-1">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" value="{{ old('nomor_rekening', $profile->nomor_rekening) }}" placeholder="Contoh: 1234567890"
                                   class="w-full bg-white border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-700 mb-1">Atas Nama Rekening</label>
                            <input type="text" name="nama_rekening" value="{{ old('nama_rekening', $profile->nama_rekening) }}" placeholder="Nama pemilik buku tabungan"
                                   class="w-full bg-white border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-[#E8E6DF] flex-wrap gap-4">
                    <label class="flex items-center gap-2 text-xs font-semibold text-gray-700 cursor-pointer">
                        <input type="checkbox" name="is_available" value="1" {{ $profile->is_available ? 'checked' : '' }} class="rounded text-[#0b5a4a] focus:ring-[#0b5a4a]">
                        <span>Buka penerimaan pesanan endorse (Available for hire)</span>
                    </label>

                    <button type="submit" class="px-6 py-2.5 bg-[#0b5a4a] hover:bg-[#084539] text-white text-[13px] font-medium rounded-[6px] shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
