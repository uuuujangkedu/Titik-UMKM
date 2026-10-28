@extends('layouts.super-admin')

@section('title', 'Kurasi & Katalog Ruko Komersial - DAYA UMKM')

@section('content')
<div class="space-y-8">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-teal-100 text-[#0F433C]">
                    Pilar Properti Komersial
                </span>
                <span class="text-xs text-gray-400 font-bold">&bull; Crowdsourcing & Kurasi Kelayakan</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C] mt-1">KURASI & KATALOG RUKO</h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                Pusat kendali peninjauan kelayakan usulan tempat usaha dari investor, pelaku UMKM, dan masyarakat umum sebelum resmi diterbitkan.
            </p>
        </div>

        <div class="flex items-center gap-2.5 self-start sm:self-auto">
            <a href="{{ route('ruko.usulkan.public') }}" target="_blank"
               class="px-5 py-2.5 rounded-2xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm inline-flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Buka Form Publik</span>
            </a>
        </div>
    </div>

    <!-- TAB NAVIGASI KURASI VS KATALOG AKTIF -->
    <div class="flex flex-wrap items-center gap-2 p-1.5 bg-white rounded-2xl border border-[#E8E6DF] w-fit shadow-sm">
        <a href="{{ route('superadmin.ruko', ['tab' => 'kurasi']) }}"
           class="px-5 py-2.5 rounded-xl text-xs font-black tracking-wider uppercase transition flex items-center gap-2 {{ ($activeTab ?? 'kurasi') === 'kurasi' ? 'bg-[#0F433C] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
            <span>KURASI USULAN MASUK</span>
            @if(isset($pendingRukoCount) && $pendingRukoCount > 0)
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ ($activeTab ?? 'kurasi') === 'kurasi' ? 'bg-amber-400 text-amber-950' : 'bg-amber-100 text-amber-800' }}">
                    {{ $pendingRukoCount }}
                </span>
            @endif
        </a>

        <a href="{{ route('superadmin.ruko', ['tab' => 'katalog']) }}"
           class="px-5 py-2.5 rounded-xl text-xs font-black tracking-wider uppercase transition flex items-center gap-2 {{ ($activeTab ?? '') === 'katalog' ? 'bg-[#0F433C] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
            <span>KATALOG RUKO AKTIF</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ ($activeTab ?? '') === 'katalog' ? 'bg-teal-300 text-teal-950' : 'bg-gray-100 text-gray-600' }}">
                {{ $rukos->total() ?? $rukos->count() }}
            </span>
        </a>

        <a href="{{ route('superadmin.ruko', ['tab' => 'transaksi']) }}"
           class="px-5 py-2.5 rounded-xl text-xs font-black tracking-wider uppercase transition flex items-center gap-2 {{ ($activeTab ?? '') === 'transaksi' ? 'bg-[#0F433C] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
            <span>SPONSOR SEWA MASUK</span>
            @if(isset($pendingSewaCount) && $pendingSewaCount > 0)
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ ($activeTab ?? '') === 'transaksi' ? 'bg-amber-400 text-amber-950 animate-pulse' : 'bg-amber-100 text-amber-800' }}">
                    {{ $pendingSewaCount }}
                </span>
            @else
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ ($activeTab ?? '') === 'transaksi' ? 'bg-teal-300 text-teal-950' : 'bg-gray-100 text-gray-600' }}">
                    {{ isset($transaksiSewas) ? $transaksiSewas->count() : 0 }}
                </span>
            @endif
        </a>
    </div>

    {{-- ========================================================================= --}}
    {{-- TAB 1: KURASI USULAN MASUK DARI CROWDSOURCING (INVESTOR, UMKM, PUBLIK)      --}}
    {{-- ========================================================================= --}}
    @if(($activeTab ?? 'kurasi') === 'kurasi')

        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-black text-[#1A202C]">Daftar Usulan Tempat Usaha</h2>
                    <p class="text-xs text-gray-400">Verifikasi kelayakan harga, akses jalan, dan potensi pasar ruko sebelum disetujui (ACC).</p>
                </div>
                <div class="text-xs font-bold text-gray-500">
                    Total Usulan: <span class="text-[#0F433C] font-black">{{ $rekomendasiRukos->count() }} Lokasi</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($rekomendasiRukos as $item)
                    <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <!-- Header Kartu: Status & Pengusul -->
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <div>
                                    @if($item->tipe_pengusul === 'investor')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            🟢 Mitra Investor
                                        </span>
                                    @elseif($item->tipe_pengusul === 'umkm')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-sky-100 text-sky-800 border border-sky-200">
                                            🔵 Pelaku UMKM
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-amber-100 text-amber-900 border border-amber-200">
                                            🟡 Publik / Warga
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    @if($item->status === 'disetujui')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-500 text-white shadow-sm">
                                            ✓ Terbit di Katalog
                                        </span>
                                    @elseif($item->status === 'ditolak')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-rose-100 text-rose-700 border border-rose-200">
                                            ✕ Ditolak
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-amber-400 text-amber-950 animate-pulse">
                                            ● Menunggu ACC
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- FOTO RUKO / ILUSTRASI FISIK -->
                            <div class="w-full h-44 rounded-2xl bg-gray-100 mb-4 overflow-hidden relative shadow-inner border border-gray-100 group">
                                @if(!empty($item->foto_ruko))
                                    <img src="{{ asset($item->foto_ruko) }}" alt="{{ $item->nama_ruko }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    <a href="{{ asset($item->foto_ruko) }}" target="_blank" class="absolute bottom-2 right-2 px-2.5 py-1 rounded-lg bg-black/60 backdrop-blur-sm text-white text-[10px] font-bold hover:bg-black/80 transition">
                                        🔍 Lihat Foto Penuh
                                    </a>
                                @else
                                    <div class="w-full h-full bg-[#6B9E8A] text-white flex items-center justify-center font-black text-xl">
                                        <div class="text-center p-4">
                                            <svg class="w-10 h-10 mx-auto opacity-80 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            <span class="text-xs font-bold uppercase tracking-wider block">Foto Belum Diunggah</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <h3 class="text-base font-black text-[#1A202C] leading-snug">
                                {{ $item->nama_ruko }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-1 flex items-start gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="line-clamp-2">{{ $item->lokasi }}</span>
                            </p>

                            <!-- RINCIAN FINANSIAL & PENGUSUL -->
                            <div class="mt-4 p-3.5 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] space-y-2 text-xs">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 font-medium">Usulan Harga Sewa:</span>
                                    <span class="font-black text-[#0F433C] text-sm">
                                        Rp {{ number_format($item->harga_sewa_per_bulan, 0, ',', '.') }} / bln
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 font-medium">Kapasitas Unit:</span>
                                    <span class="font-bold text-gray-800">
                                        {{ $item->total_unit ?? 1 }} Unit Ruko
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 font-medium">Diajukan Oleh:</span>
                                    <span class="font-bold text-gray-800 truncate max-w-[170px]" title="{{ $item->label_pengusul }}">
                                        {{ $item->label_pengusul }}
                                    </span>
                                </div>
                                @if(!empty($item->kontak_pemilik) || !empty($item->kontak_pengusul))
                                    <div class="flex justify-between items-center pt-2 border-t border-gray-200/60">
                                        <span class="text-gray-500 font-medium">Kontak HP/WA:</span>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->kontak_pemilik ?: $item->kontak_pengusul) }}" target="_blank" class="font-bold text-emerald-700 hover:underline">
                                            {{ $item->kontak_pemilik ?: $item->kontak_pengusul }} ↗
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- ANALISIS POTENSI USAHA -->
                            @if(!empty($item->potensi_usaha))
                                <div class="mt-3 p-3 rounded-xl bg-teal-50/70 border border-teal-200/70 text-[11px] text-teal-950">
                                    <strong class="block text-[10px] uppercase font-black text-teal-800 mb-0.5">Analisis Potensi Pasar:</strong>
                                    <p class="italic line-clamp-3">"{{ $item->potensi_usaha }}"</p>
                                </div>
                            @endif

                            @if(!empty($item->catatan_admin))
                                <div class="mt-3 p-3 rounded-xl bg-gray-50 border border-gray-200 text-[11px] text-gray-700">
                                    <strong class="block text-[10px] uppercase font-black text-gray-500 mb-0.5">Catatan Kurasi Admin:</strong>
                                    <p>{{ $item->catatan_admin }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- TOMBOL AKSI KURASI ADMIN -->
                        <div class="mt-5 pt-4 border-t border-gray-100">
                            @if($item->status === 'menunggu_verifikasi')
                                <div class="grid grid-cols-2 gap-2">
                                    <!-- FORM ACC / APPROVE -->
                                    <form id="form-approve-ruko-{{ $item->id_rekomendasi }}" action="{{ route('superadmin.ruko.rekomendasi.approve', $item->id_rekomendasi) }}" method="POST">
                                        @csrf
                                        <button type="button"
                                                onclick="openAppConfirmModal({
                                                    title: 'ACC & Terbitkan Ruko',
                                                    message: 'Apakah Anda yakin ruko <strong>{{ addslashes($item->nama_ruko) }}</strong> LAYAK dan ingin menerbitkannya ke Katalog Ruko Resmi DAYA UMKM?',
                                                    badge: 'Rp {{ number_format($item->harga_sewa_per_bulan, 0, ',', '.') }}/bln &bull; {{ addslashes($item->nama_ruko) }}',
                                                    confirmText: '✓ Ya, ACC & Terbitkan',
                                                    confirmClass: 'bg-[#0F433C] hover:bg-[#19584F] text-white',
                                                    icon: 'check',
                                                    form: document.getElementById('form-approve-ruko-{{ $item->id_rekomendasi }}')
                                                })"
                                                class="w-full py-2.5 px-3 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold text-center transition shadow-sm flex items-center justify-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>ACC (Terbitkan)</span>
                                        </button>
                                    </form>

                                    <!-- FORM REJECT / TOLAK -->
                                    <button type="button"
                                            onclick="openRejectRukoModal('{{ $item->id_rekomendasi }}', '{{ addslashes($item->nama_ruko) }}')"
                                            class="w-full py-2.5 px-3 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-bold text-center transition">
                                        ✕ Tidak Layak
                                    </button>
                                </div>
                            @elseif($item->status === 'disetujui')
                                <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold text-center flex items-center justify-center gap-1.5">
                                    <span>🟢 Ruko Aktif & Tayang di Katalog</span>
                                </div>
                            @else
                                <div class="p-2.5 rounded-xl bg-gray-100 border border-gray-200 text-gray-500 text-xs font-bold text-center">
                                    <span>Usulan Telah Ditolak</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-[#E8E6DF]">
                        <div class="w-16 h-16 rounded-full bg-teal-50 text-[#0F433C] mx-auto flex items-center justify-center mb-4">
                            📍
                        </div>
                        <h3 class="text-base font-black text-gray-800">Belum ada usulan ruko yang masuk</h3>
                        <p class="text-xs text-gray-500 mt-1 max-w-md mx-auto">
                            Usulan tempat usaha yang diajukan oleh masyarakat, agen properti, UMKM, atau investor akan tampil di sini untuk Anda kurasi.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

    {{-- ========================================================================= --}}
    {{-- TAB 2: KATALOG RUKO RESMI YANG SEDANG TAYANG DI PLATFORM                  --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'katalog')

        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-black text-[#1A202C]">Katalog Ruko Resmi Aktif</h2>
                    <p class="text-xs text-gray-400">Seluruh unit ruko komersial yang telah lolos kurasi dan siap disewa oleh UMKM binaan.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($rukos as $ruko)
                    <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-4">
                                <span class="text-xs font-mono font-bold text-gray-400">#RUKO-{{ $ruko->id_ruko }}</span>
                                @if($ruko->is_penuh)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-rose-100 text-rose-800 border border-rose-200 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span> Sudah Diisi (Penuh)
                                    </span>
                                @elseif(($ruko->unit_terisi ?? 0) > 0)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-amber-100 text-amber-800 border border-amber-200 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Sisa {{ $ruko->sisa_unit }} Unit
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Kosong (Sisa {{ $ruko->sisa_unit }} Unit)
                                    </span>
                                @endif
                            </div>

                            <div class="w-full h-40 rounded-2xl bg-gray-100 mb-4 overflow-hidden shadow-inner border border-gray-100">
                                @if(!empty($ruko->foto_ruko))
                                    <img src="{{ asset(ltrim($ruko->foto_ruko, '/\\')) }}" alt="{{ $ruko->nama_ruko }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                         onerror="this.onerror=null; this.src='{{ $ruko->foto_url }}';">
                                @elseif(!empty($ruko->foto_url))
                                    <img src="{{ $ruko->foto_url }}" alt="{{ $ruko->nama_ruko }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full bg-[#6B9E8A] text-white flex items-center justify-center font-black text-xl">
                                        <div class="text-center">
                                            <svg class="w-10 h-10 mx-auto opacity-80 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            <span class="text-xs font-bold uppercase tracking-wider">Unit Ruko Komersial</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <h3 class="text-base font-black text-[#1A202C]">{{ $ruko->nama_ruko }}</h3>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="truncate">{{ $ruko->lokasi }}</span>
                            </p>

                            <!-- Rating Potensi Lokasi & Kurasi Ruko -->
                            <div class="mt-2.5 flex items-center justify-between text-xs">
                                <div class="flex items-center gap-1.5">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 border border-amber-200 text-amber-900 text-xs font-black">
                                        <span class="text-amber-500">★</span>
                                        <span>{{ number_format($ruko->rating_lokasi, 1) }}</span>
                                    </span>
                                    <span class="text-gray-400 text-[11px] font-medium">Skor Kelayakan Lokasi</span>
                                </div>
                                <span class="text-[11px] font-bold text-teal-800 bg-teal-50 px-2.5 py-0.5 rounded-full border border-teal-200">
                                    ✓ Terkurasi TIKUM
                                </span>
                            </div>

                            @if(!empty($ruko->deskripsi_potensi))
                                <p class="text-[11px] text-gray-600 mt-2 line-clamp-2 italic">
                                    "{{ $ruko->deskripsi_potensi }}"
                                </p>
                            @endif

                            <!-- Box Kapasitas & Sisa Unit -->
                            <div class="mt-3.5 p-3 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] space-y-1.5 text-xs">
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="text-gray-400 font-medium">Kondisi Lapak:</span>
                                    @if($ruko->is_penuh)
                                        <span class="font-bold text-rose-600">🔴 Sudah Diisi Penuh</span>
                                    @elseif(($ruko->unit_terisi ?? 0) > 0)
                                        <span class="font-bold text-amber-700">🟡 Terisi Sebagian ({{ $ruko->unit_terisi }}/{{ $ruko->total_unit }} Unit)</span>
                                    @else
                                        <span class="font-bold text-emerald-700">🟢 Kosong (Siap Huni)</span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="text-gray-400 font-medium">Kapasitas & Ketersediaan:</span>
                                    <span class="font-black text-gray-800">
                                        <span class="{{ $ruko->sisa_unit > 0 ? 'text-emerald-700' : 'text-rose-600' }}">{{ $ruko->sisa_unit }} Unit Kosong</span>
                                        <span class="text-gray-400 font-normal">/ {{ $ruko->total_unit ?? 1 }} Total</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-gray-400 block">Sewa Bulanan</span>
                                <span class="text-sm font-black text-[#0F433C]">
                                    Rp {{ number_format($ruko->harga_sewa_per_bulan, 0, ',', '.') }} / bln
                                </span>
                            </div>
                            <div class="text-[11px] font-semibold text-gray-500">
                                {{ $ruko->penyedia->nama_perusahaan ?? 'Mitra Komunitas' }}
                            </div>
                        </div>

                        @if(!empty($ruko->kontak_pemilik))
                            <div class="mt-3 pt-2.5 border-t border-dashed border-gray-200 flex items-center justify-between text-xs">
                                <span class="text-gray-400 font-medium text-[11px]">Kontak Pemilik / WA:</span>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ruko->kontak_pemilik) }}" target="_blank"
                                   class="font-bold text-emerald-700 hover:underline inline-flex items-center gap-1 text-[11px]">
                                    <span>{{ $ruko->kontak_pemilik }}</span>
                                    <span>↗</span>
                                </a>
                            </div>
                        @endif

                        <!-- Tombol Kelola Unit & Ketersediaan -->
                        <div class="mt-3.5 pt-3 border-t border-gray-100">
                            <button type="button"
                                    onclick="openUpdateKetersediaanModal('{{ $ruko->id_ruko }}', '{{ addslashes($ruko->nama_ruko) }}', {{ $ruko->total_unit ?? 1 }}, {{ $ruko->unit_terisi ?? 0 }})"
                                    class="w-full py-2.5 px-3 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-xs">
                                <span>⚙️ Atur Kapasitas Unit & Status</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-[#E8E6DF]">
                        <p class="text-sm font-bold text-gray-500">Belum ada data unit ruko yang terdaftar.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $rukos->links() }}
            </div>
        </div>

    {{-- ========================================================================= --}}
    {{-- TAB 3: SPONSOR SEWA MASUK DARI MITRA INVESTOR                             --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'transaksi')

        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-black text-[#1A202C]">Transaksi Sponsor Sewa Ruko Komersial</h2>
                    <p class="text-xs text-gray-400">Verifikasi dan konfirmasi pencairan komitmen dana sewa ruko dari mitra investor untuk ekspansi gerai UMKM.</p>
                </div>
                <div class="text-xs font-bold text-gray-500">
                    Total Transaksi: <span class="text-[#0F433C] font-black">{{ $transaksiSewas->count() }} Kontrak</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($transaksiSewas as $sewa)
                    <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <!-- Header Kartu: Label & Status -->
                            <div class="flex items-center justify-between gap-2 mb-3">
                                @if($sewa->investor)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-teal-50 text-teal-800 border border-teal-200">
                                        🏢 Sponsor Investor
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        🏪 Sewa Mandiri UMKM
                                    </span>
                                @endif
                                <div>
                                    @if($sewa->status_pembayaran === 'dibayar')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1">
                                            ✓ DIBAYAR (AKTIF)
                                        </span>
                                    @elseif($sewa->status_pembayaran === 'dibatalkan')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-rose-100 text-rose-800 border border-rose-200">
                                            ✕ DIBATALKAN
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-amber-400 text-amber-950 animate-pulse flex items-center gap-1 shadow-sm">
                                            ● MENUNGGU KONFIRMASI
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Nama Ruko & Lokasi -->
                            <h3 class="text-base font-black text-[#1A202C] leading-snug">
                                {{ $sewa->ruko->nama_ruko ?? 'Unit Ruko' }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                📍 {{ $sewa->ruko->lokasi ?? '-' }}
                            </p>

                            <!-- Kotak Sinergi: Investor/Mandiri & UMKM -->
                            <div class="mt-4 p-4 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] space-y-2.5 text-xs">
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider">Mitra UMKM Penyewa</span>
                                    <span class="font-black text-[#1A202C] text-sm block mt-0.5">
                                        {{ $sewa->umkm->nama_usaha ?? 'UMKM Mitra' }}
                                    </span>
                                    <span class="text-[11px] text-gray-500 block">
                                        Pemilik: {{ $sewa->umkm->pemilik ?? '-' }} 
                                        @if(!empty($sewa->umkm->nomor_whatsapp))
                                            &bull; WA: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sewa->umkm->nomor_whatsapp) }}" target="_blank" class="text-emerald-700 font-bold hover:underline">{{ $sewa->umkm->nomor_whatsapp }}</a>
                                        @endif
                                    </span>
                                </div>

                                @if($sewa->investor)
                                    <div class="pt-2 border-t border-gray-200">
                                        <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider">Mitra Investor Pendana</span>
                                        <span class="font-black text-[#0F433C] text-sm block mt-0.5">
                                            {{ $sewa->investor->name }}
                                        </span>
                                        <span class="text-[11px] text-gray-500 block">
                                            {{ $sewa->investor->email ?? '-' }} &bull; {{ $sewa->investor->phone_number ?? '-' }}
                                        </span>
                                        @if(!empty($sewa->investor->bank_name))
                                            <span class="text-[10px] text-teal-800 font-semibold block mt-0.5">
                                                Rek: {{ $sewa->investor->bank_name }} - {{ $sewa->investor->nomor_rekening }} (a.n {{ $sewa->investor->nama_pemilik_rekening }})
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <div class="pt-2 border-t border-gray-200">
                                        <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider">Metode Pembiayaan</span>
                                        <span class="font-black text-emerald-800 text-sm block mt-0.5 flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            Sewa Mandiri oleh Pelaku UMKM
                                        </span>
                                        <span class="text-[11px] text-gray-500 block">
                                            Dibiayai langsung secara mandiri tanpa sponsor pihak investor.
                                        </span>
                                    </div>
                                @endif

                                <div class="pt-2 border-t border-gray-200 flex justify-between items-center">
                                    <span class="text-gray-500 font-medium">Dana Sewa:</span>
                                    <span class="font-black text-[#0F433C] text-base">
                                        Rp {{ number_format($sewa->total_harga, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="text-gray-500 font-medium">Periode Sewa:</span>
                                    <span class="font-bold text-gray-800">
                                        {{ $sewa->tanggal_mulai ? $sewa->tanggal_mulai->format('d M Y') : '-' }} s/d {{ $sewa->tanggal_selesai ? $sewa->tanggal_selesai->format('d M Y') : '-' }}
                                    </span>
                                </div>
                            </div>

                            @if(!empty($sewa->catatan_sponsor))
                                <div class="mt-3 p-3 rounded-xl bg-gray-50 border border-gray-100 text-xs text-gray-600 italic">
                                    "{{ $sewa->catatan_sponsor }}"
                                </div>
                            @endif

                            <div class="mt-2 text-[10px] text-gray-400 text-right">
                                Diajukan: {{ $sewa->created_at ? $sewa->created_at->format('d M Y, H:i') : '-' }} WIB
                            </div>
                        </div>

                        <!-- Aksi Konfirmasi Admin -->
                        <div class="mt-4 pt-3.5 border-t border-gray-100">
                            @if($sewa->status_pembayaran === 'menunggu_konfirmasi')
                                <div class="flex flex-col sm:flex-row items-center gap-2">
                                    <form id="form-confirm-sewa-{{ $sewa->id_sewa }}" method="POST" action="{{ route('superadmin.ruko.sewa.confirm', $sewa->id_sewa) }}" class="w-full sm:flex-1">
                                        @csrf
                                        <button type="button"
                                                onclick="openAppConfirmModal({
                                                    title: 'Konfirmasi Transaksi Sewa Ruko',
                                                    message: 'Konfirmasi transaksi sewa ruko sebesar <strong>Rp {{ number_format($sewa->total_harga, 0, ',', '.') }}</strong> untuk UMKM <strong>{{ addslashes($sewa->umkm->nama_usaha ?? 'Mitra UMKM') }}</strong>{{ $sewa->investor ? (' dari sponsor investor <strong>' . addslashes($sewa->investor->name) . '</strong>') : ' (Sewa Mandiri)' }} telah disalurkan dan ruko resmi diserahterimakan?',
                                                    badge: 'Rp {{ number_format($sewa->total_harga, 0, ',', '.') }} &bull; {{ addslashes($sewa->ruko->nama_ruko ?? 'Ruko') }}',
                                                    confirmText: '✓ Ya, Konfirmasi (ACC)',
                                                    confirmClass: 'bg-[#0F433C] hover:bg-[#19584F] text-white',
                                                    icon: 'check',
                                                    form: document.getElementById('form-confirm-sewa-{{ $sewa->id_sewa }}')
                                                })"
                                                class="w-full py-2.5 px-3 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-black transition shadow-sm flex items-center justify-center gap-1.5 active:scale-95">
                                            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Konfirmasi (ACC)</span>
                                        </button>
                                    </form>

                                    <form id="form-reject-sewa-{{ $sewa->id_sewa }}" method="POST" action="{{ route('superadmin.ruko.sewa.reject', $sewa->id_sewa) }}" class="w-full sm:w-auto">
                                        @csrf
                                        <button type="button"
                                                onclick="openAppConfirmModal({
                                                    title: 'Batalkan Transaksi Sewa Ruko',
                                                    message: 'Apakah Anda yakin ingin membatalkan transaksi sewa ruko <strong>{{ addslashes($sewa->ruko->nama_ruko ?? 'Ruko') }}</strong> senilai Rp {{ number_format($sewa->total_harga, 0, ',', '.') }}? Kuota unit ruko akan otomatis dikembalikan ke katalog.',
                                                    badge: '✕ Pembatalan Transaksi #SEWA-{{ $sewa->id_sewa }}',
                                                    confirmText: '✕ Ya, Batalkan Transaksi',
                                                    confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
                                                    icon: 'danger',
                                                    form: document.getElementById('form-reject-sewa-{{ $sewa->id_sewa }}')
                                                })"
                                                class="w-full py-2.5 px-3 rounded-xl border border-rose-200 hover:bg-rose-50 text-rose-600 text-xs font-bold transition flex items-center justify-center gap-1 active:scale-95">
                                            <span>✕ Tolak</span>
                                        </button>
                                    </form>
                                </div>
                            @elseif($sewa->status_pembayaran === 'dibayar')
                                <div class="space-y-2">
                                    <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-800 text-center text-xs font-bold border border-emerald-100 flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Telah Dikonfirmasi (Lunas & Aktif)</span>
                                    </div>

                                    @if(!empty($sewa->ruko->kontak_pemilik))
                                        @php
                                            $pihakSewa = $sewa->investor 
                                                ? ("didanai oleh Mitra Investor (" . $sewa->investor->name . ") untuk Mitra UMKM \"" . ($sewa->umkm->nama_usaha ?? 'UMKM') . "\" (Bpk/Ibu " . ($sewa->umkm->pemilik ?? '-') . ")")
                                                : ("disewa secara mandiri oleh Mitra UMKM \"" . ($sewa->umkm->nama_usaha ?? 'UMKM') . "\" (Bpk/Ibu " . ($sewa->umkm->pemilik ?? '-') . ")");
                                            $waMsg = "Halo Bapak/Ibu Pemilik Ruko " . ($sewa->ruko->nama_ruko ?? 'Komersial') . ", kami dari Admin Platform Titik UMKM (TIKUM).\n\n" .
                                                     "Kami ingin menginformasikan bahwa unit ruko Anda di " . ($sewa->ruko->lokasi ?? '-') . " telah resmi " . $pihakSewa . " senilai Rp " . number_format($sewa->total_harga, 0, ',', '.') . ".\n\n" .
                                                     "Mohon informasi dan koordinasi untuk proses serah terima kunci serta operasional ruko. Terima kasih.";
                                        @endphp
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sewa->ruko->kontak_pemilik) }}?text={{ urlencode($waMsg) }}"
                                           target="_blank"
                                           class="w-full py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                                            <span>💬 Hubungi Pemilik Ruko via WhatsApp</span>
                                            <span class="text-[10px]">↗</span>
                                        </a>
                                    @endif
                                </div>
                            @else
                                <div class="p-2.5 rounded-xl bg-rose-50 text-rose-700 text-center text-xs font-bold border border-rose-100">
                                    <span>Transaksi Telah Dibatalkan</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-[#E8E6DF]">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-teal-50 text-[#0F433C] flex items-center justify-center text-2xl">
                            🏢
                        </div>
                        <h3 class="text-sm font-black text-gray-800">Belum Ada Transaksi Sponsor Sewa</h3>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto">
                            Saat mitra investor memilih ruko di katalog dan mendanai sewa untuk UMKM, pengajuan komitmen akan muncul di sini untuk Anda konfirmasi.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

    @endif

</div>

<!-- MODAL KHUSUS TOLAK USULAN RUKO DENGAN ALASAN -->
<div id="modal-reject-ruko" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" onclick="closeRejectRukoModal()"></div>
    <div class="relative w-full max-w-md bg-white rounded-3xl p-6 sm:p-7 shadow-2xl border border-gray-100 z-10 animate-fadeIn">
        <div class="flex items-start gap-3.5 mb-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-black text-gray-900">Tolak Usulan Ruko</h3>
                <p id="reject-ruko-subtitle" class="text-xs text-gray-500 mt-0.5">Tandai lokasi ruko sebagai tidak layak untuk tempat usaha UMKM.</p>
            </div>
        </div>

        <form id="form-reject-ruko-submit" method="POST" action="">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alasan Kurasi Penolakan *</label>
                <textarea name="catatan_admin" required rows="3" placeholder="Contoh: Harga sewa di atas batas wajar permodalan UMKM, atau akses jalan sempit dan rawan genangan air."
                          class="w-full p-3.5 rounded-2xl border border-gray-200 text-xs font-medium focus:ring-2 focus:ring-rose-500 focus:outline-none"></textarea>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeRejectRukoModal()" class="px-4 py-2.5 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-black shadow-md bg-rose-600 hover:bg-rose-700 text-white transition">
                    ✕ Ya, Tolak Usulan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectRukoModal(id, nama) {
        const modal = document.getElementById('modal-reject-ruko');
        const form = document.getElementById('form-reject-ruko-submit');
        const subtitle = document.getElementById('reject-ruko-subtitle');
        
        form.action = '/super-admin/ruko/rekomendasi/' + id + '/reject';
        subtitle.innerText = 'Ruko: ' + nama;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeRejectRukoModal() {
        const modal = document.getElementById('modal-reject-ruko');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Modal Kelola Kapasitas & Status Unit Ruko
    function openUpdateKetersediaanModal(id, nama, totalUnit, unitTerisi) {
        const modal = document.getElementById('modal-update-ketersediaan');
        const form = document.getElementById('form-update-ketersediaan-submit');
        const subtitle = document.getElementById('update-ketersediaan-subtitle');
        const inputTotal = document.getElementById('input-modal-total-unit');
        const inputTerisi = document.getElementById('input-modal-unit-terisi');

        form.action = '/super-admin/ruko/' + id + '/update-ketersediaan';
        subtitle.innerText = 'Unit Ruko: ' + nama;
        inputTotal.value = totalUnit || 1;
        inputTerisi.value = unitTerisi || 0;

        recalcModalSisa();

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function recalcModalSisa() {
        const total = parseInt(document.getElementById('input-modal-total-unit').value) || 0;
        const terisi = parseInt(document.getElementById('input-modal-unit-terisi').value) || 0;
        const sisa = Math.max(0, total - terisi);
        const el = document.getElementById('modal-preview-sisa-unit');

        if (sisa === 0) {
            el.innerHTML = '<span class="text-rose-600 font-black">0 Unit (Sudah Diisi Penuh)</span>';
        } else if (terisi > 0) {
            el.innerHTML = '<span class="text-amber-700 font-black">' + sisa + ' Unit Kosong (Terisi Sebagian)</span>';
        } else {
            el.innerHTML = '<span class="text-emerald-700 font-black">' + sisa + ' Unit Kosong (Siap Huni)</span>';
        }
    }

    function closeUpdateKetersediaanModal() {
        const modal = document.getElementById('modal-update-ketersediaan');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

<!-- MODAL ATUR KAPASITAS & STATUS UNIT RUKO (SUPER ADMIN) -->
<div id="modal-update-ketersediaan" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" onclick="closeUpdateKetersediaanModal()"></div>
    <div class="relative w-full max-w-md bg-white rounded-3xl p-6 sm:p-7 shadow-2xl border border-gray-100 z-10 animate-fadeIn">
        <div class="flex items-start gap-3.5 mb-4">
            <div class="w-12 h-12 rounded-2xl bg-teal-100 text-[#0F433C] flex items-center justify-center shrink-0 text-xl font-black">
                🏢
            </div>
            <div>
                <h3 class="text-base font-black text-gray-900">Kelola Kapasitas & Status Unit</h3>
                <p id="update-ketersediaan-subtitle" class="text-xs text-gray-500 mt-0.5">Nama Ruko</p>
            </div>
        </div>

        <form id="form-update-ketersediaan-submit" method="POST" action="" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Jumlah Total Unit / Pintu *</label>
                <input type="number" id="input-modal-total-unit" name="total_unit" required min="1" max="100"
                       class="w-full p-3 rounded-2xl border border-gray-200 text-xs font-bold focus:ring-2 focus:ring-[#0F433C] focus:outline-none"
                       oninput="recalcModalSisa()">
                <span class="text-[10px] text-gray-400 mt-1 block">Total keseluruhan unit pintu ruko di lokasi ini.</span>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Jumlah Unit yang Sudah Terisi *</label>
                <input type="number" id="input-modal-unit-terisi" name="unit_terisi" required min="0"
                       class="w-full p-3 rounded-2xl border border-gray-200 text-xs font-bold focus:ring-2 focus:ring-[#0F433C] focus:outline-none"
                       oninput="recalcModalSisa()">
                <span class="text-[10px] text-gray-400 mt-1 block">Berapa unit yang sedang disewa atau ditempati saat ini.</span>
            </div>

            <div class="p-3.5 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] flex items-center justify-between text-xs">
                <span class="text-gray-500 font-medium">Estimasi Sisa Unit Kosong:</span>
                <span id="modal-preview-sisa-unit" class="font-black text-[#0F433C] text-sm">0 Unit</span>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeUpdateKetersediaanModal()" class="px-4 py-2.5 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-black shadow-md bg-[#0F433C] hover:bg-[#19584F] text-white transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
