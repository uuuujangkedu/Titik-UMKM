<?php $__env->startSection('title', 'Beranda'); ?>

<?php $__env->startSection('content'); ?>
<!-- ========================================================
     HERO SECTION (Sunny Miniature House on Rolling Hills)
     Tone Warna: Biru langit (#A8D8F0 → #79BEE8), 
     Wave divider di hero: Hijau rumput cerah (#6FC142),
     Tombol utama: Hijau rumput gelap (#2D6B22)
     ======================================================== -->
<section id="beranda" class="relative w-full min-h-[640px] sm:min-h-[720px] lg:h-screen lg:min-h-[700px] overflow-hidden flex items-center justify-center select-none" data-reveal aria-label="Beranda Daya UMKM">
    <!-- Gambar Visual Utama Miniatur Ruko 3D sebagai Background Cover -->
    <div class="absolute inset-0 z-0">
        <img src="<?php echo e(asset('images/Sunny Miniature House on Rolling Hills.png')); ?>" 
             alt="Visual Miniatur Ruko Daya UMKM di Atas Perbukitan Hijau" 
             class="w-full h-full object-cover object-bottom select-none pointer-events-none">
        
        <!-- Biru Langit Gradient (#A8D8F0 → #79BEE8) di Area Atas Hero -->
        <div class="absolute inset-x-0 top-0 h-36 bg-gradient-to-b from-[#A8D8F0]/70 via-[#79BEE8]/25 to-transparent pointer-events-none"></div>

        <!-- Wave divider di hero: Hijau rumput cerah (#6FC142) menyatu mulus ke canvas seksi bawah (#93c6eb) -->
        <div class="absolute inset-x-0 -bottom-px pointer-events-none z-10 leading-none">
            <svg class="w-full h-14 sm:h-20 lg:h-24 block" viewBox="0 0 1440 100" fill="none" preserveAspectRatio="none">
                <!-- Lapisan 1 Wave: Hijau rumput cerah (#6FC142) -->
                <path d="M0,35 C360,75 540,15 820,48 C1100,80 1260,20 1440,52 L1440,100 L0,100 Z" fill="#6FC142" opacity="0.45" />
                <!-- Lapisan 2 Wave: Menutup mulus ke canvas background seksi bawah (#93c6eb) -->
                <path d="M0,55 C320,88 580,28 860,62 C1140,95 1300,42 1440,68 L1440,100 L0,100 Z" fill="#93c6eb" />
            </svg>
        </div>
    </div>

    <!-- Konten Teks & Tombol Aksi Hero (Foto Pertama) - Posisi proporsional & seimbang -->
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-8 relative z-10 pt-20 sm:pt-24 pb-16 sm:pb-20 flex items-center h-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center w-full">
            
            <!-- Kolom Kiri Kosong di Desktop: Memberi ruang bagi Miniatur Ruko 3D agar terlihat utuh tanpa tertutup teks -->
            <div class="hidden lg:block lg:col-span-5 pointer-events-none" aria-hidden="true"></div>

            <!-- Kolom Kanan: Headline, Subtitle, dan CTA Buttons (Dinaikkan sedikit secara proporsional) -->
            <div class="lg:col-span-7 space-y-6 text-left py-4 sm:py-6 -translate-y-2 sm:-translate-y-3 lg:-translate-y-5 bg-white/85 sm:bg-white/75 lg:bg-transparent backdrop-blur-md lg:backdrop-blur-none rounded-3xl p-6 sm:p-9 lg:p-0 border border-[#C8BFB0]/70 lg:border-none shadow-[0_12px_36px_rgba(45,107,34,0.08)] lg:shadow-none" data-reveal-group>
                <h1 class="text-[#15241C] font-bold text-[34px] sm:text-[44px] lg:text-[48px] xl:text-[50px] leading-[1.14] tracking-[-0.025em]" data-reveal-item data-i18n="hero.title">
                    Wadah permodalan produktif dan sewa ruko bagi pelaku usaha
                </h1>

                <p class="text-[#263D30] lg:text-[#3E5445] text-[16px] sm:text-[17px] leading-[1.7] max-w-[540px] font-medium lg:font-normal" data-reveal-item data-i18n="hero.desc">
                    Platform terintegrasi bagi investor untuk menyalurkan modal usaha dan memfasilitasi pelaku UMKM memperoleh sewa ruko strategis secara transparan.
                </p>

                <!-- Tombol Utama: Hijau rumput gelap (#2D6B22, hover #1E4A1A) & Sekunder -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5 sm:gap-4 pt-2" data-reveal-item>
                    <a href="<?php echo e(route('gabung.investor')); ?>" 
                       class="inline-flex items-center justify-center w-full sm:w-auto bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] px-6 py-3.5 rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 text-center" data-i18n="hero.btn_investor">
                        Daftar jadi Investor
                    </a>
                    <a href="<?php echo e(route('gabung.umkm')); ?>" 
                       class="inline-flex items-center justify-center w-full sm:w-auto border-2 border-[#2D6B22] text-[#2D6B22] hover:bg-[#2D6B22] hover:text-white bg-white/90 backdrop-blur-sm font-semibold text-[15px] px-6 py-3.5 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 text-center" data-i18n="hero.btn_umkm">
                        Daftar jadi UMKM
                    </a>
                    <a href="<?php echo e(route('gabung.influencer')); ?>" 
                       class="inline-flex items-center justify-center w-full sm:w-auto border border-[#2D6B22]/30 text-[#15241C] hover:bg-[#2D6B22] hover:text-white bg-white/80 backdrop-blur-sm font-semibold text-[15px] px-5 py-3.5 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 text-center">
                        Mitra Influencer
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     TENTANG KAMI SECTION (Visual Showcase Miniatur Warung UMKM 3D)
     Latar Belakang: background-2.jpg (Tajam, Seimbang seperti Hero)
     Warung UMKM 3D di Kanan, Teks Profil di Kiri
     ======================================================== -->
<section id="tentang-kami" class="relative w-full min-h-[640px] sm:min-h-[720px] lg:h-screen lg:min-h-[700px] overflow-hidden flex items-center justify-center select-none scroll-mt-[70px]" data-reveal aria-label="Tentang Kami Daya UMKM">
    <!-- Gambar Visual Utama Warung UMKM 3D sebagai Background Cover Tajam -->
    <div class="absolute inset-0 z-0">
        <img src="<?php echo e(asset('images/background-2.jpg')); ?>" 
             alt="Visual Miniatur Warung UMKM Daya UMKM di Atas Perbukitan Hijau" 
             class="w-full h-full object-cover object-bottom select-none pointer-events-none">
        
        <!-- Gradasi Biru Langit (#93c6eb) di Area Atas Menghubungkan Mulus dari Wave Hero -->
        <div class="absolute inset-x-0 top-0 h-36 bg-gradient-to-b from-[#93c6eb] via-[#93c6eb]/30 to-transparent pointer-events-none z-[1]"></div>

        <!-- Wave divider di bawah Tentang Kami: Hijau rumput cerah (#6FC142) menyatu mulus ke langit background-5.jpg (#b8defb) -->
        <div class="absolute inset-x-0 -bottom-px pointer-events-none z-10 leading-none">
            <svg class="w-full h-14 sm:h-20 lg:h-24 block" viewBox="0 0 1440 100" fill="none" preserveAspectRatio="none">
                <!-- Lapisan 1 Wave: Hijau rumput cerah (#6FC142) -->
                <path d="M0,35 C360,75 540,15 820,48 C1100,80 1260,20 1440,52 L1440,100 L0,100 Z" fill="#6FC142" opacity="0.45" />
                <!-- Lapisan 2 Wave: Menutup mulus ke langit background-5.jpg (#b8defb) -->
                <path d="M0,55 C320,88 580,28 860,62 C1140,95 1300,42 1440,68 L1440,100 L0,100 Z" fill="#b8defb" />
            </svg>
        </div>
    </div>

    <!-- Konten Teks & Tombol Aksi Tentang Kami - Posisi di Kiri, Memberi Ruang Warung 3D di Kanan -->
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-8 relative z-10 pt-20 sm:pt-24 pb-16 sm:pb-20 flex items-center h-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center w-full">
            
            <!-- Kolom Kiri: Headline, Penjelasan, & CTA Buttons (Disesuaikan proporsional persis Hero) -->
            <div class="lg:col-span-7 space-y-6 text-left py-4 sm:py-6 -translate-y-2 sm:-translate-y-3 lg:-translate-y-5 bg-white/85 sm:bg-white/75 lg:bg-transparent backdrop-blur-md lg:backdrop-blur-none rounded-3xl p-6 sm:p-9 lg:p-0 border border-[#C8BFB0]/70 lg:border-none shadow-[0_12px_36px_rgba(45,107,34,0.08)] lg:shadow-none" data-reveal-group>
                
                <h2 class="text-[#15241C] font-bold text-[34px] sm:text-[44px] lg:text-[48px] xl:text-[50px] leading-[1.14] tracking-[-0.025em]" data-reveal-item data-i18n="about.title">
                    Tentang kami
                </h2>

                <p class="text-[#263D30] lg:text-[#3E5445] text-[16px] sm:text-[17px] leading-[1.7] max-w-[560px] font-medium lg:font-normal" data-reveal-item data-i18n="about.p1">
                    Daya UMKM hadir untuk menjembatani kesenjangan akses permodalan bagi pemilik usaha kecil dan menengah di Indonesia. Melalui sistem verifikasi berlapis dan audit aktivitas yang terpercaya, kami memastikan setiap dana investasi tersalurkan secara optimal dan memberi manfaat timbal balik yang sehat bagi investor maupun pengusaha.
                </p>

                <p class="text-[#263D30] lg:text-[#3E5445] text-[16px] sm:text-[17px] leading-[1.7] max-w-[560px] font-medium lg:font-normal" data-reveal-item data-i18n="about.p2">
                    Keamanan data dan transaksi diprioritaskan lewat mekanisme autentikasi terverifikasi dan pembagian hasil usaha yang tercatat rapi di sistem.
                </p>

                <!-- Tombol Aksi Menuju Tutorial & Dukungan Bantuan -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5 sm:gap-4 pt-2" data-reveal-item>
                    <a href="#tutorial" 
                       class="inline-flex items-center justify-center w-full sm:w-auto bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] px-6 py-3.5 rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 text-center" data-i18n="about.btn_tutorial">
                        Pelajari Alur Kerja
                    </a>
                    <a href="#bantuan" 
                       class="inline-flex items-center justify-center w-full sm:w-auto border-2 border-[#2D6B22] text-[#2D6B22] hover:bg-[#2D6B22] hover:text-white bg-white/90 backdrop-blur-sm font-semibold text-[15px] px-6 py-3.5 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 text-center" data-i18n="about.btn_help">
                        Pusat Bantuan
                    </a>
                </div>
            </div>

            <!-- Kolom Kanan Kosong di Desktop: Memberi ruang bagi Warung UMKM 3D agar terlihat utuh tanpa tertutup teks -->
            <div class="hidden lg:block lg:col-span-5 pointer-events-none" aria-hidden="true"></div>

        </div>
    </div>
</section>

<!-- ========================================================
     KONTEN UTAMA: PANDUAN ALUR KERJA, BANTUAN & KONTAK (1 BACKGROUND UNIFIED)
     Latar Belakang: background-5.jpg (Pemukiman, Ruko 3D & Langit Luas Cerah)
     ======================================================== -->
<div id="konten-utama" class="relative w-full overflow-hidden select-none">

    <!-- Sistem Latar Belakang background-5.jpg (Menyatu dari Tutorial hingga Kontak) -->
    <div class="absolute inset-0 z-0 pointer-events-none select-none">
        <img src="<?php echo e(asset('images/background-5.jpg')); ?>" 
             alt="Visual Pemukiman, Ruko 3D, dan Alur Kerja Daya UMKM" 
             class="w-full h-full object-cover object-bottom select-none pointer-events-none">
        
        <!-- Gradasi Biru Langit (#b8defb) di Area Atas Menghubungkan Mulus dari Wave Tentang Kami -->
        <div class="absolute inset-x-0 top-0 h-36 sm:h-48 bg-gradient-to-b from-[#b8defb] via-[#b8defb]/30 to-transparent pointer-events-none z-[1]"></div>

        <!-- Wave divider di bagian bawah menyatu mulus ke footer hijau pohon gelap (#1E4A1A) -->
        <div class="absolute inset-x-0 -bottom-px leading-none z-10 pointer-events-none">
            <svg class="w-full h-14 sm:h-20 lg:h-24 block" viewBox="0 0 1440 100" fill="none" preserveAspectRatio="none">
                <!-- Lapisan 1 Wave: Hijau rumput cerah (#6FC142) -->
                <path d="M0,35 C360,75 540,15 820,48 C1100,80 1260,20 1440,52 L1440,100 L0,100 Z" fill="#6FC142" opacity="0.45" />
                <!-- Lapisan 2 Wave: Menutup mulus ke footer (#1E4A1A) -->
                <path d="M0,55 C320,88 580,28 860,62 C1140,95 1300,42 1440,68 L1440,100 L0,100 Z" fill="#1E4A1A" />
            </svg>
        </div>
    </div>

    <!-- Konten Utama Terpusat (Tutorial, Bantuan, Kontak) -->
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-8 relative z-10 space-y-16 sm:space-y-24 pt-16 sm:pt-24 pb-28 sm:pb-36">

        <!-- ========================================================
             3. SECTION PANDUAN DAN ALUR KERJA (TUTORIAL)
             ======================================================== -->
        <section id="tutorial" class="scroll-mt-[100px] space-y-8" data-reveal>
            <!-- Header Section -->
            <div class="text-left space-y-2" data-reveal-group>
                <h2 class="text-[28px] sm:text-[34px] font-bold text-[#15241C] leading-tight" data-reveal-item data-i18n="tutorial.title">
                    Panduan dan alur kerja
                </h2>
                <p class="text-[#3E5445] text-[15px] sm:text-[16px] max-w-2xl leading-[1.6]" data-reveal-item data-i18n="tutorial.subtitle">
                    Langkah terstruktur menghubungkan pendanaan investor dan pelaku UMKM di dalam platform.
                </p>
            </div>

            <!-- Grid 3 Kartu Tahap (Clean Frosted White Cards Sesuai Mockup) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-7" data-reveal-group>
                
                <!-- Kartu 1: Tahap 1 -->
                <div class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-[22px] border border-white/95 p-7 sm:p-8 shadow-[0_8px_30px_rgba(45,107,34,0.06)] hover:shadow-[0_16px_36px_rgba(74,154,46,0.12)] hover:-translate-y-1.5 transition-all duration-300 space-y-4" data-reveal-item>
                    <span class="inline-block bg-[#6FC142] text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm" data-i18n="tutorial.step1_badge">
                        Tahap 1
                    </span>
                    <h3 class="font-bold text-[18px] sm:text-[19px] text-[#15241C]" data-i18n="tutorial.step1_title">
                        Pendaftaran akun
                    </h3>
                    <p class="text-[14px] sm:text-[15px] text-[#3E5445] leading-[1.7]" data-i18n="tutorial.step1_desc">
                        Pilih peran sebagai mitra investor atau pelaku UMKM, lalu lengkapi verifikasi email OTP resmi.
                    </p>
                </div>

                <!-- Kartu 2: Tahap 2 -->
                <div class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-[22px] border border-white/95 p-7 sm:p-8 shadow-[0_8px_30px_rgba(45,107,34,0.06)] hover:shadow-[0_16px_36px_rgba(74,154,46,0.12)] hover:-translate-y-1.5 transition-all duration-300 space-y-4" data-reveal-item>
                    <span class="inline-block bg-[#4A9A2E] text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm" data-i18n="tutorial.step2_badge">
                        Tahap 2
                    </span>
                    <h3 class="font-bold text-[18px] sm:text-[19px] text-[#15241C]" data-i18n="tutorial.step2_title">
                        Verifikasi dan penyesuaian
                    </h3>
                    <p class="text-[14px] sm:text-[15px] text-[#3E5445] leading-[1.7]" data-i18n="tutorial.step2_desc">
                        Pelaku usaha mengajukan kebutuhan sewa atau modal, sedangkan investor meninjau katalog peluang terkurasi.
                    </p>
                </div>

                <!-- Kartu 3: Tahap 3 -->
                <div class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-[22px] border border-white/95 p-7 sm:p-8 shadow-[0_8px_30px_rgba(45,107,34,0.06)] hover:shadow-[0_16px_36px_rgba(74,154,46,0.12)] hover:-translate-y-1.5 transition-all duration-300 space-y-4" data-reveal-item>
                    <span class="inline-block bg-[#2D6B22] text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm" data-i18n="tutorial.step3_badge">
                        Tahap 3
                    </span>
                    <h3 class="font-bold text-[18px] sm:text-[19px] text-[#15241C]" data-i18n="tutorial.step3_title">
                        Realisasi dan bagi hasil
                    </h3>
                    <p class="text-[14px] sm:text-[15px] text-[#3E5445] leading-[1.7]" data-i18n="tutorial.step3_desc">
                        Penyaluran modal dilakukan dengan transparansi penuh, dividen bagi hasil dicatat berkala di dashboard.
                    </p>
                </div>

            </div>
        </section>

        <!-- ========================================================
             4. SECTION PUSAT BANTUAN & KONTAK RESMI (Frosted White Cards)
             ======================================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-8 pt-4">
            
            <!-- Kartu Kiri: Pusat Bantuan -->
            <section id="bantuan" class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-[24px] border border-white/95 p-8 sm:p-10 shadow-[0_8px_30px_rgba(45,107,34,0.06)] hover:shadow-[0_16px_40px_rgba(74,154,46,0.1)] transition-all duration-300 relative text-left scroll-mt-[100px]" data-reveal data-reveal-group>
                <!-- Icon Badge Top-Left Inside Card -->
                <div class="w-11 h-11 rounded-xl bg-[#E8F7EC] border border-[#6FC142]/20 flex items-center justify-center mb-5" data-reveal-item>
                    <svg class="w-5 h-5 text-[#2D6B22]" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 10H6v-2h12v2zm0-3H6V7h12v2z"/>
                    </svg>
                </div>

                <h2 class="text-[22px] sm:text-[24px] font-bold text-[#15241C] leading-tight mb-3" data-reveal-item data-i18n="help.title">
                    Pusat bantuan
                </h2>
                
                <p class="text-[#3E5445] text-[14px] sm:text-[15px] leading-[1.7] mb-6" data-reveal-item data-i18n="help.desc">
                    Butuh panduan mengenai tata cara pendaftaran, syarat pengajuan sewa ruko, atau mekanisme bagi hasil? Tim dukungan kami siap melayani Anda.
                </p>

                <!-- Tombol Kirim Pesan: Rounded pill outline Sesuai Mockup -->
                <div data-reveal-item>
                    <a href="mailto:fauza@titik-umkm.di"
                       class="inline-flex items-center justify-center border border-[#2D6B22] text-[#2D6B22] hover:bg-[#2D6B22] hover:text-white font-semibold text-[13px] px-6 py-2.5 rounded-full transition-all duration-200 bg-white/70 shadow-sm" data-i18n="help.btn">
                        Kirim pesan ke tim bantuan
                    </a>
                </div>
            </section>

            <!-- Kartu Kanan: Kontak Resmi -->
            <section id="kontak" class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-[24px] border border-white/95 p-8 sm:p-10 shadow-[0_8px_30px_rgba(45,107,34,0.06)] hover:shadow-[0_16px_40px_rgba(74,154,46,0.1)] transition-all duration-300 relative text-left scroll-mt-[100px]" data-reveal data-reveal-group>
                <!-- Icon Badge Top-Left Inside Card -->
                <div class="w-11 h-11 rounded-xl bg-[#E8F7EC] border border-[#6FC142]/20 flex items-center justify-center mb-5" data-reveal-item>
                    <svg class="w-5 h-5 text-[#2D6B22]" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10h5v-2h-5c-4.34 0-8-3.66-8-8s3.66-8 8-8 8 3.66 8 8v1.43c0 .79-.71 1.57-1.5 1.57s-1.5-.78-1.5-1.57V12c0-2.76-2.24-5-5-5s-5 2.24-5 5 2.24 5 5 5c1.38 0 2.64-.56 3.54-1.47.65.89 1.77 1.47 2.96 1.47 1.97 0 3.5-1.6 3.5-3.57V12c0-5.52-4.48-10-10-10zm0 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"/>
                    </svg>
                </div>

                <h2 class="text-[22px] sm:text-[24px] font-bold text-[#15241C] leading-tight mb-3" data-reveal-item data-i18n="contact.title">
                    Kontak resmi
                </h2>

                <p class="text-[#3E5445] text-[14px] sm:text-[15px] leading-[1.7] mb-5" data-reveal-item data-i18n="contact.desc">
                    Hubungi sekretariat operasional Daya UMKM untuk keperluan kemitraan ruko, konsultasi kelembagaan, dan verifikasi profil usaha.
                </p>

                <div class="text-[14px] text-[#3E5445] space-y-2.5 pt-1" data-reveal-item>
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-full bg-[#E8F7EC] text-[#2D6B22] flex items-center justify-center shrink-0 text-xs font-bold">
                            ✉
                        </span>
                        <span>Email: <a href="mailto:fauza@titik-umkm.di" class="text-[#15241C] font-semibold hover:text-[#2D6B22] transition">fauza@titik-umkm.id</a></span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-full bg-[#E8F7EC] text-[#2D6B22] flex items-center justify-center shrink-0 text-xs font-bold">
                            🕐
                        </span>
                        <span><span data-i18n="contact.hours_label">Jam operasional:</span> <span class="text-[#15241C] font-semibold" data-i18n="contact.hours_val">Senin – Jumat, 08:00 – 17.00 WIB</span></span>
                    </div>
                </div>
            </section>

        </div>

        <!-- ========================================================
             5. SECTION LOKASI KANTOR / SEKRETARIAT (UNIVERSITAS DARMA PERSADA - GOOGLE MAPS)
             ======================================================== -->
        <section id="lokasi" class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-[24px] border border-white/95 p-8 sm:p-10 shadow-[0_8px_30px_rgba(45,107,34,0.06)] hover:shadow-[0_16px_40px_rgba(74,154,46,0.1)] transition-all duration-300 relative text-left mt-8 sm:mt-10 scroll-mt-[100px]" data-reveal data-reveal-group>
            
            <div class="mb-6">
                <!-- Icon Badge -->
                <div class="w-11 h-11 rounded-xl bg-[#E8F7EC] border border-[#6FC142]/20 flex items-center justify-center mb-4" data-reveal-item>
                    <svg class="w-5 h-5 text-[#2D6B22]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>

                <h2 class="text-[22px] sm:text-[24px] font-bold text-[#15241C] leading-tight" data-reveal-item>
                    Lokasi Sekretariat & Pusat Operasional
                </h2>
                
                <!-- Foto 3 menggantikan Foto 2: Nama & Alamat Lengkap Kampus -->
                <div class="text-[#3E5445] text-[14px] sm:text-[15px] mt-2 leading-relaxed" data-reveal-item>
                    <span class="font-bold text-[#15241C] block text-[16px]">Universitas Darma Persada</span>
                    <span>Jl. Radin Inten II No.2, RT.8/RW.6, Duren Sawit, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13440</span>
                </div>
            </div>

            <!-- Google Maps Embed Container (Full Width) -->
            <div class="rounded-2xl overflow-hidden border border-[#C8BFB0]/80 shadow-sm relative min-h-[360px] sm:min-h-[420px] bg-gray-100" data-reveal-item>
                <iframe 
                    src="https://maps.google.com/maps?q=Universitas+Darma+Persada+Jakarta&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                    class="w-full h-full min-h-[360px] sm:min-h-[420px] border-0" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Peta Lokasi Universitas Darma Persada di Google Maps">
                </iframe>
            </div>

        </section>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\laragon\www\tikum_core\tikum_core\resources\views/welcome.blade.php ENDPATH**/ ?>