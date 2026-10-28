@extends('layouts.auth')

@section('title', 'Menunggu Persetujuan Admin - Mitra Influencer DAYA UMKM')

@section('content')
<div class="w-full max-w-4xl mx-auto px-4 sm:px-6 py-8 space-y-8">

    <!-- TOP HEADER PROFILE & STATUS -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E5E3DC] shadow-sm">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 pb-6 border-b border-[#E5E3DC]">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-purple-600 to-pink-600 text-white flex items-center justify-center font-extrabold text-2xl shadow-md border-2 border-white shrink-0">
                    {{ strtoupper(substr($profile->nama_panggung ?? $user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-2xl font-black text-[#1B1B18] tracking-tight">{{ $profile->nama_panggung ?? $user->name }}</h1>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-purple-100 text-purple-800 border border-purple-200">
                            Mitra Influencer
                        </span>
                    </div>
                    <p class="text-xs text-[#706F6C] mt-0.5">
                        {{ $user->email }} &bull; {{ $user->phone_number ?? 'Nomor belum diisi' }}
                    </p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 border border-red-200 hover:border-red-400 text-red-600 hover:bg-red-50 text-xs font-bold rounded-xl transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>

        <!-- PROGRESSIVE STEPPER (Sesuai Alur Verifikasi) -->
        <div class="pt-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-extrabold uppercase tracking-wider text-[#075B50]">
                    Tahapan Akses Kemitraan Influencer
                </span>
                <span class="text-xs font-bold text-amber-600 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                    <span>Status: Menunggu Persetujuan (ACC) Admin ⏳</span>
                </span>
            </div>

            <!-- Stepper Indicators -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <!-- Step 1 -->
                <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-xl bg-[#075B50] text-white flex items-center justify-center text-xs font-bold shrink-0">
                        ✓
                    </div>
                    <div>
                        <span class="text-xs font-bold text-[#1B1B18] block">1. Akun & Kontak</span>
                        <span class="text-[10px] text-emerald-700 font-medium">Email & OTP Terverifikasi</span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-xl bg-[#075B50] text-white flex items-center justify-center text-xs font-bold shrink-0">
                        ✓
                    </div>
                    <div>
                        <span class="text-xs font-bold text-[#1B1B18] block">2. Profil & Rate Card</span>
                        <span class="text-[10px] text-emerald-700 font-medium">Formulir Telah Dilengkapi</span>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-300 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xs font-bold shrink-0 animate-pulse">
                        ⏳
                    </div>
                    <div>
                        <span class="text-xs font-bold text-[#1B1B18] block">3. Verifikasi & ACC Admin</span>
                        <span class="text-[10px] text-amber-700 font-bold">Sedang Ditinjau Admin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANNER STATUS MENUNGGU PERSETUJUAN ADMIN -->
    <div class="bg-amber-50 rounded-3xl p-6 sm:p-8 border border-amber-200 shadow-sm space-y-4">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-400 text-amber-950 flex items-center justify-center font-black text-2xl shrink-0 shadow-sm">
                ⏳
            </div>
            <div>
                <h3 class="text-lg sm:text-xl font-black text-amber-950">
                    Akun Mitra Influencer Anda Sedang Menunggu Verifikasi & Persetujuan (ACC) Admin
                </h3>
                <p class="text-xs sm:text-sm text-amber-900/80 mt-1.5 leading-relaxed">
                    Terima kasih telah melengkapi formulir pendaftaran mitra influencer. Demi menjaga kualitas promosi dan transparansi bagi para pelaku UMKM, tim verifikator DAYA UMKM sedang meninjau kelengkapan profil media sosial, portofolio konten, dan rate card Anda.
                </p>
                <p class="text-xs text-amber-800 mt-2 font-semibold">
                    Setelah akun disetujui oleh Administrator, profil Anda akan otomatis tayang di katalog <strong>KOLABORASI INFLUENCER</strong> dan Anda dapat langsung menerima tawaran promosi dari UMKM maupun Investor.
                </p>
            </div>
        </div>

        <div class="pt-4 border-t border-amber-200/60 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
            <span class="text-amber-800 font-medium">Estimasi waktu proses: <strong>1x24 jam kerja</strong></span>
            
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20DAYA%20UMKM,%20saya%20telah%20mendaftar%20sebagai%20Influencer%20dengan%20nama%20{{ urlencode($profile->nama_panggung ?? $user->name) }}%20dan%20sedang%20menunggu%20verifikasi%20akun." 
               target="_blank"
               class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold transition shadow-sm inline-flex items-center gap-1.5 self-start sm:self-auto">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.99.54 2.012.85 2.796.85 3.177 0 5.766-2.587 5.766-5.766 0-3.18-2.586-5.767-5.766-5.767zm7.55 5.766c0 4.164-3.393 7.552-7.55 7.552-1.312 0-2.539-.344-3.61-.951l-4.043 1.059 1.082-3.947c-.707-1.144-1.116-2.483-1.116-3.713 0-4.165 3.39-7.553 7.55-7.553 4.163 0 7.687 3.388 7.687 7.552z"/>
                </svg>
                <span>Konfirmasi Cepat via WhatsApp Admin</span>
            </a>
        </div>
    </div>

    <!-- RINCIAN DATA PENGAJUAN INFLUENCER -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E5E3DC] shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-black text-[#1B1B18]">Ringkasan Profil Mitra Influencer</h2>
            <a href="{{ route('formulir.influencer') }}" class="text-xs font-bold text-[#075B50] hover:underline">
                Ubah Formulir &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
            <div class="p-4 rounded-2xl bg-[#F8F7F2] border border-[#E5E3DC]">
                <span class="text-gray-500 block font-medium">Nama Panggung / Kreator</span>
                <span class="font-bold text-gray-900 text-sm mt-0.5 block">{{ $profile->nama_panggung ?? $user->name }}</span>
            </div>
            <div class="p-4 rounded-2xl bg-[#F8F7F2] border border-[#E5E3DC]">
                <span class="text-gray-500 block font-medium">Kategori Konten</span>
                <span class="font-bold text-purple-700 text-sm mt-0.5 block">{{ $profile->kategori ?? 'Kuliner' }}</span>
            </div>
            <div class="p-4 rounded-2xl bg-[#F8F7F2] border border-[#E5E3DC]">
                <span class="text-gray-500 block font-medium">Domisili / Wilayah</span>
                <span class="font-bold text-gray-900 text-sm mt-0.5 block">{{ $profile->kota ?? ($user->kota ?? '-') }}, {{ $profile->provinsi ?? ($user->provinsi ?? '-') }}</span>
            </div>
            <div class="p-4 rounded-2xl bg-[#F8F7F2] border border-[#E5E3DC]">
                <span class="text-gray-500 block font-medium">Media Sosial</span>
                <span class="font-bold text-gray-900 text-sm mt-0.5 block">
                    IG: {{ $profile->username_instagram ? '@'.$profile->username_instagram : '-' }} &bull; TikTok: {{ $profile->username_tiktok ? '@'.$profile->username_tiktok : '-' }}
                </span>
            </div>
            <div class="p-4 rounded-2xl bg-[#F8F7F2] border border-[#E5E3DC]">
                <span class="text-gray-500 block font-medium">Jumlah Followers</span>
                <span class="font-bold text-gray-900 text-sm mt-0.5 block">{{ number_format($profile->followers_count ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="p-4 rounded-2xl bg-[#F8F7F2] border border-[#E5E3DC]">
                <span class="text-gray-500 block font-medium">Rate Story / Reels / Visit</span>
                <span class="font-bold text-emerald-700 text-sm mt-0.5 block">
                    Rp {{ number_format($profile->rate_story ?? 0, 0, ',', '.') }} / Rp {{ number_format($profile->rate_reels_tiktok ?? 0, 0, ',', '.') }} / Rp {{ number_format($profile->rate_visit_store ?? 0, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

</div>
@endsection
