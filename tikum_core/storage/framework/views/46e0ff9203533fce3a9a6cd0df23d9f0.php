<?php $__env->startSection('title', 'Gabung Jadi Mitra Influencer - DAYA UMKM'); ?>

<?php $__env->startSection('content'); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('info') || session('error')): ?>
    <div role="alert" class="mx-auto mt-24 max-w-[1200px] px-5 sm:px-8">
        <div class="rounded-xl border border-amber-300 bg-amber-50 p-4 text-sm text-amber-950">
            <?php echo e(session('info') ?? session('error')); ?>

        </div>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<!-- ========================================================
     1. HERO SECTION INFLUENCER
     Background: Sunny Miniature House on Rolling Hills (Blur 20%)
     Wave divider menyatu mulus ke canvas seksi bawah (#93c6eb)
     ======================================================== -->
<section class="relative w-full overflow-hidden flex items-center justify-center select-none pt-24 sm:pt-28 pb-16 sm:pb-20" data-reveal data-hero aria-label="Hero Gabung Influencer">
    <!-- Gambar Visual Utama Miniatur Ruko 3D sebagai Background Blur 20% -->
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden select-none">
        <img src="<?php echo e(asset('images/Sunny Miniature House on Rolling Hills.png')); ?>" 
             alt="Visual Miniatur Daya UMKM" 
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

    <!-- Konten Hero Influencer -->
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-8 relative z-10">
        <div class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-7 sm:p-10 lg:p-12 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)]" data-reveal-group>
            <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1fr] gap-10 lg:gap-14 items-center">
                
                <div class="space-y-6 text-left">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-[#2D6B22]/10 text-[#2D6B22] border border-[#2D6B22]/20" data-reveal-item>
                        <span class="w-2 h-2 rounded-full bg-[#2D6B22]"></span>
                        <span>Ekosistem Mitra Influencer & Kreator</span>
                    </span>

                    <h1 class="text-[#15241C] font-bold text-[34px] sm:text-[44px] lg:text-[48px] leading-[1.12] tracking-[-0.025em]" data-reveal-item>
                        Kemitraan promosi bagi kreator & influencer lokal
                    </h1>

                    <p class="text-[#3E5445] text-[16px] sm:text-[18px] leading-[1.6] max-w-[46ch]" data-reveal-item>
                        Monetisasi audiens dan jangkauan media sosial Anda dengan membantu mempromosikan produk UMKM lokal terkurasi melalui sistem kontrak resmi dan pembayaran aman.
                    </p>

                    <div class="flex flex-wrap items-center gap-4 pt-2" data-reveal-item>
                        <a href="<?php echo e(route('register.influencer')); ?>" 
                           class="inline-flex items-center justify-center bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] px-6 py-3.5 rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                            Daftar sebagai mitra influencer
                        </a>
                        <a href="#manfaat-influencer" 
                           class="inline-flex items-center justify-center border-2 border-[#2D6B22] text-[#2D6B22] hover:bg-[#2D6B22] hover:text-white bg-white/90 backdrop-blur-sm font-semibold text-[15px] px-6 py-3.5 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                            Pelajari manfaat
                        </a>
                    </div>
                </div>

                <!-- Panel Profil & Karakteristik Kemitraan -->
                <div data-reveal-item>
                    <div class="bg-[#F2F8ED] rounded-2xl p-6 sm:p-7 border border-[#C8BFB0]/80 space-y-5 text-center shadow-sm">
                        <div class="space-y-1">
                            <h2 class="text-[18px] font-bold text-[#1E4A1A] leading-snug">
                                Karakteristik kemitraan kreator
                            </h2>
                            <p class="text-[14px] text-[#3E5445]">
                                Standar kolaborasi promosi di Daya UMKM
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-3.5 w-full text-left">
                            <div class="bg-white rounded-xl p-4 border border-[#C8BFB0]/60 shadow-xs">
                                <span class="text-[12px] text-[#4b5551] block font-medium">Estimasi honor promosi</span>
                                <span class="text-[18px] sm:text-[20px] font-extrabold text-[#2D6B22] mt-0.5 block">Rp 150rb – 5jt+</span>
                                <span class="text-[11px] text-[#4b5551] mt-0.5 block">Per paket kampanye</span>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-[#C8BFB0]/60 shadow-xs">
                                <span class="text-[12px] text-[#4b5551] block font-medium">Sistem pembayaran</span>
                                <span class="text-[18px] sm:text-[20px] font-extrabold text-[#15241C] mt-0.5 block">Escrow 100%</span>
                                <span class="text-[11px] text-[#4b5551] mt-0.5 block">Aman & cair tepat waktu</span>
                            </div>
                        </div>

                        <p class="text-[13px] text-[#3E5445] text-left leading-[1.5] border-t border-[#C8BFB0]/60 pt-3.5">
                            Setiap kolaborasi dilengkapi kesepakatan transparan, jaminan dana aman di sistem, serta proteksi hak karya kreator.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- ========================================================
     2. MANFAAT MENJADI MITRA INFLUENCER
     Background: background-2.jpg (Blur 20%)
     Wave divider menyatu mulus ke seksi bawah (#b8defb)
     ======================================================== -->
<section id="manfaat-influencer" class="relative w-full overflow-hidden flex items-center justify-center select-none py-16 sm:py-24 scroll-mt-[70px]" data-reveal aria-label="Manfaat Menjadi Influencer">
    <!-- Gambar Visual Warung UMKM 3D sebagai Background Blur 20% -->
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden select-none">
        <img src="<?php echo e(asset('images/background-2.jpg')); ?>" 
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

    <!-- Konten Manfaat Influencer -->
    <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-8 relative z-10">
        <div class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-7 sm:p-10 lg:p-12 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)] space-y-8" data-reveal-group>
            <div class="text-left space-y-2" data-reveal-item>
                <h2 class="text-[28px] sm:text-[34px] font-bold text-[#15241C] leading-tight">
                    Keunggulan kemitraan kreator
                </h2>
                <p class="text-[#3E5445] text-[16px] max-w-2xl leading-[1.6]">
                    Jembatan kolaborasi profesional yang mempermudah kreator mendapatkan tawaran endorse dari UMKM dan sponsor investor.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3.5 text-left shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-reveal-item>
                    <div class="w-12 h-12 rounded-xl bg-[#2D6B22]/10 flex items-center justify-center text-[#2D6B22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-[17px] text-[#15241C]">Katalog terbuka</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]">
                        Profil dan tautan portofolio Anda langsung dapat dilihat oleh ribuan pelaku UMKM dan investor pendukung.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3.5 text-left shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-reveal-item>
                    <div class="w-12 h-12 rounded-xl bg-[#2D6B22]/10 flex items-center justify-center text-[#2D6B22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-[17px] text-[#15241C]">Tarif fleksibel & mandiri</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]">
                        Tentukan rate card Anda sendiri untuk Instagram Story, Reels, TikTok, atau Visit Store tanpa potongan tersembunyi.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3.5 text-left shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-reveal-item>
                    <div class="w-12 h-12 rounded-xl bg-[#2D6B22]/10 flex items-center justify-center text-[#2D6B22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-[17px] text-[#15241C]">Jaminan pembayaran aman</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]">
                        Honor Anda dijamin aman di rekening perantara sistem sebelum Anda mulai membuat konten.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3.5 text-left shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-reveal-item>
                    <div class="w-12 h-12 rounded-xl bg-[#2D6B22]/10 flex items-center justify-center text-[#2D6B22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-[17px] text-[#15241C]">Verifikasi akun resmi</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]">
                        Keamanan autentikasi login via kode OTP email serta manajemen kolaborasi terpusat di dashboard kreator.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================
     3. TAHAPAN MENJADI MITRA & MULAI BERGABUNG (UNIFIED SECTION)
     Background: background-5.jpg (Blur 20%)
     Menyatu mulus ke footer hijau (#1E4A1A)
     ======================================================== -->
<div class="relative w-full overflow-hidden select-none py-16 sm:py-24">
    <!-- Gambar Visual Pemukiman 3D sebagai Background Blur 20% -->
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden select-none">
        <img src="<?php echo e(asset('images/background-5.jpg')); ?>" 
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
        
        <!-- 3. TAHAPAN BERKEMITRAAN -->
        <section class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-7 sm:p-10 lg:p-12 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)] space-y-8 scroll-mt-[100px]" data-reveal>
            <div class="text-left space-y-2" data-reveal-item>
                <h2 class="text-[28px] sm:text-[34px] font-bold text-[#15241C] leading-tight">
                    Tahapan menjadi mitra influencer
                </h2>
                <p class="text-[#3E5445] text-[16px] max-w-2xl leading-[1.6]">
                    Proses terstruktur mulai dari registrasi cepat, pengisian rate card, hingga pencairan honor.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3 text-left shadow-sm" data-reveal-item>
                    <span class="inline-block text-[13px] font-bold text-[#2D6B22] px-2.5 py-1 rounded-md bg-[#2D6B22]/10">Tahap 1</span>
                    <h3 class="font-bold text-[17px] text-[#15241C]">Daftar akun cepat</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]">
                        Buka formulir online khusus influencer dan verifikasi email Anda lewat kode OTP 6-digit dalam 30 detik.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3 text-left shadow-sm" data-reveal-item>
                    <span class="inline-block text-[13px] font-bold text-[#2D6B22] px-2.5 py-1 rounded-md bg-[#2D6B22]/10">Tahap 2</span>
                    <h3 class="font-bold text-[17px] text-[#15241C]">Lengkapi profil & tarif</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]">
                        Masukkan tautan akun media sosial, jumlah followers, niche konten, dan tarif promosi sesuai preferensi Anda.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3 text-left shadow-sm" data-reveal-item>
                    <span class="inline-block text-[13px] font-bold text-[#2D6B22] px-2.5 py-1 rounded-md bg-[#2D6B22]/10">Tahap 3</span>
                    <h3 class="font-bold text-[17px] text-[#15241C]">Terima pesanan endorse</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]">
                        Pelaku UMKM dan investor binaan dapat langsung memilih Anda dari katalog untuk mempromosikan produk mereka.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white/90 border border-[#C8BFB0]/70 space-y-3 text-left shadow-sm" data-reveal-item>
                    <span class="inline-block text-[13px] font-bold text-[#2D6B22] px-2.5 py-1 rounded-md bg-[#2D6B22]/10">Tahap 4</span>
                    <h3 class="font-bold text-[17px] text-[#15241C]">Karya tayang & cairkan fee</h3>
                    <p class="text-[14px] text-[#3E5445] leading-[1.6]">
                        Unggah bukti tayang promosi ke dashboard dan terima pencairan honor langsung ke rekening bank Anda.
                    </p>
                </div>
            </div>
        </section>

        <!-- 4. BOTTOM ACTION CARD -->
        <section class="bg-white/85 sm:bg-white/90 backdrop-blur-md rounded-3xl p-8 sm:p-11 border border-[#C8BFB0]/70 shadow-[0_12px_36px_rgba(45,107,34,0.08)] space-y-6 text-left scroll-mt-[100px]" data-reveal>
            <div class="space-y-2">
                <h2 class="text-[28px] sm:text-[34px] font-bold text-[#15241C] leading-tight">
                    Mulai kemitraan promosi Anda sekarang
                </h2>
                <p class="text-[#3E5445] text-[16px] max-w-2xl leading-[1.6]">
                    Dukung pertumbuhan produk lokal bersama ekosistem Daya UMKM dan nikmati peluang kerja sama berkesinambungan.
                </p>
            </div>
            <div data-reveal-item>
                <a href="<?php echo e(route('register.influencer')); ?>" 
                   class="inline-flex items-center justify-center bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] px-7 py-3.5 rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                    Daftar sebagai mitra influencer
                </a>
            </div>
        </section>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\laragon\www\tikum_core\tikum_core\resources\views/pages/gabung-influencer.blade.php ENDPATH**/ ?>