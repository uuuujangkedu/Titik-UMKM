@extends('layouts.auth')

@section('title', 'Usulkan Lokasi Ruko & Tempat Usaha UMKM')

@section('content')
<!-- ========================================================
     1. HERO SECTION USULKAN RUKO
     Background: Sunny Miniature House on Rolling Hills (Blur 20%)
     Wave divider menyatu mulus ke canvas form bawah (#93c6eb)
     ======================================================== -->
<section class="relative w-full overflow-hidden flex items-center justify-center select-none pt-24 sm:pt-28 pb-16 sm:pb-20" data-reveal data-hero aria-label="Hero Usulkan Ruko">
    <!-- Gambar Visual Utama Miniatur Ruko 3D sebagai Background Blur 20% -->
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden select-none">
        <img src="{{ asset('images/Sunny Miniature House on Rolling Hills.png') }}" 
             alt="Visual Miniatur Ruko Daya UMKM" 
             class="w-full h-full object-cover object-bottom filter blur-[20px] scale-[1.08] select-none pointer-events-none">
        
        <!-- Soft Tint Overlay agar kontras teks selalu tajam -->
        <div class="absolute inset-0 bg-white/20 pointer-events-none"></div>

        <!-- Biru Langit Gradient di Area Atas Hero -->
        <div class="absolute inset-x-0 top-0 h-36 bg-gradient-to-b from-[#A8D8F0]/80 via-[#79BEE8]/30 to-transparent pointer-events-none"></div>

        <!-- Wave divider di hero: Hijau rumput cerah (#6FC142) menyatu mulus ke seksi bawah (#93c6eb) -->
        <div class="absolute inset-x-0 -bottom-px pointer-events-none z-10 leading-none">
            <svg class="w-full h-14 sm:h-20 lg:h-24 block" viewBox="0 0 1440 100" fill="none" preserveAspectRatio="none">
                <path d="M0,35 C360,75 540,15 820,48 C1100,80 1260,20 1440,52 L1440,100 L0,100 Z" fill="#6FC142" opacity="0.45" />
                <path d="M0,55 C320,88 580,28 860,62 C1140,95 1300,42 1440,68 L1440,100 L0,100 Z" fill="#93c6eb" />
            </svg>
        </div>
    </div>

    <!-- Konten Hero Usulkan Ruko -->
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-8 relative z-10">
        <div class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-7 sm:p-10 lg:p-12 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)] text-center max-w-4xl mx-auto" data-reveal-group>
            
            <div class="space-y-4">
                <h1 class="text-[#15241C] font-bold text-[32px] sm:text-[42px] lg:text-[48px] leading-[1.14] tracking-[-0.025em]" data-reveal-item>
                    Punya Info Ruko Kosong? <br class="hidden sm:inline">
                    <span class="text-[#2D6B22]">Daftarkan Lokasi Usaha di TIKUM</span>
                </h1>

                <p class="text-[#3E5445] text-[15px] sm:text-[17px] leading-[1.65] max-w-2xl mx-auto font-normal" data-reveal-item>
                    Bantu UMKM binaan menemukan tempat usaha komersial yang strategis. Siapa pun dapat mengusulkan lokasi ruko (pemilik, agen properti, maupun warga sekitar). Usulan yang lolos kurasi berpeluang <strong class="text-[#15241C] font-bold">didanai penuh sewa tahunannya</strong> oleh Mitra Investor ekosistem.
                </p>
            </div>

            <!-- 3 NILAI KEUNTUNGAN MENDAFTARKAN RUKO -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5 mt-8 sm:mt-10 pt-8 border-t border-[#C8BFB0]/50" data-reveal-item>
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-5 border border-[#C8BFB0]/70 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-start gap-3.5 text-left">
                    <div class="w-11 h-11 rounded-xl bg-[#2D6B22]/10 text-[#2D6B22] flex items-center justify-center font-bold text-xl shrink-0">
                        🏢
                    </div>
                    <div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-[#15241C]">Penyewa UMKM Terkurasi</h2>
                        <p class="text-[12px] text-[#3E5445] mt-1 leading-relaxed">Ruko diisi oleh UMKM yang telah diverifikasi profil bisnis & legalitasnya.</p>
                    </div>
                </div>

                <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-5 border border-[#C8BFB0]/70 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-start gap-3.5 text-left">
                    <div class="w-11 h-11 rounded-xl bg-[#2D6B22]/10 text-[#2D6B22] flex items-center justify-center font-bold text-xl shrink-0">
                        💰
                    </div>
                    <div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-[#15241C]">Peluang Sponsor Investor</h2>
                        <p class="text-[12px] text-[#3E5445] mt-1 leading-relaxed">Investor platform siap membayarkan dana sewa ruko bagi UMKM terpilih.</p>
                    </div>
                </div>

                <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-5 border border-[#C8BFB0]/70 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-start gap-3.5 text-left">
                    <div class="w-11 h-11 rounded-xl bg-[#2D6B22]/10 text-[#2D6B22] flex items-center justify-center font-bold text-xl shrink-0">
                        ✓
                    </div>
                    <div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-[#15241C]">Kurasi & Publikasi Gratis</h2>
                        <p class="text-[12px] text-[#3E5445] mt-1 leading-relaxed">Peninjauan kelayakan lokasi dan penayangan di katalog tanpa pungutan biaya.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     2. FORM SECTION USULKAN RUKO
     Background: background-2.jpg (Blur 20%)
     Menyambung mulus dari wave langit (#93c6eb)
     ======================================================== -->
<section class="relative w-full overflow-hidden py-12 sm:py-16 select-none" data-reveal aria-label="Formulir Usulan Ruko">
    <!-- Visual Warung UMKM / Rolling Hills 3D sebagai Canvas Background -->
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden select-none">
        <img src="{{ asset('images/background-2.jpg') }}" 
             alt="Visual Warung UMKM Daya UMKM" 
             class="w-full h-full object-cover object-bottom filter blur-[20px] scale-[1.08] select-none pointer-events-none">
        
        <!-- Soft Tint Overlay -->
        <div class="absolute inset-0 bg-white/25 pointer-events-none"></div>

        <!-- Gradasi Biru Langit (#93c6eb) di Area Atas Menghubungkan Mulus dari Wave Hero -->
        <div class="absolute inset-x-0 top-0 h-36 bg-gradient-to-b from-[#93c6eb] via-[#93c6eb]/30 to-transparent pointer-events-none z-[1]"></div>
    </div>

    <div class="max-w-[1000px] w-full mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- NOTIFIKASI BERHASIL -->
        @if(session('success'))
            <div class="mb-8 p-6 sm:p-7 rounded-3xl bg-white/95 backdrop-blur-md border-2 border-[#2D6B22]/30 text-[#15241C] shadow-[0_12px_36px_rgba(45,107,34,0.12)]" data-reveal-item>
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-2xl bg-[#2D6B22] text-white flex items-center justify-center font-bold text-xl shrink-0 shadow-sm">
                        ✓
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-bold text-[#15241C] leading-snug">Usulan Ruko Berhasil Dikirim!</h2>
                        <p class="text-sm text-[#3E5445] mt-1 font-medium leading-relaxed">
                            {{ session('success') }}
                        </p>
                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <a href="{{ route('home') }}" class="inline-flex items-center justify-center bg-[#2D6B22] hover:bg-[#1E4A1A] text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition">
                                Kembali ke Beranda
                            </a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center border border-[#2D6B22] text-[#2D6B22] hover:bg-[#2D6B22] hover:text-white bg-white text-xs font-bold px-4 py-2.5 rounded-xl transition">
                                    Buka Dashboard Saya
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- KARTU FORMULIR PENGUSULAN RUKO -->
        <div class="bg-white/90 sm:bg-white/92 backdrop-blur-md rounded-3xl p-6 sm:p-10 lg:p-12 border border-[#C8BFB0]/70 shadow-[0_16px_40px_rgba(45,107,34,0.10)] select-text" data-reveal-item>
            <form action="{{ route('ruko.usulkan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf

                <!-- SEKSI 1: IDENTITAS PENGUSUL -->
                <div class="space-y-5">
                    <div class="border-b border-[#C8BFB0]/50 pb-4 flex items-center justify-between flex-wrap gap-2">
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#2D6B22]/10 text-[#2D6B22] border border-[#2D6B22]/20">
                                Langkah 1 dari 3
                            </span>
                            <h2 class="text-lg sm:text-xl font-bold text-[#15241C] mt-2">Identitas Pengusul</h2>
                        </div>
                        @auth
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[#F2F8ED] text-[#2D6B22] border border-[#C8BFB0]/70">
                                Akun Terdaftar: {{ Auth::user()->name }}
                            </span>
                        @endauth
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-[#15241C] uppercase tracking-wider mb-2">
                                Nama Lengkap Pengusul <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama_pengusul" required 
                                   value="{{ old('nama_pengusul', Auth::user()->name ?? '') }}"
                                   placeholder="Contoh: Bpk. Bambang Sutrisno"
                                   class="w-full px-4 py-3 rounded-xl border border-[#C8BFB0]/80 bg-white text-sm text-[#15241C] placeholder:text-gray-400 focus:ring-2 focus:ring-[#2D6B22] focus:border-[#2D6B22] outline-none transition">
                            @error('nama_pengusul')
                                <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#15241C] uppercase tracking-wider mb-2">
                                Nomor WhatsApp / Telepon <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="kontak_pengusul" required 
                                   value="{{ old('kontak_pengusul', Auth::user()->phone_number ?? '') }}"
                                   placeholder="Contoh: 081234567890"
                                   class="w-full px-4 py-3 rounded-xl border border-[#C8BFB0]/80 bg-white text-sm text-[#15241C] placeholder:text-gray-400 focus:ring-2 focus:ring-[#2D6B22] focus:border-[#2D6B22] outline-none transition">
                            <span class="text-[11px] text-[#4b5551] mt-1 block">Nomor ini digunakan tim kurator untuk konfirmasi detail lokasi.</span>
                            @error('kontak_pengusul')
                                <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEKSI 2: DETAIL RUKO & LOKASI -->
                <div class="space-y-5 pt-4 border-t border-[#C8BFB0]/50">
                    <div class="border-b border-[#C8BFB0]/50 pb-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#2D6B22]/10 text-[#2D6B22] border border-[#2D6B22]/20">
                            Langkah 2 dari 3
                        </span>
                        <h2 class="text-lg sm:text-xl font-bold text-[#15241C] mt-2">Spesifikasi & Lokasi Ruko</h2>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#15241C] uppercase tracking-wider mb-2">
                            Nama Ruko / Kompleks Komersial <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_ruko" required 
                               value="{{ old('nama_ruko') }}"
                               placeholder="Contoh: Ruko Boulevard Gading Serpong Blok AA No. 12"
                               class="w-full px-4 py-3 rounded-xl border border-[#C8BFB0]/80 bg-white text-sm text-[#15241C] placeholder:text-gray-400 focus:ring-2 focus:ring-[#2D6B22] focus:border-[#2D6B22] outline-none transition">
                        @error('nama_ruko')
                            <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="lokasi_ruko" class="block text-xs font-bold text-[#15241C] uppercase tracking-wider mb-2">
                            Alamat Lengkap, Kota & Patokan <span class="text-rose-500">*</span>
                        </label>

                        <!-- Opsi Nyalakan Lokasi Ruko: Banner Aksi Jelas & Menonjol -->
                        <div class="mb-3 p-3.5 sm:p-4 rounded-2xl bg-[#F2F8ED] border border-[#2D6B22]/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#2D6B22] text-white flex items-center justify-center shrink-0 shadow-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.071-7.071l-1.414 1.414M8.343 15.657l-1.414 1.414m12.142 0l-1.414-1.414M8.343 8.343L6.929 6.929M12 17a5 5 0 100-10 5 5 0 000 10z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[13px] font-bold text-[#15241C] block">Sedang berada di lokasi ruko?</span>
                                    <span class="text-[11px] text-[#3E5445] block">Nyalakan GPS untuk mengisi nama jalan, kelurahan, dan kota ruko secara otomatis</span>
                                </div>
                            </div>
                            <button type="button" 
                                    id="btn_detect_ruko_location"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2D6B22] hover:bg-[#1E4A1A] text-white text-[12px] font-bold shadow-sm hover:shadow transition shrink-0 cursor-pointer w-full sm:w-auto">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span id="btn_detect_ruko_text">Nyalakan Lokasi</span>
                            </button>
                        </div>
                        <div id="ruko_location_msg" class="hidden text-xs py-2 px-3 rounded-xl mb-3 font-medium"></div>
                        <textarea name="lokasi" id="lokasi_ruko" required rows="3" 
                                  placeholder="Contoh: Jl. Boulevard Raya Barat No. 12, Kelapa Dua, Tangerang, Banten (Dekat Kampus UMN, Seberang SPBU Pertamina)"
                                  class="w-full p-4 rounded-xl border border-[#C8BFB0]/80 bg-white text-sm text-[#15241C] placeholder:text-gray-400 focus:ring-2 focus:ring-[#2D6B22] focus:border-[#2D6B22] outline-none transition">{{ old('lokasi') }}</textarea>
                        @error('lokasi')
                            <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- UPLOAD FOTO RUKO -->
                    <div>
                        <label class="block text-xs font-bold text-[#15241C] uppercase tracking-wider mb-2">
                            Foto Fisik Ruko / Lokasi (Tampak Depan & Jalan)
                        </label>
                        <div class="p-5 sm:p-6 rounded-2xl border-2 border-dashed border-[#C8BFB0] bg-[#F2F8ED]/60 text-center hover:bg-[#F2F8ED] hover:border-[#2D6B22] transition group">
                            <input type="file" name="foto_ruko" id="foto_ruko" accept="image/*" class="w-full text-xs text-[#3E5445] file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#2D6B22] file:text-white hover:file:bg-[#1E4A1A] file:cursor-pointer cursor-pointer">
                            <p class="text-[12px] text-[#4b5551] mt-2">Mendukung format JPG, PNG, atau WebP (Maksimal 5MB). Foto tampak depan jalan sangat membantu kurasi.</p>
                        </div>
                        @error('foto_ruko')
                            <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- SEKSI 3: FINANSIAL & POTENSI USAHA -->
                <div class="space-y-5 pt-4 border-t border-[#C8BFB0]/50">
                    <div class="border-b border-[#C8BFB0]/50 pb-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#2D6B22]/10 text-[#2D6B22] border border-[#2D6B22]/20">
                            Langkah 3 dari 3
                        </span>
                        <h2 class="text-lg sm:text-xl font-bold text-[#15241C] mt-2">Perkiraan Biaya Sewa & Potensi Usaha</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="md:col-span-2">
                            <label for="harga_sewa_per_bulan_display" class="block text-xs font-bold text-[#15241C] uppercase tracking-wider mb-2">
                                Perkiraan Harga Sewa per Bulan (Rp) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   inputmode="numeric" 
                                   id="harga_sewa_per_bulan_display" 
                                   data-format-rupiah="true"
                                   data-target-hidden="harga_sewa_per_bulan"
                                   required
                                   value="{{ old('harga_sewa_per_bulan') ? number_format((float) preg_replace('/\D/', '', old('harga_sewa_per_bulan')), 0, ',', '.') : '' }}"
                                   placeholder="Contoh: 4.500.000"
                                   class="format-rupiah w-full px-4 py-3 rounded-xl border border-[#C8BFB0]/80 bg-white text-sm font-bold text-[#2D6B22] placeholder:text-gray-400 focus:ring-2 focus:ring-[#2D6B22] focus:border-[#2D6B22] outline-none transition"
                                   autocomplete="off">
                            <input type="hidden" 
                                   name="harga_sewa_per_bulan" 
                                   id="harga_sewa_per_bulan" 
                                   value="{{ old('harga_sewa_per_bulan') ? preg_replace('/\D/', '', old('harga_sewa_per_bulan')) : '' }}">
                            <span class="text-[11px] text-[#4b5551] mt-1 block">Jika sewa tahunan, bagi 12 bulan (misal Rp 60 jt/thn = Rp 5.000.000/bln).</span>
                            @error('harga_sewa_per_bulan')
                                <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#15241C] uppercase tracking-wider mb-2">
                                Jumlah Unit / Pintu <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="total_unit" required min="1" max="50"
                                   value="{{ old('total_unit', 1) }}"
                                   placeholder="1"
                                   class="w-full px-4 py-3 rounded-xl border border-[#C8BFB0]/80 bg-white text-sm font-bold text-[#2D6B22] placeholder:text-gray-400 focus:ring-2 focus:ring-[#2D6B22] focus:border-[#2D6B22] outline-none transition">
                            <span class="text-[11px] text-[#4b5551] mt-1 block">Total pintu ruko di lokasi.</span>
                            @error('total_unit')
                                <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#15241C] uppercase tracking-wider mb-2">
                            Kontak Pemilik Ruko / Agen Pemasar
                        </label>
                        <input type="text" name="kontak_pemilik" 
                               value="{{ old('kontak_pemilik') }}"
                               placeholder="Contoh: 081987654321 (Pak Haji Ahmad)"
                               class="w-full px-4 py-3 rounded-xl border border-[#C8BFB0]/80 bg-white text-sm text-[#15241C] placeholder:text-gray-400 focus:ring-2 focus:ring-[#2D6B22] focus:border-[#2D6B22] outline-none transition">
                        <span class="text-[11px] text-[#4b5551] mt-1 block">Boleh dikosongkan jika pengusul adalah pemilik langsung.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#15241C] uppercase tracking-wider mb-2">
                            Potensi Usaha & Mengapa Tempat Ini Cocok untuk UMKM
                        </label>
                        <textarea name="potensi_usaha" rows="3" 
                                  placeholder="Contoh: Kawasan sangat ramai lalu-lintas pekerja dan mahasiswa. Dekat perkantoran, parkiran luas, cocok untuk gerai kuliner, kopi kekinian, laundry, atau apotek."
                                  class="w-full p-4 rounded-xl border border-[#C8BFB0]/80 bg-white text-sm text-[#15241C] placeholder:text-gray-400 focus:ring-2 focus:ring-[#2D6B22] focus:border-[#2D6B22] outline-none transition">{{ old('potensi_usaha') }}</textarea>
                    </div>
                </div>

                <!-- SUBMIT BUTTON -->
                <div class="pt-6 border-t border-[#C8BFB0]/50 flex flex-col sm:flex-row items-center justify-between gap-5">
                    <p class="text-xs text-[#4b5551] max-w-md leading-relaxed">
                        Dengan menekan tombol di samping, Anda mengonfirmasi bahwa data lokasi yang diusulkan adalah akurat untuk ditinjau oleh kurator TIKUM.
                    </p>

                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] px-8 py-4 rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 cursor-pointer gap-2 shrink-0">
                        <span>Kirim Rekomendasi Ruko</span>
                        <svg class="w-4 h-4 text-[#F4B838]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>

            </form>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const displayInput = document.getElementById('harga_sewa_per_bulan_display');
    const hiddenInput = document.getElementById('harga_sewa_per_bulan');

    function formatNumberWithDots(val) {
        if (!val) return '';
        const clean = val.toString().replace(/\D/g, '');
        if (!clean) return '';
        return clean.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    if (displayInput && hiddenInput) {
        displayInput.addEventListener('input', function () {
            const cursorPosition = this.selectionStart;
            const originalVal = this.value;
            const digitsBeforeCursor = originalVal.slice(0, cursorPosition).replace(/\D/g, '').length;
            const rawDigits = originalVal.replace(/\D/g, '');

            hiddenInput.value = rawDigits;
            const formatted = formatNumberWithDots(rawDigits);
            this.value = formatted;

            if (cursorPosition !== null && document.activeElement === this) {
                let newCursorPos = 0;
                let digitCount = 0;
                for (let i = 0; i < formatted.length; i++) {
                    if (/\d/.test(formatted[i])) {
                        digitCount++;
                    }
                    if (digitCount === digitsBeforeCursor) {
                        newCursorPos = i + 1;
                        break;
                    }
                }
                if (digitCount < digitsBeforeCursor) {
                    newCursorPos = formatted.length;
                }
                this.setSelectionRange(newCursorPos, newCursorPos);
            }
        });

        // Format saat load awal jika sudah ada nilai
        if (displayInput.value) {
            const raw = displayInput.value.replace(/\D/g, '');
            hiddenInput.value = raw;
            displayInput.value = formatNumberWithDots(raw);
        }

        // Pastikan nilai hidden terisi saat form submit
        const form = displayInput.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                hiddenInput.value = displayInput.value.replace(/\D/g, '');
            });
        }
    }

    // ==========================================
    // HANDLER NYALAKAN LOKASI ALAMAT RUKO (GPS)
    // ==========================================
    const btnRukoLocation = document.getElementById('btn_detect_ruko_location');
    const btnRukoText = document.getElementById('btn_detect_ruko_text');
    const rukoLocationMsg = document.getElementById('ruko_location_msg');
    const rukoTextarea = document.getElementById('lokasi_ruko');

    function showRukoLocationMsg(text, isError = false) {
        if (!rukoLocationMsg) return;
        rukoLocationMsg.className = 'text-xs py-1.5 px-3 rounded-xl mb-2 font-medium ' +
            (isError 
                ? 'bg-amber-50 text-amber-900 border border-amber-200' 
                : 'bg-[#F2F8ED] text-[#2D6B22] border border-[#C8BFB0]/70');
        rukoLocationMsg.textContent = text;
        rukoLocationMsg.classList.remove('hidden');
    }

    if (btnRukoLocation && rukoTextarea) {
        btnRukoLocation.addEventListener('click', function() {
            if (!navigator.geolocation) {
                showRukoLocationMsg('Peramban web belum mendukung deteksi GPS.', true);
                return;
            }

            const originalBtnHtml = btnRukoText.innerHTML;
            btnRukoText.innerHTML = '<span class="inline-block animate-spin mr-1">↻</span> Mendeteksi...';
            btnRukoLocation.disabled = true;
            btnRukoLocation.classList.add('opacity-75');

            navigator.geolocation.getCurrentPosition(
                async function(pos) {
                    const lat = pos.coords.latitude;
                    const lon = pos.coords.longitude;

                    try {
                        let formattedAddress = '';

                        // 1. Coba OpenStreetMap Nominatim
                        try {
                            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}&addressdetails=1`, {
                                headers: { 'Accept-Language': 'id' }
                            });
                            if (res.ok) {
                                const d = await res.json();
                                if (d && d.display_name) {
                                    formattedAddress = d.display_name;
                                }
                            }
                        } catch (e) {}

                        // 2. Fallback BigDataCloud client API
                        if (!formattedAddress) {
                            const res2 = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=id`);
                            if (res2.ok) {
                                const d2 = await res2.json();
                                formattedAddress = [d2.locality, d2.city, d2.principalSubdivision, d2.countryName].filter(Boolean).join(', ');
                            }
                        }

                        if (formattedAddress) {
                            rukoTextarea.value = formattedAddress;
                            showRukoLocationMsg('✓ Alamat ruko terisi otomatis sesuai GPS perangkat Anda.');
                        } else {
                            showRukoLocationMsg('Nama jalan tidak teridentifikasi untuk titik ini. Silakan tulis secara manual.', true);
                        }
                    } catch (err) {
                        showRukoLocationMsg('Layanan geocoding peta sedang sibuk. Silakan tulis alamat secara manual.', true);
                    } finally {
                        btnRukoText.innerHTML = originalBtnHtml;
                        btnRukoLocation.disabled = false;
                        btnRukoLocation.classList.remove('opacity-75');
                    }
                },
                function(err) {
                    btnRukoText.innerHTML = originalBtnHtml;
                    btnRukoLocation.disabled = false;
                    btnRukoLocation.classList.remove('opacity-75');

                    if (err.code === 1) {
                        showRukoLocationMsg('Izin akses lokasi tidak diizinkan di peramban. Silakan tulis alamat secara manual.', true);
                    } else {
                        showRukoLocationMsg('Titik GPS tidak dapat dibaca. Silakan tulis alamat secara manual.', true);
                    }
                },
                { enableHighAccuracy: true, timeout: 8000, maximumAge: 60000 }
            );
        });
    }
});
</script>
@endsection
