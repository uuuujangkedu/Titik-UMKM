@extends('layouts.auth')

@section('title', 'Gabung Jadi Investor')

@section('content')
@if(session('info') || session('error'))
    <div role="alert" class="mx-auto mt-24 max-w-[1200px] px-5 sm:px-8">
        <div class="rounded-xl border border-amber-300 bg-amber-50 p-4 text-sm text-amber-950">
            {{ session('info') ?? session('error') }}
        </div>
    </div>
@endif
<!-- ========================================================
     1. HERO SECTION INVESTOR
     Background: Sunny Miniature House on Rolling Hills (Blur 20%)
     Wave divider menyatu mulus ke canvas seksi bawah (#93c6eb)
     ======================================================== -->
<section class="relative w-full overflow-hidden flex items-center justify-center select-none pt-24 sm:pt-28 pb-16 sm:pb-20" data-reveal data-hero aria-label="Hero Gabung Investor">
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

    <!-- Konten Hero Investor -->
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-8 relative z-10">
        <div class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-7 sm:p-10 lg:p-12 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)]" data-reveal-group>
            <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1fr] gap-10 lg:gap-14 items-center">
                
                <div class="space-y-6 text-left">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-[#2D6B22]/10 text-[#2D6B22] border border-[#2D6B22]/20" data-reveal-item>
                        <span class="w-2 h-2 rounded-full bg-[#2D6B22]"></span>
                        <span data-i18n="gabung.badge_investor">Ekosistem Mitra Investor</span>
                    </span>

                    <h1 class="text-[#15241C] font-bold text-[34px] sm:text-[44px] lg:text-[48px] leading-[1.12] tracking-[-0.025em]" data-reveal-item data-i18n="gabung.inv_hero_title">
                        Kemitraan permodalan bagi investor produktif
                    </h1>

                    <p class="text-[#3E5445] text-[16px] sm:text-[18px] leading-[1.6] max-w-[46ch]" data-reveal-item data-i18n="gabung.inv_hero_desc">
                        Salurkan permodalan langsung kepada pelaku UMKM terverifikasi di ekosistem Daya UMKM dengan imbal hasil terukur, berkala, dan transparan.
                    </p>

                    <div class="flex flex-wrap items-center gap-4 pt-2" data-reveal-item>
                        <a href="{{ route('register.investor') }}" 
                           class="inline-flex items-center justify-center bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] px-6 py-3.5 rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200" data-i18n="gabung.inv_btn_register">
                            Daftar sebagai investor
                        </a>
                        <a href="#manfaat-investor" 
                           class="inline-flex items-center justify-center border-2 border-[#2D6B22] text-[#2D6B22] hover:bg-[#2D6B22] hover:text-white bg-white/90 backdrop-blur-sm font-semibold text-[15px] px-6 py-3.5 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-i18n="gabung.inv_btn_learn">
                            Pelajari manfaat
                        </a>
                    </div>
                </div>

                <!-- Panel Profil & Metrik Kemitraan -->
                <div data-reveal-item>
                    <div class="bg-[#F2F8ED] rounded-2xl p-6 sm:p-7 border border-[#C8BFB0]/80 space-y-5 text-center shadow-sm">
                        <div class="space-y-1">
                            <h2 class="text-[18px] font-bold text-[#1E4A1A] leading-snug" data-i18n="gabung.inv_panel_title">
                                Karakteristik portofolio kemitraan
                            </h2>
                            <p class="text-[14px] text-[#3E5445]" data-i18n="gabung.inv_panel_sub">
                                Standar tata kelola investasi di Daya UMKM
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-3.5 w-full text-left">
                            <div class="bg-white rounded-xl p-4 border border-[#C8BFB0]/60 shadow-xs">
                                <span class="text-[12px] text-[#4b5551] block font-medium" data-i18n="gabung.inv_metric1_label">Estimasi bagi hasil</span>
                                <span class="text-[20px] font-extrabold text-[#2D6B22] mt-0.5 block">12% – 18%</span>
                                <span class="text-[11px] text-[#4b5551] mt-0.5 block" data-i18n="gabung.inv_metric1_sub">Per tahun (proyeksian)</span>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-[#C8BFB0]/60 shadow-xs">
                                <span class="text-[12px] text-[#4b5551] block font-medium" data-i18n="gabung.inv_metric2_label">Periode bagi hasil</span>
                                <span class="text-[20px] font-extrabold text-[#15241C] mt-0.5 block" data-i18n="gabung.inv_metric2_val">Bulanan</span>
                                <span class="text-[11px] text-[#4b5551] mt-0.5 block" data-i18n="gabung.inv_metric2_sub">Tercatat di sistem</span>
                            </div>
                        </div>

                        <p class="text-[13px] text-[#3E5445] text-left leading-[1.5] border-t border-[#C8BFB0]/60 pt-3.5" data-i18n="gabung.inv_panel_footer">
                            Setiap transaksi permodalan diaudit oleh admin dan dilengkapi riwayat bukti penyaluran bagi hasil resmi.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- ========================================================
     2. MANFAAT MENJADI INVESTOR
     Background: background-2.jpg (Blur 20%)
     Wave divider menyatu mulus ke seksi bawah (#b8defb)
     ======================================================== -->
<section id="manfaat-investor" class="relative w-full overflow-hidden flex items-center justify-center select-none py-16 sm:py-24 scroll-mt-[70px]" data-reveal aria-label="Manfaat Menjadi Investor">
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

    <!-- Konten Manfaat Investor -->
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-8 relative z-10">
        <div class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-7 sm:p-10 lg:p-12 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)] space-y-8" data-reveal-group>
            <div class="text-left space-y-2" data-reveal-item>
                <h2 class="text-[28px] sm:text-[34px] font-bold text-[#15241C] leading-tight" data-i18n="gabung.inv_advantages_title">
                    Keunggulan kemitraan investor
                </h2>
                <p class="text-[#3E5445] text-[16px] max-w-2xl leading-[1.6]" data-i18n="gabung.inv_advantages_desc">
                    Jembatan investasi inklusif yang mengedepankan keamanan dana dan akuntabilitas operasional.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3.5 text-left shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-reveal-item>
                    <div class="w-12 h-12 rounded-xl bg-[#2D6B22]/10 flex items-center justify-center text-[#2D6B22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.inv_card1_title">UMKM terverifikasi</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.inv_card1_desc">
                        Setiap unit usaha melewati kurasi profil, rekam jejak omzet, dan kejelasan identitas pemilik.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3.5 text-left shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-reveal-item>
                    <div class="w-12 h-12 rounded-xl bg-[#2D6B22]/10 flex items-center justify-center text-[#2D6B22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.inv_card2_title">Bagi hasil berkala</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.inv_card2_desc">
                        Distribusi keuntungan dicatat secara rinci dalam riwayat transaksi dengan bukti transfer resmi.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3.5 text-left shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-reveal-item>
                    <div class="w-12 h-12 rounded-xl bg-[#2D6B22]/10 flex items-center justify-center text-[#2D6B22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.inv_card3_title">Diversifikasi usaha</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.inv_card3_desc">
                        Alokasikan modal ke berbagai bidang usaha seperti kuliner, ritel, dan jasa untuk menjaga profil risiko.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3.5 text-left shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-reveal-item>
                    <div class="w-12 h-12 rounded-xl bg-[#2D6B22]/10 flex items-center justify-center text-[#2D6B22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.inv_card4_title">Keamanan akun</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.inv_card4_desc">
                        Verifikasi login via kode OTP email resmi dan audit trail aktivitas untuk melindungi data kemitraan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================
     3. TAHAPAN INVESTASI & MULAI BERGABUNG (UNIFIED SECTION)
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
        
        <!-- 3. CARA MEMULAI INVESTASI -->
        <section class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-7 sm:p-10 lg:p-12 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)] space-y-8 scroll-mt-[100px]" data-reveal>
            <div class="text-left space-y-2" data-reveal-item>
                <h2 class="text-[28px] sm:text-[34px] font-bold text-[#15241C] leading-tight" data-i18n="gabung.inv_steps_title">
                    Tahapan berinvestasi
                </h2>
                <p class="text-[#3E5445] text-[16px] max-w-2xl leading-[1.6]" data-i18n="gabung.inv_steps_desc">
                    Proses terstruktur mulai dari registrasi hingga penerimaan bagi hasil.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3 text-left shadow-sm" data-reveal-item>
                    <span class="inline-block text-[13px] font-bold text-[#2D6B22] px-2.5 py-1 rounded-md bg-[#2D6B22]/10" data-i18n="gabung.step1_badge">Tahap 1</span>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.inv_step1_title">Daftar akun investor</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.inv_step1_desc">
                        Buka formulir online khusus investor dan verifikasi email Anda lewat kode OTP 6-digit.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3 text-left shadow-sm" data-reveal-item>
                    <span class="inline-block text-[13px] font-bold text-[#2D6B22] px-2.5 py-1 rounded-md bg-[#2D6B22]/10" data-i18n="gabung.step2_badge">Tahap 2</span>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.inv_step2_title">Pilih UMKM potensial</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.inv_step2_desc">
                        Pelajari rincian profil usaha, kebutuhan modal kerja, dan estimasi bagi hasil yang ditawarkan.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3 text-left shadow-sm" data-reveal-item>
                    <span class="inline-block text-[13px] font-bold text-[#2D6B22] px-2.5 py-1 rounded-md bg-[#2D6B22]/10" data-i18n="gabung.step3_badge">Tahap 3</span>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.inv_step3_title">Konfirmasi permodalan</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.inv_step3_desc">
                        Kirim pengajuan investasi Anda. Permodalan akan diverifikasi dan diaudit langsung oleh admin.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3 text-left shadow-sm" data-reveal-item>
                    <span class="inline-block text-[13px] font-bold text-[#2D6B22] px-2.5 py-1 rounded-md bg-[#2D6B22]/10" data-i18n="gabung.step4_badge">Tahap 4</span>
                    <h3 class="font-bold text-[17px] text-[#15241C]" data-i18n="gabung.inv_step4_title">Terima bagi hasil</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]" data-i18n="gabung.inv_step4_desc">
                        Pantau kinerja usaha dari dashboard dan terima pembagian hasil berkala sesuai perjanjian.
                    </p>
                </div>
            </div>
        </section>

        <!-- 4. BOTTOM ACTION CARD -->
        <section class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-8 sm:p-11 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)] space-y-6 text-left scroll-mt-[100px]" data-reveal>
            <div class="space-y-2">
                <h2 class="text-[28px] sm:text-[34px] font-bold text-[#15241C] leading-tight" data-reveal-item data-i18n="gabung.inv_cta_title">
                    Mulai kemitraan investasi Anda sekarang
                </h2>
                <p class="text-[#3E5445] text-[16px] max-w-2xl leading-[1.6]" data-reveal-item data-i18n="gabung.inv_cta_desc">
                    Dukung pertumbuhan pelaku usaha lokal dan nikmati bagi hasil terukur bersama ekosistem terpercaya Daya UMKM.
                </p>
            </div>
            <div data-reveal-item>
                <a href="{{ route('register.investor') }}" 
                   class="inline-flex items-center justify-center bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] px-7 py-3.5 rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200" data-i18n="gabung.inv_btn_register">
                    Daftar sebagai investor
                </a>
            </div>
        </section>

    </div>
</div>
@endsection
