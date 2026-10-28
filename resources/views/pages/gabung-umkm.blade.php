@extends('layouts.auth')

@section('title', 'Gabung Jadi Pelaku UMKM')

@section('content')
<!-- ========================================================
     1. HERO SECTION UMKM
     Background: Sunny Miniature House on Rolling Hills (Blur 20%)
     Wave divider menyatu mulus ke canvas seksi bawah (#93c6eb)
     ======================================================== -->
<section class="relative w-full overflow-hidden flex items-center justify-center select-none pt-24 sm:pt-28 pb-16 sm:pb-20" data-reveal data-hero aria-label="Hero Gabung UMKM">
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

    <!-- Konten Hero UMKM -->
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-8 relative z-10">
        <div class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-7 sm:p-10 lg:p-12 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)]" data-reveal-group>
            <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1fr] gap-10 lg:gap-14 items-center">
                
                <div class="space-y-6 text-left">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-[#2D6B22]/10 text-[#2D6B22] border border-[#2D6B22]/20" data-reveal-item>
                        <span class="w-2 h-2 rounded-full bg-[#2D6B22]"></span>
                        <span data-i18n="gabung.badge_umkm">Ekosistem Pelaku UMKM</span>
                    </span>

                    <h1 class="text-[#15241C] font-bold text-[34px] sm:text-[44px] lg:text-[48px] leading-[1.12] tracking-[-0.025em]" data-reveal-item data-i18n="gabung.umkm_hero_title">
                        Solusi modal dan sewa ruko bagi pelaku usaha
                    </h1>

                    <p class="text-[#3E5445] text-[16px] sm:text-[18px] leading-[1.6] max-w-[46ch]" data-reveal-item data-i18n="gabung.umkm_hero_desc">
                        Kembangkan bisnis Anda dengan kemudahan akses permodalan produktif dan direktori sewa ruko strategis tanpa beban agunan memberatkan.
                    </p>

                    <div class="flex flex-wrap items-center gap-4 pt-2" data-reveal-item>
                        <a href="{{ route('register.umkm') }}" 
                           class="inline-flex items-center justify-center bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] px-6 py-3.5 rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200" data-i18n="gabung.umkm_btn_register">
                            Daftar sebagai pelaku UMKM
                        </a>
                        <a href="#manfaat-umkm" 
                           class="inline-flex items-center justify-center border-2 border-[#2D6B22] text-[#2D6B22] hover:bg-[#2D6B22] hover:text-white bg-white/90 backdrop-blur-sm font-semibold text-[15px] px-6 py-3.5 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-i18n="gabung.umkm_btn_learn">
                            Pelajari fasilitas
                        </a>
                    </div>
                </div>

                <!-- Panel Profil & Fasilitas Bisnis -->
                <div data-reveal-item>
                    <div class="bg-[#F2F8ED] rounded-2xl p-6 sm:p-7 border border-[#C8BFB0]/80 space-y-5 text-center shadow-sm">
                        <div class="space-y-1">
                            <h2 class="text-[18px] font-bold text-[#1E4A1A] leading-snug" data-i18n="gabung.umkm_panel_title">
                                Fasilitas ekosistem usaha
                            </h2>
                            <p class="text-[14px] text-[#3E5445]" data-i18n="gabung.umkm_panel_sub">
                                Dukungan menyeluruh bagi pelaku UMKM
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-3.5 w-full text-left">
                            <div class="bg-white rounded-xl p-4 border border-[#C8BFB0]/60 shadow-xs">
                                <span class="text-[12px] text-[#4b5551] block font-medium" data-i18n="gabung.umkm_metric1_label">Kebutuhan modal</span>
                                <span class="text-[20px] font-extrabold text-[#2D6B22] mt-0.5 block" data-i18n="gabung.umkm_metric1_val">Fleksibel</span>
                                <span class="text-[11px] text-[#4b5551] mt-0.5 block" data-i18n="gabung.umkm_metric1_sub">Sesuai kapasitas usaha</span>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-[#C8BFB0]/60 shadow-xs">
                                <span class="text-[12px] text-[#4b5551] block font-medium" data-i18n="gabung.umkm_metric2_label">Ketersediaan ruko</span>
                                <span class="text-[20px] font-extrabold text-[#15241C] mt-0.5 block" data-i18n="gabung.umkm_metric2_val">Strategis</span>
                                <span class="text-[11px] text-[#4b5551] mt-0.5 block" data-i18n="gabung.umkm_metric2_sub">Pusat keramaian</span>
                            </div>
                        </div>

                        <p class="text-[13px] text-[#3E5445] text-left leading-[1.5] border-t border-[#C8BFB0]/60 pt-3.5" data-i18n="gabung.umkm_panel_footer">
                            Tumbuh bersama jejaring investor terpercaya dan fasilitas sewa komersial dengan tata kelola jelas.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- ========================================================
     2. KEUNGGULAN BERGABUNG SEBAGAI UMKM
     Background: background-2.jpg (Blur 20%)
     Wave divider menyatu mulus ke seksi bawah (#b8defb)
     ======================================================== -->
<section id="manfaat-umkm" class="relative w-full overflow-hidden flex items-center justify-center select-none py-16 sm:py-24 scroll-mt-[70px]" data-reveal aria-label="Keunggulan Bergabung UMKM">
    <!-- Gambar Visual Warung UMKM 3D sebagai Background Blur 20% -->
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden select-none">
        <img src="{{ asset('images/background-2.jpg') }}" 
             alt="Visual Warung UMKM Daya UMKM" 
             class="w-full h-full object-cover object-bottom filter blur-[20px] scale-[1.08] select-none pointer-events-none">
        
        <!-- Soft Tint Overlay -->
        <div class="absolute inset-0 bg-white/20 pointer-events-none"></div>

        <!-- Gradasi Biru Langit (#93c6eb) di Area Atas Menghubungkan Mulus dari Wave Hero -->
        <div class="absolute inset-x-0 top-0 h-36 bg-gradient-to-b from-[#93c6eb] via-[#93c6eb]/30 to-transparent pointer-events-none z-[1]"></div>

        <!-- Wave divider di bawah Tentang Kami menyatu ke langit seksi 3 (#b8defb) -->
        <div class="absolute inset-x-0 -bottom-px pointer-events-none z-10 leading-none">
            <svg class="w-full h-14 sm:h-20 lg:h-24 block" viewBox="0 0 1440 100" fill="none" preserveAspectRatio="none">
                <path d="M0,35 C360,75 540,15 820,48 C1100,80 1260,20 1440,52 L1440,100 L0,100 Z" fill="#6FC142" opacity="0.45" />
                <path d="M0,55 C320,88 580,28 860,62 C1140,95 1300,42 1440,68 L1440,100 L0,100 Z" fill="#b8defb" />
            </svg>
        </div>
    </div>

    <!-- Konten Keunggulan UMKM -->
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-8 relative z-10">
        <div class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-7 sm:p-10 lg:p-12 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)] space-y-8" data-reveal-group>
            <div class="text-left space-y-2" data-reveal-item>
                <h2 class="text-[28px] sm:text-[34px] font-bold text-[#15241C] leading-tight" data-i18n="gabung.umkm_advantages_title">
                    Keunggulan bergabung di Daya UMKM
                </h2>
                <p class="text-[#3E5445] text-[16px] max-w-2xl leading-[1.6]" data-i18n="gabung.umkm_advantages_desc">
                    Dukungan fasilitas menyeluruh dari permodalan usaha hingga kemudahan sewa tempat berdagang.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3.5 text-left shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-reveal-item>
                    <div class="w-12 h-12 rounded-xl bg-[#2D6B22]/10 flex items-center justify-center text-[#2D6B22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.umkm_card1_title">Akses modal produktif</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.umkm_card1_desc">
                        Pendanaan dari investor terverifikasi dengan mekanisme bagi hasil murni yang ramah bagi arus kas usaha.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3.5 text-left shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-reveal-item>
                    <div class="w-12 h-12 rounded-xl bg-[#2D6B22]/10 flex items-center justify-center text-[#2D6B22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.umkm_card2_title">Sewa ruko strategis</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.umkm_card2_desc">
                        Akses direktori ruko komersial dari penyedia terpercaya dengan spesifikasi lengkap dan harga transparan.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3.5 text-left shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-reveal-item>
                    <div class="w-12 h-12 rounded-xl bg-[#2D6B22]/10 flex items-center justify-center text-[#2D6B22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.umkm_card3_title">Pencatatan transparan</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.umkm_card3_desc">
                        Semua transaksi sewa ruko dan penyaluran bagi hasil tercatat rapi di sistem untuk reputasi usaha Anda.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3.5 text-left shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-reveal-item>
                    <div class="w-12 h-12 rounded-xl bg-[#2D6B22]/10 flex items-center justify-center text-[#2D6B22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.umkm_card4_title">Peluang naik kelas</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.umkm_card4_desc">
                        Dukungan ekspansi lokasi gerai dan kapasitas produksi membantu UMKM bertumbuh secara berkelanjutan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================
     3. TAHAPAN PENDAFTARAN & MULAI BERGABUNG (UNIFIED SECTION)
     Background: background-5.jpg (Blur 20%)
     Menyatu mulus ke footer hijau (#1E4A1A)
     ======================================================== -->
<div class="relative w-full overflow-hidden select-none py-16 sm:py-24">
    <!-- Gambar Visual Pemukiman 3D sebagai Background Blur 20% -->
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden select-none">
        <img src="{{ asset('images/background-5.jpg') }}" 
             alt="Visual Alur Daya UMKM" 
             class="w-full h-full object-cover object-center filter blur-[20px] scale-[1.08] select-none pointer-events-none">
        
        <!-- Soft Tint Overlay -->
        <div class="absolute inset-0 bg-white/20 pointer-events-none"></div>

        <!-- Gradasi Biru Langit (#b8defb) di Area Paling Atas Menyambung dari Wave Keunggulan -->
        <div class="absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-[#b8defb] via-[#b8defb]/40 to-transparent"></div>
        
        <!-- Lapisan Soft Ambient Glow Hijau di Dasar Konten Menuju Footer -->
        <div class="absolute inset-x-0 bottom-0 h-64 bg-gradient-to-t from-[#1E4A1A]/85 via-[#2D6B22]/30 to-transparent"></div>
    </div>

    <!-- Konten Tahapan & Bottom Action Card -->
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-8 relative z-10 space-y-12">
        
        <!-- 3. CARA MEMULAI PERJALANAN USAHA -->
        <section class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-7 sm:p-10 lg:p-12 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)] space-y-8 scroll-mt-[100px]" data-reveal>
            <div class="text-left space-y-2" data-reveal-item>
                <h2 class="text-[28px] sm:text-[34px] font-bold text-[#15241C] leading-tight" data-i18n="gabung.umkm_steps_title">
                    Tahapan pendaftaran usaha
                </h2>
                <p class="text-[#3E5445] text-[16px] max-w-2xl leading-[1.6]" data-i18n="gabung.umkm_steps_desc">
                    Langkah teratur dari registrasi hingga operasional gerai usaha Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3 text-left shadow-sm" data-reveal-item>
                    <span class="inline-block text-[13px] font-bold text-[#2D6B22] px-2.5 py-1 rounded-md bg-[#2D6B22]/10" data-i18n="gabung.step1_badge">Tahap 1</span>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.umkm_step1_title">Daftar akun UMKM</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.umkm_step1_desc">
                        Isi formulir pendaftaran akun usaha dan lakukan verifikasi alamat email lewat kode OTP resmi.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3 text-left shadow-sm" data-reveal-item>
                    <span class="inline-block text-[13px] font-bold text-[#2D6B22] px-2.5 py-1 rounded-md bg-[#2D6B22]/10" data-i18n="gabung.step2_badge">Tahap 2</span>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.umkm_step2_title">Lengkapi profil usaha</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.umkm_step2_desc">
                        Masukkan nama usaha, bidang industri, kontak aktif, dan deskripsi kebutuhan pengembangan.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3 text-left shadow-sm" data-reveal-item>
                    <span class="inline-block text-[13px] font-bold text-[#2D6B22] px-2.5 py-1 rounded-md bg-[#2D6B22]/10" data-i18n="gabung.step3_badge">Tahap 3</span>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.umkm_step3_title">Pilih ruko atau modal</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.umkm_step3_desc">
                        Pilih lokasi ruko yang tersedia atau ajukan kebutuhan modal kerja agar dapat ditinjau investor.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3 text-left shadow-sm" data-reveal-item>
                    <span class="inline-block text-[13px] font-bold text-[#2D6B22] px-2.5 py-1 rounded-md bg-[#2D6B22]/10" data-i18n="gabung.step4_badge">Tahap 4</span>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.umkm_step4_title">Operasional & tumbuh</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.umkm_step4_desc">
                        Jalankan operasional usaha, catat perkembangan omzet, dan bangun hubungan kemitraan yang sehat.
                    </p>
                </div>
            </div>
        </section>

        <!-- 4. BOTTOM ACTION CARD -->
        <section class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-8 sm:p-11 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)] space-y-6 text-left scroll-mt-[100px]" data-reveal>
            <div class="space-y-2">
                <h2 class="text-[28px] sm:text-[34px] font-bold text-[#15241C] leading-tight" data-reveal-item data-i18n="gabung.umkm_cta_title">
                    Saatnya membawa usaha Anda ke tingkat selanjutnya
                </h2>
                <p class="text-[#3E5445] text-[16px] max-w-2xl leading-[1.6]" data-reveal-item data-i18n="gabung.umkm_cta_desc">
                    Daftarkan unit usaha Anda sekarang untuk mendapatkan akses modal terukur dan pilihan ruko komersial terbaik.
                </p>
            </div>
            <div data-reveal-item>
                <a href="{{ route('register.umkm') }}" 
                   class="inline-flex items-center justify-center bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] px-7 py-3.5 rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200" data-i18n="gabung.umkm_btn_register">
                    Daftar sebagai pelaku UMKM
                </a>
            </div>
        </section>

    </div>
</div>
@endsection
