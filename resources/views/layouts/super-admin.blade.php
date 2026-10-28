<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title', 'Super Admin Dashboard') - DAYA UMKM</title>

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
            --sidebar-hover: #19584F;
            --sidebar-active: #20675D;
            --main-bg: #F9F8F3;
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
                        'brand-sage': '#6B9E8A',
                        'brand-bg': '#F9F8F3',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F9F8F3] min-h-screen text-[#1A202C] flex">

    <!-- SIDEBAR (Dark Emerald #0F433C - Sesuai Mockup) -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-[#1B4D3E] text-white transition-transform duration-300 ease-in-out md:sticky md:top-0 md:h-screen md:shrink-0 md:translate-x-0 md:shadow-none overflow-y-auto shadow-2xl" style="background-color: #1B4D3E !important; height: 100vh; min-height: 100vh;">
        <div class="flex min-h-0 flex-1 flex-col overflow-y-auto">
            <!-- Brand Logo TIKUM -->
            <div class="px-5 pt-5 pb-1">
                <a href="{{ url('/') }}" class="bg-white/95 hover:bg-white px-3 py-2 rounded-xl flex items-center justify-center transition shadow-sm" title="Kembali ke Beranda TIKUM">
                    <img src="{{ asset('images/TIKUM-Logo.png') }}" alt="TIKUM - Titik UMKM" class="h-8 w-auto object-contain">
                </a>
            </div>

            <!-- Profil Super Admin (Mockup Top Left) -->
            <div class="px-4 pt-4 pb-4 border-b border-white/10">
                <div class="flex min-w-0 items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#D1D5DB] text-[#1B4D3E] font-bold text-base flex items-center justify-center shrink-0 border-2 border-white/20">
                        @if(!empty($user->avatar))
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                        @else
                            {{ strtoupper(substr($user->name ?? 'A', 0, 2)) }}
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-sm font-extrabold tracking-wide uppercase text-white truncate leading-tight">
                            {{ $user->name ?? 'SUPER ADMIN' }}
                        </h2>
                        <p class="text-[11px] text-teal-200/70 truncate mt-0.5 font-medium">
                            {{ $user->phone_number ?? $user->email ?? 'superadmin@dayaumkm.id' }}
                        </p>
                        @if($user->role === 'super_admin')
                            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-purple-500/20 text-purple-300 border border-purple-400/30">
                                Super Admin
                            </span>
                        @else
                            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-sky-500/20 text-sky-300 border border-sky-400/30">
                                Admin Operasional
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-5 px-3 space-y-1">
                <!-- 1. BERANDA -->
                <a href="{{ route('superadmin.dashboard') }}" 
                   class="group flex items-center justify-between min-h-11 gap-3 rounded-xl px-3.5 py-2.5 text-left text-[11px] font-semibold tracking-[0.08em] uppercase transition-colors duration-150 {{ request()->routeIs('superadmin.dashboard') ? 'bg-[#2D6A4F] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex min-w-0 items-center gap-3">
                        <svg class="w-4 h-4 {{ request()->routeIs('superadmin.dashboard') ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>BERANDA</span>
                    </div>
                </a>

                <!-- 2. PENGAJUAN UMKM (PRODUK / PROPOSAL) -->
                <a href="{{ route('superadmin.pengajuan') }}" 
                   class="group flex items-center justify-between min-h-11 gap-3 rounded-xl px-3.5 py-2.5 text-left text-[11px] font-semibold tracking-[0.08em] uppercase transition-colors duration-150 {{ request()->routeIs('superadmin.pengajuan*') ? 'bg-[#2D6A4F] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex min-w-0 items-center gap-3">
                        <svg class="w-4 h-4 {{ request()->routeIs('superadmin.pengajuan*') ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="min-w-0 flex-1 leading-snug">PENGAJUAN UMKM</span>
                    </div>
                    @php
                        $pendingBadge = \App\Models\Umkm::where('status_pengajuan', 'menunggu_verifikasi')->count();
                    @endphp
                    @if($pendingBadge > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-amber-950">
                            {{ $pendingBadge }}
                        </span>
                    @endif
                </a>

                <!-- 3. MANAJEMEN AKUN & VERIFIKASI -->
                <a href="{{ route('superadmin.users') }}" 
                   class="group flex items-center justify-between min-h-11 gap-3 rounded-xl px-3.5 py-2.5 text-left text-[11px] font-semibold tracking-[0.08em] uppercase transition-colors duration-150 {{ request()->routeIs('superadmin.users*') ? 'bg-[#2D6A4F] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex min-w-0 items-center gap-3">
                        <svg class="w-4 h-4 {{ request()->routeIs('superadmin.users*') ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="min-w-0 flex-1 leading-snug">MANAJEMEN AKUN</span>
                    </div>
                    @php
                        $totalUsersCount = \App\Models\User::count();
                    @endphp
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/10 text-teal-200">
                        {{ $totalUsersCount }}
                    </span>
                </a>

                @if(auth()->user()->role === 'super_admin')
                    <!-- 4. LOG AKTIVITAS (Khusus Super Admin) -->
                    <a href="{{ route('superadmin.logs') }}" 
                       class="group flex items-center justify-between min-h-11 gap-3 rounded-xl px-3.5 py-2.5 text-left text-[11px] font-semibold tracking-[0.08em] uppercase transition-colors duration-150 {{ request()->routeIs('superadmin.logs*') ? 'bg-[#2D6A4F] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                        <div class="flex min-w-0 items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('superadmin.logs*') ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span>LOG AKTIVITAS</span>
                        </div>
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                    </a>
                @endif

                <!-- 5. KURASI & KATALOG RUKO -->
                <a href="{{ route('superadmin.ruko') }}" 
                   class="group flex items-center justify-between min-h-11 gap-3 rounded-xl px-3.5 py-2.5 text-left text-[11px] font-semibold tracking-[0.08em] uppercase transition-colors duration-150 {{ request()->routeIs('superadmin.ruko*') ? 'bg-[#2D6A4F] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex min-w-0 items-center gap-3">
                        <svg class="w-4 h-4 {{ request()->routeIs('superadmin.ruko*') ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span class="min-w-0 flex-1 leading-snug">KURASI & RUKO</span>
                    </div>
                    @php
                        $pendingRukoBadge = \App\Models\RekomendasiRuko::where('status', 'menunggu_verifikasi')->count();
                    @endphp
                    @if($pendingRukoBadge > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-amber-950 animate-pulse">
                            {{ $pendingRukoBadge }}
                        </span>
                    @endif
                </a>

                <!-- 6. MONITORING DIVIDEN & KEPATUHAN -->
                <a href="{{ route('superadmin.dividen') }}" 
                   class="group flex items-center justify-between min-h-11 gap-3 rounded-xl px-3.5 py-2.5 text-left text-[11px] font-semibold tracking-[0.08em] uppercase transition-colors duration-150 {{ request()->routeIs('superadmin.dividen*') ? 'bg-[#2D6A4F] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex min-w-0 items-center gap-3">
                        <svg class="w-4 h-4 {{ request()->routeIs('superadmin.dividen*') ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="min-w-0 flex-1 leading-snug">MONITORING DIVIDEN</span>
                    </div>
                    @php
                        $pendingKlarifikasiBadge = \App\Models\KlarifikasiDividen::where('status', 'menunggu_tinjauan')->count();
                    @endphp
                    @if($pendingKlarifikasiBadge > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white animate-pulse">
                            {{ $pendingKlarifikasiBadge }}
                        </span>
                    @endif
                </a>
            </nav>
        </div>

        <!-- Bagian Bawah Sidebar (Akses Web & Keluar) -->
        <div class="p-4 border-t border-white/10 space-y-2 mt-auto shrink-0" style="background-color: #1B4D3E !important;">
            <button type="button" class="a11y-trigger w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-teal-200/90 hover:bg-white/[0.08] hover:text-white transition cursor-pointer group text-left" aria-label="Aksesibilitas & Disabilitas" title="Buka menu aksesibilitas disabilitas">
                <span aria-hidden="true">♿</span><span>Aksesibilitas</span>
            </button>
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-teal-200/80 hover:bg-white/[0.06] hover:text-white">
                <span aria-hidden="true">↗</span><span>Lihat Web Pengunjung</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-rose-300 hover:bg-rose-500/15 hover:text-rose-200 text-left">
                    <span aria-hidden="true">⇥</span><span>KELUAR</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay Mobile -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 z-30 bg-black/50 backdrop-blur-sm hidden md:hidden"></div>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        <!-- Top bar mobile header -->
        <header class="md:hidden bg-[#0F433C] text-white px-4 py-3 flex items-center justify-between shadow-sm sticky top-0 z-20">
            <div class="flex min-w-0 items-center gap-3">
                <button type="button" onclick="toggleSidebar()" aria-label="Buka navigasi" class="min-h-11 min-w-11 rounded-lg bg-white/10 text-white hover:bg-white/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <a href="{{ url('/') }}" class="bg-white/95 px-2.5 py-1 rounded-lg flex items-center">
                    <img src="{{ asset('images/TIKUM-Logo.png') }}" alt="TIKUM" class="h-6 w-auto object-contain">
                </a>
                <span class="font-extrabold text-xs tracking-wider uppercase text-teal-200">ADMIN</span>
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
                <div class="text-xs text-teal-200">
                    {{ $user->name }}
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 p-5 sm:p-8 md:p-10 max-w-7xl w-full mx-auto">
            
            <!-- Alert Notifikasi Flash -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-900 text-xs sm:text-sm font-semibold flex items-center justify-between shadow-sm animate-fade-in">
                    <div class="flex min-w-0 items-center gap-3">
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
                    <div class="flex min-w-0 items-center gap-3">
                        <div class="w-7 h-7 rounded-full bg-rose-500 text-white flex items-center justify-center shrink-0">
                            !
                        </div>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-900">&times;</button>
                </div>
            @endif

            <!-- Konten Halaman Spesifik -->
            @yield('content')

        </main>
    </div>

    <!-- MODAL KONFIRMASI MODERN & ELEGAN SUPER ADMIN -->
    <div id="app-custom-confirm-modal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">
        <!-- Backdrop Blur Halus -->
        <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity" onclick="closeAppConfirmModal()"></div>

        <!-- Box Modal -->
        <div class="relative w-full max-w-md bg-white rounded-3xl p-6 sm:p-7 shadow-2xl border border-gray-100 z-10 transform transition-all animate-fadeIn">
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
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // FUNGSI MODAL KONFIRMASI MODERN SUPER ADMIN
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

    <!-- Komponen Aksesibilitas Disabilitas -->
    @include('components.accessibility-widget', ['isDashboardLayout' => true])
    <!-- Multi-Language (i18n) Engine -->
    <script src="{{ asset('js/i18n.js') }}"></script>

</body>
</html>
