<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title', 'Titik UMKM') - Solusi Permodalan dan Sewa Ruko</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #F8FAF7;
            --surface: #ffffff;
            --ink: #15241C;
            --ink-2: #435C4E;
            --line: rgba(26, 91, 54, 0.12);
            --green: #1A5B36;
            --green-dark: #134629;
            --green-mid: #277848;
            --green-hover: #103B23;
            --green-light: #D8EED9;
            --teal-glow: rgba(39, 120, 72, 0.12);
            --mint: #EAF5E9;
            --gold: #F4B838;
            --gold-hover: #E5A726;
            --yellow-accent: #F4B838;
            --yellow-soft: rgba(244, 184, 56, 0.18);
        }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg);
            color: var(--ink);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        :focus-visible {
            outline: 2px solid var(--green);
            outline-offset: 3px;
        }
    </style>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/motion.js'])
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bg: '#FAFBF9',
                        surface: '#ffffff',
                        ink: '#15241C',
                        'ink-2': '#3E5445',
                        line: '#C8BFB0',
                        sky: '#79BEE8',
                        'sky-light': '#A8D8F0',
                        'grass-bright': '#6FC142',
                        'grass-mid': '#4A9A2E',
                        'grass-dark': '#2D6B22',
                        'cream-light': '#F7E8C8',
                        cream: '#EDD9A3',
                        'roof-dark': '#1E4A1A',
                        pavement: '#C8BFB0',
                        green: '#2D6B22',
                        'green-dark': '#1E4A1A',
                        'green-mid': '#4A9A2E',
                        'green-hover': '#1E4A1A',
                        'green-light': '#F7E8C8',
                        mint: '#F2F8ED',
                        gold: '#EDD9A3',
                        'gold-hover': '#E2CA8F',
                        'yellow-accent': '#6FC142',
                        // Compatibility aliases
                        primary: '#2D6B22',
                        'primary-dark': '#1E4A1A',
                        secondary: '#4A9A2E',
                        'neutral-bg': '#FAFBF9',
                        accent: '#6FC142',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'IBM Plex Sans', 'Segoe UI', 'system-ui', 'sans-serif'],
                    },
                    borderRadius: {
                        'sm-btn': '8px',
                        'md-panel': '12px',
                        'lg-card': '16px',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#FAFBF9] text-[#15241C] antialiased min-h-screen flex flex-col font-sans selection:bg-[#F7E8C8] selection:text-[#1E4A1A] overflow-x-hidden">

    @php
        $isAuthPage = request()->is('login') || request()->is('register*') || request()->is('forgot-password') || request()->is('reset-password') || request()->is('verify-otp');
        $isFullBleed = request()->is('/') || request()->is('gabung*') || $isAuthPage;
    @endphp

    <!-- Header Publik (Tinggi 72px, fixed, transparan di hero, solid di konten) -->
    <header id="site-header" class="header-public fixed top-0 left-0 w-full z-50 h-[72px] sm:h-[76px] flex items-center transition-all duration-300 ease-in-out {{ $isFullBleed ? 'header-transparent' : 'header-scrolled' }}">
        <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-8 flex items-center justify-between">
            
            <!-- 1. Logo Brand TIKUM -->
            <a href="{{ url('/') }}" class="flex items-center group rounded-[8px] focus-visible:outline focus-visible:outline-2 focus-visible:outline-[#2D6B22]" aria-label="TIKUM - Titik UMKM">
                <img src="{{ asset('images/TIKUM-Logo.png') }}" alt="TIKUM - Titik UMKM" class="h-10 sm:h-11 md:h-12 w-auto object-contain drop-shadow-sm transition-transform duration-200 group-hover:scale-[1.03]">
            </a>

            <!-- 2. Menu Navigasi (Urutan: Beranda > Tentang kami > Gabung > Tutorial > Bantuan > Kontak) -->
            <nav class="hidden lg:flex items-center gap-7 text-[14px] font-medium" aria-label="Utama">
                <a href="{{ url('/') }}" id="nav-link-beranda" class="nav-item transition-all py-1 {{ request()->is('/') ? 'active text-[#2D6B22] font-semibold border-b-2 border-[#2D6B22]' : 'text-[#15241C] hover:text-[#2D6B22]' }}" {{ request()->is('/') ? 'aria-current="page"' : '' }} data-i18n="nav.beranda">Beranda</a>
                <a href="{{ url('/#tentang-kami') }}" id="nav-link-tentang-kami" class="nav-item transition-all py-1 text-[#15241C] hover:text-[#2D6B22]" data-i18n="nav.tentang">Tentang kami</a>
                
                <!-- Dropdown Gabung -->
                <div class="relative group" id="gabung-dropdown-wrapper">
                    <button type="button" 
                            id="gabung-dropdown-btn"
                            class="nav-item inline-flex items-center gap-1.5 focus-visible:outline focus-visible:outline-2 focus-visible:outline-[#2D6B22] cursor-pointer py-1 text-[#15241C] hover:text-[#2D6B22] {{ request()->is('gabung*') ? 'active text-[#2D6B22] font-semibold border-b-2 border-[#2D6B22]' : '' }}">
                        <span data-i18n="nav.gabung">Gabung</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:rotate-180 text-[#3E5445]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown Box -->
                    <div class="absolute left-0 top-full pt-3 w-64 hidden group-hover:block hover:block z-50">
                        <div class="bg-[#ffffff] rounded-[12px] border border-[#C8BFB0]/50 p-2 text-left space-y-1 shadow-lg">
                            <a href="{{ route('gabung.investor') }}" 
                               class="block p-3 rounded-[8px] hover:bg-[#F7E8C8]/40 transition group/item">
                                <span class="font-semibold text-[14px] text-[#2D6B22] block" data-i18n="nav.gabung_investor_title">
                                    Daftar mitra investor
                                </span>
                                <span class="text-[12.5px] text-[#3E5445] block mt-0.5" data-i18n="nav.gabung_investor_sub">
                                    Mulai danai dan kembangkan usaha
                                </span>
                            </a>

                            <div class="h-px bg-[#C8BFB0]/40 my-1"></div>

                            <a href="{{ route('gabung.umkm') }}" 
                               class="block p-3 rounded-[8px] hover:bg-[#F7E8C8]/40 transition group/item">
                                <span class="font-semibold text-[14px] text-[#2D6B22] block" data-i18n="nav.gabung_umkm_title">
                                    Daftar pelaku UMKM
                                </span>
                                <span class="text-[12.5px] text-[#3E5445] block mt-0.5" data-i18n="nav.gabung_umkm_sub">
                                    Dapatkan akses modal dan sewa ruko
                                </span>
                            </a>
                            <div class="h-px bg-[#C8BFB0]/40 my-1"></div>

                            <a href="{{ route('ruko.usulkan.public') }}" 
                               class="block p-3 rounded-[8px] hover:bg-teal-50 transition group/item">
                                <span class="font-semibold text-[14px] text-[#0F433C] block" data-i18n="nav.usulkan_ruko">
                                    Ajukan Lokasi Ruko
                                </span>
                                <span class="text-[12.5px] text-[#3E5445] block mt-0.5" data-i18n="nav.usulkan_ruko_desc">
                                    Ajukan lokasi ruko untuk ditinjau
                                </span>
                            </a>

                            <div class="h-px bg-[#C8BFB0]/40 my-1"></div>

                            <a href="{{ route('gabung.influencer') }}" 
                               class="block p-3 rounded-[8px] hover:bg-amber-50 transition group/item">
                                <span class="font-semibold text-[14px] text-amber-900 block flex items-center gap-1.5">
                                    <span>✨</span>
                                    <span>Daftar Mitra Influencer</span>
                                </span>
                                <span class="text-[12.5px] text-[#3E5445] block mt-0.5">
                                    Promosikan UMKM & raih penghasilan promosi
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('ruko.usulkan.public') }}" id="nav-link-usulkan-ruko" class="nav-item transition-all py-1 {{ request()->routeIs('ruko.usulkan*') ? 'active text-[#2D6B22] font-semibold border-b-2 border-[#2D6B22]' : 'text-[#15241C] hover:text-[#2D6B22]' }}" data-i18n="nav.usulkan_ruko">
                    Ajukan Lokasi Ruko
                </a>
                <a href="{{ url('/#tutorial') }}" id="nav-link-tutorial" class="nav-item transition-all py-1 text-[#15241C] hover:text-[#2D6B22]" data-i18n="nav.tutorial">Tutorial</a>
                <a href="{{ url('/#bantuan') }}" id="nav-link-bantuan" class="nav-item transition-all py-1 text-[#15241C] hover:text-[#2D6B22]" data-i18n="nav.bantuan">Bantuan</a>
                <a href="{{ url('/#kontak') }}" id="nav-link-kontak" class="nav-item transition-all py-1 text-[#15241C] hover:text-[#2D6B22]" data-i18n="nav.kontak">Kontak</a>
            </nav>

            <!-- 3. Button Translate IDN / ENG & 4. Tombol Masuk (Kuning Asli #F4B838) -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:inline-flex lang-switch-container" aria-label="Pilihan bahasa" id="lang-switch-box">
                    <button type="button" id="lang-btn-id" class="lang-btn active" data-lang="id" title="Bahasa Indonesia">
                        IDN
                    </button>
                    <button type="button" id="lang-btn-en" class="lang-btn" data-lang="en" title="English">
                        ENG
                    </button>
                </div>

                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center bg-[#F4B838] hover:bg-[#E5A726] text-[#15241C] font-semibold text-[14px] px-5 py-2 rounded-lg shadow-sm hover:shadow transition-all duration-150" data-i18n="nav.dashboard">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-[#F4B838] hover:bg-[#E5A726] text-[#15241C] font-semibold text-[14px] px-5 py-2 rounded-lg shadow-sm hover:shadow transition-all duration-150" data-i18n="nav.masuk">
                        Masuk
                    </a>
                @endauth

                <!-- Tombol Menu Mobile -->
                <button type="button" 
                        id="mobile-menu-btn" 
                        class="lg:hidden p-2 rounded-[8px] text-[#15241C] hover:bg-[#4A9A2E]/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-[#2D6B22]"
                        aria-label="Menu navigasi">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Panel Menu Mobile -->
        <div id="mobile-menu" class="hidden lg:hidden absolute top-[80px] left-0 w-full bg-[#ffffff] border-b border-[#C8BFB0]/50 px-5 py-4 space-y-3 text-[15px] font-medium text-[#15241C] shadow-sm">
            <a href="{{ url('/') }}" class="block py-1.5 hover:text-[#2D6B22]" data-i18n="nav.beranda">Beranda</a>
            <a href="{{ url('/#tentang-kami') }}" class="block py-1.5 hover:text-[#2D6B22]" data-i18n="nav.tentang">Tentang kami</a>
            
            <div class="pt-2 pb-2 border-t border-[#C8BFB0]/40">
                <span class="text-[13px] font-semibold text-[#3E5445] block mb-1" data-i18n="nav.gabung_label">Gabung:</span>
                <div class="pl-2 space-y-1">
                    <a href="{{ route('gabung.investor') }}" class="block py-1 hover:text-[#2D6B22]" data-i18n="nav.gabung_investor_title">Daftar mitra investor</a>
                    <a href="{{ route('gabung.umkm') }}" class="block py-1 hover:text-[#2D6B22]" data-i18n="nav.gabung_umkm_title">Daftar pelaku UMKM</a>
                    <a href="{{ route('gabung.influencer') }}" class="block py-1 hover:text-[#2D6B22]">Daftar mitra influencer</a>
                </div>
            </div>

            <a href="{{ route('ruko.usulkan.public') }}" class="block py-1.5 hover:text-[#2D6B22]" data-i18n="nav.usulkan_ruko">Ajukan Lokasi Ruko</a>
            <a href="{{ url('/#tutorial') }}" class="block py-1.5 hover:text-[#2D6B22]" data-i18n="nav.tutorial">Tutorial</a>
            <a href="{{ url('/#bantuan') }}" class="block py-1.5 hover:text-[#2D6B22]" data-i18n="nav.bantuan">Bantuan</a>
            <a href="{{ url('/#kontak') }}" class="block py-1.5 hover:text-[#2D6B22]" data-i18n="nav.kontak">Kontak</a>

            <div class="pt-3 border-t border-[#C8BFB0]/40 flex items-center justify-between text-[14px]">
                <span class="text-[#3E5445]" data-i18n="nav.bahasa_label">Bahasa:</span>
                <div class="inline-flex lang-switch-container">
                    <button type="button" id="mobile-lang-btn-id" class="lang-btn active" data-lang="id" title="Bahasa Indonesia">IDN</button>
                    <button type="button" id="mobile-lang-btn-en" class="lang-btn" data-lang="en" title="English">ENG</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Konten Utama Halaman (Tengah secara horizontal) -->
    <main class="flex-grow w-full flex flex-col items-center relative {{ $isFullBleed ? '' : 'pt-[72px] sm:pt-[76px]' }}">
        @if ($isAuthPage)
            <!-- Background Visual Miniatur 3D (Blur 20%) untuk Halaman Masuk & Daftar -->
            <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden select-none">
                <img src="{{ asset('images/Sunny Miniature House on Rolling Hills.png') }}" 
                     alt="Latar Belakang Titik UMKM" 
                     class="w-full h-full object-cover object-bottom filter blur-[20px] scale-[1.08] select-none pointer-events-none">
                
                <!-- Soft Tint Overlay agar kontras kartu selalu tajam -->
                <div class="absolute inset-0 bg-white/20 pointer-events-none"></div>

                <!-- Biru Langit Gradient di Area Atas -->
                <div class="absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-[#A8D8F0]/85 via-[#79BEE8]/35 to-transparent pointer-events-none"></div>

                <!-- Lapisan Soft Ambient Glow Hijau di Dasar Menuju Footer -->
                <div class="absolute inset-x-0 bottom-0 h-56 bg-gradient-to-t from-[#1E4A1A]/80 via-[#2D6B22]/20 to-transparent pointer-events-none"></div>
            </div>

            <!-- Konten Form Auth dengan Jarak Proporsional -->
            <div class="relative z-10 w-full flex flex-col items-center justify-center pt-24 sm:pt-28 pb-12 px-4 min-h-[calc(100vh-72px)]">
                @yield('content')
            </div>
        @else
            @yield('content')
        @endif
    </main>

    <!-- Footer Publik: Hijau genteng/pohon gelap (#1E4A1A) Sesuai Settingan -->
    <footer class="bg-[#1E4A1A] {{ $isFullBleed ? 'border-t-0' : 'border-t border-[#2D6B22]' }} text-[#EDD9A3] text-[13px] py-8 sm:py-9 mt-0 w-full relative z-10">
        <div class="max-w-[1200px] mx-auto px-5 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3 text-[#F7E8C8]">
                <a href="{{ url('/') }}" class="bg-white/95 px-2.5 py-1 rounded-lg inline-flex items-center hover:bg-white transition shadow-sm" aria-label="TIKUM Beranda">
                    <img src="{{ asset('images/TIKUM-Logo.png') }}" alt="TIKUM - Titik UMKM" class="h-6 w-auto object-contain">
                </a>
                <span class="text-[#EDD9A3]/80" data-i18n="footer.copyright">&copy; {{ date('Y') }}. Hak cipta dilindungi.</span>
            </div>
            <div class="flex flex-wrap items-center gap-6 text-[#EDD9A3]">
                <a href="{{ route('privacy') }}" class="hover:text-white transition-colors" data-i18n="footer.privacy">Kebijakan privasi</a>
                <a href="{{ route('terms') }}" class="hover:text-white transition-colors" data-i18n="footer.terms">Syarat dan ketentuan</a>
                <a href="{{ url('/#bantuan') }}" class="hover:text-white transition-colors" data-i18n="footer.help">Hubungi bantuan</a>
            </div>
        </div>
    </footer>

    <script>
        (function() {
            const header = document.getElementById('site-header');
            
            // 1. Scroll header state (transparan di posisi teratas, frosted glass saat scroll)
            const onHeaderScroll = () => {
                if (!header) return;
                const isScrolled = window.scrollY > 15;
                if (isScrolled) {
                    header.classList.remove('header-transparent');
                    header.classList.add('header-scrolled');
                } else {
                    header.classList.add('header-transparent');
                    header.classList.remove('header-scrolled');
                }
            };
            window.addEventListener('scroll', onHeaderScroll, { passive: true });
            onHeaderScroll();

            // 2. Active nav link helper
            const navLinks = {
                '#beranda': document.getElementById('nav-link-beranda'),
                '#tentang-kami': document.getElementById('nav-link-tentang-kami'),
                '#tutorial': document.getElementById('nav-link-tutorial'),
                '#bantuan': document.getElementById('nav-link-bantuan'),
                '#kontak': document.getElementById('nav-link-kontak')
            };

            function setActiveNav(targetHash) {
                // Jangan override jika kita di halaman selain landing page
                const isLanding = window.location.pathname === '/' || window.location.pathname === '';
                if (!isLanding) return;

                Object.entries(navLinks).forEach(([hash, link]) => {
                    if (!link) return;
                    if (hash === targetHash) {
                        link.classList.add('active', 'font-semibold');
                        link.setAttribute('aria-current', 'page');
                    } else {
                        link.classList.remove('active', 'font-semibold');
                        link.removeAttribute('aria-current');
                    }
                });
            }

            // 3. ScrollSpy untuk mendeteksi posisi seksi yang sedang dilihat
            function updateScrollSpy() {
                const isLanding = window.location.pathname === '/' || window.location.pathname === '';
                if (!isLanding) return;

                // Threshold batas aktif: tinggi header (76px) + offset visual
                const threshold = 140;

                // Jika scroll sudah di ujung paling bawah halaman, aktifkan #kontak
                if ((window.innerHeight + window.scrollY) >= (document.documentElement.scrollHeight - 60)) {
                    setActiveNav('#kontak');
                    return;
                }

                // Jika berada di area atas halaman / hero visual showcase, selalu aktifkan #beranda
                const berandaSec = document.getElementById('beranda');
                if (window.scrollY < 100 || (berandaSec && berandaSec.getBoundingClientRect().bottom > threshold)) {
                    setActiveNav('#beranda');
                    return;
                }

                // Jika scroll sudah di ujung paling bawah halaman, aktifkan #kontak
                if ((window.innerHeight + window.scrollY) >= (document.documentElement.scrollHeight - 60)) {
                    setActiveNav('#kontak');
                    return;
                }

                const sections = [
                    { id: '#kontak', el: document.querySelector('#kontak') },
                    { id: '#bantuan', el: document.querySelector('#bantuan') },
                    { id: '#tutorial', el: document.querySelector('#tutorial') },
                    { id: '#tentang-kami', el: document.querySelector('#tentang-kami') },
                    { id: '#beranda', el: document.querySelector('#beranda') }
                ];

                let current = '#beranda';
                for (const item of sections) {
                    if (item.el) {
                        const rect = item.el.getBoundingClientRect();
                        if (rect.top <= threshold && rect.bottom > 40) {
                            current = item.id;
                            break;
                        }
                    }
                }

                setActiveNav(current);
            }
            window.updateScrollSpy = updateScrollSpy;

            window.addEventListener('scroll', updateScrollSpy, { passive: true });
            // Initial call
            setTimeout(updateScrollSpy, 100);

            // 4. Smooth scroll dengan offset tepat (96px) saat link anchor diklik
            document.querySelectorAll('a[href*="#"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (window.lenis) return; // Lenis in motion.js handles smooth scrolling

                    const href = this.getAttribute('href');
                    if (!href) return;
                    const hashIndex = href.indexOf('#');
                    if (hashIndex === -1) return;

                    const hash = href.substring(hashIndex);
                    const targetEl = document.querySelector(hash);

                    const isCurrentPageLanding = window.location.pathname === '/' || window.location.pathname === '';
                    if (isCurrentPageLanding && targetEl) {
                        e.preventDefault();
                        const headerOffset = 96;
                        const elementPosition = targetEl.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });

                        setActiveNav(hash);
                        history.pushState(null, null, hash);

                        // Tutup menu mobile jika terbuka
                        const mobileMenu = document.getElementById('mobile-menu');
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }
                    }
                });
            });

            // Handle klik Beranda link saat di landing page
            const berandaLink = document.getElementById('nav-link-beranda');
            if (berandaLink) {
                berandaLink.addEventListener('click', function(e) {
                    if (window.lenis) return; // Lenis in motion.js handles it
                    if (window.location.pathname === '/' || window.location.pathname === '') {
                        e.preventDefault();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        setActiveNav('#beranda');
                        history.pushState(null, null, ' ');
                    }
                });
            }

            // 5. Multi-Language (i18n) Engine & Language Switcher
            const i18nDict = {
                id: {
                    'brand.subtitle': 'Produksi & sewa ruko',
                    'nav.beranda': 'Beranda',
                    'nav.tentang': 'Tentang kami',
                    'nav.gabung': 'Gabung',
                    'nav.gabung_label': 'Gabung:',
                    'nav.gabung_investor_title': 'Daftar mitra investor',
                    'nav.gabung_investor_sub': 'Mulai danai dan kembangkan usaha',
                    'nav.gabung_umkm_title': 'Daftar pelaku UMKM',
                    'nav.gabung_umkm_sub': 'Dapatkan akses modal dan sewa ruko',
                    'nav.usulkan_ruko': 'Ajukan Lokasi Ruko',
                    'nav.usulkan_ruko_desc': 'Kirim lokasi untuk ditinjau',
                    'nav.tutorial': 'Tutorial',
                    'nav.bantuan': 'Bantuan',
                    'nav.kontak': 'Kontak',
                    'nav.masuk': 'Masuk',
                    'nav.dashboard': 'Dashboard',
                    'nav.bahasa_label': 'Bahasa:',
                    'footer.copyright': '© {{ date("Y") }}. Hak cipta dilindungi.',
                    'footer.privacy': 'Kebijakan privasi',
                    'footer.terms': 'Syarat dan ketentuan',
                    'footer.help': 'Hubungi bantuan',
                    'hero.title': 'Wadah permodalan produktif dan sewa ruko bagi pelaku usaha',
                    'hero.desc': 'Platform terintegrasi bagi investor untuk menyalurkan modal usaha dan memfasilitasi pelaku UMKM memperoleh sewa ruko strategis secara transparan.',
                    'hero.btn_investor': 'Daftar jadi Investor',
                    'hero.btn_umkm': 'Daftar jadi UMKM',
                    'about.title': 'Tentang kami',
                    'about.p1': 'Titik UMKM hadir untuk menjembatani kesenjangan akses permodalan bagi pemilik usaha kecil dan menengah di Indonesia. Melalui sistem verifikasi berlapis dan audit aktivitas yang terpercaya, kami memastikan setiap dana investasi tersalurkan secara optimal dan memberi manfaat timbal balik yang sehat bagi investor maupun pengusaha.',
                    'about.p2': 'Keamanan data dan transaksi diprioritaskan lewat mekanisme autentikasi terverifikasi dan pembagian hasil usaha yang tercatat rapi di sistem.',
                    'about.btn_tutorial': 'Pelajari Alur Kerja',
                    'about.btn_help': 'Pusat Bantuan',
                    'tutorial.title': 'Panduan dan alur kerja',
                    'tutorial.subtitle': 'Langkah terstruktur menghubungkan pendanaan investor dan pelaku UMKM di dalam platform.',
                    'tutorial.step1_badge': 'Tahap 1',
                    'tutorial.step1_title': 'Pendaftaran akun',
                    'tutorial.step1_desc': 'Pilih peran sebagai mitra investor atau pelaku UMKM, lalu lengkapi verifikasi email OTP resmi.',
                    'tutorial.step2_badge': 'Tahap 2',
                    'tutorial.step2_title': 'Verifikasi dan penyesuaian',
                    'tutorial.step2_desc': 'Pelaku usaha mengajukan kebutuhan sewa atau modal, sedangkan investor meninjau katalog peluang terkurasi.',
                    'tutorial.step3_badge': 'Tahap 3',
                    'tutorial.step3_title': 'Realisasi dan bagi hasil',
                    'tutorial.step3_desc': 'Penyaluran modal dilakukan dengan transparansi penuh, dividen bagi hasil dicatat berkala di dashboard.',
                    'help.title': 'Pusat bantuan',
                    'help.desc': 'Butuh panduan mengenai tata cara pendaftaran, syarat pengajuan sewa ruko, atau mekanisme bagi hasil? Tim dukungan kami siap melayani Anda.',
                    'help.btn': 'Kirim pesan ke tim bantuan',
                    'contact.title': 'Kontak resmi',
                    'contact.desc': 'Hubungi sekretariat operasional Titik UMKM untuk keperluan kemitraan ruko, konsultasi kelembagaan, dan verifikasi profil usaha.',
                    'contact.hours_label': 'Jam operasional:',
                    'contact.hours_val': 'Senin – Jumat, 08:00 – 17.00 WIB',

                    // Auth - Login
                    'auth.login_title': 'Masuk ke akun',
                    'auth.login_subtitle': 'Gunakan kredensial akun Titik UMKM Anda untuk melanjutkan.',
                    'auth.google_login': 'Masuk dengan Google',
                    'auth.or_email': 'atau masuk dengan email',
                    'auth.email_label': 'Alamat email',
                    'auth.email_placeholder': 'nama@email.com',
                    'auth.password_label': 'Kata sandi',
                    'auth.password_placeholder': '••••••••',
                    'auth.forgot_password': 'Lupa sandi?',
                    'auth.remember_me': 'Ingat sesi saya',
                    'auth.login_btn': 'Masuk ke akun',
                    'auth.no_account': 'Belum memiliki akun?',
                    'auth.register_now': 'Daftar sekarang',

                    // Auth - Register
                    'auth.register_title': 'Daftar akun baru',
                    'auth.register_title_investor': 'Daftar sebagai mitra investor',
                    'auth.register_title_umkm': 'Daftar sebagai pelaku UMKM',
                    'auth.register_subtitle': 'Pilih peran dan lengkapi data untuk mulai bergabung di Titik UMKM.',
                    'auth.register_subtitle_investor': 'Salurkan permodalan produktif dan pantau bagi hasil secara berkala.',
                    'auth.register_subtitle_umkm': 'Dapatkan akses modal usaha dan direktori sewa ruko strategis.',
                    'auth.google_register': 'Daftar dengan Google',
                    'auth.or_email_register': 'atau formulir pendaftaran email',
                    'auth.role_label': 'Daftar sebagai',
                    'auth.role_investor': 'Investor',
                    'auth.role_investor_desc': 'Pemodal usaha',
                    'auth.role_umkm': 'Pelaku UMKM',
                    'auth.role_umkm_desc': 'Pencari modal & sewa',
                    'auth.name_label': 'Nama lengkap',
                    'auth.name_placeholder': 'Nama lengkap Anda',
                    'auth.phone_label': 'Nomor WhatsApp / HP',
                    'auth.phone_placeholder': '0812xxxxxxxx',
                    'auth.confirm_password_label': 'Konfirmasi kata sandi',
                    'auth.pwd_req_title': 'Persyaratan kata sandi:',
                    'auth.pwd_req_min': 'Minimal 8 karakter',
                    'auth.pwd_req_case': 'Huruf besar & kecil (A-z)',
                    'auth.pwd_req_num': 'Mengandung angka (0-9)',
                    'auth.pwd_req_spec': 'Karakter khusus (!@#$%)',
                    'auth.otp_info_card': 'Kode verifikasi OTP 6-digit akan dikirimkan ke alamat email terdaftar untuk aktivasi akun resmi Anda.',
                    'auth.terms_agreement': 'Saya menyetujui Syarat & Ketentuan serta Kebijakan Privasi platform Titik UMKM.',
                    'auth.register_btn': 'Daftar dan kirim kode OTP',
                    'auth.have_account': 'Sudah memiliki akun?',
                    'auth.login_now': 'Masuk sekarang',

                    // Auth - Forgot Password
                    'auth.forgot_title': 'Lupa kata sandi',
                    'auth.forgot_subtitle': 'Masukkan alamat email akun Anda. Kami akan mengirimkan kode verifikasi OTP untuk menyetel ulang kata sandi.',
                    'auth.forgot_email_label': 'Alamat email terdaftar',
                    'auth.forgot_info': 'Kode verifikasi OTP 6-digit akan dikirimkan ke email untuk memastikan kepemilikan akun Anda.',
                    'auth.send_reset_btn': 'Kirim kode pemulihan',
                    'auth.remember_password': 'Ingat kata sandi Anda?',
                    'auth.back_to_login': 'Kembali masuk',

                    // Auth - Verify OTP
                    'auth.otp_title': 'Verifikasi email Anda',
                    'auth.otp_subtitle': 'Masukkan 6 digit kode OTP yang telah dikirimkan ke alamat email terdaftar.',
                    'auth.otp_sent_to': 'Kode dikirimkan ke:',
                    'auth.otp_input_label': 'Kode verifikasi 6 digit',
                    'auth.otp_expires_in': 'Kode kedaluwarsa dalam:',
                    'auth.otp_verify_btn': 'Verifikasi dan masuk',
                    'auth.otp_no_code': 'Belum menerima kode OTP?',
                    'auth.otp_resend_btn': 'Kirim ulang kode',
                    'auth.otp_switch_account': 'Gunakan akun atau email lain',

                    // Auth - Reset Password
                    'auth.reset_title': 'Atur kata sandi baru',
                    'auth.reset_subtitle': 'Buat kata sandi baru yang aman untuk akun Anda.',
                    'auth.reset_pwd_label': 'Kata sandi baru',
                    'auth.reset_confirm_label': 'Konfirmasi kata sandi baru',
                    'auth.reset_pwd_placeholder': 'Minimal 8 karakter',
                    'auth.reset_confirm_placeholder': 'Ulangi kata sandi baru',
                    'auth.reset_back_label': 'Sudah selesai atau ingin login?',
                    'auth.reset_submit_btn': 'Simpan kata sandi baru',

                    // Gabung - Shared & Investor
                    'gabung.badge_investor': 'Ekosistem Mitra Investor',
                    'gabung.inv_hero_title': 'Kemitraan permodalan bagi investor produktif',
                    'gabung.inv_hero_desc': 'Salurkan permodalan langsung kepada pelaku UMKM terverifikasi di ekosistem Titik UMKM dengan imbal hasil terukur, berkala, dan transparan.',
                    'gabung.inv_btn_register': 'Daftar sebagai investor',
                    'gabung.inv_btn_learn': 'Pelajari manfaat',
                    'gabung.inv_panel_title': 'Karakteristik portofolio kemitraan',
                    'gabung.inv_panel_sub': 'Standar tata kelola investasi di Titik UMKM',
                    'gabung.inv_metric1_label': 'Estimasi bagi hasil',
                    'gabung.inv_metric1_sub': 'Per tahun (proyeksian)',
                    'gabung.inv_metric2_label': 'Periode bagi hasil',
                    'gabung.inv_metric2_val': 'Bulanan',
                    'gabung.inv_metric2_sub': 'Tercatat di sistem',
                    'gabung.inv_panel_footer': 'Setiap transaksi permodalan diaudit oleh admin dan dilengkapi riwayat bukti penyaluran bagi hasil resmi.',
                    'gabung.inv_advantages_title': 'Keunggulan kemitraan investor',
                    'gabung.inv_advantages_desc': 'Jembatan investasi inklusif yang mengedepankan keamanan dana dan akuntabilitas operasional.',
                    'gabung.inv_card1_title': 'UMKM terverifikasi',
                    'gabung.inv_card1_desc': 'Setiap unit usaha melewati kurasi profil, rekam jejak omzet, dan kejelasan identitas pemilik.',
                    'gabung.inv_card2_title': 'Bagi hasil berkala',
                    'gabung.inv_card2_desc': 'Distribusi keuntungan dicatat secara rinci dalam riwayat transaksi dengan bukti transfer resmi.',
                    'gabung.inv_card3_title': 'Diversifikasi usaha',
                    'gabung.inv_card3_desc': 'Alokasikan modal ke berbagai bidang usaha seperti kuliner, ritel, dan jasa untuk menjaga profil risiko.',
                    'gabung.inv_card4_title': 'Keamanan akun',
                    'gabung.inv_card4_desc': 'Verifikasi login via kode OTP email resmi dan audit trail aktivitas untuk melindungi data kemitraan.',
                    'gabung.inv_steps_title': 'Tahapan berinvestasi',
                    'gabung.inv_steps_desc': 'Proses terstruktur mulai dari registrasi hingga penerimaan bagi hasil.',
                    'gabung.step1_badge': 'Tahap 1',
                    'gabung.step2_badge': 'Tahap 2',
                    'gabung.step3_badge': 'Tahap 3',
                    'gabung.step4_badge': 'Tahap 4',
                    'gabung.inv_step1_title': 'Daftar akun investor',
                    'gabung.inv_step1_desc': 'Buka formulir online khusus investor dan verifikasi email Anda lewat kode OTP 6-digit.',
                    'gabung.inv_step2_title': 'Pilih UMKM potensial',
                    'gabung.inv_step2_desc': 'Pelajari rincian profil usaha, kebutuhan modal kerja, dan estimasi bagi hasil yang ditawarkan.',
                    'gabung.inv_step3_title': 'Konfirmasi permodalan',
                    'gabung.inv_step3_desc': 'Kirim pengajuan investasi Anda. Permodalan akan diverifikasi dan diaudit langsung oleh admin.',
                    'gabung.inv_step4_title': 'Terima bagi hasil',
                    'gabung.inv_step4_desc': 'Pantau kinerja usaha dari dashboard dan terima pembagian hasil berkala sesuai perjanjian.',
                    'gabung.inv_cta_title': 'Mulai kemitraan investasi Anda sekarang',
                    'gabung.inv_cta_desc': 'Dukung pertumbuhan pelaku usaha lokal dan nikmati bagi hasil terukur bersama ekosistem terpercaya Titik UMKM.',

                    // Gabung - UMKM
                    'gabung.badge_umkm': 'Ekosistem Pelaku UMKM',
                    'gabung.umkm_hero_title': 'Solusi modal dan sewa ruko bagi pelaku usaha',
                    'gabung.umkm_hero_desc': 'Kembangkan bisnis Anda dengan kemudahan akses permodalan produktif dan direktori sewa ruko strategis tanpa beban agunan memberatkan.',
                    'gabung.umkm_btn_register': 'Daftar sebagai pelaku UMKM',
                    'gabung.umkm_btn_learn': 'Pelajari fasilitas',
                    'gabung.umkm_panel_title': 'Fasilitas ekosistem usaha',
                    'gabung.umkm_panel_sub': 'Dukungan menyeluruh bagi pelaku UMKM',
                    'gabung.umkm_metric1_label': 'Kebutuhan modal',
                    'gabung.umkm_metric1_val': 'Fleksibel',
                    'gabung.umkm_metric1_sub': 'Sesuai kapasitas usaha',
                    'gabung.umkm_metric2_label': 'Ketersediaan ruko',
                    'gabung.umkm_metric2_val': 'Strategis',
                    'gabung.umkm_metric2_sub': 'Pusat keramaian',
                    'gabung.umkm_panel_footer': 'Tumbuh bersama jejaring investor terpercaya dan fasilitas sewa komersial dengan tata kelola jelas.',
                    'gabung.umkm_advantages_title': 'Keunggulan bergabung di Titik UMKM',
                    'gabung.umkm_advantages_desc': 'Dukungan fasilitas menyeluruh dari permodalan usaha hingga kemudahan sewa tempat berdagang.',
                    'gabung.umkm_card1_title': 'Akses modal produktif',
                    'gabung.umkm_card1_desc': 'Pendanaan dari investor terverifikasi dengan mekanisme bagi hasil murni yang ramah bagi arus kas usaha.',
                    'gabung.umkm_card2_title': 'Sewa ruko strategis',
                    'gabung.umkm_card2_desc': 'Akses direktori ruko komersial dari penyedia terpercaya dengan spesifikasi lengkap dan harga transparan.',
                    'gabung.umkm_card3_title': 'Pencatatan transparan',
                    'gabung.umkm_card3_desc': 'Semua transaksi sewa ruko dan penyaluran bagi hasil tercatat rapi di sistem untuk reputasi usaha Anda.',
                    'gabung.umkm_card4_title': 'Peluang naik kelas',
                    'gabung.umkm_card4_desc': 'Dukungan ekspansi lokasi gerai dan kapasitas produksi membantu UMKM bertumbuh secara berkelanjutan.',
                    'gabung.umkm_steps_title': 'Tahapan pendaftaran usaha',
                    'gabung.umkm_steps_desc': 'Langkah teratur dari registrasi hingga operasional gerai usaha Anda.',
                    'gabung.umkm_step1_title': 'Daftar akun UMKM',
                    'gabung.umkm_step1_desc': 'Isi formulir pendaftaran akun usaha dan lakukan verifikasi alamat email lewat kode OTP resmi.',
                    'gabung.umkm_step2_title': 'Lengkapi profil usaha',
                    'gabung.umkm_step2_desc': 'Masukkan nama usaha, bidang industri, kontak aktif, dan deskripsi kebutuhan pengembangan.',
                    'gabung.umkm_step3_title': 'Pilih ruko atau modal',
                    'gabung.umkm_step3_desc': 'Pilih lokasi ruko yang tersedia atau ajukan kebutuhan modal kerja agar dapat ditinjau investor.',
                    'gabung.umkm_step4_title': 'Operasional & tumbuh',
                    'gabung.umkm_step4_desc': 'Jalankan operasional usaha, catat perkembangan omzet, dan bangun hubungan kemitraan yang sehat.',
                    'gabung.umkm_cta_title': 'Saatnya membawa usaha Anda ke tingkat selanjutnya',
                    'gabung.umkm_cta_desc': 'Daftarkan unit usaha Anda sekarang untuk mendapatkan akses modal terukur dan pilihan ruko komersial terbaik.'
                },
                en: {
                    'brand.subtitle': 'Production & shop rental',
                    'nav.beranda': 'Home',
                    'nav.tentang': 'About us',
                    'nav.gabung': 'Join',
                    'nav.gabung_label': 'Join:',
                    'nav.gabung_investor_title': 'Register as Investor Partner',
                    'nav.gabung_investor_sub': 'Fund and scale promising businesses',
                    'nav.gabung_umkm_title': 'Register as MSME Entrepreneur',
                    'nav.gabung_umkm_sub': 'Access productive capital and rentals',
                    'nav.usulkan_ruko': 'Suggest a Shophouse',
                    'nav.usulkan_ruko_desc': 'Submit a location for review',
                    'nav.tutorial': 'How It Works',
                    'nav.bantuan': 'Support',
                    'nav.kontak': 'Contact',
                    'nav.masuk': 'Sign In',
                    'nav.dashboard': 'Dashboard',
                    'nav.bahasa_label': 'Language:',
                    'footer.copyright': '© {{ date("Y") }}. All rights reserved.',
                    'footer.privacy': 'Privacy Policy',
                    'footer.terms': 'Terms & Conditions',
                    'footer.help': 'Contact Support',
                    'hero.title': 'Productive capital platform and strategic shop rental for businesses',
                    'hero.desc': 'An integrated platform for investors to channel business funding and facilitate MSMEs in securing strategic shop rentals transparently.',
                    'hero.btn_investor': 'Join as Investor',
                    'hero.btn_umkm': 'Join as MSME',
                    'about.title': 'About Us',
                    'about.p1': 'Titik UMKM bridges the capital access gap for small and medium-sized business owners across Indonesia. Through multi-layered verification and trusted activity audits, we ensure every investment fund is channeled optimally, providing healthy mutual benefits for both investors and entrepreneurs.',
                    'about.p2': 'Data and transaction security is prioritized through verified authentication mechanisms and transparent profit-sharing recorded neatly in the system.',
                    'about.btn_tutorial': 'How It Works',
                    'about.btn_help': 'Support Center',
                    'tutorial.title': 'Workflow & Step-by-Step Guide',
                    'tutorial.subtitle': 'A structured journey connecting investor funding with MSME entrepreneurs on the platform.',
                    'tutorial.step1_badge': 'Step 1',
                    'tutorial.step1_title': 'Account Registration',
                    'tutorial.step1_desc': 'Select your role as an investor partner or MSME entrepreneur, then complete official OTP email verification.',
                    'tutorial.step2_badge': 'Step 2',
                    'tutorial.step2_title': 'Verification & Matching',
                    'tutorial.step2_desc': 'Entrepreneurs submit rental or funding requirements, while investors browse the curated catalog of opportunities.',
                    'tutorial.step3_badge': 'Step 3',
                    'tutorial.step3_title': 'Execution & Profit Sharing',
                    'tutorial.step3_desc': 'Capital distribution is carried out with full transparency, and dividend sharing is recorded periodically on the dashboard.',
                    'help.title': 'Help Center',
                    'help.desc': 'Need guidance on registration procedures, shop rental requirements, or profit-sharing mechanisms? Our dedicated support team is ready to assist you.',
                    'help.btn': 'Send message to support team',
                    'contact.title': 'Official Contact',
                    'contact.desc': 'Contact the Titik UMKM operational secretariat for shophouse partnerships, institutional consultations, and business profile verifications.',
                    'contact.hours_label': 'Business hours:',
                    'contact.hours_val': 'Monday – Friday, 08:00 – 17:00 WIB',

                    // Auth - Login
                    'auth.login_title': 'Sign in to account',
                    'auth.login_subtitle': 'Use your Titik UMKM account credentials to continue.',
                    'auth.google_login': 'Sign in with Google',
                    'auth.or_email': 'or sign in with email',
                    'auth.email_label': 'Email address',
                    'auth.email_placeholder': 'name@email.com',
                    'auth.password_label': 'Password',
                    'auth.password_placeholder': '••••••••',
                    'auth.forgot_password': 'Forgot password?',
                    'auth.remember_me': 'Remember my session',
                    'auth.login_btn': 'Sign In',
                    'auth.no_account': "Don't have an account?",
                    'auth.register_now': 'Register now',

                    // Auth - Register
                    'auth.register_title': 'Register new account',
                    'auth.register_title_investor': 'Register as investor partner',
                    'auth.register_title_umkm': 'Register as MSME entrepreneur',
                    'auth.register_subtitle': 'Choose your role and complete your details to join Titik UMKM.',
                    'auth.register_subtitle_investor': 'Channel capital directly and monitor returns periodically.',
                    'auth.register_subtitle_umkm': 'Access business capital and strategic shophouse rental listings.',
                    'auth.google_register': 'Sign up with Google',
                    'auth.or_email_register': 'or email registration form',
                    'auth.role_label': 'Register as',
                    'auth.role_investor': 'Investor',
                    'auth.role_investor_desc': 'Business funder',
                    'auth.role_umkm': 'MSME Entrepreneur',
                    'auth.role_umkm_desc': 'Capital & rental seeker',
                    'auth.name_label': 'Full name',
                    'auth.name_placeholder': 'Your full name',
                    'auth.phone_label': 'WhatsApp / Phone number',
                    'auth.phone_placeholder': '0812xxxxxxxx',
                    'auth.confirm_password_label': 'Confirm password',
                    'auth.pwd_req_title': 'Password requirements:',
                    'auth.pwd_req_min': 'At least 8 characters',
                    'auth.pwd_req_case': 'Uppercase & lowercase (A-z)',
                    'auth.pwd_req_num': 'Contains numbers (0-9)',
                    'auth.pwd_req_spec': 'Special characters (!@#$%)',
                    'auth.otp_info_card': 'A 6-digit OTP verification code will be sent to your registered email for account activation.',
                    'auth.terms_agreement': 'I agree to the Terms & Conditions and Privacy Policy of the Titik UMKM platform.',
                    'auth.register_btn': 'Register and send OTP code',
                    'auth.have_account': 'Already have an account?',
                    'auth.login_now': 'Sign in here',

                    // Auth - Forgot Password
                    'auth.forgot_title': 'Forgot password',
                    'auth.forgot_subtitle': 'Enter your registered email address. We will send an OTP verification code to reset your password.',
                    'auth.forgot_email_label': 'Registered email address',
                    'auth.forgot_info': 'A 6-digit OTP verification code will be sent to your email to confirm account ownership.',
                    'auth.send_reset_btn': 'Send recovery code',
                    'auth.remember_password': 'Remember your password?',
                    'auth.back_to_login': 'Back to sign in',

                    // Auth - Verify OTP
                    'auth.otp_title': 'Verify your email',
                    'auth.otp_subtitle': 'Enter the 6-digit OTP code sent to your registered email address.',
                    'auth.otp_sent_to': 'Code sent to:',
                    'auth.otp_input_label': '6-digit verification code',
                    'auth.otp_expires_in': 'Code expires in:',
                    'auth.otp_verify_btn': 'Verify and proceed',
                    'auth.otp_no_code': "Didn't receive the OTP code?",
                    'auth.otp_resend_btn': 'Resend code',
                    'auth.otp_switch_account': 'Use another account or email',

                    // Auth - Reset Password
                    'auth.reset_title': 'Set new password',
                    'auth.reset_subtitle': 'Create a secure new password for your account.',
                    'auth.reset_pwd_label': 'New password',
                    'auth.reset_confirm_label': 'Confirm new password',
                    'auth.reset_pwd_placeholder': 'At least 8 characters',
                    'auth.reset_confirm_placeholder': 'Repeat new password',
                    'auth.reset_back_label': 'Finished or want to sign in?',
                    'auth.reset_submit_btn': 'Save new password',

                    // Gabung - Shared & Investor
                    'gabung.badge_investor': 'Investor Partner Ecosystem',
                    'gabung.inv_hero_title': 'Productive capital partnerships for investors',
                    'gabung.inv_hero_desc': 'Channel capital directly to verified MSMEs in the Titik UMKM ecosystem with measurable, periodic, and transparent returns.',
                    'gabung.inv_btn_register': 'Register as an investor',
                    'gabung.inv_btn_learn': 'Learn benefits',
                    'gabung.inv_panel_title': 'Partnership portfolio characteristics',
                    'gabung.inv_panel_sub': 'Investment governance standards at Titik UMKM',
                    'gabung.inv_metric1_label': 'Estimated returns',
                    'gabung.inv_metric1_sub': 'Per annum (projected)',
                    'gabung.inv_metric2_label': 'Return frequency',
                    'gabung.inv_metric2_val': 'Monthly',
                    'gabung.inv_metric2_sub': 'Recorded in system',
                    'gabung.inv_panel_footer': 'Every capital transaction is audited by admins and backed by official profit-sharing disbursement records.',
                    'gabung.inv_advantages_title': 'Investor partnership advantages',
                    'gabung.inv_advantages_desc': 'An inclusive investment bridge prioritizing fund security and operational accountability.',
                    'gabung.inv_card1_title': 'Verified MSMEs',
                    'gabung.inv_card1_desc': 'Every business unit passes profile curation, turnover track records, and verified owner identity.',
                    'gabung.inv_card2_title': 'Periodic returns',
                    'gabung.inv_card2_desc': 'Profit distribution is recorded in detail in transaction history with official transfer proof.',
                    'gabung.inv_card3_title': 'Business diversification',
                    'gabung.inv_card3_desc': 'Allocate capital to varied sectors such as culinary, retail, and services to balance risk profiles.',
                    'gabung.inv_card4_title': 'Account security',
                    'gabung.inv_card4_desc': 'Login verification via official email OTP code and audit trails to protect partnership data.',
                    'gabung.inv_steps_title': 'Investment steps',
                    'gabung.inv_steps_desc': 'A structured journey from registration to receiving profit shares.',
                    'gabung.step1_badge': 'Step 1',
                    'gabung.step2_badge': 'Step 2',
                    'gabung.step3_badge': 'Step 3',
                    'gabung.step4_badge': 'Step 4',
                    'gabung.inv_step1_title': 'Register investor account',
                    'gabung.inv_step1_desc': 'Open the dedicated investor online form and verify your email with a 6-digit OTP code.',
                    'gabung.inv_step2_title': 'Select promising MSMEs',
                    'gabung.inv_step2_desc': 'Review business profiles, working capital requirements, and offered projected returns.',
                    'gabung.inv_step3_title': 'Confirm funding',
                    'gabung.inv_step3_desc': 'Submit your investment application. Funding will be directly verified and audited by admins.',
                    'gabung.inv_step4_title': 'Receive profit shares',
                    'gabung.inv_step4_desc': 'Monitor business performance on the dashboard and receive periodic profit shares per agreement.',
                    'gabung.inv_cta_title': 'Start your investment partnership now',
                    'gabung.inv_cta_desc': "Support the growth of local entrepreneurs and enjoy measurable returns with Titik UMKM's trusted ecosystem.",

                    // Gabung - UMKM
                    'gabung.badge_umkm': 'MSME Entrepreneur Ecosystem',
                    'gabung.umkm_hero_title': 'Capital and shophouse rental solutions for businesses',
                    'gabung.umkm_hero_desc': 'Scale your business with easy access to productive funding and strategic shophouse rentals without burdensome collateral.',
                    'gabung.umkm_btn_register': 'Register as an MSME',
                    'gabung.umkm_btn_learn': 'Learn facilities',
                    'gabung.umkm_panel_title': 'Business ecosystem facilities',
                    'gabung.umkm_panel_sub': 'Comprehensive support for MSME entrepreneurs',
                    'gabung.umkm_metric1_label': 'Capital needs',
                    'gabung.umkm_metric1_val': 'Flexible',
                    'gabung.umkm_metric1_sub': 'Tailored to business capacity',
                    'gabung.umkm_metric2_label': 'Shophouse availability',
                    'gabung.umkm_metric2_val': 'Strategic',
                    'gabung.umkm_metric2_sub': 'High-traffic hubs',
                    'gabung.umkm_panel_footer': 'Grow alongside a trusted investor network and commercial rental facilities with clear governance.',
                    'gabung.umkm_advantages_title': 'Advantages of joining Titik UMKM',
                    'gabung.umkm_advantages_desc': 'Full support from business capital access to convenient commercial trading spaces.',
                    'gabung.umkm_card1_title': 'Productive capital access',
                    'gabung.umkm_card1_desc': 'Funding from verified investors with pure profit-sharing models friendly to business cash flow.',
                    'gabung.umkm_card2_title': 'Strategic shophouse rentals',
                    'gabung.umkm_card2_desc': 'Access commercial shophouse listings from trusted partners with clear specs and transparent rates.',
                    'gabung.umkm_card3_title': 'Transparent record-keeping',
                    'gabung.umkm_card3_desc': 'All shophouse rentals and profit distribution records are tracked systematically to build business reputation.',
                    'gabung.umkm_card4_title': 'Scaling opportunities',
                    'gabung.umkm_card4_desc': 'Support for outlet expansion and production capacity helping MSMEs grow sustainably.',
                    'gabung.umkm_steps_title': 'Business registration steps',
                    'gabung.umkm_steps_desc': 'An organized sequence from registration to your shophouse opening.',
                    'gabung.umkm_step1_title': 'Register MSME account',
                    'gabung.umkm_step1_desc': 'Complete the business registration form and verify your email address via official OTP.',
                    'gabung.umkm_step2_title': 'Complete business profile',
                    'gabung.umkm_step2_desc': 'Enter business name, industry sector, contact info, and growth requirement details.',
                    'gabung.umkm_step3_title': 'Choose shophouse or capital',
                    'gabung.umkm_step3_desc': 'Select available shophouse locations or apply for working capital for investor review.',
                    'gabung.umkm_step4_title': 'Operate & grow',
                    'gabung.umkm_step4_desc': 'Run operations, track turnover progress, and foster healthy long-term partnerships.',
                    'gabung.umkm_cta_title': 'Time to take your business to the next level',
                    'gabung.umkm_cta_desc': 'Register your business unit now for tailored funding access and premier commercial shophouses.'
                }
            };

            const langButtons = document.querySelectorAll('.lang-btn');
            const savedLang = localStorage.getItem('daya_umkm_lang') || 'id';

            function applyLanguage(lang) {
                const currentDict = i18nDict[lang] || i18nDict['id'];
                document.documentElement.lang = lang;

                // Update text content of all elements with data-i18n
                document.querySelectorAll('[data-i18n]').forEach(el => {
                    const key = el.getAttribute('data-i18n');
                    if (currentDict[key]) {
                        if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                            el.placeholder = currentDict[key];
                        } else {
                            el.textContent = currentDict[key];
                        }
                    }
                });

                // Update input placeholders with data-i18n-placeholder
                document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                    const pKey = el.getAttribute('data-i18n-placeholder');
                    if (currentDict[pKey]) {
                        el.placeholder = currentDict[pKey];
                    }
                });

                // Update elements with data-i18n-title
                document.querySelectorAll('[data-i18n-title]').forEach(el => {
                    const tKey = el.getAttribute('data-i18n-title');
                    if (currentDict[tKey]) {
                        el.title = currentDict[tKey];
                    }
                });

                // Update active state of language buttons
                langButtons.forEach(btn => {
                    const btnLang = btn.getAttribute('data-lang');
                    if (btnLang === lang) {
                        btn.classList.add('active');
                        btn.setAttribute('aria-pressed', 'true');
                    } else {
                        btn.classList.remove('active');
                        btn.setAttribute('aria-pressed', 'false');
                    }
                });

                window.dispatchEvent(new CustomEvent('appLanguageChanged', { detail: { lang } }));
            }

            // Expose globally for instant interaction
            window.applyLanguage = applyLanguage;
            applyLanguage(savedLang);

            langButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const lang = this.getAttribute('data-lang');
                    localStorage.setItem('daya_umkm_lang', lang);
                    applyLanguage(lang);
                });
            });

            // 6. Mobile Menu Toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        })();

        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }

        // Global Auto-formatter untuk input angka / nominal dengan pemisah ribuan titik (contoh: 4.444.444)
        function initRupiahFormatters() {
            document.querySelectorAll('input.format-rupiah, input[data-format-rupiah]').forEach(input => {
                if (input.dataset.formatBound) return;
                input.dataset.formatBound = 'true';

                const targetHiddenId = input.dataset.targetHidden;
                const hiddenInput = targetHiddenId ? document.getElementById(targetHiddenId) : null;

                const formatRupiahWithDots = (val) => {
                    if (!val) return '';
                    const clean = val.toString().replace(/\D/g, '');
                    if (!clean) return '';
                    return clean.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                };

                const formatFn = () => {
                    const originalVal = input.value;
                    const cursorPosition = input.selectionStart;
                    const digitsBeforeCursor = originalVal.slice(0, cursorPosition).replace(/\D/g, '').length;
                    const rawDigits = originalVal.replace(/\D/g, '');

                    if (hiddenInput) {
                        hiddenInput.value = rawDigits;
                    }

                    const formatted = formatRupiahWithDots(rawDigits);
                    input.value = formatted;

                    if (cursorPosition !== null && document.activeElement === input) {
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
                        input.setSelectionRange(newCursorPos, newCursorPos);
                    }
                };

                input.addEventListener('input', formatFn);

                if (input.value) {
                    formatFn();
                }

                const form = input.closest('form');
                if (form) {
                    form.addEventListener('submit', () => {
                        if (hiddenInput) {
                            hiddenInput.value = input.value.replace(/\D/g, '');
                        } else {
                            input.value = input.value.replace(/\D/g, '');
                        }
                    });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', initRupiahFormatters);
    </script>

    <!-- Komponen Aksesibilitas Disabilitas -->
    @include('components.accessibility-widget')

    <!-- Komponen AI Customer Support Assistant Widget -->
    @include('components.chatbot-widget')
</body>
</html>
