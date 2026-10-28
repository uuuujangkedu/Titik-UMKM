@extends('layouts.umkm')

@section('title', 'Dashboard Pelaku UMKM - DAYA UMKM')

@section('content')
<div class="space-y-8">

    {{-- ========================================================================= --}}
    {{-- TAB 1: BERANDA UMKM (Sesuai Mockup Gambar 2 Atas)                         --}}
    {{-- ========================================================================= --}}
    @if(($activeTab ?? 'beranda') === 'beranda')

        <!-- NOTIFIKASI MINAT INVESTASI MASUK DARI INVESTOR (Fitur Inti Permintaan User) -->
        @if(isset($notifikasiInvestasi) && $notifikasiInvestasi->count() > 0)
            <div class="bg-gradient-to-r from-amber-50/90 via-yellow-50/80 to-emerald-50/90 rounded-3xl p-6 sm:p-7 shadow-sm border border-amber-200/50 animate-fade-in">
                <!-- Header Banner Notifikasi Investor -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 mb-5 border-b border-amber-200/70">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-amber-400 text-amber-950 flex items-center justify-center text-xl font-bold shrink-0 shadow-sm">
                            🎉
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2.5">
                                <h3 class="text-base sm:text-lg font-extrabold text-[#1A202C]">
                                    Kabar Baik! Ada Investor Tertarik Mendanai Usaha Anda
                                </h3>
                                @if(isset($unreadInvestasiCount) && $unreadInvestasiCount > 0)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white animate-pulse">
                                        {{ $unreadInvestasiCount }} Baru
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-[#555555] mt-1 font-medium">
                                Calon investor telah meninjau proposal Anda dan menyatakan komitmen pendanaan
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('dashboard', ['tab' => 'inbox']) }}" 
                       class="px-4 py-2.5 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold shadow-sm transition flex items-center gap-2 shrink-0 self-start sm:self-center">
                        <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>Buka Inbox Pendanaan</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <!-- Daftar Notifikasi Investor Berjarak Rapi -->
                <div class="space-y-4">
                    @foreach($notifikasiInvestasi as $notif)
                        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-amber-100 flex flex-col lg:flex-row lg:items-center justify-between gap-5 transition hover:shadow-md">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-900 flex items-center justify-center font-black text-sm shrink-0 border border-blue-200 shadow-sm">
                                    {{ strtoupper(substr($notif->pengguna->name ?? 'I', 0, 2)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2.5">
                                        <h4 class="text-base font-extrabold text-[#1A202C]">
                                            {{ $notif->pengguna->name ?? 'Investor' }}
                                        </h4>
                                        @if($notif->status === 'aktif')
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                🟢 Kemitraan Aktif
                                            </span>
                                        @elseif($notif->status === 'ditolak')
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-gray-100 text-gray-600 border border-gray-200">
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-amber-100 text-amber-900 border border-amber-200">
                                                Menunggu Respon Anda
                                            </span>
                                        @endif

                                        @if(!$notif->dibaca)
                                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500 ring-2 ring-rose-200" title="Belum dibaca"></span>
                                        @endif
                                    </div>
                                    <p class="text-xs sm:text-sm text-gray-700 mt-2">
                                        Komitmen Modal: <span class="font-extrabold text-emerald-700 text-sm sm:text-base">Rp {{ number_format($notif->jumlah_modal, 0, ',', '.') }}</span>
                                        &bull; Bagi Hasil: <span class="font-bold text-gray-800">{{ $notif->persentase_bagi_hasil }}% ({{ $notif->periode_pembagian }})</span>
                                    </p>
                                    @if(!empty($notif->catatan))
                                        <p class="text-xs text-gray-600 italic mt-3 bg-gray-50/90 p-3 rounded-xl border border-gray-100">
                                            "{{ $notif->catatan }}"
                                        </p>
                                    @endif
                                    <span class="text-[11px] text-gray-400 mt-2 block font-medium">
                                        Diajukan {{ $notif->tanggal_investasi ? $notif->tanggal_investasi->diffForHumans() : '-' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Tombol Tindak Lanjut UMKM (Sinergi Dua Arah) -->
                            <div class="flex flex-wrap items-center gap-2.5 shrink-0 self-start lg:self-center pt-2 lg:pt-0">
                                @if($notif->status === 'pending')
                                    <!-- Aksi Terima Investasi -->
                                    <form id="form-terima-beranda-{{ $notif->id_investasi }}" action="{{ route('dashboard.umkm.investasi.terima', $notif->id_investasi) }}" method="POST">
                                        @csrf
                                        <button type="button" 
                                                onclick="openAppConfirmModal({
                                                    title: 'Terima Komitmen Investasi',
                                                    message: 'Apakah Anda yakin ingin menerima komitmen investasi ini dari <strong>{{ addslashes($notif->pengguna->name ?? 'Investor') }}</strong>? Status kemitraan akan resmi berstatus <strong>AKTIF</strong> dan tercatat dalam permodalan usaha.',
                                                    badge: 'Rp {{ number_format($notif->jumlah_modal, 0, ',', '.') }} &bull; {{ $notif->persentase_bagi_hasil }}% Bagi Hasil',
                                                    confirmText: 'Ya, Terima Investasi',
                                                    confirmClass: 'bg-[#0F433C] hover:bg-[#19584F] text-white',
                                                    icon: 'check',
                                                    form: document.getElementById('form-terima-beranda-{{ $notif->id_investasi }}')
                                                })"
                                                class="px-4 py-2.5 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Terima Investasi</span>
                                        </button>
                                    </form>

                                    <!-- Aksi Tolak Investasi -->
                                    <form id="form-tolak-beranda-{{ $notif->id_investasi }}" action="{{ route('dashboard.umkm.investasi.tolak', $notif->id_investasi) }}" method="POST">
                                        @csrf
                                        <button type="button"
                                                onclick="openAppConfirmModal({
                                                    title: 'Tolak Minat Investasi',
                                                    message: 'Apakah Anda yakin ingin menolak minat pendanaan dari <strong>{{ addslashes($notif->pengguna->name ?? 'Investor') }}</strong>? Penolakan ini akan mengembalikan status pengajuan.',
                                                    badge: 'Tolak Tawaran Rp {{ number_format($notif->jumlah_modal, 0, ',', '.') }}',
                                                    confirmText: 'Ya, Tolak Investasi',
                                                    confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
                                                    icon: 'danger',
                                                    form: document.getElementById('form-tolak-beranda-{{ $notif->id_investasi }}')
                                                })"
                                                class="px-4 py-2.5 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-bold transition">
                                            ✕ Tolak
                                        </button>
                                    </form>
                                @elseif($notif->status === 'aktif')
                                    <!-- Tombol E-Sign & Akad Digital -->
                                    <a href="{{ route('kontrak.show', $notif->id_investasi) }}" 
                                       class="px-4 py-2.5 rounded-xl hover:opacity-90 transition shadow-sm flex items-center gap-2"
                                       style="background-color: #0F433C !important; color: #ffffff !important; border: 1px solid #165E54 !important;">
                                        <svg class="w-4 h-4 text-amber-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span style="color: #ffffff !important; font-weight: 800; font-size: 12px;">Akad & E-Sign</span>
                                    </a>

                                    <!-- Tombol Setor Dividen Cepat -->
                                    <button type="button" 
                                            onclick="openSetorDividenModal('{{ $notif->id_investasi }}', '{{ addslashes($notif->pengguna?->name ?? 'Mitra Investor') }}', '{{ addslashes($notif->pengguna?->bank_name ?? 'Belum Diatur') }}', '{{ $notif->pengguna?->nomor_rekening ?? '-' }}', '{{ addslashes($notif->pengguna?->nama_pemilik_rekening ?? ($notif->pengguna?->name ?? 'Mitra Investor')) }}')"
                                            class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>💸 Setor Dividen</span>
                                    </button>
                                @endif

                                @if(!empty($notif->pengguna?->phone_number))
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $notif->pengguna->phone_number) }}?text=Halo%20{{ urlencode($notif->pengguna?->name ?? 'Investor') }},%20terima%20kasih%20atas%20minat%20investasi%20Anda%20di%20usaha%20{{ urlencode($umkm->nama_usaha) }}%20melalui%20DAYA%20UMKM." 
                                       target="_blank"
                                       class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.99.54 2.012.85 2.796.85 3.177 0 5.766-2.587 5.766-5.766 0-3.18-2.586-5.767-5.766-5.767zm7.55 5.766c0 4.164-3.393 7.552-7.55 7.552-1.312 0-2.539-.344-3.61-.951l-4.043 1.059 1.082-3.947c-.707-1.144-1.116-2.483-1.116-3.713 0-4.165 3.39-7.553 7.55-7.553 4.163 0 7.687 3.388 7.687 7.552z"/>
                                        </svg>
                                        <span>WA</span>
                                    </a>
                                @endif

                                @if(!$notif->dibaca)
                                    <form action="{{ route('dashboard.umkm.notifikasi.read', $notif->id_investasi) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-600 text-xs font-semibold transition" title="Tandai Sudah Dibaca">
                                            ✓
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- PAGE HEADER (Presisi Sesuai Mockup Gambar 2) -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#1A202C]">BERANDA</h1>
            <p class="text-sm sm:text-base text-[#555555] mt-1.5 font-medium">
                Halo, <span class="font-bold text-[#20675D]">{{ $user->name }}</span>. Ini ringkasan usahamu.
            </p>
        </div>

        <!-- BANNER NOTIFIKASI: KLARIFIKASI KENDALA USAHA DI-ACC OLEH ADMIN (PENYELESAIAN BULAN DEPAN) -->
        @if(!empty($klarifikasiDisetujuiTerbaru))
            <div class="rounded-3xl p-6 sm:p-7 border-2 border-emerald-500 bg-gradient-to-r from-emerald-50 via-teal-50 to-green-50 shadow-xl relative overflow-hidden animate-fade-in mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-3xl shrink-0 shadow-lg ring-4 ring-white">
                            ✅
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-emerald-700 text-white shadow-sm">
                                    Dispensasi Disetujui Admin
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white text-emerald-800 border border-emerald-200">
                                    Periode: {{ $klarifikasiDisetujuiTerbaru->bulan_periode }}
                                </span>
                                @if($klarifikasiDisetujuiTerbaru->investasi && $klarifikasiDisetujuiTerbaru->investasi->pengguna)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white text-emerald-800 border border-emerald-200">
                                        Mitra Investor: <strong>{{ $klarifikasiDisetujuiTerbaru->investasi->pengguna->name }}</strong>
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-base sm:text-xl font-black text-emerald-950 mt-2">
                                Klarifikasi Kendala Usaha Telah Di-ACC! Kewajiban Dapat Diselesaikan Bulan Depan
                            </h3>

                            <p class="text-xs sm:text-sm text-emerald-900/90 font-medium mt-1.5 leading-relaxed max-w-3xl">
                                Laporan kendala usaha Anda telah diverifikasi dan <strong>disetujui oleh Tim Compliance Platform</strong>. Anda resmi diberikan kelonggaran waktu untuk menyelesaikan penyetoran bagi hasil dividen pada jadwal <strong>bulan depan</strong> tanpa dikenakan penalti atau sanksi kepatuhan (SP).
                            </p>

                            @if(!empty($klarifikasiDisetujuiTerbaru->catatan_admin))
                                <div class="mt-3 p-3.5 rounded-2xl bg-white/90 border border-emerald-300 text-xs text-emerald-950 shadow-sm">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 block mb-0.5">Catatan Verifikator Admin:</span>
                                    <p class="italic font-medium">"{{ $klarifikasiDisetujuiTerbaru->catatan_admin }}"</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="shrink-0 self-stretch lg:self-center flex flex-col gap-2">
                        <a href="{{ route('dashboard', ['tab' => 'inbox']) }}" 
                           class="px-5 py-3 rounded-2xl font-bold text-xs sm:text-sm text-white shadow-md hover:shadow-lg transition flex items-center justify-center gap-2"
                           style="background-color: #065F46 !important; color: #FFFFFF !important;">
                            <span>💬 Buka Pesan Persetujuan</span>
                            <span>&rarr;</span>
                        </a>
                        <span class="text-[11px] text-center text-emerald-800 font-bold">
                            ✓ Status Kemitraan: Aman
                        </span>
                    </div>
                </div>
            </div>
        @endif

        <!-- BANNER PERINGATAN RESMI: SURAT PERINGATAN (SP) KEPATUHAN DIVIDEN -->
        @if(!empty($teguranSpTerbaru) || ($umkm->jumlah_teguran_sp ?? 0) > 0)
            @php
                $spTerbaru = $teguranSpTerbaru;
                $tingkatSp = $spTerbaru ? $spTerbaru->tingkat_sp : ('SP-' . ($umkm->jumlah_teguran_sp ?? 1));
                $tenggatSp = $spTerbaru && $spTerbaru->created_at ? $spTerbaru->created_at->addDays(3) : now()->addDays(3);
                $sisaHari = now()->diffInDays($tenggatSp, false);
                $isDanger = in_array($tingkatSp, ['SP-2', 'SP-3']);
                $invTerkait = $spTerbaru ? $spTerbaru->investasi : null;
                $namaInvestor = $invTerkait && $invTerkait->pengguna ? $invTerkait->pengguna->name : 'Mitra Investor';
                $bankInvestor = $invTerkait && $invTerkait->pengguna ? ($invTerkait->pengguna->bank_name ?? 'Bank Belum Diatur') : 'Bank Belum Diatur';
                $rekInvestor = $invTerkait && $invTerkait->pengguna ? ($invTerkait->pengguna->nomor_rekening ?? '-') : '-';
                $namaRekInvestor = $invTerkait && $invTerkait->pengguna ? ($invTerkait->pengguna->nama_pemilik_rekening ?? $invTerkait->pengguna->name) : 'Mitra Investor';
                $hasDispensasi = !empty($klarifikasiDisetujuiTerbaru) && ($klarifikasiDisetujuiTerbaru->id_investasi === ($invTerkait->id_investasi ?? null));
            @endphp
            <div class="rounded-3xl p-6 sm:p-7 border-2 {{ $isDanger ? 'border-rose-600 bg-gradient-to-r from-rose-50 via-red-50 to-orange-50' : 'border-amber-500 bg-gradient-to-r from-amber-50 via-orange-50 to-red-50' }} shadow-xl relative overflow-hidden animate-fade-in mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl {{ $isDanger ? 'bg-rose-600 text-white' : 'bg-amber-500 text-white' }} flex items-center justify-center text-3xl shrink-0 shadow-lg ring-4 ring-white"
                             style="background-color: {{ $isDanger ? '#E11D48' : '#F59E0B' }} !important; color: #FFFFFF !important;">
                            ⚠️
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider text-white shadow-sm"
                                      style="background-color: {{ $isDanger ? '#BE123C' : '#D97706' }} !important; color: #FFFFFF !important;">
                                    SURAT PERINGATAN RESMI: {{ $tingkatSp }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white text-gray-700 border border-gray-200">
                                    Diterbitkan: {{ $spTerbaru && $spTerbaru->created_at ? $spTerbaru->created_at->translatedFormat('d M Y, H:i') : now()->translatedFormat('d M Y') }} WIB
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white text-gray-700 border border-gray-200">
                                    Investor Terkait: <strong>{{ $namaInvestor }}</strong>
                                </span>
                                @if($hasDispensasi)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        ✓ Telah Diberikan Toleransi ke Bulan Depan
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-base sm:text-xl font-black text-gray-900 mt-2">
                                Usaha Anda Telah Menerima {{ $tingkatSp }} Terkait Kepatuhan Dividen Bagi Hasil
                            </h3>

                            <p class="text-xs sm:text-sm text-gray-700 font-medium mt-1.5 max-w-3xl leading-relaxed">
                                @if($spTerbaru && !empty($spTerbaru->pesan_teguran))
                                    <span class="italic">"{{ Str::limit($spTerbaru->pesan_teguran, 160) }}"</span>
                                @else
                                    Berdasarkan rekapitulasi data sistem, bagi hasil dividen kemitraan belum disetorkan. Mohon segera selesaikan kewajiban bagi hasil atau ajukan klarifikasi resmi.
                                @endif
                            </p>

                            <div class="mt-3 flex flex-wrap items-center gap-3 text-xs">
                                <div class="inline-flex items-center gap-1.5 font-bold {{ $sisaHari <= 1 ? 'text-rose-700' : 'text-amber-800' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Tenggat Respons: <strong>{{ $tenggatSp->translatedFormat('d F Y') }}</strong></span>
                                    @if($sisaHari >= 0)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $sisaHari <= 1 ? 'bg-rose-200 text-rose-900' : 'bg-amber-200 text-amber-900' }}">
                                            (Tersisa {{ max(1, $sisaHari) }} hari)
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-600 text-white">
                                            Melewati Batas Waktu!
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi Buka Surat & Solusi (Ditingkatkan dengan Kontras Tinggi & Merah Terang) -->
                    <div class="flex flex-col sm:flex-row lg:flex-col gap-2.5 shrink-0 self-stretch lg:self-center">
                        <button type="button" 
                                onclick="openSuratPeringatanModal(
                                    '{{ $tingkatSp }}',
                                    '{{ $spTerbaru && $spTerbaru->created_at ? $spTerbaru->created_at->translatedFormat('d F Y, H:i') : now()->translatedFormat('d F Y') }}',
                                    '{{ $tenggatSp->translatedFormat('d F Y') }}',
                                    `{{ addslashes($spTerbaru->pesan_teguran ?? 'Berdasarkan rekapitulasi data sistem, bagi hasil dividen kemitraan belum disetorkan.') }}`,
                                    '{{ addslashes($spTerbaru->admin->name ?? 'Super Administrator') }}',
                                    '{{ addslashes($namaInvestor) }}',
                                    '{{ $invTerkait ? $invTerkait->id_investasi : '' }}',
                                    '{{ addslashes($bankInvestor) }}',
                                    '{{ $rekInvestor }}',
                                    '{{ addslashes($namaRekInvestor) }}',
                                    '{{ $spTerbaru->id_teguran ?? 1 }}'
                                )"
                                class="w-full px-6 py-3.5 rounded-2xl font-black text-xs sm:text-sm shadow-xl transition flex items-center justify-center gap-2.5 cursor-pointer hover:brightness-110 active:scale-95"
                                style="background: linear-gradient(135deg, #B91C1C 0%, #DC2626 50%, #991B1B 100%) !important; background-color: #DC2626 !important; color: #FFFFFF !important; border: 2px solid #FFFFFF !important; box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.45) !important;">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #FFFFFF !important;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="tracking-wide uppercase font-extrabold" style="color: #FFFFFF !important; text-shadow: 0 1px 2px rgba(0,0,0,0.35);">
                                Buka Dokumen Surat Peringatan (SP)
                            </span>
                        </button>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="#daftar-mitra-investor" class="px-3.5 py-2.5 rounded-xl bg-white hover:bg-gray-100 text-gray-800 text-xs font-bold text-center border border-gray-300 transition shadow-sm">
                                Setor Dividen ↓
                            </a>
                            <a href="{{ route('dashboard', ['tab' => 'inbox']) }}" class="px-3.5 py-2.5 rounded-xl bg-gray-900 hover:bg-black text-white text-xs font-bold text-center transition shadow-sm">
                                💬 Ruang Chat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- ALERT PERINGATAN KEPATUHAN JATUH TEMPO BAGI HASIL DIVIDEN -->
        @if(!empty($adaDividenTenggangAtauNunggak))
            <div class="rounded-2xl p-5 border-2 border-amber-400 bg-gradient-to-r from-amber-50 via-yellow-50 to-orange-50 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 animate-fade-in">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl shrink-0 shadow">
                        ⚠️
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-black uppercase tracking-wider text-amber-900 bg-amber-200/80 px-2 py-0.5 rounded-full">
                                Pengingat Kepatuhan Bagi Hasil
                            </span>
                        </div>
                        <h4 class="text-sm sm:text-base font-extrabold text-amber-950 mt-1">
                            Ada Kewajiban Dividen Memasuki Masa Tenggang / Jatuh Tempo
                        </h4>
                        <p class="text-xs text-amber-900/90 mt-0.5 max-w-2xl">
                            Sesuai SOP platform (jatuh tempo tgl 25), silakan segera setor dividen atau sampaikan formulir <strong>Klarifikasi Penundaan / Kendala Usaha</strong> pada kartu investor di bawah agar tidak dikenakan Surat Peringatan (SP) dan pembekuan akun.
                        </p>
                    </div>
                </div>
                <a href="#daftar-mitra-investor" class="px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition shadow-sm shrink-0 whitespace-nowrap">
                    Lihat Kemitraan ↓
                </a>
            </div>
        @endif



        <!-- FITUR SINERGI 1: BANNER SEWA RUKO (SPONSOR INVESTOR & SEWA MANDIRI) -->
        @if(isset($sewaDisponsori) && $sewaDisponsori->isNotEmpty())
            @php
                $adaSewaMandiri = $sewaDisponsori->contains(fn($s) => is_null($s->id_investor));
                $adaSewaInvestor = $sewaDisponsori->contains(fn($s) => !is_null($s->id_investor));
            @endphp
            <div class="rounded-2xl p-6 sm:p-7 shadow-lg"
                 style="background: linear-gradient(135deg, #0F433C 0%, #20675D 100%) !important; color: #ffffff !important;">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 text-amber-300 border border-white/20 flex items-center justify-center text-2xl shrink-0">
                            🏢
                        </div>
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-wider text-teal-300 block">Status Kontrak Tempat Usaha (Ruko)</span>
                            <h3 class="text-base sm:text-lg font-black text-white mt-0.5">
                                @if($adaSewaInvestor && !$adaSewaMandiri)
                                    Selamat! Biaya Sewa Ruko Anda Telah Disponsori oleh Investor
                                @elseif($adaSewaMandiri && !$adaSewaInvestor)
                                    Unit Ruko Usaha Didaftarkan (Sewa Mandiri)
                                @else
                                    Daftar Penggunaan Ruko Komersial Usaha Anda
                                @endif
                            </h3>
                            @foreach($sewaDisponsori as $sewa)
                                @if($sewa->investor)
                                    <p class="text-xs text-teal-100/90 mt-1">
                                        Ruko <strong>{{ $sewa->ruko->nama_ruko ?? 'Komersial' }}</strong> ({{ $sewa->ruko->lokasi ?? '-' }}) disponsori oleh <strong>{{ $sewa->investor->name }}</strong> senilai <strong class="text-amber-300">Rp {{ number_format($sewa->total_harga, 0, ',', '.') }}</strong> (Periode sewa: {{ $sewa->tanggal_mulai }} s/d {{ $sewa->tanggal_selesai }}).
                                    </p>
                                @else
                                    <p class="text-xs text-teal-100/90 mt-1">
                                        Ruko <strong>{{ $sewa->ruko->nama_ruko ?? 'Komersial' }}</strong> ({{ $sewa->ruko->lokasi ?? '-' }}) disewa secara mandiri senilai <strong class="text-amber-300">Rp {{ number_format($sewa->total_harga, 0, ',', '.') }}</strong> &bull; Status: <span class="font-bold {{ $sewa->status_pembayaran === 'dibayar' ? 'text-emerald-300' : 'text-amber-300' }}">{{ $sewa->status_pembayaran === 'dibayar' ? 'Aktif (Lunas)' : 'Menunggu Konfirmasi Admin' }}</span>.
                                    </p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <span class="px-3.5 py-2 rounded-xl bg-white text-[#0F433C] text-xs font-bold self-start sm:self-auto shadow-sm">
                        {{ $adaSewaInvestor ? '✓ Sewa Ditanggung Investor' : '✓ Sewa Mandiri' }}
                    </span>
                </div>
            </div>
        @endif

        <!-- ========================================================================= -->
        <!-- FITUR MILESTONE PENDANAAN & INVESTOR TRACKER (Pusat Progres Modal UMKM)  -->
        <!-- ========================================================================= -->
        <div class="card-soft p-6 sm:p-8 space-y-6">
            <!-- Header Milestone & Tombol Atur Target -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-5 border-b border-[#E8E6DF]">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.12em] bg-emerald-50 text-emerald-800 border border-emerald-300">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            🎯 MILESTONE PENDANAAN &amp; SINDIKASI INVESTOR
                        </span>
                        <span class="text-xs text-gray-400 font-medium hidden sm:inline">&bull; Real-time Platform Tracker</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-[#1A202C] mt-2 tracking-tight">
                        Progres Modal &amp; Mitra Investor Usaha
                    </h2>
                    <p class="text-xs sm:text-sm text-[#555555] font-medium mt-1 leading-relaxed max-w-2xl">
                        Pantau sejauh mana target modal usaha <strong>{{ $umkm->nama_usaha }}</strong> telah didanai, berapa banyak mitra investor yang telah bergabung, serta tahapan milestone operasional yang telah dicapai.
                    </p>
                </div>

                <div class="flex items-center gap-2 self-start lg:self-center shrink-0">
                    <a href="{{ route('dashboard', ['tab' => 'profil']) }}" 
                       class="px-4 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold transition flex items-center gap-1.5 shadow-xs">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Ubah Target Modal</span>
                    </a>
                    @if(isset($investasiAktif) && $investasiAktif->isNotEmpty())
                        <a href="#daftar-mitra-investor" 
                           class="px-4 py-2.5 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                            <span>Kelola Dividen</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- 4 KARTU METRIK UTAMA PENDANAAN & INVESTOR -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Metrik 1: Dana Terkumpul -->
                <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-emerald-50/70 to-teal-50/40 border border-emerald-200/80 shadow-xs">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800">Dana Terkumpul</span>
                        <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs font-bold">
                            💰
                        </div>
                    </div>
                    <div class="text-xl sm:text-2xl font-black text-[#0F433C]">
                        Rp {{ number_format($totalModalTerkumpul ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-gray-500 font-medium mt-1">
                        Target: <span class="font-bold text-gray-700">Rp {{ number_format($targetModalUmkm ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Metrik 2: Investor yang Berinvestasi -->
                <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-blue-50/70 to-indigo-50/40 border border-blue-200/80 shadow-xs">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-black uppercase tracking-wider text-blue-800">Total Investor</span>
                        <div class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs font-bold">
                            👥
                        </div>
                    </div>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-xl sm:text-2xl font-black text-blue-950">{{ $jumlahInvestorAktif ?? 0 }}</span>
                        <span class="text-xs font-bold text-blue-800">Orang Investor</span>
                    </div>
                    <div class="text-[11px] text-gray-500 font-medium mt-1 flex items-center gap-1">
                        <span>{{ $investasiAktif->count() }} Kontrak Aktif</span>
                        @if(($jumlahInvestorPending ?? 0) > 0)
                            <span class="px-1.5 py-0.2 rounded-full text-[9px] font-black bg-amber-200 text-amber-900">+{{ $jumlahInvestorPending }} Pending</span>
                        @endif
                    </div>
                </div>

                <!-- Metrik 3: Persentase Milestone Terpenuhi -->
                <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-amber-50/70 to-yellow-50/40 border border-amber-200/80 shadow-xs">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-black uppercase tracking-wider text-amber-900">Milestone Terpenuhi</span>
                        <div class="w-7 h-7 rounded-lg bg-amber-500 text-white flex items-center justify-center text-xs font-bold">
                            📈
                        </div>
                    </div>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-xl sm:text-2xl font-black text-amber-950">{{ $persentaseMilestone ?? 0 }}%</span>
                        <span class="text-xs font-bold text-amber-800">Tercapai</span>
                    </div>
                    <div class="text-[11px] text-gray-500 font-medium mt-1">
                        @if(($sisaModalDibutuhkan ?? 0) > 0)
                            Sisa: <span class="font-bold text-rose-600">Rp {{ number_format($sisaModalDibutuhkan, 0, ',', '.') }}</span>
                        @else
                            <span class="font-bold text-emerald-700">✓ Target 100% Penuh!</span>
                        @endif
                    </div>
                </div>

                <!-- Metrik 4: Total Dividen Disetor -->
                <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-purple-50/70 to-fuchsia-50/40 border border-purple-200/80 shadow-xs">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-black uppercase tracking-wider text-purple-900">Dividen Disetor</span>
                        <div class="w-7 h-7 rounded-lg bg-purple-600 text-white flex items-center justify-center text-xs font-bold">
                            🤝
                        </div>
                    </div>
                    <div class="text-xl sm:text-2xl font-black text-purple-950">
                        Rp {{ number_format($totalDividenDisetor ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-gray-500 font-medium mt-1">
                        Bagi hasil riil ke rekening investor
                    </div>
                </div>
            </div>

            <!-- VISUAL PROGRESS BAR & MILESTONE ROADMAP (4 TAHAPAN STRATEGIS) -->
            <div class="p-5 sm:p-6 rounded-2xl bg-[#FBF9F4] border border-[#E8E6DF] space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-gray-500">Roadmap Tahapan Milestone Usaha</span>
                        <h3 class="text-sm sm:text-base font-extrabold text-[#1A202C]">
                            Realisasi Pendanaan: {{ $persentaseMilestone }}% dari Target Rp {{ number_format($targetModalUmkm, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold">
                        @if($persentaseMilestone >= 100)
                            <span class="px-3 py-1 rounded-full bg-emerald-600 text-white shadow-xs">🏆 Sindikasi Penuh (100%)</span>
                        @elseif($persentaseMilestone >= 75)
                            <span class="px-3 py-1 rounded-full bg-teal-700 text-white shadow-xs">🚀 Tahap 3: Ekspansi Pasar</span>
                        @elseif($persentaseMilestone >= 50)
                            <span class="px-3 py-1 rounded-full bg-amber-600 text-white shadow-xs">⚙️ Tahap 2: Operasional Skala</span>
                        @elseif($persentaseMilestone >= 25)
                            <span class="px-3 py-1 rounded-full bg-blue-600 text-white shadow-xs">🌱 Tahap 1: Modal Awal</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-gray-600 text-white shadow-xs">⏳ Menunggu Investor Perdana</span>
                        @endif
                    </div>
                </div>

                <!-- Progress Bar Utama -->
                <div class="relative w-full bg-gray-200 rounded-full h-4 overflow-hidden shadow-inner p-0.5">
                    <div class="h-full rounded-full transition-all duration-700 ease-out" 
                         style="width: {{ max(4, min(100, $persentaseMilestone)) }}%; background: linear-gradient(90deg, #0F766E 0%, #10B981 60%, #F59E0B 100%);">
                    </div>
                </div>

                <!-- 4 Kotak Milestone Stages -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 pt-1">
                    <!-- Tahap 1 (25%) -->
                    <div class="p-3.5 rounded-xl border {{ $persentaseMilestone >= 25 ? 'bg-emerald-50/90 border-emerald-300' : ($persentaseMilestone > 0 ? 'bg-amber-50/80 border-amber-300' : 'bg-white border-gray-200 opacity-70') }} flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-[10px] font-black uppercase tracking-wider {{ $persentaseMilestone >= 25 ? 'text-emerald-800' : 'text-gray-500' }}">Tahap 1 &bull; 25%</span>
                                <span class="text-xs font-black">
                                    {{ $persentaseMilestone >= 25 ? '✅ Tercapai' : ($persentaseMilestone > 0 ? '⚡ Berjalan' : '⏳ Belum') }}
                                </span>
                            </div>
                            <h4 class="text-xs font-extrabold text-[#1A202C]">Modal Awal &amp; Legalitas</h4>
                            <p class="text-[11px] text-gray-600 mt-1 leading-snug">Pengadaan bahan baku awal dan perlengkapan dasar operasional.</p>
                        </div>
                        <span class="text-[10px] font-bold text-gray-500 mt-2 block">Min. Rp {{ number_format($targetModalUmkm * 0.25, 0, ',', '.') }}</span>
                    </div>

                    <!-- Tahap 2 (50%) -->
                    <div class="p-3.5 rounded-xl border {{ $persentaseMilestone >= 50 ? 'bg-emerald-50/90 border-emerald-300' : ($persentaseMilestone >= 25 ? 'bg-amber-50/80 border-amber-300' : 'bg-white border-gray-200 opacity-70') }} flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-[10px] font-black uppercase tracking-wider {{ $persentaseMilestone >= 50 ? 'text-emerald-800' : 'text-gray-500' }}">Tahap 2 &bull; 50%</span>
                                <span class="text-xs font-black">
                                    {{ $persentaseMilestone >= 50 ? '✅ Tercapai' : ($persentaseMilestone >= 25 ? '⚡ Berjalan' : '🔒 Terkunci') }}
                                </span>
                            </div>
                            <h4 class="text-xs font-extrabold text-[#1A202C]">Operasional &amp; Sewa Ruko</h4>
                            <p class="text-[11px] text-gray-600 mt-1 leading-snug">Sewa tempat komersial dan pembelian mesin/alat produksi modern.</p>
                        </div>
                        <span class="text-[10px] font-bold text-gray-500 mt-2 block">Min. Rp {{ number_format($targetModalUmkm * 0.50, 0, ',', '.') }}</span>
                    </div>

                    <!-- Tahap 3 (75%) -->
                    <div class="p-3.5 rounded-xl border {{ $persentaseMilestone >= 75 ? 'bg-emerald-50/90 border-emerald-300' : ($persentaseMilestone >= 50 ? 'bg-amber-50/80 border-amber-300' : 'bg-white border-gray-200 opacity-70') }} flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-[10px] font-black uppercase tracking-wider {{ $persentaseMilestone >= 75 ? 'text-emerald-800' : 'text-gray-500' }}">Tahap 3 &bull; 75%</span>
                                <span class="text-xs font-black">
                                    {{ $persentaseMilestone >= 75 ? '✅ Tercapai' : ($persentaseMilestone >= 50 ? '⚡ Berjalan' : '🔒 Terkunci') }}
                                </span>
                            </div>
                            <h4 class="text-xs font-extrabold text-[#1A202C]">Pemasaran &amp; Influencer</h4>
                            <p class="text-[11px] text-gray-600 mt-1 leading-snug">Kampanye endorsement influencer lokal dan perluasan jangkauan pasar.</p>
                        </div>
                        <span class="text-[10px] font-bold text-gray-500 mt-2 block">Min. Rp {{ number_format($targetModalUmkm * 0.75, 0, ',', '.') }}</span>
                    </div>

                    <!-- Tahap 4 (100%) -->
                    <div class="p-3.5 rounded-xl border {{ $persentaseMilestone >= 100 ? 'bg-emerald-50/90 border-emerald-300' : ($persentaseMilestone >= 75 ? 'bg-amber-50/80 border-amber-300' : 'bg-white border-gray-200 opacity-70') }} flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-[10px] font-black uppercase tracking-wider {{ $persentaseMilestone >= 100 ? 'text-emerald-800' : 'text-gray-500' }}">Tahap 4 &bull; 100%</span>
                                <span class="text-xs font-black">
                                    {{ $persentaseMilestone >= 100 ? '🏆 Penuh!' : ($persentaseMilestone >= 75 ? '⚡ Mendekati' : '🔒 Terkunci') }}
                                </span>
                            </div>
                            <h4 class="text-xs font-extrabold text-[#1A202C]">Target Tercapai (Penuh)</h4>
                            <p class="text-[11px] text-gray-600 mt-1 leading-snug">Sindikasi pendanaan ditutup, kapasitas maksimal dan dividen optimal.</p>
                        </div>
                        <span class="text-[10px] font-bold text-gray-500 mt-2 block">Target Rp {{ number_format($targetModalUmkm, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- DAFTAR ORANG / INVESTOR YANG MENDANAI USAHA ANDA -->
            <div class="pt-2">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-[#0F433C] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            👥
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-extrabold text-[#1A202C]">
                                Daftar Investor yang Berinvestasi ({{ $jumlahInvestorAktif ?? 0 }} Investor Aktif)
                            </h3>
                            <p class="text-[11px] text-gray-500">
                                Rincian mitra pemodal yang telah menyalurkan modal investasi riil ke usaha Anda
                            </p>
                        </div>
                    </div>
                    @if(isset($investasiAktif) && $investasiAktif->isNotEmpty())
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            {{ $investasiAktif->count() }} Porsi Investasi
                        </span>
                    @endif
                </div>

                @if(isset($investasiAktif) && $investasiAktif->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($investasiAktif as $inv)
                            <div class="p-4 rounded-2xl bg-white border border-[#E8E6DF] hover:border-teal-600 transition shadow-xs flex flex-col justify-between gap-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-11 h-11 rounded-full bg-[#0F433C] text-white flex items-center justify-center font-black text-sm shrink-0 border-2 border-emerald-400/40 shadow-sm">
                                            {{ strtoupper(substr($inv->pengguna->name ?? 'I', 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-1.5">
                                                <h4 class="text-xs sm:text-sm font-extrabold text-[#1A202C] truncate">
                                                    {{ $inv->pengguna->name ?? 'Mitra Investor' }}
                                                </h4>
                                                <span class="w-3.5 h-3.5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[8px] font-black shrink-0" title="Investor Terverifikasi">✓</span>
                                            </div>
                                            <span class="text-[10px] text-gray-400 block">
                                                Bergabung: {{ $inv->tanggal_investasi ? $inv->tanggal_investasi->translatedFormat('d M Y') : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Aktif
                                    </span>
                                </div>

                                <div class="p-3 rounded-xl bg-gray-50 border border-gray-100 space-y-1 text-xs">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-500 text-[11px]">Modal Diinvestasikan:</span>
                                        <span class="font-black text-[#0F433C] text-xs sm:text-sm">Rp {{ number_format($inv->jumlah_modal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-500 text-[11px]">Bagi Hasil:</span>
                                        <span class="font-bold text-gray-700 text-[11px]">{{ $inv->persentase_bagi_hasil }}% ({{ $inv->periode_pembagian }})</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-500 text-[11px]">Porsi dari Target:</span>
                                        <span class="font-bold text-teal-700 text-[11px]">
                                            {{ $targetModalUmkm > 0 ? round(($inv->jumlah_modal / $targetModalUmkm) * 100, 1) : 0 }}%
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 pt-1">
                                    <a href="{{ route('kontrak.show', $inv->id_investasi) }}" 
                                       class="flex-1 py-2 px-3 rounded-xl text-center text-[11px] font-bold text-teal-900 bg-teal-50 hover:bg-teal-100 border border-teal-200 transition">
                                        📄 Akad &amp; E-Sign
                                    </a>
                                    @if(!empty($inv->pengguna?->phone_number))
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inv->pengguna->phone_number) }}?text=Halo%20{{ urlencode($inv->pengguna->name) }},%20terima%20kasih%20telah%20menjadi%20investor%20di%20{{ urlencode($umkm->nama_usaha) }}."
                                           target="_blank"
                                           class="p-2 rounded-xl text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition"
                                           title="Hubungi via WhatsApp">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.99.54 2.012.85 2.796.85 3.177 0 5.766-2.587 5.766-5.766 0-3.18-2.586-5.767-5.766-5.767zm7.55 5.766c0 4.164-3.393 7.552-7.55 7.552-1.312 0-2.539-.344-3.61-.951l-4.043 1.059 1.082-3.947c-.707-1.144-1.116-2.483-1.116-3.713 0-4.165 3.39-7.553 7.55-7.553 4.163 0 7.687 3.388 7.687 7.552z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- STATE JIKA BELUM ADA INVESTOR YANG MENDANAI -->
                    <div class="p-6 sm:p-8 rounded-2xl bg-white border border-dashed border-gray-300 text-center space-y-3">
                        <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl shadow-xs">
                            🤝
                        </div>
                        <h4 class="text-base font-extrabold text-[#1A202C]">Belum Ada Investor yang Mendanai</h4>
                        <p class="text-xs text-gray-500 max-w-md mx-auto leading-relaxed">
                            Saat ini belum ada investor yang mengalirkan modal ke usaha Anda (<strong>0 Investor</strong>). Target modal yang dibutuhkan adalah <strong>Rp {{ number_format($targetModalUmkm, 0, ',', '.') }}</strong>. Sempurnakan proposal usaha dan gunakan promosi influencer untuk memikat para investor.
                        </p>
                        <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                            <a href="{{ route('dashboard', ['tab' => 'profil']) }}" 
                               class="px-4 py-2.5 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm">
                                📋 Sempurnakan Proposal Usaha
                            </a>
                            <a href="{{ route('dashboard', ['tab' => 'influencer']) }}" 
                               class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition shadow-sm">
                                📢 Promosikan Usaha ke Influencer
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- FITUR SINERGI 2 (KARTU 2): DAFTAR MITRA INVESTOR AKTIF -->
        @if(isset($investasiAktif) && $investasiAktif->isNotEmpty())
            <div id="daftar-mitra-investor" class="card-soft p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#555555]">Kemitraan Berjalan</p>
                        <h2 class="text-lg font-bold text-[#1A202C] tracking-tight mt-0.5">Mitra Investor Aktif & Kepatuhan Dividen</h2>
                    </div>
                    <span class="text-xs font-semibold text-[#20675D]">{{ $investasiAktif->count() }} kemitraan aktif</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($investasiAktif as $inv)
                        @php
                            $statusBulanIni = $inv->status_dividen_bulan_ini;
                        @endphp
                        <div class="p-5 rounded-2xl bg-[#F8F6F0] flex flex-col justify-between gap-4 hover:shadow-md transition border border-[#E8E6DF]">
                            <div>
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-[#0F433C] text-white flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ strtoupper(substr($inv->pengguna->name ?? 'I', 0, 2)) }}
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-[#1A202C]">{{ $inv->pengguna->name ?? 'Investor Mitra' }}</h4>
                                            <span class="text-[10px] text-[#777]">Mulai: {{ $inv->tanggal_investasi ? $inv->tanggal_investasi->format('d M Y') : '-' }}</span>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold uppercase tracking-[0.06em] bg-emerald-100 text-emerald-800">
                                        Aktif
                                    </span>
                                </div>

                                <!-- INDIKATOR STATUS DIVIDEN BULAN BERJALAN -->
                                <div class="mt-3.5 p-3 rounded-xl border flex items-center justify-between gap-2 {{ $statusBulanIni['badge_class'] }}">
                                    <div class="flex items-center gap-2">
                                        <span class="text-base">{{ $statusBulanIni['icon'] }}</span>
                                        <div>
                                            <span class="text-[11px] font-extrabold block leading-tight">{{ $statusBulanIni['badge_label'] }}</span>
                                            <span class="text-[10px] opacity-80">Jatuh tempo: 25 {{ $statusBulanIni['bulan_periode'] }}</span>
                                        </div>
                                    </div>
                                    @if($statusBulanIni['code'] === 'lancar')
                                        <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-emerald-600 text-white">Lunas</span>
                                    @elseif($statusBulanIni['code'] === 'klarifikasi_disetujui')
                                        <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-emerald-700 text-white shadow-sm">✓ ACC Bulan Depan</span>
                                    @elseif($statusBulanIni['code'] === 'klarifikasi')
                                        <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-sky-600 text-white">Ditinjau</span>
                                    @endif
                                </div>

                                <div class="mt-4 space-y-1.5 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-[#777]">Modal Disalurkan:</span>
                                        <span class="font-bold text-[#0F433C]">Rp {{ number_format($inv->jumlah_modal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-[#777]">Porsi Bagi Hasil:</span>
                                        <span class="font-semibold text-[#555]">{{ $inv->persentase_bagi_hasil }}% ({{ $inv->periode_pembagian }})</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-[#777]">Dividen Terbayar:</span>
                                        <span class="font-bold text-emerald-700">Rp {{ number_format($inv->bagiHasilLog->sum('nominal_diterima'), 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <!-- KARTU REKENING BANK TUJUAN INVESTOR (TERHUBUNG KE FITUR 3 INVESTOR) -->
                                <div class="mt-3.5 p-3 rounded-xl bg-white text-xs">
                                    <span class="text-[10px] font-semibold text-[#777] uppercase tracking-[0.08em] block mb-1">Rekening Transfer Investor:</span>
                                    <div class="flex items-center justify-between font-mono">
                                        <span class="font-bold text-[#0F433C]">{{ $inv->pengguna->bank_name ?? 'Bank Belum Diatur' }}</span>
                                        <span class="font-bold text-[#1A202C]">{{ $inv->pengguna->nomor_rekening ?? '-' }}</span>
                                    </div>
                                    <span class="text-[11px] text-[#777] block mt-0.5 truncate">a.n. {{ $inv->pengguna->nama_pemilik_rekening ?? ($inv->pengguna->name ?? '-') }}</span>
                                </div>
                                @php
                                    $spInv = $inv->teguranDividen->first();
                                    $invHasDispensasi = !empty($statusBulanIni['disetujui_bulan_depan']);
                                @endphp
                                @if($spInv)
                                    <div class="mt-3 p-3 rounded-xl bg-gradient-to-r from-rose-50 to-red-50 border border-rose-300 text-rose-900 flex items-center justify-between gap-2 shadow-sm">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="w-6 h-6 rounded-lg bg-rose-600 text-white flex items-center justify-center text-xs font-black shrink-0"
                                                  style="background-color: #DC2626 !important; color: #FFFFFF !important;">!</span>
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-1.5 flex-wrap">
                                                    <span class="text-[11px] font-black uppercase text-rose-950 block truncate">Dikenakan {{ $spInv->tingkat_sp }}</span>
                                                    @if($invHasDispensasi)
                                                        <span class="px-1.5 py-0.2 rounded text-[9px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                            ✓ Dispensasi
                                                        </span>
                                                    @endif
                                                </div>
                                                <span class="text-[10px] text-rose-800 font-medium block truncate">Tenggat: {{ $spInv->created_at ? $spInv->created_at->addDays(3)->translatedFormat('d M Y') : '-' }}</span>
                                            </div>
                                        </div>
                                        <button type="button" 
                                                onclick="openSuratPeringatanModal(
                                                    '{{ $spInv->tingkat_sp }}',
                                                    '{{ $spInv->created_at ? $spInv->created_at->translatedFormat('d F Y, H:i') : '' }}',
                                                    '{{ $spInv->created_at ? $spInv->created_at->addDays(3)->translatedFormat('d F Y') : '' }}',
                                                    `{{ addslashes($spInv->pesan_teguran) }}`,
                                                    '{{ addslashes($spInv->admin->name ?? 'Super Administrator') }}',
                                                    '{{ addslashes($inv->pengguna?->name ?? 'Mitra Investor') }}',
                                                    '{{ $inv->id_investasi }}',
                                                    '{{ addslashes($inv->pengguna?->bank_name ?? 'Bank Belum Diatur') }}',
                                                    '{{ $inv->pengguna?->nomor_rekening ?? '-' }}',
                                                    '{{ addslashes($inv->pengguna?->nama_pemilik_rekening ?? ($inv->pengguna?->name ?? 'Mitra Investor')) }}',
                                                    '{{ $spInv->id_teguran }}'
                                                )"
                                                class="px-3 py-1.5 rounded-xl font-bold text-[11px] shadow-sm transition shrink-0 whitespace-nowrap cursor-pointer hover:opacity-90"
                                                style="background-color: #DC2626 !important; color: #FFFFFF !important; border: 1px solid #FFFFFF !important;">
                                            📄 Baca Surat SP
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <!-- TOMBOL AKSI: SETOR DIVIDEN, AKAD DIGITAL & KLARIFIKASI KENDALA -->
                            <div class="space-y-2 pt-2">
                                <a href="{{ route('kontrak.show', $inv->id_investasi) }}"
                                   class="w-full py-2.5 px-3 rounded-xl hover:opacity-90 transition flex items-center justify-center gap-2 shadow-sm"
                                   style="background-color: #0F433C !important; color: #ffffff !important; border: 1px solid #165E54 !important;">
                                    <svg class="w-4 h-4 text-amber-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span style="color: #ffffff !important; font-weight: 800; font-size: 12px;">Akad Digital & E-Sign</span>
                                </a>

                                <button type="button"
                                        onclick="openSetorDividenModal('{{ $inv->id_investasi }}', '{{ addslashes($inv->pengguna?->name ?? 'Mitra Investor') }}', '{{ addslashes($inv->pengguna?->bank_name ?? 'Bank Belum Diatur') }}', '{{ $inv->pengguna?->nomor_rekening ?? '-' }}', '{{ addslashes($inv->pengguna?->nama_pemilik_rekening ?? ($inv->pengguna?->name ?? 'Mitra Investor')) }}')"
                                        class="w-full py-2.5 px-3 rounded-xl bg-[#20675D] hover:bg-[#0F433C] text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                                    <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Setor Dividen Bagi Hasil</span>
                                </button>

                                <button type="button"
                                        onclick="openKlarifikasiModal('{{ $inv->id_investasi }}', '{{ addslashes($inv->pengguna?->name ?? 'Mitra Investor') }}', '{{ $statusBulanIni['bulan_periode'] }}')"
                                        class="w-full py-2 px-3 rounded-xl border border-amber-300 bg-amber-50 hover:bg-amber-100 text-amber-900 text-xs font-bold transition flex items-center justify-center gap-1.5">
                                    <span>📝 Ajukan Klarifikasi Kendala</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="card-soft p-8 text-center space-y-2">
                <span class="text-3xl block">🤝</span>
                <h3 class="text-sm font-semibold text-[#1A202C]">Belum Ada Kemitraan Investor Aktif</h3>
                <p class="text-xs text-[#555555] max-w-md mx-auto">
                    Ketika Anda menyetujui komitmen pendanaan dari calon investor pada notifikasi di atas, profil investor dan nomor rekeningnya akan langsung muncul di sini.
                </p>
            </div>
        @endif

        <!-- LOG RIWAYAT SURAT PERINGATAN (SP) KEPATUHAN USAHA -->
        @if(isset($daftarTeguranSp) && $daftarTeguranSp->isNotEmpty())
            <div class="card-soft p-6 sm:p-8 border-2 border-rose-200 bg-white">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center text-lg font-black">
                            ⚖️
                        </div>
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-wider text-rose-700 block">Kepatuhan Regulasi &amp; Kemitraan</span>
                            <h3 class="text-base sm:text-lg font-black text-[#1A202C]">
                                Riwayat Penerbitan Surat Peringatan (Log Kepatuhan Usaha)
                            </h3>
                        </div>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-rose-100 text-rose-800 border border-rose-200 self-start sm:self-auto">
                        {{ $daftarTeguranSp->count() }} Surat Tercatat
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                                <th class="pb-3 pr-4">Tanggal Terbit</th>
                                <th class="pb-3 px-4">Tingkat SP</th>
                                <th class="pb-3 px-4">Status</th>
                                <th class="pb-3 px-4">Mitra Investor</th>
                                <th class="pb-3 px-4">Tenggat Respons</th>
                                <th class="pb-3 px-4">Admin Penerbit</th>
                                <th class="pb-3 px-4">Isi Teguran</th>
                                <th class="pb-3 pl-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($daftarTeguranSp as $teguran)
                                @php
                                    $tenggatTeguran = $teguran->created_at ? $teguran->created_at->addDays(3) : null;
                                @endphp
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="py-3.5 pr-4 font-medium text-gray-600 whitespace-nowrap">
                                        {{ $teguran->created_at ? $teguran->created_at->translatedFormat('d M Y, H:i') : '-' }}
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="px-2.5 py-0.5 rounded-full font-black text-[10px] {{ $teguran->tingkat_sp === 'SP-3' ? 'bg-rose-600 text-white' : ($teguran->tingkat_sp === 'SP-2' ? 'bg-orange-500 text-white' : 'bg-amber-500 text-white') }}">
                                            {{ $teguran->tingkat_sp }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @if(($teguran->status ?? 'aktif') === 'selesai')
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                                ✓ Selesai (Lunas)
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-900 border border-amber-300 inline-flex items-center gap-1">
                                                ● Menunggu Penyetoran
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-gray-800 whitespace-nowrap">
                                        {{ $teguran->investasi->pengguna->name ?? 'Investor Mitra' }}
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-rose-600 whitespace-nowrap">
                                        {{ $tenggatTeguran ? $tenggatTeguran->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">
                                        {{ $teguran->admin->name ?? 'Tim Compliance' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-600 max-w-xs truncate" title="{{ $teguran->pesan_teguran }}">
                                        {{ Str::limit($teguran->pesan_teguran, 55) }}
                                        @if(!empty($teguran->catatan_penyelesaian))
                                            <div class="text-[10px] text-emerald-700 font-semibold mt-0.5">
                                                ✓ {{ $teguran->catatan_penyelesaian }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3.5 pl-4 text-right whitespace-nowrap">
                                        <button type="button"
                                                onclick="openSuratPeringatanModal(
                                                    '{{ $teguran->tingkat_sp }}',
                                                    '{{ $teguran->created_at ? $teguran->created_at->translatedFormat('d F Y, H:i') : '' }}',
                                                    '{{ $tenggatTeguran ? $tenggatTeguran->translatedFormat('d F Y') : '' }}',
                                                    `{{ addslashes($teguran->pesan_teguran) }}`,
                                                    '{{ addslashes($teguran->admin->name ?? 'Super Administrator') }}',
                                                    '{{ addslashes($teguran->investasi->pengguna->name ?? 'Mitra Investor') }}',
                                                    '{{ $teguran->id_investasi }}',
                                                    '{{ addslashes($teguran->investasi->pengguna->bank_name ?? 'Bank Belum Diatur') }}',
                                                    '{{ $teguran->investasi->pengguna->nomor_rekening ?? '-' }}',
                                                    '{{ addslashes($teguran->investasi->pengguna->nama_pemilik_rekening ?? $teguran->investasi->pengguna->name ?? 'Mitra Investor') }}',
                                                    '{{ $teguran->id_teguran }}',
                                                    '{{ $teguran->status ?? 'aktif' }}',
                                                    `{{ addslashes($teguran->catatan_penyelesaian ?? '') }}`
                                                )"
                                                class="px-3 py-1.5 rounded-lg bg-gray-900 hover:bg-black text-white text-[11px] font-bold transition shadow-sm">
                                            Buka Surat
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- FITUR SINERGI 3: REPUTASI & ULASAN DARI MITRA INVESTOR -->
        <div class="card-soft p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-amber-100 text-amber-800 border border-amber-200">
                            Reputasi & Kredibilitas Usaha
                        </span>
                        <span class="text-xs text-gray-400 font-bold">&bull;</span>
                        <span class="text-xs font-semibold text-gray-500">Khusus Investor Terverifikasi</span>
                    </div>
                    <h2 class="text-lg font-bold text-[#1A202C] tracking-tight mt-1">Ulasan & Rating dari Investor Mitra</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Rating ini tampil di katalog proposal publik dan membantu meningkatkan kepercayaan calon investor baru.</p>
                </div>

                <div class="flex items-center gap-3 self-start sm:self-auto">
                    <div class="flex items-center gap-3 bg-[#F8F6F0] px-4 py-2.5 rounded-2xl border border-[#EDEAE2]">
                        <span class="text-2xl font-black text-[#1A202C]">{{ number_format($ratingRataRata ?? 0, 1) }}</span>
                        <div>
                            <div class="flex text-amber-400 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= round($ratingRataRata ?? 0) ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            <span class="text-[10px] text-gray-500 font-semibold">{{ $totalUlasan ?? 0 }} ulasan terverifikasi</span>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($ulasanDiterima) && $ulasanDiterima->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($ulasanDiterima as $u)
                        <div class="p-5 rounded-2xl bg-[#F8F6F0] border border-[#EDEAE2] flex flex-col justify-between gap-3 shadow-xs">
                            <div>
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-9 h-9 rounded-full bg-[#0F433C] text-white flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($u->investor->name ?? 'I', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                <h4 class="text-xs font-bold text-[#1A202C]">{{ $u->nama_investor_tersensor }}</h4>
                                                <span class="px-1.5 py-0.2 rounded text-[9px] font-extrabold bg-emerald-100 text-emerald-800">
                                                    ✓ Investor
                                                </span>
                                            </div>
                                            <span class="text-[9px] text-gray-400 font-medium">{{ $u->created_at ? $u->created_at->diffForHumans() : '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 text-amber-500 font-black text-xs bg-white px-2 py-1 rounded-xl border border-gray-100">
                                        <span>★</span>
                                        <span>{{ $u->rating }}/5</span>
                                    </div>
                                </div>

                                <!-- Sub-kriteria penilaian -->
                                <div class="mt-3 flex flex-wrap gap-1.5 text-[10px]">
                                    <span class="px-2 py-0.5 rounded-lg bg-white text-gray-600 border border-gray-100 font-medium">
                                        Transparansi: <strong class="text-emerald-700">{{ $u->rating_transparansi ?? 5 }}/5</strong>
                                    </span>
                                    <span class="px-2 py-0.5 rounded-lg bg-white text-gray-600 border border-gray-100 font-medium">
                                        Dividen: <strong class="text-emerald-700">{{ $u->rating_dividen ?? 5 }}/5</strong>
                                    </span>
                                </div>

                                <!-- Kutipan Ulasan -->
                                <div class="mt-3 text-xs text-gray-700 italic bg-white/70 p-3 rounded-xl border border-gray-100">
                                    "{{ $u->ulasan }}"
                                </div>

                                <!-- Balasan UMKM jika sudah dibalas -->
                                @if(!empty($u->balasan_umkm))
                                    <div class="mt-3 p-3 rounded-xl bg-teal-50 border border-teal-100 text-xs">
                                        <div class="flex items-center gap-1.5 font-bold text-teal-900 text-[11px] mb-1">
                                            <span>💬 Tanggapan Anda:</span>
                                        </div>
                                        <p class="text-teal-800 text-[11px] leading-relaxed">{{ $u->balasan_umkm }}</p>
                                        <span class="text-[9px] text-teal-600 mt-1 block">{{ $u->tanggal_balasan ? $u->tanggal_balasan->diffForHumans() : '' }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Tombol Balas jika belum dibalas -->
                            @if(empty($u->balasan_umkm))
                                <div class="pt-2 border-t border-gray-200/60">
                                    <button type="button" 
                                            onclick="openBalasUlasanModal('{{ $u->id_ulasan }}', '{{ addslashes($u->nama_investor_tersensor) }}', `{{ addslashes($u->ulasan) }}`)"
                                            class="w-full py-2 px-3 rounded-xl bg-white hover:bg-gray-100 text-[#0F433C] border border-[#0F433C]/30 text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                                        <span>💬 Berikan Tanggapan Resmi</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center bg-[#F8F6F0] rounded-2xl border border-dashed border-[#EDEAE2]">
                    <span class="text-3xl block mb-1">⭐</span>
                    <h3 class="text-xs font-bold text-gray-700">Belum Ada Ulasan dari Investor Mitra</h3>
                    <p class="text-[11px] text-gray-400 max-w-md mx-auto mt-0.5">
                        Investor yang telah mendanai usaha Anda dapat memberikan rating kredibilitas serta ulasan bagi hasil. Nilai rating yang tinggi akan langsung memperkuat daya tarik proposal usaha Anda di mata investor lain!
                    </p>
                </div>
            @endif
        </div>

        <!-- GRAFIK PENJUALAN 7 HARI (Desain Modern, Tajam & Berisi Nilai Nominal) -->
        <div class="card-soft p-6 sm:p-8 bg-white border border-[#E8E6DF] rounded-3xl shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-100">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800">
                            Tren Mingguan POS
                        </span>
                        <span class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            ● Live Kasir
                        </span>
                    </div>
                    <h2 class="text-xl font-black text-[#1A202C] tracking-tight mt-1">Grafik Penjualan 7 Hari</h2>
                    <p class="text-xs text-gray-500 font-medium mt-0.5">
                        Total Penjualan: <strong class="text-[#0F433C] font-bold">Rp 13.400.000</strong> &bull; Rata-rata: <strong class="text-gray-800 font-bold">Rp 1.914.000 / hari</strong>
                    </p>
                </div>

                <div class="flex items-center gap-3 self-start sm:self-auto">
                    <div class="px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 9.586 14.586 6H12z" clip-rule="evenodd"/></svg>
                        <span>+14.2% vs Pekan Lalu</span>
                    </div>
                    <span class="text-xs font-bold px-3 py-1.5 bg-gray-100 rounded-xl text-gray-600">
                        7 Hari Terakhir
                    </span>
                </div>
            </div>

            <!-- Area Grafik dengan Garis Bantu Grid -->
            <div class="relative pt-6 pb-2">
                <!-- Garis Horizontal Grid -->
                <div class="absolute inset-0 flex flex-col justify-between pointer-events-none pb-8 pt-6 opacity-30">
                    <div class="border-b border-dashed border-gray-400 w-full flex justify-between text-[10px] text-gray-500 font-mono"><span>Rp 3,5 Jt</span></div>
                    <div class="border-b border-dashed border-gray-400 w-full flex justify-between text-[10px] text-gray-500 font-mono"><span>Rp 2,5 Jt</span></div>
                    <div class="border-b border-dashed border-gray-400 w-full flex justify-between text-[10px] text-gray-500 font-mono"><span>Rp 1,5 Jt</span></div>
                    <div class="border-b border-gray-300 w-full flex justify-between text-[10px] text-gray-500 font-mono"><span>Rp 0</span></div>
                </div>

                <!-- Batang Bar Chart Modern -->
                <div class="h-60 sm:h-68 flex items-end justify-between gap-2.5 sm:gap-6 px-2 sm:px-6 relative z-10">
                    @php
                        $nominalMap = [
                            'Sen' => 'Rp 1,6 Jt',
                            'Sel' => 'Rp 2,3 Jt',
                            'Rab' => 'Rp 1,1 Jt',
                            'Kam' => 'Rp 2,6 Jt',
                            'Jum' => 'Rp 700 Rb',
                            'Sab' => 'Rp 3,2 Jt',
                            'Min' => 'Rp 1,9 Jt',
                        ];
                    @endphp

                    @foreach($days as $label => $height)
                        <div class="flex-1 flex flex-col items-center h-full justify-end group">
                            <!-- Nominal Tag Selalu Terlihat Jelas -->
                            <div class="mb-2 px-2 py-0.5 rounded-lg text-[10px] sm:text-[11px] font-black transition-all shadow-xs {{ $label === 'Sab' ? 'bg-amber-400 text-teal-950 font-black scale-105' : 'bg-[#0F433C] text-white' }}">
                                {{ $nominalMap[$label] ?? ($height . '%') }}
                            </div>
                            
                            <!-- Track & Batang Solid Berkualitas Tinggi -->
                            <div class="w-full max-w-[46px] h-full flex items-end justify-center bg-gray-100/70 rounded-xl p-1 border border-gray-200/60 shadow-inner">
                                <div class="w-full transition-all duration-700 ease-out rounded-lg shadow-sm {{ $label === 'Sab' ? 'bg-gradient-to-t from-[#0F433C] via-[#10B981] to-emerald-400 border-t-2 border-emerald-300' : 'bg-gradient-to-t from-[#0F433C] to-[#20675D] border-t-2 border-emerald-400' }}"
                                     style="height: {{ max(18, $height) }}%;">
                                </div>
                            </div>

                            <!-- Label Hari -->
                            <span class="text-xs sm:text-sm font-black mt-3 transition-colors {{ $label === 'Sab' ? 'text-emerald-700' : 'text-gray-600' }}">
                                {{ $label }}
                                @if($label === 'Sab')
                                    <span class="text-[9px] text-amber-500">★</span>
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Footer Ringkasan Grafik -->
            <div class="mt-4 pt-3 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3 text-xs text-gray-500">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded bg-[#0F433C]"></span>
                    <span class="font-semibold text-gray-700">Volume Penjualan Harian</span>
                    <span class="text-gray-300">&bull;</span>
                    <span class="font-bold text-amber-700">Puncak: Sabtu (Rp 3.200.000)</span>
                </div>
                <div class="flex items-center gap-1.5 text-gray-400 text-[11px]">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Terverifikasi dari Pembukuan Kas Toko</span>
                </div>
            </div>
        </div>

    {{-- ========================================================================= --}}
    {{-- TAB INBOX: KOTAK MASUK PENDANAAN & OBROLAN INVESTOR (Fitur Permintaan)   --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'inbox')

        <!-- PAGE HEADER INBOX PENDANAAN -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#1A202C]">INBOX PENDANAAN</h1>
                <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                    Tinjau komitmen modal masuk dari calon investor, lakukan negosiasi langsung di dalam web, dan sepakati kontrak kemitraan.
                </p>
            </div>

            <!-- Filter Badge Ringkasan -->
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <span class="px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold">
                    {{ $notifikasiInvestasi->where('status', 'pending')->count() }} Menunggu Respon
                </span>
                <span class="px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold">
                    {{ $notifikasiInvestasi->where('status', 'aktif')->count() }} Kemitraan Aktif
                </span>
            </div>
        </div>

        <!-- MAIN TWO-COLUMN INBOX LAYOUT (GRID 12) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- KOLOM KIRI (5 COLS): DAFTAR PENGAJUAN MASUK & UTAS OBROLAN -->
            <div class="lg:col-span-5 bg-white rounded-2xl p-5 border border-[#E8E6DF] shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <span class="text-xs font-black uppercase tracking-wider text-gray-400">Daftar Investor Masuk</span>
                    <span class="text-xs font-bold text-[#0F433C]">{{ $notifikasiInvestasi->count() }} Percakapan</span>
                </div>

                <div class="space-y-2.5 max-h-[620px] overflow-y-auto pr-1">
                    @forelse($notifikasiInvestasi as $invItem)
                        @php
                            $isSelected = ($selectedInvestasi && $selectedInvestasi->id_investasi === $invItem->id_investasi);
                        @endphp
                        <a href="{{ route('dashboard', ['tab' => 'inbox', 'investasi_id' => $invItem->id_investasi]) }}"
                           class="block p-4 rounded-2xl border transition-all {{ $isSelected ? 'border-2 border-[#0F433C] bg-teal-50/60 shadow-sm' : 'border-[#E8E6DF] bg-white hover:bg-gray-50/80 hover:border-gray-300' }}">
                            <div class="flex items-start justify-between gap-2 mb-1.5">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="w-9 h-9 rounded-full bg-[#0F433C] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-sm">
                                        {{ strtoupper(substr($invItem->pengguna->name ?? 'I', 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-xs font-black text-[#1A202C] truncate">
                                            {{ $invItem->pengguna->name ?? 'Calon Investor' }}
                                        </h4>
                                        <span class="text-[10px] text-gray-400 block">
                                            {{ $invItem->tanggal_investasi ? $invItem->tanggal_investasi->diffForHumans() : '-' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                @if($invItem->status === 'aktif')
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-emerald-100 text-emerald-800 shrink-0">
                                        🟢 Aktif
                                    </span>
                                @elseif($invItem->status === 'ditolak')
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-gray-100 text-gray-500 shrink-0">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-amber-100 text-amber-800 shrink-0">
                                        Menunggu
                                    </span>
                                @endif
                            </div>

                            <!-- Detail Nominal -->
                            <div class="mt-2 text-xs flex justify-between items-center bg-white/70 p-2 rounded-xl border border-gray-100">
                                <span class="text-[11px] text-gray-500">Tawaran Modal:</span>
                                <span class="font-extrabold text-[#0F433C]">Rp {{ number_format($invItem->jumlah_modal, 0, ',', '.') }}</span>
                            </div>

                            <!-- Cuplikan Pesan Terakhir -->
                            <p class="text-[11px] text-gray-600 mt-2 line-clamp-1 italic">
                                "{{ $invItem->pesanInvestasi->last()?->pesan ?? $invItem->catatan ?? 'Menunggu diskusi awal...' }}"
                            </p>
                        </a>
                    @empty
                        <div class="p-8 text-center text-xs text-gray-400">
                            Belum ada minat pendanaan dari investor yang masuk saat ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- KOLOM KANAN (7 COLS): RUANG DISKUSI CHAT & LEMBAR KOMITMEN INVESTOR -->
            <div class="lg:col-span-7 bg-white rounded-2xl p-6 sm:p-7 border border-[#E8E6DF] shadow-sm flex flex-col justify-between min-h-[620px]">
                @if($selectedInvestasi)
                    <div>
                        <!-- HEADER OBROLAN & PROFIL INVESTOR -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-[#0F433C] text-white flex items-center justify-center font-black text-sm shrink-0 shadow-sm">
                                    {{ strtoupper(substr($selectedInvestasi->pengguna->name ?? 'I', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-base font-black text-[#1A202C]">
                                            {{ $selectedInvestasi->pengguna->name ?? 'Calon Investor' }}
                                        </h3>
                                        @if($selectedInvestasi->status === 'aktif')
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800">
                                                🟢 Kemitraan Aktif
                                            </span>
                                        @elseif($selectedInvestasi->status === 'ditolak')
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-gray-100 text-gray-600">
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-amber-100 text-amber-800">
                                                Menunggu Respon Anda
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-400 font-medium mt-0.5">
                                        Diajukan pada {{ $selectedInvestasi->tanggal_investasi ? $selectedInvestasi->tanggal_investasi->format('d M Y, H:i') : '-' }} WIB
                                    </p>
                                </div>
                            </div>

                            <!-- Aksi Kontak & WhatsApp -->
                            <div class="flex items-center gap-2 self-start sm:self-auto">
                                @if(!empty($selectedInvestasi->pengguna->phone_number))
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $selectedInvestasi->pengguna->phone_number) }}?text=Halo%20{{ urlencode($selectedInvestasi->pengguna->name) }},%20saya%20pemilik%20usaha%20{{ urlencode($umkm->nama_usaha) }}%20di%20DAYA%20UMKM."
                                       target="_blank"
                                       class="px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5"
                                       title="Lanjutkan Diskusi ke WhatsApp">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.99.54 2.012.85 2.796.85 3.177 0 5.766-2.587 5.766-5.766 0-3.18-2.586-5.767-5.766-5.767zm7.55 5.766c0 4.164-3.393 7.552-7.55 7.552-1.312 0-2.539-.344-3.61-.951l-4.043 1.059 1.082-3.947c-.707-1.144-1.116-2.483-1.116-3.713 0-4.165 3.39-7.553 7.55-7.553 4.163 0 7.687 3.388 7.687 7.552z"/>
                                        </svg>
                                        <span>Lanjut ke WA</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- KARTU RINGKASAN LEMBAR KOMITMEN MODAL -->
                        <div class="mt-4 p-4 rounded-2xl bg-teal-50/70 border border-teal-200/80 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black uppercase tracking-wider text-[#0F433C]">Parameter Usulan Investasi:</span>
                                @if($selectedInvestasi->status === 'pending')
                                    <div class="flex items-center gap-2">
                                        <!-- Form Terima -->
                                        <form id="form-terima-inbox-{{ $selectedInvestasi->id_investasi }}" action="{{ route('dashboard.umkm.investasi.terima', $selectedInvestasi->id_investasi) }}" method="POST">
                                            @csrf
                                            <button type="button"
                                                    onclick="openAppConfirmModal({
                                                        title: 'Terima Komitmen Investasi',
                                                        message: 'Terima komitmen investasi sebesar <strong>Rp {{ number_format($selectedInvestasi->jumlah_modal, 0, ',', '.') }}</strong> dari <strong>{{ addslashes($selectedInvestasi->pengguna->name ?? 'Investor') }}</strong>? Status kemitraan akan resmi berstatus <strong>AKTIF</strong>.',
                                                        badge: 'Rp {{ number_format($selectedInvestasi->jumlah_modal, 0, ',', '.') }} &bull; {{ $selectedInvestasi->persentase_bagi_hasil }}% Bagi Hasil',
                                                        confirmText: '✓ Ya, Terima Investasi',
                                                        confirmClass: 'bg-[#0F433C] hover:bg-[#20675D] text-white',
                                                        icon: 'check',
                                                        form: document.getElementById('form-terima-inbox-{{ $selectedInvestasi->id_investasi }}')
                                                    })"
                                                    class="px-3 py-1.5 rounded-xl bg-[#0F433C] hover:bg-[#20675D] text-white text-xs font-bold transition shadow-sm">
                                                ✓ Terima Investasi
                                            </button>
                                        </form>
                                        <!-- Form Tolak -->
                                        <form id="form-tolak-inbox-{{ $selectedInvestasi->id_investasi }}" action="{{ route('dashboard.umkm.investasi.tolak', $selectedInvestasi->id_investasi) }}" method="POST">
                                            @csrf
                                            <button type="button"
                                                    onclick="openAppConfirmModal({
                                                        title: 'Tolak Minat Investasi',
                                                        message: 'Tolak pengajuan minat investasi sebesar <strong>Rp {{ number_format($selectedInvestasi->jumlah_modal, 0, ',', '.') }}</strong> dari <strong>{{ addslashes($selectedInvestasi->pengguna->name ?? 'Investor') }}</strong>?',
                                                        badge: 'Tolak Penawaran',
                                                        confirmText: '✕ Ya, Tolak Investasi',
                                                        confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
                                                        icon: 'danger',
                                                        form: document.getElementById('form-tolak-inbox-{{ $selectedInvestasi->id_investasi }}')
                                                    })"
                                                    class="px-3 py-1.5 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-bold transition">
                                                ✕ Tolak
                                            </button>
                                        </form>
                                    </div>
                                @elseif($selectedInvestasi->status === 'aktif')
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('kontrak.show', $selectedInvestasi->id_investasi) }}" 
                                           class="px-3.5 py-1.5 rounded-xl hover:opacity-90 transition shadow-sm flex items-center gap-1.5"
                                           style="background-color: #0F433C !important; color: #ffffff !important; border: 1px solid #165E54 !important;">
                                            <svg class="w-3.5 h-3.5 text-amber-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span style="color: #ffffff !important; font-weight: 800; font-size: 12px;">Akad & E-Sign</span>
                                        </a>
                                        <button type="button" 
                                                onclick="openSetorDividenModal('{{ $selectedInvestasi->id_investasi }}', '{{ addslashes($selectedInvestasi->pengguna?->name ?? 'Mitra Investor') }}', '{{ addslashes($selectedInvestasi->pengguna?->bank_name ?? 'Belum Diatur') }}', '{{ $selectedInvestasi->pengguna?->nomor_rekening ?? '-' }}', '{{ addslashes($selectedInvestasi->pengguna?->nama_pemilik_rekening ?? ($selectedInvestasi->pengguna?->name ?? 'Mitra Investor')) }}')"
                                                class="px-3.5 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                                            <span>💸 Setor Dividen</span>
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <div class="grid grid-cols-3 gap-3 pt-1 text-xs">
                                <div>
                                    <span class="text-[10px] text-gray-500 block">Komitmen Modal</span>
                                    <span class="font-extrabold text-[#0F433C] text-sm">Rp {{ number_format($selectedInvestasi->jumlah_modal, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-500 block">Target Bagi Hasil</span>
                                    <span class="font-bold text-gray-800">{{ $selectedInvestasi->persentase_bagi_hasil }}% p.a.</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-500 block">Distribusi Dividen</span>
                                    <span class="font-bold text-gray-800">{{ $selectedInvestasi->periode_pembagian }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- RUANG CHAT / PERCAKAPAN IN-APP LANGSUNG (Fitur Inti Diskusi Web) -->
                        <div class="mt-4">
                            <span class="text-[10px] font-black uppercase tracking-wider text-gray-400 block mb-2">Riwayat Diskusi Resmi:</span>
                            <div class="space-y-3 max-h-[300px] overflow-y-auto p-4 rounded-2xl bg-[#F5F0E8] border border-[#E8E6DF]">
                                @forelse($selectedInvestasi->pesanInvestasi as $msg)
                                    @php
                                        $isMe = ($msg->id_pengirim === Auth::id());
                                    @endphp
                                    <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                                        <div class="max-w-[80%] rounded-2xl p-3 text-xs shadow-sm {{ $isMe ? 'bg-[#0F433C] text-white rounded-br-sm' : 'bg-white text-gray-800 border border-gray-200 rounded-bl-sm' }}">
                                            <div class="flex items-center justify-between gap-2 mb-1">
                                                <span class="font-bold text-[10px] {{ $isMe ? 'text-teal-200' : 'text-[#0F433C]' }}">
                                                    {{ $isMe ? 'Anda (UMKM)' : ($msg->pengirim->name ?? 'Investor') }}
                                                </span>
                                                <span class="text-[9px] {{ $isMe ? 'text-teal-300/70' : 'text-gray-400' }}">
                                                    {{ $msg->created_at ? $msg->created_at->format('H:i') : '' }}
                                                </span>
                                            </div>
                                            <p class="leading-relaxed whitespace-pre-wrap">{{ $msg->pesan }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 text-xs text-gray-400">
                                        Belum ada pesan obrolan lanjutan. Kirim pesan pertama Anda untuk menyapa investor!
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- FORM KIRIM PESAN CHAT LANGSUNG DI DALAM WEB -->
                    <form action="{{ route('dashboard.investasi.pesan', $selectedInvestasi->id_investasi) }}" method="POST" class="mt-4 pt-3 border-t border-gray-100 flex items-center gap-2">
                        @csrf
                        <input type="text" name="pesan" required placeholder="Tulis pesan atau pertanyaan untuk {{ $selectedInvestasi->pengguna?->name ?? 'Investor' }}..."
                               class="flex-1 px-4 py-3 rounded-2xl border border-[#E8E6DF] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                        <button type="submit" class="px-5 py-3 rounded-2xl bg-[#0F433C] hover:bg-[#20675D] text-white text-xs font-black transition shadow-sm flex items-center gap-1.5 shrink-0">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4l19 8-19 8 3-8-3-8zm3 8h10"/>
                            </svg>
                            <span>Kirim</span>
                        </button>
                    </form>
                @else
                    <div class="flex flex-col items-center justify-center h-full text-center py-16 text-gray-400 space-y-3">
                        <span class="text-4xl">📬</span>
                        <h3 class="text-sm font-bold text-gray-700">Pilih Percakapan di Sisi Kiri</h3>
                        <p class="text-xs max-w-sm">
                            Klik salah satu calon investor di daftar sebelah kiri untuk meninjau penawaran modal dan memulai percakapan langsung.
                        </p>
                    </div>
                @endif
            </div>

        </div>



    {{-- ========================================================================= --}}
    {{-- TAB 3: ANALISIS KEUANGAN                                                  --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'keuangan')

        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#1A202C]">Analisis Keuangan</h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                Pencatatan arus kas, omzet, dan laporan bagi hasil usaha.
            </p>
        </div>

        <!-- 3 KARTU METRIK RINGKASAN KEUANGAN -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-[#E8E6DF] shadow-sm">
                <span class="text-xs font-bold text-gray-500">Estimasi Omzet Bulanan</span>
                <h3 class="text-2xl font-black text-emerald-800 mt-1">
                    {{ isset($totalOmzetBulanAktif) && $totalOmzetBulanAktif > 0 ? 'Rp ' . number_format($totalOmzetBulanAktif, 0, ',', '.') : (isset($latestKeuangan) ? 'Rp ' . number_format($latestKeuangan->pendapatan, 0, ',', '.') : 'Rp 12.500.000') }}
                </h3>
                <span class="text-[11px] text-gray-400 font-medium">
                    @if(isset($jumlahCatatanBulanAktif) && $jumlahCatatanBulanAktif > 1)
                        Total akumulasi dari {{ $jumlahCatatanBulanAktif }} catatan di {{ $bulanAktif }}
                    @else
                        Berdasarkan periode {{ $bulanAktif ?? 'berjalan' }}
                    @endif
                </span>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-[#E8E6DF] shadow-sm">
                <span class="text-xs font-bold text-gray-500">Kebutuhan Modal Pendanaan</span>
                <h3 class="text-2xl font-black text-[#0F433C] mt-1">
                    {{ $umkm->modal_dibutuhkan ? 'Rp ' . number_format($umkm->modal_dibutuhkan, 0, ',', '.') : 'Rp 1.000.000' }}
                </h3>
                <span class="text-[11px] text-gray-400 font-medium">Target ekspansi bisnis</span>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-[#E8E6DF] shadow-sm">
                <span class="text-xs font-bold text-gray-500">Persentase Bagi Hasil</span>
                <h3 class="text-2xl font-black text-amber-600 mt-1">
                    {{ $umkm->persentase_bagi_hasil ? $umkm->persentase_bagi_hasil . '%' : ($umkm->estimasi_bagi_hasil ?: '15% p.a.') }}
                </h3>
                <span class="text-[11px] text-gray-400 font-medium">Ditawarkan ke mitra investor</span>
            </div>
        </div>

        <!-- KARTU HASIL ANALISIS LABA / RUGI TERKINI (Ditotalkan Secara Akumulatif) -->
        @if(isset($latestKeuangan))
            @php
                $statusCard = $statusLabaBulanAktif ?? $latestKeuangan->status_laba;
                $labaCard = $totalLabaBersihBulanAktif ?? $latestKeuangan->laba_bersih;
                $marginCard = $marginLabaBulanAktif ?? $latestKeuangan->margin_laba;
                $omzetCard = $totalOmzetBulanAktif ?? $latestKeuangan->pendapatan;
                $hppCard = $totalHppBulanAktif ?? $latestKeuangan->hpp;
                $opsCard = isset($totalBebanBulanAktif) ? ($totalBebanBulanAktif - ($totalHppBulanAktif ?? 0)) : ($latestKeuangan->beban_operasional + $latestKeuangan->beban_lain);
            @endphp
            <div class="p-6 sm:p-7 rounded-2xl border-2 {{ $statusCard === 'untung' ? 'bg-emerald-50/80 border-emerald-300' : ($statusCard === 'rugi' ? 'bg-rose-50/80 border-rose-300' : 'bg-blue-50/80 border-blue-300') }} shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl {{ $statusCard === 'untung' ? 'bg-emerald-500 text-white' : ($statusCard === 'rugi' ? 'bg-rose-500 text-white' : 'bg-blue-500 text-white') }} flex items-center justify-center font-black text-2xl shrink-0 shadow-sm">
                            {{ $statusCard === 'untung' ? '📈' : ($statusCard === 'rugi' ? '📉' : '⚖️') }}
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ $statusCard === 'untung' ? 'bg-emerald-200 text-emerald-900' : ($statusCard === 'rugi' ? 'bg-rose-200 text-rose-900' : 'bg-blue-200 text-blue-900') }}">
                                    Status: {{ strtoupper($statusCard) }}
                                </span>
                                <span class="text-xs font-bold text-gray-600">Periode {{ $bulanAktif ?? $latestKeuangan->bulan_tahun }}</span>
                                @if(isset($jumlahCatatanBulanAktif) && $jumlahCatatanBulanAktif > 1)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-900 border border-amber-300">
                                        Total Akumulasi dari {{ $jumlahCatatanBulanAktif }} Transaksi
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-xl sm:text-2xl font-black text-[#1A202C] mt-1">
                                {{ $statusCard === 'untung' ? 'Total Laba Bersih: Rp ' . number_format($labaCard, 0, ',', '.') : ($statusCard === 'rugi' ? 'Total Defisit Rugi: Rp ' . number_format(abs($labaCard), 0, ',', '.') : 'Impas (BEP)') }}
                            </h3>
                            <p class="text-xs font-semibold {{ $statusCard === 'untung' ? 'text-emerald-800' : 'text-rose-800' }} mt-0.5">
                                Margin Laba: {{ $marginCard > 0 ? '+' : '' }}{{ $marginCard }}% dari Total Omzet Penjualan
                            </p>
                        </div>
                    </div>

                    <div class="bg-white/90 p-4 rounded-2xl border border-gray-200/60 max-w-sm text-xs space-y-1.5 shadow-xs">
                        <div class="flex justify-between text-gray-600">
                            <span>Total Omzet Pendapatan:</span>
                            <span class="font-black text-gray-900">Rp {{ number_format($omzetCard, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Harga Pokok (HPP):</span>
                            <span class="font-bold text-gray-900">Rp {{ number_format($hppCard, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Beban Operasional Usaha:</span>
                            <span class="font-bold text-gray-900">Rp {{ number_format($opsCard, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                @if(isset($jumlahCatatanBulanAktif) && $jumlahCatatanBulanAktif > 1)
                    <div class="mt-4 pt-3 border-t border-gray-200/60 flex flex-wrap items-center justify-between gap-3 text-xs">
                        <div class="flex items-center gap-2 text-gray-700">
                            <span>ℹ️</span>
                            <span>
                                Anda memiliki <strong>{{ $jumlahCatatanBulanAktif }} transaksi</strong> terpisah di periode <strong>{{ $bulanAktif }}</strong> yang otomatis <strong>ditotalkan secara kumulatif</strong>.
                            </span>
                        </div>
                        <form id="form-gabung-keuangan-top" action="{{ route('dashboard.umkm.keuangan.gabung') }}" method="POST">
                            @csrf
                            <input type="hidden" name="bulan_tahun" value="{{ $bulanAktif }}">
                            <button type="button" 
                                    onclick="openAppConfirmModal({
                                        title: 'Satukan Catatan Keuangan',
                                        message: 'Satukan seluruh <strong>{{ $jumlahCatatanBulanAktif }} transaksi</strong> pada periode <strong>{{ $bulanAktif }}</strong> menjadi 1 catatan kumulatif konsolidasi?',
                                        badge: 'Periode {{ $bulanAktif }}',
                                        confirmText: '⚡ Satukan Catatan',
                                        confirmClass: 'bg-[#0F433C] hover:bg-[#20675D] text-white',
                                        icon: 'check',
                                        form: document.getElementById('form-gabung-keuangan-top')
                                    })"
                                    class="px-3.5 py-1.5 rounded-xl bg-[#0F433C] hover:bg-[#20675D] text-white text-[11px] font-black shadow-sm transition flex items-center gap-1.5">
                                <span>⚡ Satukan Menjadi 1 Catatan Kumulatif</span>
                            </button>
                        </form>
                    </div>
                @endif

                <div class="mt-3 pt-2 text-xs {{ $statusCard === 'untung' ? 'text-emerald-900' : 'text-rose-900' }}">
                    <strong>Analisis Sistem:</strong>
                    @if($statusCard === 'untung')
                        Usaha Anda berjalan sehat dengan arus kas positif. Performa ini sangat meyakinkan bagi calon mitra investor untuk menyalurkan modal ekspansi.
                    @elseif($statusCard === 'rugi')
                        Total beban operasional dan HPP melebihi omzet pemasukan. Evaluasi kembali harga bahan baku dan efisiensi pengeluaran harian.
                    @else
                        Pendapatan seimbang dengan beban operasional (Break Even Point).
                    @endif
                </div>
            </div>
        @endif

        <!-- FORMULIR INPUT PENDAPATAN & BEBAN KEUANGAN BESERTA UPLOAD BUKTI (Redesign Sesuai Permintaan User) -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm">
            <!-- Header Card: Eyebrow Badge, Judul, & Deskripsi (Di Bagian Atas) -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-6 border-b border-[#E8E6DF] mb-6">
                <div>
                    <div class="inline-flex items-center gap-1.5 rounded-md bg-[#EFECE3] border border-[#DFD9C8] px-3 py-1 text-xs font-semibold tracking-wide text-[#785C22] mb-2">
                        <span>Kalkulator Laba Rugi</span>
                    </div>
                    
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 leading-snug">
                        Form Input Analisis Pendapatan &amp; Pengeluaran
                    </h2>
                    
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                        Masukkan data omzet dan pengeluaran atau lampirkan foto buku kas / nota untuk dianalisis otomatis.
                    </p>
                </div>
            </div>

            <!-- Form Input Lengkap Diletakkan di Bawah Judul -->
            <form id="form-keuangan" action="{{ route('dashboard.umkm.keuangan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" id="form-id-keuangan" name="id_keuangan" value="">

                <!-- BANNER MODE EDIT (MUNCUL JIKA USER KLIK TOMBOL EDIT DI TABEL) -->
                <div id="edit-mode-banner" class="hidden p-3.5 rounded-xl bg-amber-50 border border-amber-300 text-amber-900 text-xs flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <span class="text-lg">✏️</span>
                        <div>
                            <strong class="font-bold block">Mode Edit Catatan Keuangan</strong>
                            <span class="text-[11px] text-amber-800">Anda sedang mengubah data catatan periode <span id="edit-periode-text" class="font-bold underline"></span>.</span>
                        </div>
                    </div>
                    <button type="button" onclick="cancelEditKeuangan()" class="px-3 py-1.5 rounded-lg bg-amber-200 hover:bg-amber-300 text-amber-900 font-bold text-xs transition">
                        ✕ Batal Edit
                    </button>
                </div>

                <!-- BARIS 1: Periode & Total Pendapatan -->
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 items-end">
                    
                    <!-- Field 1: Periode Bulan & Tahun -->
                    <div class="flex flex-col justify-between">
                        <label for="input-bulan-tahun" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Periode Bulan &amp; Tahun <span class="text-red-600">*</span>
                        </label>
                        <input
                            type="text"
                            id="input-bulan-tahun"
                            name="bulan_tahun"
                            value="{{ date('F Y') }}"
                            placeholder="Contoh: {{ date('F Y') }}"
                            required
                            class="h-11 w-full rounded-lg border border-slate-300 bg-white px-3.5 text-sm font-medium text-slate-900 shadow-2xs transition focus:border-[#0F433C] focus:outline-hidden focus:ring-2 focus:ring-[#0F433C]/15"
                        />
                    </div>

                    <!-- Field 2: Total Pendapatan / Omzet Penjualan -->
                    <div class="flex flex-col justify-between">
                        <div class="flex flex-wrap items-center justify-between gap-1.5 mb-2">
                            <label for="input-pendapatan" class="text-xs font-bold uppercase tracking-wider text-slate-700">
                                Total Pendapatan / Omzet Penjualan (Rp) <span class="text-red-600">*</span>
                            </label>
                            <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 border border-emerald-200 px-2 py-0.5 text-[11px] font-medium text-emerald-800">
                                ⚡ Otomatis terisi jika unggah Excel / Foto Nota
                            </span>
                        </div>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs font-semibold text-slate-400">
                                Rp
                            </span>
                            <input
                                type="number"
                                id="input-pendapatan"
                                name="pendapatan"
                                min="0"
                                step="any"
                                placeholder="15000000"
                                oninput="calculateLiveProfit()"
                                required
                                class="h-11 w-full rounded-lg border border-slate-300 bg-white pl-9 pr-3.5 text-sm font-medium text-slate-900 placeholder:text-slate-400 shadow-2xs transition focus:border-[#0F433C] focus:outline-hidden focus:ring-2 focus:ring-[#0F433C]/15"
                            />
                        </div>
                    </div>

                </div>

                <!-- BARIS 2: Komponen Pengeluaran (3 Kolom) -->
                <div class="grid grid-cols-1 gap-5 md:grid-cols-3 items-start pt-1">
                    
                    <!-- Field 3: Harga Pokok (HPP) -->
                    <div>
                        <label for="input-hpp" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Harga Pokok (HPP / Bahan Baku)
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs font-semibold text-slate-400">
                                Rp
                            </span>
                            <input
                                type="number"
                                id="input-hpp"
                                name="hpp"
                                min="0"
                                step="any"
                                placeholder="6000000"
                                oninput="calculateLiveProfit()"
                                class="h-11 w-full rounded-lg border border-slate-300 bg-white pl-9 pr-3.5 text-sm font-medium text-slate-900 placeholder:text-slate-400 shadow-2xs transition focus:border-[#0F433C] focus:outline-hidden focus:ring-2 focus:ring-[#0F433C]/15"
                            />
                        </div>
                        <p class="mt-1.5 text-xs text-slate-500">Biaya bahan pokok produksi</p>
                    </div>

                    <!-- Field 4: Beban Operasional Usaha -->
                    <div>
                        <label for="input-operasional" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Beban Operasional Usaha
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs font-semibold text-slate-400">
                                Rp
                            </span>
                            <input
                                type="number"
                                id="input-operasional"
                                name="beban_operasional"
                                min="0"
                                step="any"
                                placeholder="3500000"
                                oninput="calculateLiveProfit()"
                                class="h-11 w-full rounded-lg border border-slate-300 bg-white pl-9 pr-3.5 text-sm font-medium text-slate-900 placeholder:text-slate-400 shadow-2xs transition focus:border-[#0F433C] focus:outline-hidden focus:ring-2 focus:ring-[#0F433C]/15"
                            />
                        </div>
                        <p class="mt-1.5 text-xs text-slate-500">Gaji, listrik, sewa, kemasan</p>
                    </div>

                    <!-- Field 5: Beban Lain-Lain -->
                    <div>
                        <label for="input-lain" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Beban Lain-Lain
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs font-semibold text-slate-400">
                                Rp
                            </span>
                            <input
                                type="number"
                                id="input-lain"
                                name="beban_lain"
                                min="0"
                                step="any"
                                placeholder="500000"
                                oninput="calculateLiveProfit()"
                                class="h-11 w-full rounded-lg border border-slate-300 bg-white pl-9 pr-3.5 text-sm font-medium text-slate-900 placeholder:text-slate-400 shadow-2xs transition focus:border-[#0F433C] focus:outline-hidden focus:ring-2 focus:ring-[#0F433C]/15"
                            />
                        </div>
                        <p class="mt-1.5 text-xs text-slate-500">Transportasi, perawatan, tak terduga</p>
                    </div>

                </div>

                <!-- BARIS 3: Banner Simulasi Estimasi Laba Bersih -->
                <div id="live-profit-box" class="flex items-center justify-between rounded-xl bg-[#F2EFE9] border border-[#E4E0D6] px-5 py-4">
                    <div>
                        <p class="text-xs font-medium text-slate-600">Simulasi Estimasi Laba Bersih:</p>
                        <p id="live-profit-text" class="mt-0.5 text-xl sm:text-2xl font-extrabold tracking-tight text-slate-900">
                            Rp 0
                        </p>
                    </div>
                    <span id="live-profit-badge" class="inline-flex items-center rounded-full bg-[#E2E4E8] px-3.5 py-1 text-xs font-bold text-slate-800">
                        Belum Diisi
                    </span>
                </div>

                <!-- BARIS 4: Unggah Berkas & Keterangan Tambahan -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 items-start pt-1">
                    
                    <!-- Field 6: Lampirkan Berkas Laporan Keuangan / Bukti -->
                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-1.5 mb-2 min-h-[24px]">
                            <label for="input-berkas-keuangan" class="text-xs font-bold uppercase tracking-wider text-slate-700">
                                Lampirkan Berkas Laporan Keuangan / Bukti
                            </label>
                            <span class="inline-flex items-center rounded-md bg-emerald-50 border border-emerald-200 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-emerald-800">
                                Auto-Detect: Excel &amp; Foto Nota
                            </span>
                        </div>

                        <div class="flex items-center h-11 w-full rounded-lg border border-slate-300 bg-white px-2 shadow-2xs focus-within:border-[#0F433C] focus-within:ring-2 focus-within:ring-[#0F433C]/15">
                            <input
                                type="file"
                                id="input-berkas-keuangan"
                                name="foto_bukti"
                                accept=".xlsx,.xls,.csv,.jpg,.jpeg,.png,.webp,.pdf,.doc,.docx"
                                onchange="handleFileSelected(event)"
                                class="w-full text-xs text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-[#0F433C] file:px-3.5 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-[#20675D] file:cursor-pointer"
                            />
                        </div>

                        <!-- Format Badges -->
                        <div class="mt-2.5 flex flex-wrap items-center gap-1.5">
                            <span class="text-xs text-slate-500 mr-1">Format:</span>
                            <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 border border-emerald-200/80 px-2 py-0.5 text-[11px] font-medium text-emerald-800">
                                📊 Excel (.xlsx, .xls, .csv)
                            </span>
                            <span class="inline-flex items-center gap-1 rounded-md bg-teal-50 border border-teal-200/80 px-2 py-0.5 text-[11px] font-medium text-teal-800">
                                🖼️ Foto Nota / Kuitansi (Auto OCR)
                            </span>
                            <span class="inline-flex items-center gap-1 rounded-md bg-rose-50 border border-rose-200/80 px-2 py-0.5 text-[11px] font-medium text-rose-800">
                                📄 PDF (.pdf)
                            </span>
                            <span class="inline-flex items-center gap-1 rounded-md bg-blue-50 border border-blue-200/80 px-2 py-0.5 text-[11px] font-medium text-blue-800">
                                📝 Word (.doc, .docx)
                            </span>
                        </div>

                        <!-- Auto-detect badge when file selected -->
                        <div id="file-info-badge" class="hidden mt-2.5 p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs items-center gap-2.5 shadow-2xs">
                            <span id="file-icon" class="text-xl">📊</span>
                            <div class="min-w-0 flex-1">
                                <span id="file-name" class="font-bold truncate block"></span>
                                <span id="file-hint" class="text-[10px] text-emerald-700 block mt-0.5"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Field 7: Keterangan / Catatan Tambahan -->
                    <div>
                        <div class="flex items-center mb-2 min-h-[24px]">
                            <label for="input-catatan" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Keterangan / Catatan Tambahan
                            </label>
                        </div>
                        <input
                            type="text"
                            id="input-catatan"
                            name="catatan"
                            placeholder="Contoh: Lampiran Excel rekapitulasi penjualan harian."
                            class="h-11 w-full rounded-lg border border-slate-300 bg-white px-3.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-2xs transition focus:border-[#0F433C] focus:outline-hidden focus:ring-2 focus:ring-[#0F433C]/15"
                        />
                        <p class="mt-1.5 text-xs text-slate-500">
                            Catatan singkat mengenai sumber data laporan keuangan
                        </p>
                    </div>

                </div>

                <!-- BARIS 5: Pilihan Penanganan Input -->
                <div id="mode-aksi-container" class="rounded-xl bg-[#F2EFE9] border border-[#E4E0D6] p-4 sm:p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 mb-3.5">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                            Pilihan Penanganan Input:
                        </h3>
                        <span class="text-xs text-slate-500">
                            Tentukan aksi jika periode bulan sudah memiliki catatan
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                        
                        <!-- Radio 1: Totalkan / Akumulasikan -->
                        <label class="relative flex cursor-pointer items-start gap-3 rounded-xl border-2 border-emerald-500 bg-emerald-50/60 p-3.5 transition hover:bg-emerald-50 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/80">
                            <input
                                type="radio"
                                name="mode_aksi"
                                value="akumulasi"
                                checked
                                class="mt-0.5 h-4 w-4 shrink-0 border-slate-300 text-emerald-600 focus:ring-emerald-600"
                            />
                            <div class="text-xs leading-relaxed">
                                <div class="font-bold text-slate-900">
                                    ➕ Totalkan / Akumulasikan (Default)
                                </div>
                                <p class="mt-1 text-emerald-900/80">
                                    Nominal baru otomatis dijumlahkan/ditotalkan dengan catatan bulan ini yang sudah ada.
                                </p>
                            </div>
                        </label>

                        <!-- Radio 2: Perbarui / Ganti Total -->
                        <label class="relative flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-white p-3.5 transition hover:border-slate-300 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/80">
                            <input
                                type="radio"
                                name="mode_aksi"
                                value="ganti"
                                class="mt-0.5 h-4 w-4 shrink-0 border-slate-300 text-emerald-600 focus:ring-emerald-600"
                            />
                            <div class="text-xs leading-relaxed">
                                <div class="font-bold text-slate-900">
                                    🔄 Perbarui / Ganti Total
                                </div>
                                <p class="mt-1 text-slate-600">
                                    Mengganti total periode bulan ini secara langsung dengan nominal baru.
                                </p>
                            </div>
                        </label>

                        <!-- Radio 3: Catat Sebagai Baris Baru -->
                        <label class="relative flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-white p-3.5 transition hover:border-slate-300 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/80">
                            <input
                                type="radio"
                                name="mode_aksi"
                                value="baru"
                                class="mt-0.5 h-4 w-4 shrink-0 border-slate-300 text-emerald-600 focus:ring-emerald-600"
                            />
                            <div class="text-xs leading-relaxed">
                                <div class="font-bold text-slate-900">
                                    📑 Catat Sebagai Baris Baru
                                </div>
                                <p class="mt-1 text-slate-600">
                                    Simpan sebagai transaksi/nota terpisah di tabel riwayat.
                                </p>
                            </div>
                        </label>

                    </div>
                </div>

                <!-- BARIS 6: Tombol Submit -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button
                        type="button"
                        id="btn-cancel-edit"
                        onclick="cancelEditKeuangan()"
                        class="hidden w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 rounded-xl border border-slate-300 hover:bg-slate-100 text-slate-700 text-sm font-bold transition shadow-2xs"
                    >
                        ✕ Batal Edit
                    </button>
                    <button
                        type="submit"
                        id="btn-submit-keuangan"
                        class="inline-flex w-full sm:w-auto items-center justify-center gap-2.5 rounded-xl bg-[#0F433C] px-6 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#20675D] focus:outline-hidden focus:ring-2 focus:ring-[#0F433C] focus:ring-offset-2 active:scale-[0.99]"
                    >
                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <span id="btn-submit-keuangan-text">Simpan &amp; Hitung Analisis Laba Rugi</span>
                    </button>
                </div>

            </form>
        </div>

        <!-- TABEL RIWAYAT CATATAN KEUANGAN & BERKAS LAMPIRAN -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm">
            <h2 class="text-lg font-black text-[#1A202C] mb-4">Riwayat Catatan Keuangan Bulanan</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F5F0E8] border-b border-[#E8E6DF] text-[11px] font-black uppercase tracking-wider text-gray-500">
                            <th class="py-3.5 px-5">Periode</th>
                            <th class="py-3.5 px-5">Omzet Penjualan</th>
                            <th class="py-3.5 px-5">Total Beban (HPP + Ops)</th>
                            <th class="py-3.5 px-5">Laba Bersih</th>
                            <th class="py-3.5 px-5">Margin</th>
                            <th class="py-3.5 px-5">Status Laba/Rugi</th>
                            <th class="py-3.5 px-5">Lampiran Berkas / Bukti</th>
                            <th class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs font-medium">
                        @forelse($catatanKeuangan ?? [] as $ck)
                            @php
                                $totalBeban = $ck->hpp + $ck->beban_operasional + $ck->beban_lain;
                                $ext = strtolower(pathinfo($ck->foto_bukti ?? '', PATHINFO_EXTENSION));
                                $isExcel = in_array($ext, ['xlsx', 'xls', 'csv']);
                                $isPdf = $ext === 'pdf';
                                $isWord = in_array($ext, ['doc', 'docx']);
                            @endphp
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="py-3.5 px-5 font-extrabold text-[#1A202C]">
                                    {{ $ck->bulan_tahun }}
                                </td>
                                <td class="py-3.5 px-5 font-bold text-gray-900">
                                    Rp {{ number_format($ck->pendapatan, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-5 text-gray-600">
                                    Rp {{ number_format($totalBeban, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-5 font-black {{ $ck->status_laba === 'untung' ? 'text-emerald-700' : 'text-rose-600' }}">
                                    {{ $ck->status_laba === 'untung' ? '+' : '' }}Rp {{ number_format($ck->laba_bersih, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-5 font-bold {{ $ck->margin_laba > 0 ? 'text-emerald-700' : 'text-rose-600' }}">
                                    {{ $ck->margin_laba }}%
                                </td>
                                <td class="py-3.5 px-5">
                                    @if($ck->status_laba === 'untung')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800">
                                            🟢 Untung
                                        </span>
                                    @elseif($ck->status_laba === 'rugi')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-rose-100 text-rose-800">
                                            🔴 Rugi
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-gray-100 text-gray-800">
                                            ⚪ Impas
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5">
                                    @if(!empty($ck->foto_bukti))
                                        @if($isExcel)
                                            <a href="{{ asset('storage/' . $ck->foto_bukti) }}" download target="_blank" 
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-[11px] font-extrabold border border-emerald-300 transition shadow-sm">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm2 14h-8v-2h8v2zm0-4h-8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                                                </svg>
                                                <span>Unduh Excel (.{{ strtoupper($ext) }})</span>
                                            </a>
                                        @elseif($isPdf)
                                            <a href="{{ asset('storage/' . $ck->foto_bukti) }}" target="_blank" 
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-800 text-[11px] font-extrabold border border-rose-300 transition shadow-sm">
                                                <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9.5 8.5h-2v3H6V7.5h3.5c1.1 0 2 .9 2 2s-.9 2-2 2zm8 0h-2v3h-1.5V7.5H16c1.1 0 2 .9 2 2s-.9 2-2 2zm-4-2H12v6h-1.5V7.5h3c.83 0 1.5.67 1.5 1.5v1c0 .83-.67 1.5-1.5 1.5z"/>
                                                </svg>
                                                <span>Buka PDF</span>
                                            </a>
                                        @elseif($isWord)
                                            <a href="{{ asset('storage/' . $ck->foto_bukti) }}" download target="_blank" 
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-800 text-[11px] font-extrabold border border-blue-300 transition shadow-sm">
                                                <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm2 14h-8v-2h8v2zm0-4h-8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                                                </svg>
                                                <span>Unduh Word (.{{ strtoupper($ext) }})</span>
                                            </a>
                                        @else
                                            <a href="{{ asset('storage/' . $ck->foto_bukti) }}" target="_blank" 
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-800 text-[11px] font-extrabold border border-teal-200 transition shadow-sm">
                                                <svg class="w-3.5 h-3.5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span>Lihat Foto Bukti</span>
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-[11px] text-gray-400 italic">Tidak ada berkas</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" 
                                                onclick="editKeuangan('{{ $ck->id_keuangan }}', '{{ $ck->bulan_tahun }}', '{{ $ck->pendapatan }}', '{{ $ck->hpp }}', '{{ $ck->beban_operasional }}', '{{ $ck->beban_lain }}', '{{ addslashes($ck->catatan ?? '') }}')" 
                                                class="p-1.5 rounded-lg text-emerald-700 hover:bg-emerald-50 transition" 
                                                title="Edit Catatan Ini">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                        <form id="form-delete-keuangan-{{ $ck->id_keuangan }}" action="{{ route('dashboard.umkm.keuangan.delete', $ck->id_keuangan) }}" method="POST">
                                            @csrf
                                            <button type="button" 
                                                    onclick="openAppConfirmModal({
                                                        title: 'Hapus Catatan Keuangan',
                                                        message: 'Apakah Anda yakin ingin menghapus catatan keuangan periode <strong>{{ $ck->bulan_tahun }}</strong>?',
                                                        badge: 'Periode {{ $ck->bulan_tahun }}',
                                                        confirmText: '✕ Ya, Hapus',
                                                        confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
                                                        icon: 'danger',
                                                        form: document.getElementById('form-delete-keuangan-{{ $ck->id_keuangan }}')
                                                    })"
                                                    class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-gray-400 text-xs">
                                    Belum ada data catatan keuangan. Gunakan formulir di atas untuk mulai mencatat omzet & pengeluaran Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if(isset($jumlahCatatanBulanAktif) && $jumlahCatatanBulanAktif > 1)
                        <tfoot class="bg-[#F5F0E8] border-t-2 border-[#E8E6DF] font-black text-xs">
                            <tr>
                                <td class="py-3.5 px-5 text-[#0F433C]">
                                    TOTAL AKUMULASI ({{ $bulanAktif }})
                                </td>
                                <td class="py-3.5 px-5 text-gray-900">
                                    Rp {{ number_format($totalOmzetBulanAktif, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-5 text-gray-700">
                                    Rp {{ number_format($totalBebanBulanAktif, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-5 {{ $statusLabaBulanAktif === 'untung' ? 'text-emerald-700' : 'text-rose-600' }}">
                                    {{ $statusLabaBulanAktif === 'untung' ? '+' : '' }}Rp {{ number_format($totalLabaBersihBulanAktif, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-5 {{ $statusLabaBulanAktif === 'untung' ? 'text-emerald-700' : 'text-rose-600' }}">
                                    {{ $marginLabaBulanAktif }}%
                                </td>
                                <td class="py-3.5 px-5">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase {{ $statusLabaBulanAktif === 'untung' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ strtoupper($statusLabaBulanAktif) }}
                                    </span>
                                </td>
                                <td colspan="2" class="py-3.5 px-5 text-right">
                                    <form id="form-gabung-keuangan-table" action="{{ route('dashboard.umkm.keuangan.gabung') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="bulan_tahun" value="{{ $bulanAktif }}">
                                        <button type="button" 
                                                onclick="openAppConfirmModal({
                                                    title: 'Satukan Catatan Keuangan',
                                                    message: 'Satukan seluruh transaksi di periode <strong>{{ $bulanAktif }}</strong>?',
                                                    badge: 'Periode {{ $bulanAktif }}',
                                                    confirmText: '⚡ Satukan Jadi 1 Catatan',
                                                    confirmClass: 'bg-[#0F433C] hover:bg-[#20675D] text-white',
                                                    icon: 'check',
                                                    form: document.getElementById('form-gabung-keuangan-table')
                                                })"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#0F433C] hover:bg-[#20675D] text-white text-[11px] font-bold shadow-sm transition">
                                            ⚡ Satukan Jadi 1 Catatan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>

        <!-- SheetJS Library untuk Membaca Excel (.xlsx, .xls) di Sisi Browser -->
        <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
        <!-- Tesseract.js Library untuk OCR Deteksi Teks & Angka Otomatis dari Foto Nota / Struk -->
        <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>

        <script>
            // Helper membersihkan format mata uang / angka (contoh: "Rp 15.000.000,00" -> 15000000)
            function parseCellNumber(val) {
                if (typeof val === 'number') return val;
                if (!val) return 0;
                let str = String(val).trim().replace(/[^\d,\.\-]/g, '');
                if (!str || str === '-') return 0;
                if (str.includes('.') && str.includes(',')) {
                    if (str.lastIndexOf(',') > str.lastIndexOf('.')) {
                        str = str.replace(/\./g, '').replace(',', '.');
                    } else {
                        str = str.replace(/,/g, '');
                    }
                } else if (str.includes('.') && !str.includes(',')) {
                    if (/\.\d{3}/.test(str)) str = str.replace(/\./g, '');
                } else if (str.includes(',') && !str.includes('.')) {
                    if (/,\d{3}/.test(str)) str = str.replace(/,/g, '');
                    else str = str.replace(',', '.');
                }
                const n = parseFloat(str);
                return isNaN(n) ? 0 : n;
            }

            function containsKeywords(txt, keywords) {
                const lower = String(txt || '').toLowerCase();
                return keywords.some(k => lower.includes(k));
            }

            // Fungsi cerdas menganalisis baris spreadsheet dan mengisi formulir otomatis
            function processParsedSpreadsheet(rows, fileName) {
                if (!rows || rows.length === 0) return;

                let detectedPendapatan = 0;
                let detectedHpp = 0;
                let detectedOps = 0;
                let isDetected = false;

                // 1. Periksa format Ringkasan Baris per Baris (TOTAL, GRAND TOTAL, SUBTOTAL, TOTAL PENJUALAN, dsb.)
                let grandTotal = 0;
                let totalFound = 0;
                let subtotal = 0;

                rows.forEach(row => {
                    if (!Array.isArray(row)) return;
                    let textCombined = '';
                    let numbers = [];

                    row.forEach(cell => {
                        const str = String(cell || '').trim();
                        const num = parseCellNumber(str);
                        if (num > 0) {
                            numbers.push(num);
                        } else if (/[a-zA-Z]/.test(str)) {
                            textCombined += ' ' + str.toLowerCase();
                        }
                    });
                    textCombined = textCombined.trim();

                    if (numbers.length > 0) {
                        const lastNumber = numbers[numbers.length - 1]; // Angka terakhir di baris summary (misal di kolom Jumlah/Total)

                        if (containsKeywords(textCombined, ['grand total', 'total tagihan', 'sisa tagihan', 'total bayar', 'total penjualan', 'total omzet', 'total pendapatan', 'total pemasukan', 'jumlah total'])) {
                            grandTotal = lastNumber;
                        } else if (/\b(total)\b/i.test(textCombined) && !containsKeywords(textCombined, ['pengeluaran', 'beban', 'biaya'])) {
                            totalFound = lastNumber;
                        } else if (containsKeywords(textCombined, ['subtotal', 'sub total'])) {
                            subtotal = lastNumber;
                        } else if (containsKeywords(textCombined, ['total hpp', 'harga pokok', 'bahan baku', 'hpp'])) {
                            detectedHpp = lastNumber;
                            isDetected = true;
                        } else if (containsKeywords(textCombined, ['biaya operasional', 'beban operasional', 'total pengeluaran', 'total beban', 'total biaya', 'total operasional', 'jumlah pengeluaran', 'jumlah beban'])) {
                            detectedOps = lastNumber;
                            isDetected = true;
                        }
                    }
                });

                if (grandTotal > 0) {
                    detectedPendapatan = grandTotal;
                    isDetected = true;
                } else if (totalFound > 0) {
                    detectedPendapatan = totalFound;
                    isDetected = true;
                } else if (subtotal > 0) {
                    detectedPendapatan = subtotal;
                    isDetected = true;
                }

                // 2. Jika bukan format ringkasan, periksa format Kolom Tabel (Header: No | Nama Barang | Qty | Harga | Jumlah)
                const ignoreColHeaders = ['no', 'no.', 'nomor', 'kode', 'id', 'item', 'nama barang', 'nama jasa', 'barang', 'deskripsi', 'qty', 'kuantitas', 'satuan', 'unit', 'harga satuan', 'diskon', 'diskon (%)', 'tanggal', 'tgl', 'keterangan'];

                let colIncome = null;
                let colExpense = null;
                let colHpp = null;
                let headerIdx = null;

                // Hanya periksa baris yang memiliki minimal 3 kolom terisi agar tidak tertipu judul banner "NOTA PENJUALAN"
                for (let r = 0; r < Math.min(15, rows.length); r++) {
                    const row = rows[r];
                    if (!Array.isArray(row)) continue;

                    let nonEmptyCount = 0;
                    row.forEach(cell => {
                        if (String(cell || '').trim() !== '') nonEmptyCount++;
                    });
                    if (nonEmptyCount < 3) continue;

                    row.forEach((cell, cIdx) => {
                        const text = String(cell || '').toLowerCase().trim();
                        if (!text) return;

                        // Abaikan kolom non-nominal seperti No, Qty, Satuan, Diskon
                        if (ignoreColHeaders.includes(text) || /^(no|nomor|kode|qty|satuan|diskon)\b/.test(text)) {
                            return;
                        }

                        if (colIncome === null && containsKeywords(text, ['jumlah (rp)', 'jumlah rp', 'total (rp)', 'total rp', 'subtotal', 'total harga', 'harga total', 'pemasukan', 'pendapatan', 'omzet', 'penjualan', 'kredit', 'masuk', 'nominal'])) {
                            colIncome = cIdx;
                            headerIdx = r;
                        }
                        if (colExpense === null && containsKeywords(text, ['pengeluaran', 'beban', 'biaya', 'operasional', 'debit', 'keluar', 'belanja', 'pembelian'])) {
                            colExpense = cIdx;
                            headerIdx = r;
                        }
                        if (colHpp === null && containsKeywords(text, ['hpp', 'harga pokok', 'bahan baku', 'modal', 'kulakan'])) {
                            colHpp = cIdx;
                            headerIdx = r;
                        }
                    });

                    if (colIncome !== null || colExpense !== null) break;
                }

                // Jika kolom ditemukan, jumlahkan item baris di bawah header
                if (colIncome !== null || colExpense !== null || colHpp !== null) {
                    const start = (headerIdx !== null) ? headerIdx + 1 : 0;
                    let itemPendapatan = 0;
                    let itemHpp = 0;
                    let itemExpense = 0;

                    for (let i = start; i < rows.length; i++) {
                        const row = rows[i];
                        if (!Array.isArray(row)) continue;
                        const rowText = row.join(' ').toLowerCase();

                        // Abaikan baris total bawaan spreadsheet agar tidak dihitung ganda
                        if (containsKeywords(rowText, ['total', 'subtotal', 'grand total', 'sisa', 'catatan', 'penerima', 'hormat', 'petunjuk'])) {
                            continue;
                        }

                        if (colIncome !== null && row[colIncome] !== undefined) {
                            const val = parseCellNumber(row[colIncome]);
                            if (val > 0) {
                                itemPendapatan += val;
                            }
                        }
                        if (colHpp !== null && row[colHpp] !== undefined) {
                            const val = parseCellNumber(row[colHpp]);
                            if (val > 0) itemHpp += val;
                        }
                        if (colExpense !== null && row[colExpense] !== undefined) {
                            const val = parseCellNumber(row[colExpense]);
                            if (val > 0) {
                                itemExpense += val;
                            }
                        }
                    }

                    if (detectedPendapatan === 0 && itemPendapatan > 0) {
                        detectedPendapatan = itemPendapatan;
                        isDetected = true;
                    }
                    if (detectedHpp === 0 && itemHpp > 0) {
                        detectedHpp = itemHpp;
                        isDetected = true;
                    }
                    if (detectedOps === 0 && itemExpense > 0) {
                        detectedOps = itemExpense;
                        isDetected = true;
                    }
                }

                // Terapkan hasil otomatis ke field formulir jika ditemukan
                if (isDetected && (detectedPendapatan > 0 || (detectedHpp + detectedOps) > 0)) {
                    const inputPendapatan = document.getElementById('input-pendapatan');
                    const inputHpp = document.getElementById('input-hpp');
                    const inputOps = document.getElementById('input-operasional');
                    const hintEl = document.getElementById('file-hint');
                    const badgeEl = document.getElementById('file-info-badge');

                    if (detectedPendapatan > 0) {
                        inputPendapatan.value = Math.round(detectedPendapatan);
                        inputPendapatan.classList.add('ring-2', 'ring-emerald-500', 'bg-emerald-50/50');
                    }
                    if (detectedHpp > 0) {
                        inputHpp.value = Math.round(detectedHpp);
                        inputHpp.classList.add('ring-2', 'ring-emerald-500', 'bg-emerald-50/50');
                    }
                    if (detectedOps > 0) {
                        inputOps.value = Math.round(detectedOps);
                        inputOps.classList.add('ring-2', 'ring-emerald-500', 'bg-emerald-50/50');
                    }

                    // Jalankan simulasi laba rugi real-time
                    calculateLiveProfit();

                    // Tampilkan notifikasi keberhasilan deteksi
                    badgeEl.className = 'mt-2 p-3.5 rounded-2xl bg-emerald-50 border-2 border-emerald-400 text-emerald-950 text-xs flex items-center gap-3 shadow-sm';
                    hintEl.innerHTML = `
                        <strong class="text-emerald-900 text-xs block">
                            ✓ Berhasil Mendeteksi Data dari Berkas Excel!
                        </strong>
                        <span class="text-[11px] text-emerald-800 block mt-0.5">
                            Pemasukan: <strong>Rp ${Math.round(detectedPendapatan).toLocaleString('id-ID')}</strong> &bull; Total Pengeluaran: <strong>Rp ${Math.round(detectedHpp + detectedOps).toLocaleString('id-ID')}</strong>
                        </span>
                        <span class="text-[10px] text-emerald-700 block mt-0.5 italic">
                            Formulir telah terisi otomatis dan siap dihitung. Anda dapat menyesuaikan nominal sebelum menyimpan.
                        </span>
                    `;
                }
            }

            function handleFileSelected(event) {
                const file = event.target.files[0];
                const badge = document.getElementById('file-info-badge');
                const icon = document.getElementById('file-icon');
                const name = document.getElementById('file-name');
                const hint = document.getElementById('file-hint');

                if (!file) {
                    badge.classList.add('hidden');
                    return;
                }

                badge.classList.remove('hidden');
                badge.classList.add('flex');
                badge.className = 'mt-2 p-2.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs flex items-center gap-2.5';
                name.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';

                const ext = file.name.split('.').pop().toLowerCase();

                if (['xlsx', 'xls'].includes(ext)) {
                    icon.textContent = '📊';
                    hint.innerHTML = '<span class="text-emerald-700 animate-pulse">🔄 Membaca dan mendeteksi pemasukan & pengeluaran dari Excel...</span>';

                    // Parse dengan SheetJS di sisi browser
                    if (typeof XLSX !== 'undefined') {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            try {
                                const data = new Uint8Array(e.target.result);
                                const workbook = XLSX.read(data, { type: 'array' });
                                const firstSheetName = workbook.SheetNames[0];
                                const worksheet = workbook.Sheets[firstSheetName];
                                const rows = XLSX.utils.sheet_to_json(worksheet, { header: 1, defval: '' });
                                processParsedSpreadsheet(rows, file.name);
                            } catch (err) {
                                console.warn('Gagal membaca sheet Excel:', err);
                                hint.textContent = 'File Excel terlampir. Sistem di server akan memproses isi laporan saat disimpan.';
                            }
                        };
                        reader.readAsArrayBuffer(file);
                    } else {
                        hint.textContent = 'File Excel terlampir. Sistem di server akan otomatis mendeteksi omzet dan pengeluaran saat Anda klik Simpan.';
                    }
                } else if (ext === 'csv') {
                    icon.textContent = '📊';
                    hint.innerHTML = '<span class="text-emerald-700 animate-pulse">🔄 Membaca dan mendeteksi data CSV...</span>';

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        try {
                            const text = e.target.result;
                            const lines = text.split(/\r\n|\n/);
                            const delimiter = (text.indexOf(';') > text.indexOf(',')) ? ';' : ',';
                            const rows = lines.map(line => line.split(delimiter).map(c => c.trim().replace(/^["']|["']$/g, '')));
                            processParsedSpreadsheet(rows, file.name);
                        } catch (err) {
                            console.warn('Gagal membaca CSV:', err);
                            hint.textContent = 'File CSV terlampir.';
                        }
                    };
                    reader.readAsText(file);
                } else if (ext === 'pdf') {
                    icon.textContent = '📄';
                    hint.textContent = 'Dokumen PDF laporan keuangan siap dilampirkan.';
                } else if (['doc', 'docx'].includes(ext)) {
                    icon.textContent = '📝';
                    hint.textContent = 'Dokumen Word laporan keuangan siap dilampirkan.';
                } else if (['png', 'jpg', 'jpeg', 'webp', 'bmp'].includes(ext)) {
                    icon.textContent = '🖼️';
                    processImageOcr(file);
                } else {
                    icon.textContent = '📎';
                    hint.textContent = 'Berkas terlampir siap diunggah.';
                }
            }

            // =========================================================================
            // OCR (OPTICAL CHARACTER RECOGNITION) PEMINDAI FOTO NOTA / STRUK / KUITANSI
            // =========================================================================
            function preprocessImageForOcr(file) {
                return new Promise((resolve) => {
                    const img = new Image();
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.onload = function() {
                            try {
                                const canvas = document.createElement('canvas');
                                const scale = Math.max(1.5, Math.min(3, 2000 / Math.max(img.width, img.height)));
                                canvas.width = Math.round(img.width * scale);
                                canvas.height = Math.round(img.height * scale);
                                const ctx = canvas.getContext('2d');
                                ctx.imageSmoothingEnabled = true;
                                ctx.imageSmoothingQuality = 'high';
                                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                                const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                                const d = imgData.data;
                                for (let i = 0; i < d.length; i += 4) {
                                    const gray = 0.299 * d[i] + 0.587 * d[i + 1] + 0.114 * d[i + 2];
                                    // Peningkatan kontras agar teks lebih tajam & angka terbaca sempurna
                                    const contrastVal = gray > 175 ? 255 : (gray < 95 ? 0 : gray);
                                    d[i] = contrastVal;
                                    d[i + 1] = contrastVal;
                                    d[i + 2] = contrastVal;
                                }
                                ctx.putImageData(imgData, 0, 0);
                                resolve(canvas.toDataURL('image/png'));
                            } catch (err) {
                                resolve(file); // fallback file mentah jika canvas gagal
                            }
                        };
                        img.onerror = function() { resolve(file); };
                        img.src = e.target.result;
                    };
                    reader.onerror = function() { resolve(file); };
                    reader.readAsDataURL(file);
                });
            }

            async function processImageOcr(file) {
                const hint = document.getElementById('file-hint');
                const icon = document.getElementById('file-icon');
                const submitBtn = document.getElementById('btn-submit-keuangan');
                const submitText = document.getElementById('btn-submit-keuangan-text');

                icon.textContent = '🔍';
                hint.innerHTML = '<span class="text-emerald-700 animate-pulse font-bold">🔄 Sedang mengoptimalkan & membaca teks dari foto nota (OCR)... <span id="ocr-progress">0%</span></span>';
                
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                }
                if (submitText) {
                    submitText.innerText = 'Memindai Foto Nota...';
                }

                if (typeof Tesseract === 'undefined') {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    }
                    if (submitText) {
                        submitText.innerText = 'Simpan & Hitung Analisis Laba Rugi';
                    }
                    hint.textContent = 'Foto nota siap diunggah. Silakan lengkapi nominal pendapatan/beban di atas.';
                    return;
                }

                try {
                    // Pra-proses gambar (upscale & kontras) agar angka dan teks tabel tidak buram
                    const processedSource = await preprocessImageForOcr(file);

                    const result = await Tesseract.recognize(
                        processedSource,
                        'eng',
                        {
                            logger: m => {
                                if (m.status === 'recognizing text') {
                                    const progEl = document.getElementById('ocr-progress');
                                    if (progEl) {
                                        progEl.textContent = Math.round((m.progress || 0) * 100) + '%';
                                    }
                                }
                            }
                        }
                    );

                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    }
                    if (submitText) {
                        submitText.innerText = 'Simpan & Hitung Analisis Laba Rugi';
                    }

                    const fullText = (result && result.data && result.data.text) ? result.data.text : '';
                    parseOcrExtractedText(fullText, file.name);
                } catch (err) {
                    console.warn('Gagal OCR Tesseract:', err);
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    }
                    if (submitText) {
                        submitText.innerText = 'Simpan & Hitung Analisis Laba Rugi';
                    }
                    hint.textContent = 'Foto nota terlampir. Anda dapat mengisi nominal omzet di formulir.';
                }
            }

            function parseIndonesianCurrency(str) {
                if (!str) return 0;
                let s = String(str).trim().replace(/[^\d,\.]/g, '');
                if (!s) return 0;
                // Format 335,000 atau 335.000
                if (/^\d{1,3}[,\.]\d{3}$/.test(s)) {
                    return parseInt(s.replace(/[,\.]/g, ''), 10);
                }
                // Multi ribuan 1.000.000 atau 1,000,000
                if (/^\d{1,3}([,\.]\d{3})+$/.test(s)) {
                    return parseInt(s.replace(/[,\.]/g, ''), 10);
                }
                // Format digit murni 335000
                if (/^\d+$/.test(s)) {
                    return parseInt(s, 10);
                }
                s = s.replace(/,/g, '');
                const n = parseFloat(s);
                return isNaN(n) ? 0 : n;
            }

            function parseOcrExtractedText(text, fileName) {
                const hint = document.getElementById('file-hint');
                const icon = document.getElementById('file-icon');

                if (!text || text.trim().length === 0) {
                    hint.textContent = 'Foto terlampir. Teks angka belum terdeteksi jelas, silakan isi formulir secara manual.';
                    return;
                }

                const lines = text.split(/\r?\n/).map(l => l.trim()).filter(Boolean);
                const lowerText = text.toLowerCase();

                // Deteksi konteks nota penjualan vs belanja/pengeluaran
                const isPenjualan = /nota\s*penjualan|faktur\s*penjualan|invoice|penjualan|sales|omzet|pelanggan|customer|pembeli|terima\s*dari|kasir/i.test(lowerText);
                const isPengeluaran = /nota\s*pembelian|faktur\s*pembelian|pengeluaran|biaya|beban|kulakan|belanja|supplier|toko\s*bahan|kasbon/i.test(lowerText);

                // Regex mencari nominal angka utuh (dengan ribuan atau >= 4 digit)
                const numRegex = /(?:rp\.?\s*)?(\b\d{1,3}(?:[.,]\d{3})+(?:[.,]\d{2})?\b|\b\d{4,}\b|\b\d+\b)/gi;

                const candidateNumbers = [];

                for (let i = 0; i < lines.length; i++) {
                    const line = lines[i];
                    const lineLower = line.toLowerCase();

                    // Abaikan baris metadata dokumen (tanggal, no nota, metode bayar) agar tidak keliru mengambil nomor baris/tanggal
                    if (lineLower.includes('tanggal') || lineLower.includes('no.nota') || lineLower.includes('pembayaran') || lineLower.includes('metode')) {
                        continue;
                    }

                    const matches = line.matchAll(numRegex);
                    for (const m of matches) {
                        const val = parseIndonesianCurrency(m[1]);
                        if (val > 0) {
                            // Indikasi baris total, grand total, subtotal, jumlah, tagihan, sisa (termasuk variasi typo OCR)
                            const isTotalLine = /total|grand|subtotal|swtoal|tora|tota|jumlah|tagihan|netto|sisa/i.test(lineLower);
                            candidateNumbers.push({ val, line, isTotalLine });
                        }
                    }
                }

                // Saring kandidat nominal: utamakan nominal di baris Total yang merupakan angka ribuan (>= 1.000)
                const totalLineLargeCandidates = candidateNumbers.filter(c => c.isTotalLine && c.val >= 1000);
                const allLargeCandidates = candidateNumbers.filter(c => c.val >= 1000);

                let finalNominal = 0;
                if (totalLineLargeCandidates.length > 0) {
                    finalNominal = Math.max(...totalLineLargeCandidates.map(c => c.val));
                } else if (allLargeCandidates.length > 0) {
                    finalNominal = Math.max(...allLargeCandidates.map(c => c.val));
                } else if (candidateNumbers.length > 0) {
                    finalNominal = Math.max(...candidateNumbers.map(c => c.val));
                }

                if (finalNominal > 0) {
                    icon.textContent = '🧾';

                    let targetInputId = 'input-pendapatan';
                    let targetLabel = 'Total Pendapatan / Omzet';

                    if (isPengeluaran && !isPenjualan) {
                        targetInputId = 'input-operasional';
                        targetLabel = 'Beban Operasional Usaha';
                    }

                    const targetInput = document.getElementById(targetInputId);
                    if (targetInput) {
                        targetInput.value = Math.round(finalNominal);
                        // Efek visual highlight pada input yang terisi otomatis
                        targetInput.classList.add('ring-4', 'ring-emerald-400', 'bg-emerald-50');
                        setTimeout(() => {
                            targetInput.classList.remove('ring-4', 'ring-emerald-400', 'bg-emerald-50');
                        }, 2500);
                    }

                    // Isi catatan otomatis bila masih kosong
                    const catatanInput = document.getElementById('input-catatan');
                    if (catatanInput && (!catatanInput.value || catatanInput.value.includes('Terdeteksi Total'))) {
                        const tipeNota = (isPengeluaran && !isPenjualan) ? 'Pengeluaran/Belanja' : 'Penjualan/Omzet';
                        catatanInput.value = `Nota ${tipeNota} (${fileName}) - Terdeteksi Total Rp ${Math.round(finalNominal).toLocaleString('id-ID')}`;
                    }

                    calculateLiveProfit();

                    hint.innerHTML = `
                        <span class="font-black text-emerald-800 flex items-center gap-1.5">
                            <span class="text-emerald-600">✓</span> Berhasil Memindai Foto Nota: Rp ${Math.round(finalNominal).toLocaleString('id-ID')}
                        </span>
                        <span class="text-[10px] text-emerald-700 block mt-0.5">
                            Nominal otomatis diisikan ke kolom <b>${targetLabel}</b>. Anda dapat mengubah nominal jika diperlukan.
                        </span>
                    `;
                } else {
                    hint.textContent = 'Foto nota terlampir, namun teks total belum terdeteksi. Silakan lengkapi nominal di atas secara manual.';
                }
            }

            function calculateLiveProfit() {
                const pendapatan = parseFloat(document.getElementById('input-pendapatan').value) || 0;
                const hpp = parseFloat(document.getElementById('input-hpp').value) || 0;
                const ops = parseFloat(document.getElementById('input-operasional').value) || 0;
                const lain = parseFloat(document.getElementById('input-lain').value) || 0;

                const totalBeban = hpp + ops + lain;
                const laba = pendapatan - totalBeban;

                const textEl = document.getElementById('live-profit-text');
                const badgeEl = document.getElementById('live-profit-badge');

                if (pendapatan === 0 && totalBeban === 0) {
                    textEl.innerText = 'Rp 0';
                    textEl.className = 'mt-0.5 text-xl sm:text-2xl font-extrabold tracking-tight text-slate-900';
                    badgeEl.innerText = 'Belum Diisi';
                    badgeEl.className = 'inline-flex items-center rounded-full bg-[#E2E4E8] px-3.5 py-1 text-xs font-bold text-slate-800';
                    return;
                }

                if (laba > 0) {
                    textEl.innerText = '+ Rp ' + laba.toLocaleString('id-ID');
                    textEl.className = 'mt-0.5 text-xl sm:text-2xl font-extrabold tracking-tight text-emerald-700';
                    badgeEl.innerText = '🟢 Untung (Laba)';
                    badgeEl.className = 'inline-flex items-center rounded-full bg-emerald-100 px-3.5 py-1 text-xs font-bold text-emerald-800';
                } else if (laba < 0) {
                    textEl.innerText = '- Rp ' + Math.abs(laba).toLocaleString('id-ID');
                    textEl.className = 'mt-0.5 text-xl sm:text-2xl font-extrabold tracking-tight text-rose-600';
                    badgeEl.innerText = '🔴 Rugi (Defisit)';
                    badgeEl.className = 'inline-flex items-center rounded-full bg-rose-100 px-3.5 py-1 text-xs font-bold text-rose-800';
                } else {
                    textEl.innerText = 'Rp 0 (Impas)';
                    textEl.className = 'mt-0.5 text-xl sm:text-2xl font-extrabold tracking-tight text-blue-700';
                    badgeEl.innerText = '⚪ Impas (BEP)';
                    badgeEl.className = 'inline-flex items-center rounded-full bg-blue-100 px-3.5 py-1 text-xs font-bold text-blue-800';
                }
            }

            function editKeuangan(id, bulan, pendapatan, hpp, ops, lain, catatan) {
                document.getElementById('form-id-keuangan').value = id;
                document.getElementById('input-bulan-tahun').value = bulan;
                document.getElementById('input-pendapatan').value = Math.round(parseFloat(pendapatan) || 0);
                document.getElementById('input-hpp').value = Math.round(parseFloat(hpp) || 0);
                document.getElementById('input-operasional').value = Math.round(parseFloat(ops) || 0);
                document.getElementById('input-lain').value = Math.round(parseFloat(lain) || 0);
                document.getElementById('input-catatan').value = catatan || '';

                document.getElementById('edit-mode-banner').classList.remove('hidden');
                document.getElementById('edit-periode-text').innerText = bulan;
                document.getElementById('mode-aksi-container').classList.add('hidden');
                document.getElementById('btn-cancel-edit').classList.remove('hidden');
                document.getElementById('btn-submit-keuangan-text').innerText = 'Perbarui Catatan Ini';

                calculateLiveProfit();
                document.getElementById('form-keuangan').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            function cancelEditKeuangan() {
                document.getElementById('form-id-keuangan').value = '';
                document.getElementById('edit-mode-banner').classList.add('hidden');
                document.getElementById('mode-aksi-container').classList.remove('hidden');
                document.getElementById('btn-cancel-edit').classList.add('hidden');
                document.getElementById('btn-submit-keuangan-text').innerText = 'Simpan & Hitung Analisis Laba Rugi';
                document.getElementById('input-pendapatan').value = '';
                document.getElementById('input-hpp').value = '';
                document.getElementById('input-operasional').value = '';
                document.getElementById('input-lain').value = '';
                document.getElementById('input-catatan').value = '';
                calculateLiveProfit();
            }
        </script>

    {{-- ========================================================================= --}}
    {{-- TAB 4: BANTUAN                                                            --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'bantuan')

        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#1A202C]">Pusat Bantuan</h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                Dukungan dan konsultasi bisnis untuk pelaku UMKM.
            </p>
        </div>

        <div class="bg-white rounded-2xl p-8 border border-[#E8E6DF] shadow-sm max-w-2xl">
            <h3 class="text-lg font-black text-[#1A202C] mb-2">Butuh Bantuan Operasional atau Sewa Ruko?</h3>
            <p class="text-xs text-gray-600 mb-6 leading-relaxed">
                Tim kurator dan pendamping usaha DAYA UMKM siap membantu proses verifikasi proposal, konsultasi tata kelola keuangan, dan pemilihan ruko strategis.
            </p>
            <a href="https://wa.me/6281234567890?text=Halo%20Tim%20DAYA%20UMKM,%20saya%20butuh%20bantuan%20terkait%20dashboard%20usaha." target="_blank"
               class="px-6 py-3 rounded-2xl bg-[#0F433C] hover:bg-[#20675D] text-white text-xs font-bold transition shadow-sm inline-flex items-center gap-2">
                <span>Hubungi CS WhatsApp DAYA UMKM</span> &rarr;
            </a>
        </div>

    {{-- ========================================================================= --}}
    {{-- TAB 5: INFORMASI RUKO                                                     --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'ruko')

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#1A202C]">Katalog Ruko Komersial</h1>
                <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                    Tempat usaha strategis terkurasi yang siap disewa atau disponsori pendanaannya oleh investor ekosistem.
                </p>
            </div>
            <button type="button" onclick="openUsulkanRukoUmkmModal()"
                    class="px-5 py-2.5 rounded-2xl bg-[#0F433C] hover:bg-[#20675D] text-white text-xs font-bold transition shadow-sm inline-flex items-center gap-2 self-start sm:self-auto">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Usulkan Ruko Baru</span>
            </button>
        </div>

        <!-- FILTER STATUS KETERSEDIAAN RUKO -->
        <div class="flex flex-wrap items-center gap-2 mb-6">
            <a href="{{ route('dashboard', ['tab' => 'ruko', 'ruko_status' => 'semua']) }}"
               class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ ($rukoStatusFilter ?? 'semua') === 'semua' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                Semua Ruko
            </a>
            <a href="{{ route('dashboard', ['tab' => 'ruko', 'ruko_status' => 'kosong']) }}"
               class="px-4 py-2 rounded-2xl text-xs font-bold transition inline-flex items-center gap-1.5 {{ ($rukoStatusFilter ?? '') === 'kosong' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>🟢 Kosong (Siap Huni)</span>
            </a>
            <a href="{{ route('dashboard', ['tab' => 'ruko', 'ruko_status' => 'terisi']) }}"
               class="px-4 py-2 rounded-2xl text-xs font-bold transition inline-flex items-center gap-1.5 {{ ($rukoStatusFilter ?? '') === 'terisi' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                <span>🔴 Sudah Diisi / Penuh</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($rukos as $ruko)
                <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition flex flex-col justify-between {{ $ruko->is_penuh ? 'opacity-90' : '' }}">
                    <div>
                        <div class="w-full h-44 rounded-2xl bg-gray-100 mb-4 overflow-hidden shadow-inner border border-gray-100 relative">
                            @if(!empty($ruko->foto_ruko))
                                <img src="{{ asset(ltrim($ruko->foto_ruko, '/\\')) }}" alt="{{ $ruko->nama_ruko }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                     onerror="this.onerror=null; this.src='{{ $ruko->foto_url }}';">
                            @elseif(!empty($ruko->foto_url))
                                <img src="{{ $ruko->foto_url }}" alt="{{ $ruko->nama_ruko }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full bg-[#7BAE91] text-white flex items-center justify-center font-bold">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 mx-auto opacity-80 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span class="text-xs uppercase tracking-wider block">Unit Ruko Komersial</span>
                                    </div>
                                </div>
                            @endif

                            <!-- BADGE KETERSEDIAAN DI SUDUT FOTO -->
                            <div class="absolute top-3 right-3">
                                @if($ruko->is_penuh)
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-600 text-white shadow-sm flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Sudah Diisi (Penuh)
                                    </span>
                                @elseif(($ruko->unit_terisi ?? 0) > 0)
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500 text-white shadow-sm flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span> Sisa {{ $ruko->sisa_unit }} Unit
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-600 text-white shadow-sm flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span> Kosong (Sisa {{ $ruko->sisa_unit }} Unit)
                                    </span>
                                @endif
                            </div>
                        </div>

                        <h3 class="text-base font-black text-[#1A202C]">{{ $ruko->nama_ruko }}</h3>
                        <p class="text-xs text-gray-500 mt-1 flex items-start gap-1">
                            <span class="text-rose-500">📍</span>
                            <span>{{ $ruko->lokasi }}</span>
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

                        <!-- BOX RINCIAN STATUS KOSONG/TERISI & SISA UNIT -->
                        <div class="mt-4 p-3.5 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400 font-medium text-[11px]">Kondisi Lapak:</span>
                                @if($ruko->is_penuh)
                                    <span class="font-bold text-rose-600 text-xs flex items-center gap-1">🔴 Sudah Diisi Penuh</span>
                                @elseif(($ruko->unit_terisi ?? 0) > 0)
                                    <span class="font-bold text-amber-700 text-xs flex items-center gap-1">🟡 Terisi Sebagian ({{ $ruko->unit_terisi }}/{{ $ruko->total_unit }} Unit)</span>
                                @else
                                    <span class="font-bold text-emerald-700 text-xs flex items-center gap-1">🟢 Kosong (Siap Huni)</span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-gray-400 font-medium text-[11px]">Sisa Unit Tersedia:</span>
                                <span class="font-extrabold text-xs">
                                    <span class="{{ $ruko->sisa_unit > 0 ? 'text-emerald-700' : 'text-rose-600' }}">
                                        {{ $ruko->sisa_unit }} Unit Kosong
                                    </span>
                                    <span class="text-gray-400 font-normal text-[11px]">/ {{ $ruko->total_unit ?? 1 }} Total</span>
                                </span>
                            </div>

                            <!-- Mini Visual Bar Kapasitas -->
                            @php
                                $totalU = max(1, (int) ($ruko->total_unit ?? 1));
                                $terisiU = min($totalU, (int) ($ruko->unit_terisi ?? 0));
                                $persenTerisi = round(($terisiU / $totalU) * 100);
                            @endphp
                            <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden mt-1">
                                <div class="h-1.5 rounded-full transition-all duration-500 {{ $ruko->is_penuh ? 'bg-rose-500' : ($ruko->unit_terisi > 0 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                                     style="width: {{ $persenTerisi }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3.5 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-gray-400 block">Sewa Bulanan</span>
                            <span class="text-sm font-black text-[#0F433C]">
                                Rp {{ number_format($ruko->harga_sewa_per_bulan, 0, ',', '.') }} / bln
                            </span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $ruko->status_badge_class }}">
                            {{ $ruko->status_display }}
                        </span>
                    </div>

                    <!-- TOMBOL AKSI SEWA MANDIRI (UNTUK PELAKU UMKM) -->
                    <div class="mt-3.5 pt-3 border-t border-gray-100">
                        @if(!$ruko->is_penuh)
                            <button type="button"
                                    onclick="openSewaRukoMandiriModal('{{ $ruko->id_ruko }}', '{{ addslashes($ruko->nama_ruko) }}', '{{ $ruko->harga_sewa_per_bulan }}', '{{ addslashes($ruko->lokasi) }}', '{{ $ruko->sisa_unit }}')"
                                    class="w-full py-2.5 px-4 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-black transition shadow-sm flex items-center justify-center gap-2 active:scale-95">
                                <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                <span>Sewa Ruko Ini (Mandiri) &bull; Sisa {{ $ruko->sisa_unit }} Unit</span>
                            </button>
                        @else
                            <button disabled class="w-full py-2.5 px-4 rounded-xl bg-gray-100 text-gray-400 text-xs font-bold cursor-not-allowed flex items-center justify-center gap-1.5">
                                <span>🔴 Unit Ruko Sudah Penuh (Terisi)</span>
                            </button>
                        @endif
                    </div>

                    @if(!empty($ruko->kontak_pemilik))
                        <div class="mt-2.5 pt-2.5 border-t border-dashed border-gray-200 flex items-center justify-between">
                            @if($ruko->is_penuh)
                                <span class="text-[11px] text-gray-400 font-medium">Ingin info unit ruko lain?</span>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ruko->kontak_pemilik) }}?text=Halo%2C%20saya%20pelaku%20UMKM%20dari%20aplikasi%20DAYA-UMKM.%20Saya%20tertarik%20dengan%20ruko%20Anda%20({{ urlencode($ruko->nama_ruko) }}).%20Apakah%20akan%20ada%20unit%20kosong%20dalam%20waktu%20dekat%3F"
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-200 text-xs font-bold transition">
                                    <span>💬 Tanya Pemilik</span>
                                    <span class="text-[10px]">↗</span>
                                </a>
                            @else
                                <span class="text-[11px] text-gray-400 font-medium">Berminat sewa?</span>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ruko->kontak_pemilik) }}?text=Halo%2C%20saya%20pelaku%20UMKM%20dari%20aplikasi%20DAYA-UMKM.%20Saya%20tertarik%20dan%20ingin%20bertanya%20mengenai%20sewa%20ruko%20Anda%20({{ urlencode($ruko->nama_ruko) }})."
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold transition">
                                    <span>💬 Chat Pemilik</span>
                                    <span class="text-[10px]">↗</span>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-12 text-center text-xs text-gray-500 border border-[#E8E6DF]">
                    Belum ada unit ruko dengan status ini. Anda dapat mengusulkan ruko strategis melalui tombol di atas.
                </div>
            @endforelse
        </div>

    {{-- ========================================================================= --}}
    {{-- TAB 6: EDIT PROFIL & PROPOSAL USAHA                                       --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'profil')

        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#0F433C]/10 text-[#0F433C] mb-2">
                        <span class="w-2 h-2 rounded-full bg-[#0F433C] animate-pulse"></span>
                        Profil & Dokumen Proposal Usaha
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#1A202C]">
                        Edit Profil & Proposal Usaha
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1 font-medium">
                        Perbarui identitas penanggung jawab, profil bisnis, dokumen proposal pendanaan, dan preferensi ruko komersial Anda.
                    </p>
                </div>

                <!-- Status Badge Banner -->
                <div class="shrink-0 self-start sm:self-center">
                    @if(($umkm->status_pengajuan ?? 'draf') === 'terverifikasi')
                        <div class="px-4 py-2.5 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center gap-2.5 shadow-sm">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <div>
                                <span class="text-xs font-black text-emerald-900 block leading-tight">Terverifikasi & Tayang</span>
                                <span class="text-[11px] text-emerald-700 font-medium">Proposal aktif di katalog investor</span>
                            </div>
                        </div>
                    @elseif(($umkm->status_pengajuan ?? '') === 'menunggu_verifikasi')
                        <div class="px-4 py-2.5 rounded-2xl bg-amber-50 border border-amber-200 flex items-center gap-2.5 shadow-sm">
                            <span class="w-3 h-3 rounded-full bg-amber-500 animate-ping"></span>
                            <div>
                                <span class="text-xs font-black text-amber-900 block leading-tight">Menunggu Verifikasi Admin</span>
                                <span class="text-[11px] text-amber-700 font-medium">Antrean kurasi tim Daya UMKM</span>
                            </div>
                        </div>
                    @elseif(($umkm->status_pengajuan ?? '') === 'perlu_perbaikan')
                        <div class="px-4 py-2.5 rounded-2xl bg-rose-50 border border-rose-200 flex items-center gap-2.5 shadow-sm">
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                            <div>
                                <span class="text-xs font-black text-rose-900 block leading-tight">Perlu Perbaikan / Revisi</span>
                                <span class="text-[11px] text-rose-700 font-medium">Silakan perbaiki data & ajukan ulang</span>
                            </div>
                        </div>
                    @else
                        <div class="px-4 py-2.5 rounded-2xl bg-slate-100 border border-slate-200 flex items-center gap-2.5 shadow-sm">
                            <span class="w-3 h-3 rounded-full bg-slate-400"></span>
                            <div>
                                <span class="text-xs font-black text-slate-800 block leading-tight">Status: Draf Formulir</span>
                                <span class="text-[11px] text-slate-600 font-medium">Belum dikirimkan ke tim kurator</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pesan Notifikasi Sukses / Error -->
            @if (session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs sm:text-sm font-semibold flex items-center gap-3 shadow-sm">
                    <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold shrink-0">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 sm:p-5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs sm:text-sm space-y-1.5 shadow-sm">
                    <div class="font-bold flex items-center gap-2">
                        <span>⚠️</span>
                        <span>Mohon periksa kembali formulir profil Anda:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-700 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dashboard.umkm.pengajuan') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Grid 2 Kolom Utama di Desktop (lg:grid-cols-12) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-start">
                    
                    <!-- KOLOM KIRI (lg:col-span-5): Identitas & Domisili -->
                    <div class="lg:col-span-5 space-y-6">
                        
                        <!-- Card 1: Identitas Penanggung Jawab -->
                        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E8E6DF] shadow-sm space-y-5">
                            <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-xl bg-[#0F433C]/10 text-[#0F433C] flex items-center justify-center text-xs font-bold">1</span>
                                    <h3 class="text-base font-extrabold text-[#1A202C]">Identitas Pemilik Usaha</h3>
                                </div>
                                <span class="text-[11px] font-semibold text-gray-400">Data Personal</span>
                            </div>

                            <!-- Foto Profil Avatar -->
                            <div>
                                <label class="block text-xs font-bold text-[#1A202C] mb-2">
                                    Foto Profil Pemilik Usaha
                                </label>
                                <div class="flex items-center gap-4 p-3 rounded-2xl bg-[#F9F8F4] border border-[#E8E6DF]">
                                    <div class="w-16 h-16 rounded-2xl bg-white border-2 border-dashed border-[#20675D]/40 overflow-hidden flex items-center justify-center shrink-0 shadow-sm relative group">
                                        @if($user->avatar)
                                            <img id="preview-tab-foto-umkm" src="{{ $user->avatar }}" alt="Avatar" class="w-full h-full object-cover">
                                        @else
                                            <img id="preview-tab-foto-umkm" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                                            <span id="placeholder-tab-foto-umkm" class="text-2xl text-[#20675D]">👤</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <input type="file" 
                                               id="tab_foto_profil" 
                                               name="foto_profil" 
                                               accept="image/png,image/jpeg,image/webp,image/jpg" 
                                               onchange="previewTabImage(this, 'preview-tab-foto-umkm', 'placeholder-tab-foto-umkm')"
                                               class="w-full text-xs text-gray-500 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-[#0F433C] file:text-white hover:file:bg-[#19584F] cursor-pointer">
                                        <p class="text-[10px] text-gray-500 mt-1">JPG, PNG, atau WEBP. Maks 3MB.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Nama Pemilik -->
                            <div>
                                <label for="tab_pemilik" class="block text-xs font-bold text-[#1A202C] mb-1.5">
                                    Nama Lengkap Pemilik / Pengelola <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" 
                                       id="tab_pemilik" 
                                       name="pemilik" 
                                       value="{{ old('pemilik', $user->name) }}" 
                                       required
                                       placeholder="Contoh: Raka Wibian" 
                                       class="w-full h-11 px-3.5 bg-white border border-[#E8E6DF] focus:border-[#0F433C] focus:ring-1 focus:ring-[#0F433C] rounded-xl text-xs sm:text-sm text-[#1A202C] transition outline-none shadow-xs font-medium">
                            </div>

                            <!-- NIK KTP -->
                            <div>
                                <label for="tab_nik" class="block text-xs font-bold text-[#1A202C] mb-1.5">
                                    NIK KTP Penanggung Jawab
                                </label>
                                <input type="text" 
                                       id="tab_nik" 
                                       name="nik_penanggung_jawab" 
                                       value="{{ old('nik_penanggung_jawab', $umkm->nik_penanggung_jawab) }}" 
                                       placeholder="16 digit NIK KTP (opsional)" 
                                       maxlength="20"
                                       class="w-full h-11 px-3.5 bg-white border border-[#E8E6DF] focus:border-[#0F433C] focus:ring-1 focus:ring-[#0F433C] rounded-xl text-xs sm:text-sm text-[#1A202C] transition outline-none shadow-xs font-medium">
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <label for="tab_nomor_whatsapp" class="block text-xs font-bold text-[#1A202C] mb-1.5">
                                    Nomor WhatsApp Usaha Aktif <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-3 text-xs font-bold text-gray-400">📱</span>
                                    <input type="text" 
                                           id="tab_nomor_whatsapp" 
                                           name="nomor_whatsapp" 
                                           value="{{ old('nomor_whatsapp', $umkm->nomor_whatsapp ?? $user->phone_number) }}" 
                                           required
                                           placeholder="Contoh: 081234567890" 
                                           class="w-full h-11 pl-9 pr-3.5 bg-white border border-[#E8E6DF] focus:border-[#0F433C] focus:ring-1 focus:ring-[#0F433C] rounded-xl text-xs sm:text-sm text-[#1A202C] transition outline-none shadow-xs font-medium">
                                </div>
                                <p class="text-[11px] text-gray-400 mt-1 font-medium">Nomor ini digunakan investor untuk berdiskusi langsung via WhatsApp.</p>
                            </div>
                        </div>

                        <!-- Card 2: Wilayah Domisili Usaha -->
                        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E8E6DF] shadow-sm space-y-4">
                            <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-xl bg-[#0F433C]/10 text-[#0F433C] flex items-center justify-center text-xs font-bold">2</span>
                                    <h3 class="text-base font-extrabold text-[#1A202C]">Wilayah Domisili Usaha</h3>
                                </div>
                                <span class="text-[11px] font-semibold text-gray-400">Lokasi Operasional</span>
                            </div>

                            <x-wilayah-domisili 
                                label="Alamat & Domisili Usaha"
                                :provinsi="old('provinsi', $umkm->provinsi ?? $user->provinsi)"
                                :kota="old('kota', $umkm->kota ?? $user->kota)"
                                :provinsi-kota="old('provinsi_kota', $umkm->provinsi_kota ?? $user->provinsi_kota)"
                                :kecamatan="old('kecamatan', $umkm->kecamatan ?? $user->kecamatan)"
                                :kelurahan="old('kelurahan', $umkm->kelurahan ?? $user->kelurahan)"
                                :rt="old('rt', $umkm->rt ?? $user->rt)"
                                :rw="old('rw', $umkm->rw ?? $user->rw)"
                                id-prefix="edit_umkm_domisili"
                            />
                        </div>

                    </div>

                    <!-- KOLOM KANAN (lg:col-span-7): Profil Bisnis, Modal & Dokumen -->
                    <div class="lg:col-span-7 space-y-6">

                        <!-- Card 3: Profil Bisnis & Finansial -->
                        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E8E6DF] shadow-sm space-y-5">
                            <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-xl bg-[#0F433C]/10 text-[#0F433C] flex items-center justify-center text-xs font-bold">3</span>
                                    <h3 class="text-base font-extrabold text-[#1A202C]">Profil Usaha & Target Modal</h3>
                                </div>
                                <span class="text-[11px] font-semibold text-gray-400">Parameter Kemitraan</span>
                            </div>

                            <!-- Nama Usaha & Kategori Usaha -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="tab_nama_usaha" class="block text-xs font-bold text-[#1A202C] mb-1.5">
                                        Nama Usaha / Merk Dagang <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="tab_nama_usaha" 
                                           name="nama_usaha" 
                                           value="{{ old('nama_usaha', $umkm->nama_usaha) }}" 
                                           placeholder="Contoh: Kopi Muria Sejahtera" 
                                           class="w-full h-11 px-3.5 bg-white border border-[#E8E6DF] focus:border-[#0F433C] focus:ring-1 focus:ring-[#0F433C] rounded-xl text-xs sm:text-sm text-[#1A202C] transition outline-none shadow-xs font-medium">
                                </div>

                                <div>
                                    <label for="tab_jenis_usaha" class="block text-xs font-bold text-[#1A202C] mb-1.5">
                                        Kategori Sektor Usaha <span class="text-rose-500">*</span>
                                    </label>
                                    @php $currentKat = old('jenis_usaha', $umkm->jenis_usaha ?? 'Makanan'); @endphp
                                    <select id="tab_jenis_usaha" 
                                            name="jenis_usaha" 
                                            class="w-full h-11 px-3.5 bg-white border border-[#E8E6DF] focus:border-[#0F433C] focus:ring-1 focus:ring-[#0F433C] rounded-xl text-xs sm:text-sm text-[#1A202C] transition outline-none shadow-xs font-medium cursor-pointer">
                                        <option value="Makanan" {{ $currentKat === 'Makanan' ? 'selected' : '' }}>Makanan & Minuman (F&B)</option>
                                        <option value="Jasa" {{ $currentKat === 'Jasa' ? 'selected' : '' }}>Jasa & Layanan</option>
                                        <option value="Fashion" {{ $currentKat === 'Fashion' ? 'selected' : '' }}>Fashion & Pakaian</option>
                                        <option value="Agribisnis" {{ $currentKat === 'Agribisnis' ? 'selected' : '' }}>Agribisnis & Pertanian</option>
                                        <option value="Retail" {{ $currentKat === 'Retail' ? 'selected' : '' }}>Retail & Toko Kelontong</option>
                                        <option value="Kerajinan" {{ $currentKat === 'Kerajinan' ? 'selected' : '' }}>Kerajinan Tangan / Kriya</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Target Kebutuhan Modal & Estimasi Bagi Hasil -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="tab_modal_display" class="block text-xs font-bold text-[#1A202C] mb-1.5">
                                        Kebutuhan Modal Kerja (Rp)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-3 text-xs font-black text-gray-400">Rp</span>
                                        <input type="text" 
                                               inputmode="numeric" 
                                               id="tab_modal_display" 
                                               value="{{ old('modal_dibutuhkan', $umkm->modal_dibutuhkan) ? number_format((float) preg_replace('/\D/', '', old('modal_dibutuhkan', $umkm->modal_dibutuhkan)), 0, ',', '.') : '' }}" 
                                               placeholder="Contoh: 25.000.000" 
                                               oninput="formatNominalRupiah(this, 'tab_modal_hidden')"
                                               class="w-full h-11 pl-9 pr-3.5 bg-white border border-[#E8E6DF] focus:border-[#0F433C] focus:ring-1 focus:ring-[#0F433C] rounded-xl text-xs sm:text-sm text-[#1A202C] outline-none transition shadow-xs font-bold" 
                                               autocomplete="off">
                                    </div>
                                    <input type="hidden" 
                                           name="modal_dibutuhkan" 
                                           id="tab_modal_hidden" 
                                           value="{{ old('modal_dibutuhkan', $umkm->modal_dibutuhkan) ? preg_replace('/\D/', '', old('modal_dibutuhkan', $umkm->modal_dibutuhkan)) : '' }}">
                                    <p class="text-[11px] text-gray-400 mt-1 font-medium">Target permodalan dari calon mitra investor.</p>
                                </div>

                                <div>
                                    <label for="tab_estimasi_bagi_hasil" class="block text-xs font-bold text-[#1A202C] mb-1.5">
                                        Estimasi Bagi Hasil Bulanan
                                    </label>
                                    <input type="text" 
                                           id="tab_estimasi_bagi_hasil" 
                                           name="estimasi_bagi_hasil" 
                                           value="{{ old('estimasi_bagi_hasil', $umkm->estimasi_bagi_hasil ?? '15% per bulan') }}" 
                                           placeholder="Contoh: 15% dari laba bersih per bulan" 
                                           class="w-full h-11 px-3.5 bg-white border border-[#E8E6DF] focus:border-[#0F433C] focus:ring-1 focus:ring-[#0F433C] rounded-xl text-xs sm:text-sm text-[#1A202C] outline-none transition shadow-xs font-medium">
                                    <p class="text-[11px] text-gray-400 mt-1 font-medium">Skema penawaran bagi hasil untuk investor.</p>
                                </div>
                            </div>

                            <!-- Deskripsi Usaha -->
                            <div>
                                <label for="tab_deskripsi" class="block text-xs font-bold text-[#1A202C] mb-1.5">
                                    Deskripsi Singkat Usaha & Rencana Ekspansi
                                </label>
                                <textarea id="tab_deskripsi" 
                                          name="deskripsi" 
                                          rows="4" 
                                          placeholder="Jelaskan jenis produk, keunggulan kompetitif, pelanggan potensial, dan rencana alokasi modal..." 
                                          class="w-full px-3.5 py-3 bg-white border border-[#E8E6DF] focus:border-[#0F433C] focus:ring-1 focus:ring-[#0F433C] rounded-xl text-xs sm:text-sm text-[#1A202C] outline-none transition shadow-xs min-h-[110px] resize-y font-medium leading-relaxed">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                            </div>
                        </div>

                        <!-- Card 4: Dokumen Proposal & Foto Produk -->
                        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E8E6DF] shadow-sm space-y-5">
                            <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-xl bg-[#0F433C]/10 text-[#0F433C] flex items-center justify-center text-xs font-bold">4</span>
                                    <h3 class="text-base font-extrabold text-[#1A202C]">Berkas Proposal & Foto Produk</h3>
                                </div>
                                <span class="text-[11px] font-semibold text-gray-400">Media & Dokumen</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 items-start">
                                <!-- Upload Foto Produk -->
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold text-[#1A202C]">
                                        Foto Produk / Tempat Usaha
                                    </label>
                                    @if ($umkm->foto_produk)
                                        <div class="p-2.5 rounded-2xl bg-emerald-50/80 border border-emerald-200 flex items-center gap-3">
                                            <img src="{{ asset('storage/' . $umkm->foto_produk) }}" class="w-12 h-12 rounded-xl object-cover shrink-0 border border-emerald-300">
                                            <div class="min-w-0 flex-1">
                                                <span class="text-xs font-bold text-emerald-900 block truncate">Foto Produk Terpasang</span>
                                                <span class="text-[10px] text-emerald-700 font-medium">Klik tombol di bawah jika ingin mengganti</span>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" 
                                           id="tab_foto_produk" 
                                           name="foto_produk" 
                                           accept="image/*" 
                                           class="hidden" 
                                           onchange="updateTabFileName(this, 'tab_foto_produk_label')">
                                    <label for="tab_foto_produk" 
                                           id="tab_foto_produk_label" 
                                           class="w-full h-11 px-3.5 bg-[#F9F8F4] hover:bg-emerald-50/80 text-[#0F433C] border border-dashed border-[#0F433C] rounded-xl text-xs font-bold text-center cursor-pointer transition flex items-center justify-center gap-2 shadow-2xs">
                                        <span>📷 {{ $umkm->foto_produk ? 'Ganti Berkas Foto Produk' : 'Pilih Berkas Foto Produk' }}</span>
                                    </label>
                                    <span class="text-[11px] text-gray-400 block font-medium">Format: JPG, PNG, WEBP (Maks 5MB)</span>
                                </div>

                                <!-- Upload File Proposal -->
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold text-[#1A202C]">
                                        File Dokumen Proposal Usaha
                                    </label>
                                    @if ($umkm->file_proposal)
                                        <div class="p-2.5 rounded-2xl bg-teal-50/80 border border-teal-200 flex items-center justify-between gap-3 text-xs">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <span class="text-base">📄</span>
                                                <span class="font-bold text-[#0F433C] truncate">Proposal Aktif</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $umkm->file_proposal) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-[#0F433C] text-white text-[11px] font-bold hover:bg-[#19584F] transition shrink-0">
                                                Unduh ↗
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" 
                                           id="tab_file_proposal" 
                                           name="file_proposal" 
                                           accept=".pdf,.doc,.docx,.zip" 
                                           class="hidden" 
                                           onchange="updateTabFileName(this, 'tab_file_proposal_label')">
                                    <label for="tab_file_proposal" 
                                           id="tab_file_proposal_label" 
                                           class="w-full h-11 px-3.5 bg-[#F9F8F4] hover:bg-teal-50/80 text-[#0F433C] border border-dashed border-[#0F433C] rounded-xl text-xs font-bold text-center cursor-pointer transition flex items-center justify-center gap-2 shadow-2xs">
                                        <span>📁 {{ $umkm->file_proposal ? 'Ganti File Proposal' : 'Pilih File Proposal' }}</span>
                                    </label>
                                    <span class="text-[11px] text-gray-400 block font-medium">Format: PDF, DOC, DOCX, ZIP (Maks 10MB)</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- BAGIAN BAWAH: Preferensi Unit Ruko Komersial (Lebar Penuh) -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl bg-[#0F433C]/10 text-[#0F433C] flex items-center justify-center text-xs font-black">5</span>
                            <div>
                                <h3 class="text-base sm:text-lg font-extrabold text-[#1A202C]">Preferensi Lokasi Ruko Komersial</h3>
                                <p class="text-xs text-gray-500 font-medium">Pilih unit ruko strategis jika usaha Anda membutuhkan tempat operasional baru.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <button type="button" 
                                    id="btn-clear-ruko-tab" 
                                    class="px-3.5 py-1.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-100 hover:text-rose-600 transition">
                                ✕ Hapus Pilihan Ruko
                            </button>
                        </div>
                    </div>

                    <!-- Search Filter Ruko Realtime -->
                    <div class="relative max-w-md">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3.5 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" 
                               id="tab-ruko-search" 
                               onkeyup="filterTabRukoCards()" 
                               placeholder="Cari ruko berdasarkan nama atau lokasi..." 
                               class="w-full h-11 pl-10 pr-3.5 bg-[#F9F8F4] border border-[#E8E6DF] focus:border-[#0F433C] focus:ring-1 focus:ring-[#0F433C] rounded-xl text-xs sm:text-sm text-[#1A202C] outline-none transition font-medium">
                    </div>

                    <!-- Grid Kartu Ruko Responsif (1 col di mobile, 2 di sm, 3 di lg, 4 di xl) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 pt-1" id="tab-ruko-grid">
                        @php
                            $selectedRukoTabId = old('id_ruko_diminati', $umkm->id_ruko_diminati);
                        @endphp

                        @forelse ($rukos as $ruko)
                            <label class="tab-ruko-card block rounded-2xl border-2 {{ $selectedRukoTabId == $ruko->id_ruko ? 'border-[#0F433C] bg-teal-50/20 shadow-md ring-2 ring-[#0F433C]/20' : 'border-[#E8E6DF] hover:border-[#0F433C]/60 bg-white' }} p-3.5 cursor-pointer transition relative group">
                                <input type="radio" 
                                       name="id_ruko_diminati" 
                                       value="{{ $ruko->id_ruko }}" 
                                       {{ $selectedRukoTabId == $ruko->id_ruko ? 'checked' : '' }} 
                                       onchange="highlightSelectedRuko(this)"
                                       class="absolute top-4 right-4 w-4 h-4 text-[#0F433C] focus:ring-[#0F433C]">
                                
                                <div class="w-full aspect-[16/10] rounded-xl overflow-hidden mb-3 bg-gray-100 relative border border-gray-100">
                                    <img src="{{ $ruko->foto_url }}" 
                                         alt="{{ $ruko->nama_ruko }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300" 
                                         loading="lazy">
                                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-[#0F433C]/80 backdrop-blur-xs text-white text-[10px] font-bold">
                                        Daya Ruko
                                    </span>
                                </div>

                                <div class="space-y-1">
                                    <h4 class="tab-ruko-title text-xs sm:text-sm font-extrabold text-[#1A202C] truncate">
                                        {{ $ruko->nama_ruko }}
                                    </h4>
                                    <p class="tab-ruko-loc text-[11px] text-gray-500 line-clamp-2 leading-relaxed">
                                        {{ $ruko->lokasi }}
                                    </p>
                                    <div class="pt-2 border-t border-gray-100 mt-2 flex items-center justify-between">
                                        <div>
                                            <span class="text-[9px] uppercase font-bold text-gray-400 block">Sewa</span>
                                            <span class="text-xs font-black text-[#0F433C]">
                                                Rp {{ number_format($ruko->harga_sewa_per_bulan, 0, ',', '.') }} <span class="text-[10px] font-normal text-gray-500">/bln</span>
                                            </span>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            {{ $ruko->total_unit - $ruko->unit_terisi }} Unit Kosong
                                        </span>
                                    </div>
                                </div>
                            </label>
                        @empty
                            <div class="col-span-full p-8 text-center text-xs text-gray-500 bg-[#F9F8F4] rounded-2xl border border-dashed border-[#E8E6DF]">
                                Belum ada unit ruko yang terdaftar saat ini.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- ACTION BUTTONS: Simpan Draf & Kirim Pengajuan -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E8E6DF] shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4 sticky bottom-4 z-20 backdrop-blur-md bg-white/95">
                    <div class="text-xs text-gray-500 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Perubahan data tersimpan aman di akun Anda. Anda dapat memperbarui draf ini kapan saja.</span>
                    </div>

                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button type="submit" 
                                name="aksi" 
                                value="simpan_draf" 
                                class="w-full sm:w-auto px-5 py-3 rounded-2xl border border-[#E8E6DF] bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            <span>Simpan Draf Usaha</span>
                        </button>

                        <button type="submit" 
                                name="aksi" 
                                value="kirim_pengajuan" 
                                class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-extrabold transition shadow-md flex items-center justify-center gap-2 cursor-pointer">
                            <span>Kirim Pengajuan ke Admin</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <script>
            function previewTabImage(input, previewId, placeholderId) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById(previewId);
                        const placeholder = document.getElementById(placeholderId);
                        if (preview) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                        }
                        if (placeholder) {
                            placeholder.classList.add('hidden');
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function updateTabFileName(input, labelId) {
                const label = document.getElementById(labelId);
                if (input.files && input.files.length > 0) {
                    label.innerHTML = `
                        <span class="truncate max-w-[220px] text-[#0F433C] font-extrabold">✓ ${input.files[0].name}</span>
                    `;
                    label.classList.add('bg-teal-50', 'border-[#0F433C]');
                }
            }

            function formatNominalRupiah(input, targetHiddenId) {
                let val = input.value.replace(/\D/g, '');
                let hidden = document.getElementById(targetHiddenId);
                if (hidden) {
                    hidden.value = val;
                }
                if (!val) {
                    input.value = '';
                    return;
                }
                input.value = new Intl.NumberFormat('id-ID').format(val);
            }

            function filterTabRukoCards() {
                const query = (document.getElementById('tab-ruko-search').value || '').toLowerCase();
                const cards = document.querySelectorAll('.tab-ruko-card');
                cards.forEach(card => {
                    const title = (card.querySelector('.tab-ruko-title')?.innerText || '').toLowerCase();
                    const loc = (card.querySelector('.tab-ruko-loc')?.innerText || '').toLowerCase();
                    if (title.includes(query) || loc.includes(query)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            function highlightSelectedRuko(radioInput) {
                document.querySelectorAll('.tab-ruko-card').forEach(card => {
                    card.classList.remove('border-[#0F433C]', 'bg-teal-50/20', 'shadow-md', 'ring-2', 'ring-[#0F433C]/20');
                    card.classList.add('border-[#E8E6DF]', 'bg-white');
                });
                if (radioInput.checked) {
                    const parentCard = radioInput.closest('.tab-ruko-card');
                    if (parentCard) {
                        parentCard.classList.remove('border-[#E8E6DF]', 'bg-white');
                        parentCard.classList.add('border-[#0F433C]', 'bg-teal-50/20', 'shadow-md', 'ring-2', 'ring-[#0F433C]/20');
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                const btnClearRuko = document.getElementById('btn-clear-ruko-tab');
                if (btnClearRuko) {
                    btnClearRuko.addEventListener('click', () => {
                        document.querySelectorAll('input[name="id_ruko_diminati"]').forEach(input => {
                            input.checked = false;
                        });
                        document.querySelectorAll('.tab-ruko-card').forEach(card => {
                            card.classList.remove('border-[#0F433C]', 'bg-teal-50/20', 'shadow-md', 'ring-2', 'ring-[#0F433C]/20');
                            card.classList.add('border-[#E8E6DF]', 'bg-white');
                        });
                    });
                }
            });
        </script>

    {{-- ========================================================================= --}}
    {{-- TAB 7: SEWA INFLUENCER & PROMOSI DIGITAL                                  --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'influencer')
        @include('dashboard.partials.umkm-influencer-tab')

    @endif

</div>



<!-- MODAL SETOR DIVIDEN BAGI HASIL KE INVESTOR -->
<div id="modal-setor-dividen" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-base font-black">💸</span>
                <h3 class="text-xl font-black text-[#1A202C]">Setor Dividen Bagi Hasil</h3>
            </div>
            <button type="button" onclick="closeSetorDividenModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center text-sm font-bold">✕</button>
        </div>
        <p class="text-xs text-gray-500 mb-5">
            Salurkan keuntungan bagi hasil riil ke nomor rekening bank mitra investor Anda, lalu lampirkan bukti/struk transfer.
        </p>

        <form action="{{ route('dashboard.umkm.dividen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <!-- Pilih Mitra Investor -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Mitra Investor Penerima *</label>
                <select id="modal-select-investasi" name="id_investasi" required onchange="onModalInvestorChange()"
                        class="w-full px-4 py-2.5 rounded-xl border border-[#E8E6DF] text-xs font-bold focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                    @foreach($investasiAktif as $inv)
                        <option value="{{ $inv->id_investasi }}"
                                data-investor="{{ $inv->pengguna?->name ?? 'Mitra Investor' }}"
                                data-bank="{{ $inv->pengguna?->bank_name ?? 'Bank Belum Diatur' }}"
                                data-rek="{{ $inv->pengguna?->nomor_rekening ?? '-' }}"
                                data-nama="{{ $inv->pengguna?->nama_pemilik_rekening ?? ($inv->pengguna?->name ?? 'Mitra Investor') }}">
                            {{ $inv->pengguna?->name ?? 'Mitra Investor' }} - Modal Rp {{ number_format($inv->jumlah_modal, 0, ',', '.') }} (Bagi Hasil {{ $inv->persentase_bagi_hasil }}%)
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- KOTAK REKENING BANK INVESTOR (INFO TRANSFER) -->
            <div class="p-4 rounded-2xl bg-teal-50/80 border border-teal-200/90 text-xs space-y-1.5">
                <span class="text-[10px] font-black uppercase tracking-wider text-[#0F433C] block">Rekening Bank Tujuan Transfer:</span>
                <div class="flex items-center justify-between pt-1">
                    <span class="text-gray-500">Nama Bank:</span>
                    <span id="modal-dividen-bank" class="font-extrabold text-[#0F433C] text-sm">-</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Nomor Rekening:</span>
                    <span id="modal-dividen-rek" class="font-black text-[#1A202C] text-sm font-mono tracking-wider">-</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Atas Nama Pemilik:</span>
                    <span id="modal-dividen-nama" class="font-bold text-gray-800">-</span>
                </div>
            </div>

            <!-- Nominal Dividen -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nominal Dividen Ditransfer (Rp) *</label>
                <input type="number" name="nominal_diterima" required min="10000" step="1000" placeholder="Contoh: 150000"
                       class="w-full px-4 py-2.5 rounded-xl border border-[#E8E6DF] text-sm font-black text-[#0F433C] focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                <span class="text-[10px] text-gray-400 mt-1 block">Pastikan nominal sesuai dengan mutasi transfer yang Anda lakukan.</span>
            </div>

            <!-- Tanggal Transfer -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tanggal Transfer *</label>
                <input type="date" name="tanggal_distribusi" value="{{ date('Y-m-d') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-[#E8E6DF] text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
            </div>

            <!-- Upload Struk Bukti Transfer -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Foto Struk / Resi Bukti Transfer *</label>
                <input type="file" name="bukti_transfer" accept="image/*" required
                       class="w-full text-xs text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0F433C] file:text-white hover:file:bg-[#20675D] file:cursor-pointer">
                <span class="text-[10px] text-gray-400 mt-1 block">Format: JPG, PNG, atau WEBP. Maksimal 5MB. Struk ini otomatis dapat diunduh/dilihat oleh investor.</span>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeSetorDividenModal()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Kirim & Catat Dividen</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>


    // Modal Setor Dividen
    function openSetorDividenModal(idInvestasi, investorName, bankName, noRek, namaRek) {
        const select = document.getElementById('modal-select-investasi');
        if (select && idInvestasi) {
            select.value = idInvestasi;
        }
        document.getElementById('modal-dividen-bank').innerText = bankName || 'Bank Belum Diatur';
        document.getElementById('modal-dividen-rek').innerText = noRek || '-';
        document.getElementById('modal-dividen-nama').innerText = namaRek || '-';
        document.getElementById('modal-setor-dividen').classList.remove('hidden');
    }

    function onModalInvestorChange() {
        const select = document.getElementById('modal-select-investasi');
        if (!select) return;
        const opt = select.options[select.selectedIndex];
        if (opt) {
            document.getElementById('modal-dividen-bank').innerText = opt.getAttribute('data-bank') || 'Bank Belum Diatur';
            document.getElementById('modal-dividen-rek').innerText = opt.getAttribute('data-rek') || '-';
            document.getElementById('modal-dividen-nama').innerText = opt.getAttribute('data-nama') || '-';
        }
    }

    function closeSetorDividenModal() {
        document.getElementById('modal-setor-dividen').classList.add('hidden');
    }

    // Modal Usulkan Ruko UMKM
    function openUsulkanRukoUmkmModal() {
        document.getElementById('modal-usulkan-ruko-umkm').classList.remove('hidden');
    }
    function closeUsulkanRukoUmkmModal() {
        document.getElementById('modal-usulkan-ruko-umkm').classList.add('hidden');
    }

    // Modal Sewa Ruko Mandiri untuk Pelaku UMKM
    let currentSewaMandiriMonthlyPrice = 0;
    function openSewaRukoMandiriModal(idRuko, namaRuko, hargaBulanan, lokasi, sisaUnit) {
        currentSewaMandiriMonthlyPrice = parseFloat(hargaBulanan) || 0;
        document.getElementById('sewa-mandiri-nama-ruko').innerText = namaRuko;
        document.getElementById('sewa-mandiri-lokasi-ruko').innerText = '📍 ' + lokasi;
        document.getElementById('sewa-mandiri-tarif').innerText = 'Rp ' + Number(currentSewaMandiriMonthlyPrice).toLocaleString('id-ID') + ' / bln';
        document.getElementById('sewa-mandiri-sisa').innerText = (sisaUnit || '1') + ' Unit Tersedia';
        document.getElementById('form-sewa-ruko-mandiri').action = '/dashboard/umkm/sewa-ruko/' + idRuko;
        updateSewaMandiriTotal();
        document.getElementById('modal-sewa-ruko-mandiri').classList.remove('hidden');
    }

    function updateSewaMandiriTotal() {
        const durasi = parseInt(document.getElementById('sewa-mandiri-durasi-select').value) || 1;
        const total = currentSewaMandiriMonthlyPrice * durasi;
        document.getElementById('sewa-mandiri-total-harga').innerText = 'Rp ' + Number(total).toLocaleString('id-ID');
        document.getElementById('sewa-mandiri-durasi-label').innerText = durasi + ' Bulan';
    }

    function closeSewaRukoMandiriModal() {
        document.getElementById('modal-sewa-ruko-mandiri').classList.add('hidden');
    }

    // Modal Balas Ulasan Investor
    function openBalasUlasanModal(idUlasan, investorName, reviewText) {
        document.getElementById('balas-modal-investor').innerText = investorName;
        document.getElementById('balas-modal-quote').innerText = '"' + reviewText + '"';
        document.getElementById('form-balas-ulasan').action = '/dashboard/umkm/ulasan/' + idUlasan + '/balas';
        document.getElementById('modal-balas-ulasan').classList.remove('hidden');
    }
    function closeBalasUlasanModal() {
        document.getElementById('modal-balas-ulasan').classList.add('hidden');
    }
</script>

<!-- MODAL USULKAN RUKO STRATEGIS (PELAKU UMKM) -->
<div id="modal-usulkan-ruko-umkm" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-2xl bg-teal-100 text-[#0F433C] flex items-center justify-center text-xl font-black shrink-0">
                📍
            </div>
            <div>
                <h3 class="text-lg font-black text-[#1A202C]">Usulkan Lokasi Ruko Baru</h3>
                <p class="text-xs text-gray-500">Rekomendasikan tempat usaha yang potensial untuk usaha Anda ke tim kurator TIKUM</p>
            </div>
        </div>

        <form action="{{ route('dashboard.umkm.ruko.rekomendasi') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Ruko / Kawasan *</label>
                <input type="text" name="nama_ruko" required placeholder="Contoh: Ruko Golden City Blok B No. 7"
                       class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat Lengkap & Kota *</label>
                <textarea name="lokasi" required rows="2" placeholder="Contoh: Jl. Kaliurang Km 5 No. 10, Sleman, D.I. Yogyakarta"
                          class="w-full p-3 rounded-2xl border border-[#E8E6DF] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
            </div>

            <!-- FOTO RUKO -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Foto Ruko / Lokasi</label>
                <input type="file" name="foto_ruko" accept="image/*"
                       class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0F433C] file:text-white cursor-pointer">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Perkiraan Sewa / Bulan *</label>
                    <input type="number" name="harga_sewa_per_bulan" required min="100000" step="100000" placeholder="3500000"
                           class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Jumlah Unit *</label>
                    <input type="number" name="total_unit" value="1" required min="1" max="50"
                           class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Kontak Pemilik / Pengelola (HP/WA)</label>
                <input type="text" name="kontak_pemilik" placeholder="081234567890"
                       class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Potensi Pasar & Target Konsumen</label>
                <textarea name="potensi_usaha" rows="2" placeholder="Contoh: Dekat pemukiman padat dan kampus, ramai dilewati kendaraan, cocok untuk cabang gerai baru."
                          class="w-full p-3 rounded-2xl border border-[#E8E6DF] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <button type="button" onclick="closeUsulkanRukoUmkmModal()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-[#0F433C] hover:bg-[#20675D] text-white text-xs font-bold transition shadow-sm">
                    Kirim Usulan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL SEWA RUKO MANDIRI (PELAKU UMKM) -->
<div id="modal-sewa-ruko-mandiri" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-teal-100 text-[#0F433C] flex items-center justify-center text-xl font-black shrink-0">
                    🏢
                </div>
                <div>
                    <h3 class="text-lg font-black text-[#1A202C]">Sewa Ruko Komersial (Mandiri)</h3>
                    <p class="text-xs text-gray-500">Pesan dan sewa tempat usaha langsung untuk operasional usaha Anda</p>
                </div>
            </div>
            <button type="button" onclick="closeSewaRukoMandiriModal()" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition">✕</button>
        </div>

        <!-- Info Unit Ruko Dipilih -->
        <div class="p-4 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] mb-4 text-xs space-y-1.5">
            <div class="flex items-center justify-between">
                <span class="font-black text-[#0F433C] text-sm" id="sewa-mandiri-nama-ruko">Nama Ruko</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800" id="sewa-mandiri-sisa">1 Unit Tersedia</span>
            </div>
            <div class="text-gray-500 text-[11px]" id="sewa-mandiri-lokasi-ruko">📍 Lokasi Ruko</div>
            <div class="pt-1.5 border-t border-gray-200/60 flex justify-between items-center text-[11px] font-bold text-gray-700">
                <span>Tarif Sewa Pokok:</span>
                <span id="sewa-mandiri-tarif" class="text-emerald-700 font-black">Rp 0 / bln</span>
            </div>
        </div>

        <form id="form-sewa-ruko-mandiri" action="" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Durasi Waktu Sewa *</label>
                <select id="sewa-mandiri-durasi-select" name="durasi_bulan" onchange="updateSewaMandiriTotal()" required
                        class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C] bg-white">
                    <option value="1">1 Bulan (Uji Coba)</option>
                    <option value="3">3 Bulan (Jangka Pendek)</option>
                    <option value="6" selected>6 Bulan (Rekomendasi Operasional)</option>
                    <option value="12">12 Bulan (1 Tahun Penuh)</option>
                    <option value="24">24 Bulan (2 Tahun)</option>
                    <option value="36">36 Bulan (3 Tahun)</option>
                </select>
            </div>

            <!-- Estimasi Total Biaya Sewa -->
            <div class="p-4 rounded-2xl bg-teal-50 border border-teal-200 text-xs space-y-1">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-teal-900">Total Biaya Sewa (<span id="sewa-mandiri-durasi-label">6 Bulan</span>):</span>
                    <span id="sewa-mandiri-total-harga" class="text-base font-black text-[#0F433C]">Rp 0</span>
                </div>
                <p class="text-[10px] text-teal-700 mt-0.5">
                    * Pembayaran dan serah terima kunci akan diverifikasi oleh Admin TIKUM bersama pemilik ruko.
                </p>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Rencana Pemanfaatan Gerai / Catatan (Opsional)</label>
                <textarea name="catatan_sewa" rows="2" placeholder="Contoh: Digunakan untuk cabang baru penjualan offline dan tempat etalase produk."
                          class="w-full p-3 rounded-2xl border border-[#E8E6DF] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <button type="button" onclick="closeSewaRukoMandiriModal()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-black transition shadow-sm flex items-center justify-center gap-1.5 active:scale-95">
                    <span>✓ Ajukan Sewa Mandiri</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL BALAS ULASAN INVESTOR MITRA -->
<div id="modal-balas-ulasan" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-teal-100 text-[#0F433C] flex items-center justify-center text-xl font-black shrink-0">
                    💬
                </div>
                <div>
                    <h3 class="text-lg font-black text-[#1A202C]">Tanggapi Ulasan Investor</h3>
                    <p class="text-xs text-gray-500">Ulasan resmi dari mitra terverifikasi</p>
                </div>
            </div>
            <button onclick="closeBalasUlasanModal()" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition">✕</button>
        </div>

        <div class="p-3.5 rounded-2xl bg-[#F8F6F0] border border-[#EDEAE2] mb-4">
            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block mb-1">
                Kutipan Ulasan dari <strong id="balas-modal-investor" class="text-gray-800"></strong>:
            </span>
            <p id="balas-modal-quote" class="text-xs text-gray-700 italic leading-relaxed"></p>
        </div>

        <form id="form-balas-ulasan" action="" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                    Tanggapan / Apresiasi Anda *
                </label>
                <textarea name="balasan_umkm" rows="4" required minlength="3" maxlength="1000"
                          placeholder="Contoh: Terima kasih banyak atas kepercayaan dan dukungan modal Bapak/Ibu. Kami berkomitmen untuk terus menjaga transparansi dan ketepatan bagi hasil usaha..."
                          class="w-full p-3.5 rounded-2xl border border-[#EDEAE2] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
                <span class="text-[10px] text-gray-400 mt-1 block">Tanggapan ini akan tampil secara publik di bawah ulasan investor terkait di katalog proposal.</span>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <button type="button" onclick="closeBalasUlasanModal()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-[#0F433C] hover:bg-[#20675D] text-white text-xs font-bold transition shadow-sm">
                    Kirim Tanggapan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL KLARIFIKASI PENUNDAAN DIVIDEN / LAPORAN KENDALA USAHA -->
<div id="modal-klarifikasi-dividen" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-lg font-black shrink-0">
                    📝
                </div>
                <div>
                    <h3 class="text-lg font-black text-[#1A202C]">Klarifikasi Penundaan Dividen</h3>
                    <p class="text-xs text-gray-500">Laporkan kendala usaha secara transparan ke investor & admin</p>
                </div>
            </div>
            <button type="button" onclick="closeKlarifikasiModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center text-sm font-bold">✕</button>
        </div>

        <div class="p-3.5 rounded-2xl bg-blue-50 border border-blue-200 text-xs text-blue-900 mb-4 space-y-1">
            <p class="font-bold">Kemitraan Investor: <span id="klarifikasi-investor-name" class="font-black text-blue-950"></span></p>
            <p>Periode Kewajiban: <span id="klarifikasi-periode" class="font-bold text-blue-950"></span></p>
            <p class="text-[11px] text-blue-800">Menyampaikan klarifikasi resmi melindungi status kemitraan Anda dari sanksi wanprestasi atau Surat Peringatan (SP).</p>
        </div>

        <form action="{{ route('dashboard.umkm.dividen.klarifikasi') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="id_investasi" id="klarifikasi-id-investasi" value="">
            <input type="hidden" name="bulan_periode" id="klarifikasi-bulan-periode-input" value="">

            <!-- Kategori Kendala -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Faktor / Kategori Kendala *</label>
                <select name="kategori_kendala" required class="w-full px-4 py-2.5 rounded-xl border border-[#E8E6DF] text-xs font-bold focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                    <option value="omzet_menurun">Penjualan / Omzet Menurun Bulan Ini</option>
                    <option value="beban_operasional">Lonjakan Beban Operasional / Bahan Baku</option>
                    <option value="piutang_tertunda">Pelunasan Piutang Konsumen Tertunda</option>
                    <option value="force_majeure">Bencana / Kendala Tak Terduga (Force Majeure)</option>
                    <option value="lainnya">Kendala Operasional Lainnya</option>
                </select>
            </div>

            <!-- Penjelasan Detail -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Uraian Penyebab Keterlambatan *</label>
                <textarea name="alasan" required rows="3" minlength="10"
                          placeholder="Jelaskan secara jujur kondisi keuangan atau kendala operasional usaha pada bulan ini..."
                          class="w-full p-3 rounded-xl border border-[#E8E6DF] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
            </div>

            <!-- Komitmen Solusi / Rencana Pemulihan -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Rencana Solusi & Komitmen Pemulihan *</label>
                <textarea name="komitmen_solusi" required rows="3" minlength="10"
                          placeholder="Contoh: Kami telah menyiapkan promo bundling minggu depan dan menagih piutang jatuh tempo. Estimasi penyetoran dividen tanggal 10 bulan depan..."
                          class="w-full p-3 rounded-xl border border-[#E8E6DF] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
            </div>

            <!-- Lampiran Bukti (Opsional) -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Dokumen / Bukti Pendukung (Opsional)</label>
                <input type="file" name="lampiran_bukti" accept="image/*,.pdf"
                       class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0F433C] file:text-white cursor-pointer">
                <span class="text-[10px] text-gray-400 mt-1 block">Contoh: Laporan mutasi kas, nota beban darurat, dsb. Format PDF/Gambar max 5MB.</span>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeKlarifikasiModal()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-[#0F433C] hover:bg-[#20675D] text-white text-xs font-bold transition shadow-sm">
                    Kirim Klarifikasi Resmi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL SURAT PERINGATAN RESMI (KOP SURAT DAYA UMKM & COMPLIANCE PLATFORM) -->
<div id="modal-surat-peringatan-resmi" class="fixed inset-0 z-50 bg-slate-950/75 backdrop-blur-sm hidden flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-gray-200 animate-scale-up max-h-[92vh] flex flex-col overflow-hidden">
        
        <!-- Header Modal Top Bar -->
        <div class="px-6 py-4 bg-gradient-to-r from-gray-900 via-rose-950 to-gray-900 text-white flex items-center justify-between shrink-0">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center text-sm font-black shadow">⚠️</span>
                <div>
                    <h3 class="text-sm font-black tracking-wide uppercase text-white flex items-center gap-2">
                        Dokumen Resmi Kepatuhan Platform
                        <span id="modal-sp-tingkat-badge" class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white">SP-1</span>
                    </h3>
                    <p class="text-[11px] text-gray-300">Surat Peringatan Pemenuhan Bagi Hasil Dividen Kemitraan</p>
                </div>
            </div>
            <button type="button" onclick="closeSuratPeringatanModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm font-bold transition">✕</button>
        </div>

        <!-- Body Surat Fisik Resmi (Kop Surat & Dokumen Legal) -->
        <div class="p-6 sm:p-8 overflow-y-auto space-y-6 text-xs sm:text-sm text-gray-800 font-serif leading-relaxed bg-[#FFFDF9]">
            
            <!-- KOP SURAT RESMI PLATFORM -->
            <div class="text-center pb-4 border-b-2 border-black font-sans">
                <div class="flex items-center justify-center gap-3 mb-1">
                    <img src="{{ asset('images/TIKUM-Logo.png') }}" alt="TIKUM" class="h-8 w-auto object-contain">
                    <div class="h-6 w-px bg-gray-300"></div>
                    <span class="text-base sm:text-lg font-black tracking-wider text-[#0F433C]">DAYA UMKM INDONESIA</span>
                </div>
                <h4 class="text-xs font-black tracking-wider uppercase text-gray-900 mt-1">
                    DIREKTORAT KEPATUHAN &amp; TATA KELOLA KEMITRAAN INVESTASI
                </h4>
                <p class="text-[10px] text-gray-500 font-medium mt-0.5 font-sans">
                    Gedung Sinergi Finansial Lt. 8, Jl. Kemitraan Strategis Kav. 18, Jakarta Selatan &bull; Layanan: compliance@dayaumkm.id
                </p>
                <div class="w-full h-0.5 bg-black mt-2"></div>
                <div class="w-full h-px bg-black mt-0.5"></div>
            </div>

            <!-- METADATA SURAT -->
            <div class="font-sans text-xs space-y-1 pt-1">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <div><strong>Nomor:</strong> <span id="modal-sp-nomor" class="font-mono font-bold text-gray-900">SP.001/COMP-DU/2026</span></div>
                    <div><strong>Tanggal Terbit:</strong> <span id="modal-sp-tanggal" class="font-bold text-gray-900">-</span></div>
                </div>
                <div><strong>Sifat:</strong> <span class="text-rose-700 font-black uppercase">PENTING &amp; SEGERA (CONFIDENTIAL)</span></div>
                <div><strong>Lampiran:</strong> <span>1 (Satu) Berkas Lembar Rekapitulasi Kewajiban</span></div>
                <div><strong>Perihal:</strong> <span class="font-black text-gray-900 underline">SURAT PERINGATAN (<span id="modal-sp-tingkat">SP-1</span>) ATAS KELALAIAN PEMENUHAN BAGI HASIL DIVIDEN USAHA</span></div>
            </div>

            <!-- TUJUAN SURAT -->
            <div class="font-sans text-xs pt-1">
                <p>Kepada Yth.</p>
                <p class="font-black text-gray-900 text-sm">Pimpinan / Pemilik Usaha: <span class="text-[#0F433C]">{{ $user->name }}</span></p>
                <p class="font-bold text-gray-800">Nama Usaha UMKM: <span>{{ $umkm->nama_usaha }}</span></p>
                <p class="text-gray-600">Mitra Investor Terkait: <strong id="modal-sp-investor" class="text-gray-900">-</strong></p>
                <p class="text-gray-500">Di Tempat</p>
            </div>

            <!-- ISI UTAMA SURAT -->
            <div class="space-y-3 pt-2 text-justify text-xs sm:text-[13px] leading-relaxed">
                <p>
                    Dengan hormat,
                </p>
                <p>
                    Berdasarkan rekapitulasi audit sistem dan pemantauan kepatuhan permodalan kemitraan platform <strong>DAYA UMKM</strong>, bersama surat resmi ini kami memberitahukan bahwa usaha Saudara tercatat <strong>belum menyetorkan bagi hasil dividen berkala</strong> yang telah melewati batas tanggal jatuh tempo (tanggal 25 setiap bulannya) sesuai dengan Akad Perjanjian Kemitraan Investasi yang disepakati bersama Mitra Investor.
                </p>

                <!-- KOTAK TEGURAN RESMI DARI VERIFIKATOR -->
                <div class="p-4 rounded-2xl bg-rose-50/90 border-l-4 border-rose-600 font-sans text-xs text-rose-950 space-y-1.5 shadow-sm">
                    <span class="text-[10px] font-black uppercase tracking-wider text-rose-800 block">
                        Uraian Teguran Resmi Tim Compliance:
                    </span>
                    <p id="modal-sp-isi-pesan" class="italic leading-relaxed font-medium">
                        "Kewajiban bagi hasil dividen belum disetorkan."
                    </p>
                    <div class="pt-1 flex items-center justify-between text-[10px] text-rose-700 border-t border-rose-200/60 mt-2">
                        <span>Penerbit / Verifikator: <strong id="modal-sp-admin">Super Administrator</strong></span>
                        <span>Otoritas: Tim Compliance DAYA UMKM</span>
                    </div>
                </div>

                <p>
                    Sehubungan dengan hal tersebut, Manajemen DAYA UMKM memberikan kesempatan tenggat waktu respons penyelesaian paling lambat hingga:
                </p>

                <div class="p-3 rounded-xl bg-amber-50 border border-amber-300 font-sans text-center">
                    <span class="text-[10px] font-bold text-amber-900 uppercase tracking-wider block">Batas Akhir Penyelesaian / Tindak Lanjut:</span>
                    <span id="modal-sp-tenggat" class="text-base font-black text-rose-700 mt-0.5 block">-</span>
                    <span class="text-[10px] text-amber-800">(Maksimal 3 hari kerja sejak surat ini diterbitkan sistem)</span>
                </div>

                <p>
                    Saudara diwajibkan untuk segera mengambil salah satu langkah penyelesaian resmi di bawah ini:
                </p>
                <ol class="list-decimal pl-5 space-y-1.5 font-sans text-xs">
                    <li>
                        <strong>Menyetorkan Dividen Bagi Hasil:</strong> Melakukan transfer dividen ke rekening mitra investor dan mengunggah bukti transfer yang sah melalui menu kemitraan di dashboard.
                    </li>
                    <li>
                        <strong>Menyampaikan Formulir Klarifikasi Resmi:</strong> Jika usaha sedang mengalami kendala perputaran kas, omzet menurun, atau force majeure, sampaikan dokumen klarifikasi agar mendapatkan restrukturisasi waktu dan perlindungan status akun dari penalti lanjutan.
                    </li>
                </ol>

                <div class="p-3 rounded-xl bg-gray-100 font-sans text-[11px] text-gray-700 space-y-1">
                    <strong class="text-gray-900 block">Pemberitahuan Sanksi Kepatuhan:</strong>
                    Apabila Saudara mengabaikan peringatan ini hingga tenggat waktu berakhir tanpa konfirmasi resmi, sistem akan otomatis meningkatkan status ke <strong>SP-2 / SP-3</strong>, membekukan sementara fasilitas permodalan, serta meninjau ulang status kemitraan sebagai indikasi wanprestasi.
                </div>

                <p>
                    Demikian surat peringatan resmi ini kami sampaikan agar menjadi perhatian penuh dan segera ditindaklanjuti dengan itikad baik.
                </p>
            </div>

            <!-- TANDA TANGAN DIGITAL PLATFORM -->
            <div class="pt-4 border-t border-gray-200 font-sans text-xs flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
                <div>
                    <span class="text-[10px] text-gray-400 block font-mono">Kode Validasi Dokumen:</span>
                    <span class="text-[10px] text-gray-500 font-mono font-bold block">SEC-REG-{{ date('Ymd') }}-COMPLIANCE-VERIFIED</span>
                    <span class="text-[9px] text-gray-400 mt-1 block max-w-xs">Dokumen ini diterbitkan sah secara elektronik oleh Sistem Monitoring Kepatuhan DAYA UMKM dan memiliki kekuatan pembuktian internal platform.</span>
                </div>
                <div class="text-left sm:text-right shrink-0">
                    <p class="text-gray-500 text-[10px]">Jakarta, {{ date('d F Y') }}</p>
                    <p class="font-bold text-gray-900 mt-0.5">Direktorat Kepatuhan DAYA UMKM</p>
                    <div class="my-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-300 text-[10px] font-mono font-bold">
                        <span>✓</span> TERVERIFIKASI SISTEM ELEKTRONIK
                    </div>
                    <p class="text-[11px] font-black text-gray-900">TIM MONITORING &amp; AUDIT KEMITRAAN</p>
                </div>
            </div>

        </div>

        <!-- Tombol Aksi di Bawah Surat -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-wrap items-center justify-between gap-3 shrink-0">
            <button type="button" onclick="closeSuratPeringatanModal()" class="px-4 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-100 transition">
                Tutup Dokumen
            </button>

            <div class="flex flex-wrap items-center gap-2">
                <a id="modal-sp-btn-chat" href="{{ route('dashboard', ['tab' => 'inbox']) }}" class="px-4 py-2.5 rounded-xl bg-gray-900 hover:bg-black text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                    <span>💬 Chat Mitra / Verifikator</span>
                </a>
                <button type="button" id="modal-sp-btn-klarifikasi" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                    <span>📝 Ajukan Klarifikasi Kendala</span>
                </button>
                <button type="button" id="modal-sp-btn-setor" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                    <span>💸 Setor Dividen Sekarang</span>
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    function openKlarifikasiModal(idInvestasi, investorName, bulanPeriode) {
        document.getElementById('klarifikasi-id-investasi').value = idInvestasi;
        document.getElementById('klarifikasi-bulan-periode-input').value = bulanPeriode;
        document.getElementById('klarifikasi-investor-name').innerText = investorName;
        document.getElementById('klarifikasi-periode').innerText = bulanPeriode;
        document.getElementById('modal-klarifikasi-dividen').classList.remove('hidden');
    }

    function closeKlarifikasiModal() {
        document.getElementById('modal-klarifikasi-dividen').classList.add('hidden');
    }

    function openSuratPeringatanModal(tingkatSp, tanggal, tenggat, pesan, adminName, investorName, idInvestasi, bankName, noRek, namaRek, idTeguran, statusSp, catatanPenyelesaian) {
        document.getElementById('modal-sp-tingkat').innerText = tingkatSp || 'SP-1';
        
        const badge = document.getElementById('modal-sp-tingkat-badge');
        if (statusSp === 'selesai') {
            badge.innerText = (tingkatSp || 'SP') + ' (LUNAS / SELESAI)';
            badge.className = 'px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-500 text-white';
        } else {
            badge.innerText = tingkatSp || 'SP-1';
            badge.className = 'px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white';
        }

        document.getElementById('modal-sp-nomor').innerText = 'SP.' + (idTeguran ? String(idTeguran).padStart(3, '0') : '001') + '/COMP-DU/' + new Date().getFullYear();
        document.getElementById('modal-sp-tanggal').innerText = tanggal || '-';
        document.getElementById('modal-sp-tenggat').innerText = tenggat || '-';

        let fullPesan = pesan || 'Berdasarkan data sistem, bagi hasil dividen kemitraan belum disetorkan.';
        if (statusSp === 'selesai' && catatanPenyelesaian) {
            fullPesan += '\n\n[STATUS: RESMI DISELESAIKAN]\n' + catatanPenyelesaian;
        }
        document.getElementById('modal-sp-isi-pesan').innerText = fullPesan;
        document.getElementById('modal-sp-admin').innerText = adminName || 'Super Administrator';
        document.getElementById('modal-sp-investor').innerText = investorName || 'Mitra Investor';
        
        // Atur tombol setor dividen & klarifikasi
        const btnSetor = document.getElementById('modal-sp-btn-setor');
        const btnKlarifikasi = document.getElementById('modal-sp-btn-klarifikasi');

        if (statusSp === 'selesai') {
            if (btnSetor) btnSetor.classList.add('hidden');
            if (btnKlarifikasi) btnKlarifikasi.classList.add('hidden');
        } else {
            if (btnSetor) {
                btnSetor.classList.remove('hidden');
                btnSetor.onclick = function() {
                    closeSuratPeringatanModal();
                    if (typeof openSetorDividenModal === 'function') {
                        openSetorDividenModal(idInvestasi, investorName, bankName, noRek, namaRek);
                    }
                };
            }
            if (btnKlarifikasi) {
                btnKlarifikasi.classList.remove('hidden');
                btnKlarifikasi.onclick = function() {
                    closeSuratPeringatanModal();
                    if (typeof openKlarifikasiModal === 'function') {
                        openKlarifikasiModal(idInvestasi, investorName, 'Bulan Berjalan');
                    }
                };
            }
        }

        // Atur tombol chat
        const btnChat = document.getElementById('modal-sp-btn-chat');
        if (btnChat && idInvestasi) {
            btnChat.href = "{{ route('dashboard') }}?tab=inbox&investasi_id=" + idInvestasi;
        }

        document.getElementById('modal-surat-peringatan-resmi').classList.remove('hidden');
    }

    function closeSuratPeringatanModal() {
        document.getElementById('modal-surat-peringatan-resmi').classList.add('hidden');
    }
</script>
@endsection
