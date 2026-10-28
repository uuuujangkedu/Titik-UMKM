<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title', 'Dashboard Pelaku UMKM') - DAYA UMKM</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: #0F433C;
            --sidebar-active: #20675D;
            --main-bg: #F5F0E8;
            --text-dark: #1A202C;
            --card-border: #E8E6DF;
        }
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, sans-serif;
            background-color: var(--main-bg);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
        }
        .card-soft {
            background: #ffffff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 1px 2px rgba(27, 77, 62, 0.05), 0 10px 30px rgba(27, 77, 62, 0.07);
            transition: box-shadow 0.25s ease, transform 0.25s ease;
        }
        .card-soft:hover {
            box-shadow: 0 2px 4px rgba(27, 77, 62, 0.06), 0 14px 36px rgba(27, 77, 62, 0.10);
        }
        .sidebar-link {
            transition: opacity 0.2s ease, background-color 0.2s ease, color 0.2s ease;
        }
        .sidebar-link:hover {
            opacity: 0.85;
        }
    </style>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-dark': '#0F433C',
                        'brand-pill': '#20675D',
                        'brand-sage': '#7BAE91',
                        'brand-bg': '#F5F0E8',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F5F0E8] min-h-screen text-[#1A202C] flex">

    <!-- SIDEBAR UMKM (Sesuai Gambar 2: Mockup Dashboard UMKM) -->
    <aside id="sidebar-umkm" class="fixed inset-y-0 left-0 z-40 w-64 bg-[#0F433C] text-white flex flex-col justify-between transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 md:sticky md:top-0 md:h-screen md:shrink-0 overflow-y-auto shadow-2xl md:shadow-none"
           style="background-color: #0F433C !important; height: 100vh; min-height: 100vh;">
        
        <div>
            <!-- Brand Logo TIKUM -->
            <div class="px-5 pt-5 pb-1">
                <a href="{{ url('/') }}" class="bg-white/95 hover:bg-white px-3 py-2 rounded-xl flex items-center justify-center transition shadow-sm" title="Kembali ke Beranda TIKUM">
                    <img src="{{ asset('images/TIKUM-Logo.png') }}" alt="TIKUM - Titik UMKM" class="h-8 w-auto object-contain">
                </a>
            </div>

            <!-- Profil UMKM Top Left (Sesuai Gambar 2) -->
            <div class="px-4 pt-4 pb-4 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="relative group cursor-pointer" onclick="openModalEditFotoProfil()" title="Klik untuk ubah foto profil">
                        <div class="user-avatar-target w-10 h-10 rounded-full bg-[#D1D5DB] text-[#0F433C] font-bold text-base flex items-center justify-center shrink-0 border-2 border-white/20 overflow-hidden">
                            @if(!empty($user->avatar))
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                            @endif
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-[#0F433C] text-white border border-white flex items-center justify-center text-[8px] shadow group-hover:bg-[#20675D] transition" title="Ubah Foto Profil">
                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-[13px] font-bold tracking-wide text-white truncate leading-tight">
                            {{ $user->name ?? 'PELAKU UMKM' }}
                        </h2>
                        <p class="text-[11px] text-teal-200/70 truncate font-medium">
                            {{ $user->phone_number ?? '08123456789' }}
                        </p>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[9px] font-semibold uppercase tracking-[0.06em] bg-teal-500/20 text-teal-300 border border-teal-400/30 truncate max-w-full">
                            {{ $umkm->nama_usaha ?? 'Pelaku UMKM' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Navigation Links UMKM Sesuai Mockup Gambar 2 -->
            <nav class="mt-5 px-3 space-y-1">
                <!-- 1. BERANDA -->
                <a href="{{ route('dashboard', ['tab' => 'beranda']) }}" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-[11px] font-semibold tracking-[0.08em] uppercase sidebar-link {{ ($activeTab ?? 'beranda') === 'beranda' ? 'bg-[#20675D] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? 'beranda') === 'beranda' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>BERANDA</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        @if(!empty($umkm) && ($umkm->jumlah_teguran_sp ?? 0) > 0)
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-rose-600 text-white shadow animate-pulse" title="Terdapat Surat Peringatan Kepatuhan">
                                SP-{{ $umkm->jumlah_teguran_sp }}
                            </span>
                        @endif
                        @if(isset($unreadInvestasiCount) && $unreadInvestasiCount > 0)
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                            </span>
                        @endif
                    </div>
                </a>

                <!-- 2. INBOX PENDANAAN (Komunikasi & Minat Modal Investor) -->
                <a href="{{ route('dashboard', ['tab' => 'inbox']) }}" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-[11px] font-semibold tracking-[0.08em] uppercase sidebar-link {{ ($activeTab ?? '') === 'inbox' ? 'bg-[#20675D] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'inbox' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>INBOX PENDANAAN</span>
                    </div>
                    @if(isset($unreadInvestasiCount) && $unreadInvestasiCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-teal-950 shadow-sm animate-pulse">
                            {{ $unreadInvestasiCount }}
                        </span>
                    @endif
                </a>

                <!-- 3. ANALISIS KEUANGAN -->
                <a href="{{ route('dashboard', ['tab' => 'keuangan']) }}" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-[11px] font-semibold tracking-[0.08em] uppercase sidebar-link {{ ($activeTab ?? '') === 'keuangan' ? 'bg-[#20675D] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'keuangan' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>ANALISIS KEUANGAN</span>
                    </div>
                </a>

                <!-- 4. BANTUAN -->
                <a href="{{ route('dashboard', ['tab' => 'bantuan']) }}" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-[11px] font-semibold tracking-[0.08em] uppercase sidebar-link {{ ($activeTab ?? '') === 'bantuan' ? 'bg-[#20675D] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'bantuan' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 5.636l-3.536 3.536m-2.036-5.036l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>BANTUAN</span>
                    </div>
                </a>

                <!-- 5. INFORMASI RUKO -->
                <a href="{{ route('dashboard', ['tab' => 'ruko']) }}" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-[11px] font-semibold tracking-[0.08em] uppercase sidebar-link {{ ($activeTab ?? '') === 'ruko' ? 'bg-[#20675D] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'ruko' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>INFORMASI RUKO</span>
                    </div>
                </a>

                <!-- 5.5 SEWA INFLUENCER / PROMOSI -->
                <a href="{{ route('dashboard', ['tab' => 'influencer']) }}" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-[11px] font-semibold tracking-[0.08em] uppercase sidebar-link {{ ($activeTab ?? '') === 'influencer' ? 'bg-[#20675D] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'influencer' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        <span>SEWA INFLUENCER</span>
                    </div>
                </a>

                <!-- 6. PROFIL & FORMULIR PENGAJUAN -->
                <a href="{{ route('dashboard', ['tab' => 'profil']) }}" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-[11px] font-semibold tracking-[0.08em] uppercase sidebar-link {{ ($activeTab ?? '') === 'profil' ? 'bg-[#20675D] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'profil' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>EDIT PROFIL & PROPOSAL</span>
                    </div>
                </a>
            </nav>
        </div>

        <!-- Bawah Sidebar: Tautan Web & Keluar -->
        <div class="p-4 border-t border-white/10 space-y-2 mt-auto shrink-0 bg-[#0F433C]"
             style="background-color: #0F433C !important;">
            <!-- Tombol Aksesibilitas (Menu Khusus Sidebar) -->
            <button type="button" 
                    class="a11y-trigger w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-teal-200/90 hover:bg-white/[0.08] hover:text-white sidebar-link transition cursor-pointer group text-left"
                    aria-label="Aksesibilitas & Disabilitas"
                    title="Buka menu aksesibilitas disabilitas">
                <svg class="w-4 h-4 text-teal-300 group-hover:text-white transition shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM20.5 6.5C19.8 5.8 18.7 5.7 17.9 6.2L13.8 8.7C13.3 9 12.7 9.2 12 9.2C11.3 9.2 10.7 9 10.2 8.7L6.1 6.2C5.3 5.7 4.2 5.8 3.5 6.5C2.7 7.2 2.7 8.3 3.3 9.1L6.5 13.3C6.8 13.7 7 14.3 7 14.8V21C7 21.6 7.4 22 8 22H10C10.6 22 11 21.6 11 21V16H13V21C13 21.6 13.4 22 14 22H16C16.6 22 17 21.6 17 21V14.8C17 14.3 17.2 13.7 17.5 13.3L20.7 9.1C21.3 8.3 21.3 7.2 20.5 6.5Z"/>
                </svg>
                <span>Aksesibilitas</span>
            </button>

            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-teal-200/80 hover:bg-white/[0.06] hover:text-white sidebar-link">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                <span>Halaman Utama</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-rose-300 hover:bg-rose-500/15 hover:text-rose-200 sidebar-link">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    <span>KELUAR</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay Mobile -->
    <div id="sidebar-overlay-umkm" onclick="toggleSidebarUmkm()" class="fixed inset-0 z-30 bg-black/50 backdrop-blur-sm hidden md:hidden"></div>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        <!-- Mobile Header Top Bar -->
        <header class="md:hidden bg-[#0F433C] text-white px-4 py-3 flex items-center justify-between shadow-sm sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebarUmkm()" class="p-2 rounded-lg bg-white/10 hover:bg-white/20 text-white focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <a href="{{ url('/') }}" class="bg-white/95 px-2.5 py-1 rounded-lg flex items-center">
                    <img src="{{ asset('images/TIKUM-Logo.png') }}" alt="TIKUM" class="h-6 w-auto object-contain">
                </a>
            </div>
            <div class="flex items-center gap-2.5">
                <!-- Tombol Cepat Aksesibilitas di Mobile Top Bar -->
                <button type="button" 
                        class="a11y-trigger p-2 rounded-lg bg-white/10 hover:bg-white/20 text-white cursor-pointer transition flex items-center justify-center"
                        aria-label="Aksesibilitas & Disabilitas"
                        title="Buka menu aksesibilitas disabilitas">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM20.5 6.5C19.8 5.8 18.7 5.7 17.9 6.2L13.8 8.7C13.3 9 12.7 9.2 12 9.2C11.3 9.2 10.7 9 10.2 8.7L6.1 6.2C5.3 5.7 4.2 5.8 3.5 6.5C2.7 7.2 2.7 8.3 3.3 9.1L6.5 13.3C6.8 13.7 7 14.3 7 14.8V21C7 21.6 7.4 22 8 22H10C10.6 22 11 21.6 11 21V16H13V21C13 21.6 13.4 22 14 22H16C16.6 22 17 21.6 17 21V14.8C17 14.3 17.2 13.7 17.5 13.3L20.7 9.1C21.3 8.3 21.3 7.2 20.5 6.5Z"/>
                    </svg>
                </button>
                @if(!empty($umkm) && ($umkm->jumlah_teguran_sp ?? 0) > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-600 text-white animate-pulse">
                        ⚠️ SP-{{ $umkm->jumlah_teguran_sp }}
                    </span>
                @endif
                <div class="text-xs text-teal-200">
                    {{ $user->name }}
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 px-8 py-8 lg:px-10 lg:py-10 max-w-[1280px] w-full mx-auto">
            
            <!-- Alert Flash Notifications -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-900 text-xs sm:text-sm font-semibold flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">
                            ✓
                        </div>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-300 text-rose-900 text-xs sm:text-sm font-semibold flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-full bg-rose-500 text-white flex items-center justify-center shrink-0">
                            !
                        </div>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-900">&times;</button>
                </div>
            @endif

            <!-- Konten Halaman Spesifik UMKM -->
            @yield('content')

        </main>
    </div>

    <!-- MODAL KONFIRMASI MODERN & ELEGAN (PENGGANTI NATIVE BROWSER CONFIRM/ALERT) -->
    <div id="app-custom-confirm-modal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">
        <!-- Backdrop Blur Halus -->
        <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity" onclick="closeAppConfirmModal()"></div>

        <!-- Box Modal -->
        <div class="relative w-full max-w-md bg-white rounded-2xl p-6 sm:p-7 shadow-2xl z-10 transform transition-all animate-fadeIn">
            <div class="flex items-start gap-4">
                <div id="app-confirm-icon-box" class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 bg-emerald-100 text-emerald-700 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 id="app-confirm-title" class="text-base sm:text-lg font-black text-[#1A202C] leading-snug">
                        Konfirmasi Tindakan
                    </h3>
                    <div id="app-confirm-badge" class="mt-1.5 hidden">
                        <span id="app-confirm-badge-text" class="inline-block px-2.5 py-0.5 rounded-full text-xs font-black bg-teal-50 text-teal-900 border border-teal-200"></span>
                    </div>
                    <div id="app-confirm-message" class="mt-2 text-xs text-gray-600 leading-relaxed font-medium">
                        Apakah Anda yakin ingin melanjutkan tindakan ini?
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" 
                        onclick="closeAppConfirmModal()" 
                        class="px-4 py-2.5 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="button" 
                        id="app-confirm-submit-btn" 
                        class="px-5 py-2.5 rounded-xl text-xs font-extrabold shadow-md transition transform active:scale-95 bg-[#0F433C] hover:bg-[#19584F] text-white">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebarUmkm() {
            const sidebar = document.getElementById('sidebar-umkm');
            const overlay = document.getElementById('sidebar-overlay-umkm');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // FUNGSI MODAL KONFIRMASI MODERN DAYA-UMKM
        function openAppConfirmModal(config) {
            const modal = document.getElementById('app-custom-confirm-modal');
            if (!modal) return;
            
            document.getElementById('app-confirm-title').innerText = config.title || 'Konfirmasi Tindakan';
            document.getElementById('app-confirm-message').innerHTML = config.message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
            
            const badgeEl = document.getElementById('app-confirm-badge');
            const badgeText = document.getElementById('app-confirm-badge-text');
            if (config.badge) {
                badgeText.innerHTML = config.badge;
                badgeEl.classList.remove('hidden');
            } else {
                badgeEl.classList.add('hidden');
            }
            
            const iconContainer = document.getElementById('app-confirm-icon-box');
            const iconType = config.icon || 'check';
            if (iconType === 'check' || iconType === 'success') {
                iconContainer.className = 'w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 bg-emerald-100 text-emerald-700 shadow-sm';
                iconContainer.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>';
            } else if (iconType === 'danger' || iconType === 'rose') {
                iconContainer.className = 'w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 bg-rose-100 text-rose-600 shadow-sm';
                iconContainer.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
            } else {
                iconContainer.className = 'w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 bg-teal-100 text-[#0F433C] shadow-sm';
                iconContainer.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            }
            
            const submitBtn = document.getElementById('app-confirm-submit-btn');
            submitBtn.innerText = config.confirmText || 'Ya, Lanjutkan';
            submitBtn.className = 'px-5 py-2.5 rounded-xl text-xs font-black shadow-md transition transform active:scale-95 ' + 
                (config.confirmClass || 'bg-[#0F433C] hover:bg-[#19584F] text-white');
            
            submitBtn.onclick = function() {
                closeAppConfirmModal();
                if (config.form) {
                    config.form.submit();
                } else if (typeof config.onConfirm === 'function') {
                    config.onConfirm();
                }
            };
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeAppConfirmModal() {
            const modal = document.getElementById('app-custom-confirm-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }
    </script>

    <!-- Komponen Modal Ubah Foto Profil -->
    @include('components.modal-edit-foto-profil')

    <!-- Komponen Aksesibilitas Disabilitas -->
    @include('components.accessibility-widget', ['isDashboardLayout' => true])
    <!-- Multi-Language (i18n) Engine -->
    <script src="{{ asset('js/i18n.js') }}"></script>

</body>
</html>
