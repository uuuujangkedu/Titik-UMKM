<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title', 'Dashboard Mitra Investor') - DAYA UMKM</title>

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

        .print-only {
            display: none !important;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm 15mm 12mm 15mm;
            }

            html, body {
                background: #ffffff !important;
                background-color: #ffffff !important;
                color: #111827 !important;
                font-size: 10pt !important;
                line-height: 1.4 !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                display: block !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            #sidebar-investor,
            #sidebar-overlay-investor,
            header,
            footer,
            .a11y-trigger,
            #a11y-widget,
            #a11y-modal,
            #app-custom-confirm-modal,
            #modal-edit-foto-profil,
            #modal-tambah-bank,
            #modal-sponsor-ruko,
            #modal-detail-ulasan,
            #modal-lihat-struk,
            .no-print,
            .print\:hidden {
                display: none !important;
            }

            .min-h-screen,
            .flex-1 {
                min-height: auto !important;
                flex: none !important;
                display: block !important;
                width: 100% !important;
            }

            main {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            * {
                box-shadow: none !important;
                text-shadow: none !important;
            }

            .print-only {
                display: block !important;
            }

            .screen-only {
                display: none !important;
            }

            .page-break-avoid {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
            }
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

    <!-- SIDEBAR INVESTOR (Sesuai Gambar 3: Mockup Dashboard Investor) -->
    <aside id="sidebar-investor" class="fixed inset-y-0 left-0 z-40 w-72 bg-[#0F433C] text-white flex flex-col justify-between transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 md:sticky md:top-0 md:h-screen md:shrink-0 overflow-y-auto shadow-2xl md:shadow-none"
           style="background-color: #0F433C !important; height: 100vh; min-height: 100vh;">
        
        <div>
            <!-- Brand Logo TIKUM -->
            <div class="px-6 pt-6 pb-2">
                <a href="{{ url('/') }}" class="bg-white/95 hover:bg-white px-3 py-2 rounded-xl flex items-center justify-center transition shadow-sm" title="Kembali ke Beranda TIKUM">
                    <img src="{{ asset('images/TIKUM-Logo.png') }}" alt="TIKUM - Titik UMKM" class="h-8 w-auto object-contain">
                </a>
            </div>

            <!-- Profil Investor Top Left -->
            <div class="p-6 sm:p-7 border-b border-white/10">
                <div class="flex items-center gap-3.5">
                    <div class="relative group cursor-pointer" onclick="openModalEditFotoProfil()" title="Klik untuk ubah foto profil">
                        <div class="user-avatar-target w-12 h-12 rounded-full bg-[#D1D5DB] text-[#0F433C] font-black text-lg flex items-center justify-center shrink-0 shadow-inner border-2 border-white/20 overflow-hidden">
                            @if(!empty($user->avatar))
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($user->name ?? 'I', 0, 2)) }}
                            @endif
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-[#0F433C] text-white border border-white flex items-center justify-center text-[10px] shadow group-hover:bg-[#20675D] transition" title="Ubah Foto Profil">
                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-sm font-extrabold tracking-wide uppercase text-white truncate leading-tight">
                            {{ $user->name ?? 'MITRA INVESTOR' }}
                        </h2>
                        <p class="text-[11px] text-teal-200/70 truncate font-medium">
                            {{ $user->phone_number ?? $user->email }}
                        </p>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-blue-500/20 text-blue-300 border border-blue-400/30">
                            Mitra Investor
                        </span>
                    </div>
                </div>
            </div>

            <!-- Navigation Links Investor (BERANDA, PORTOFOLIO SAYA, PROPOSAL LIST, LAPORAN KEUANGAN, KOMUNITAS) -->
            <nav class="mt-8 px-4 space-y-2.5">
                <!-- 1. BERANDA -->
                <a href="{{ route('dashboard', ['tab' => 'beranda']) }}" 
                   class="group flex items-center justify-between px-4 py-3.5 rounded-2xl text-xs font-black tracking-wider uppercase transition-all duration-200 {{ ($activeTab ?? 'beranda') === 'beranda' ? 'bg-[#20675D] text-white shadow-md' : 'text-teal-100/80 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? 'beranda') === 'beranda' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>BERANDA</span>
                    </div>
                </a>

                <!-- 2. PORTOFOLIO SAYA (Fitur Baru Menu Portofolio) -->
                <a href="{{ route('dashboard', ['tab' => 'portofolio']) }}" 
                   class="group flex items-center justify-between px-4 py-3.5 rounded-2xl text-xs font-black tracking-wider uppercase transition-all duration-200 {{ ($activeTab ?? '') === 'portofolio' ? 'bg-[#20675D] text-white shadow-md' : 'text-teal-100/80 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'portofolio' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>PORTOFOLIO SAYA</span>
                    </div>
                    @if(isset($realInvestasiCount) && $realInvestasiCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-teal-300 text-teal-950">
                            {{ $realInvestasiCount }}
                        </span>
                    @endif
                </a>

                <!-- 2.5 OBROLAN KEMITRAAN (Tempat Chat & Diskusi Langsung Investor dengan UMKM) -->
                <a href="{{ route('dashboard', ['tab' => 'pesan']) }}" 
                   class="group flex items-center justify-between px-4 py-3.5 rounded-2xl text-xs font-black tracking-wider uppercase transition-all duration-200 {{ in_array(($activeTab ?? ''), ['pesan', 'inbox']) ? 'bg-[#20675D] text-white shadow-md' : 'text-teal-100/80 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ in_array(($activeTab ?? ''), ['pesan', 'inbox']) ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span>OBROLAN KEMITRAAN</span>
                    </div>
                    @if(isset($unreadInvestorChatCount) && $unreadInvestorChatCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-amber-950 animate-pulse">
                            {{ $unreadInvestorChatCount }} Baru
                        </span>
                    @endif
                </a>

                <!-- 3. PROPOSAL LIST (Fitur Inti) -->
                <a href="{{ route('dashboard', ['tab' => 'proposal']) }}" 
                   class="group flex items-center justify-between px-4 py-3.5 rounded-2xl text-xs font-black tracking-wider uppercase transition-all duration-200 {{ ($activeTab ?? '') === 'proposal' ? 'bg-[#20675D] text-white shadow-md' : 'text-teal-100/80 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'proposal' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>PROPOSAL LIST</span>
                    </div>
                    @if(isset($availableProposalsCount) && $availableProposalsCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-400 text-emerald-950">
                            {{ $availableProposalsCount }}
                        </span>
                    @endif
                </a>

                <!-- 4. KATALOG RUKO (Pilar Sewa Komersial UMKM) -->
                <a href="{{ route('dashboard', ['tab' => 'ruko']) }}" 
                   class="group flex items-center justify-between px-4 py-3.5 rounded-2xl text-xs font-black tracking-wider uppercase transition-all duration-200 {{ ($activeTab ?? '') === 'ruko' ? 'bg-[#20675D] text-white shadow-md' : 'text-teal-100/80 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'ruko' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>KATALOG RUKO</span>
                    </div>
                </a>

                <!-- 4.5 SPONSOR INFLUENCER (Pemberdayaan Promosi UMKM) -->
                <a href="{{ route('dashboard', ['tab' => 'influencer']) }}" 
                   class="group flex items-center justify-between px-4 py-3.5 rounded-2xl text-xs font-black tracking-wider uppercase transition-all duration-200 {{ ($activeTab ?? '') === 'influencer' ? 'bg-[#20675D] text-white shadow-md' : 'text-teal-100/80 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'influencer' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        <span>SPONSOR INFLUENCER</span>
                    </div>
                    @if(isset($pengajuanSponsorMasuk) && $pengajuanSponsorMasuk->count() > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-amber-950 animate-pulse">
                            {{ $pengajuanSponsorMasuk->count() }} Baru
                        </span>
                    @else
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-amber-400 text-teal-950">
                            BARU
                        </span>
                    @endif
                </a>

                <!-- 5. LAPORAN KEUANGAN & DIVIDEN -->
                <a href="{{ route('dashboard', ['tab' => 'keuangan']) }}" 
                   class="group flex items-center justify-between px-4 py-3.5 rounded-2xl text-xs font-black tracking-wider uppercase transition-all duration-200 {{ ($activeTab ?? '') === 'keuangan' ? 'bg-[#20675D] text-white shadow-md' : 'text-teal-100/80 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'keuangan' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>LAPORAN KEUANGAN</span>
                    </div>
                </a>

                <!-- 6. KALKULATOR SIMULASI INVESTASI -->
                <a href="{{ route('dashboard', ['tab' => 'kalkulator']) }}" 
                   class="group flex items-center justify-between px-4 py-3.5 rounded-2xl text-xs font-black tracking-wider uppercase transition-all duration-200 {{ ($activeTab ?? '') === 'kalkulator' ? 'bg-[#20675D] text-white shadow-md' : 'text-teal-100/80 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'kalkulator' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <span>KALKULATOR SIMULASI</span>
                    </div>
                </a>

                <!-- 7. KOMUNITAS -->
                <a href="{{ route('dashboard', ['tab' => 'komunitas']) }}" 
                   class="group flex items-center justify-between px-4 py-3.5 rounded-2xl text-xs font-black tracking-wider uppercase transition-all duration-200 {{ ($activeTab ?? '') === 'komunitas' ? 'bg-[#20675D] text-white shadow-md' : 'text-teal-100/80 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ ($activeTab ?? '') === 'komunitas' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>KOMUNITAS</span>
                    </div>
                </a>
            </nav>
        </div>

        <!-- Bagian Bawah: Tautan Web & Keluar -->
        <div class="p-4 border-t border-white/10 space-y-2 mt-auto shrink-0 bg-[#0F433C]">
            <!-- Tombol Aksesibilitas (Menu Khusus Sidebar) -->
            <button type="button" 
                    class="a11y-trigger w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold text-teal-200/90 hover:bg-white/10 hover:text-white transition cursor-pointer group text-left"
                    aria-label="Aksesibilitas & Disabilitas"
                    title="Buka menu aksesibilitas disabilitas">
                <svg class="w-4 h-4 text-teal-300 group-hover:text-white transition shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM20.5 6.5C19.8 5.8 18.7 5.7 17.9 6.2L13.8 8.7C13.3 9 12.7 9.2 12 9.2C11.3 9.2 10.7 9 10.2 8.7L6.1 6.2C5.3 5.7 4.2 5.8 3.5 6.5C2.7 7.2 2.7 8.3 3.3 9.1L6.5 13.3C6.8 13.7 7 14.3 7 14.8V21C7 21.6 7.4 22 8 22H10C10.6 22 11 21.6 11 21V16H13V21C13 21.6 13.4 22 14 22H16C16.6 22 17 21.6 17 21V14.8C17 14.3 17.2 13.7 17.5 13.3L20.7 9.1C21.3 8.3 21.3 7.2 20.5 6.5Z"/>
                </svg>
                <span>Aksesibilitas</span>
            </button>

            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold text-teal-200/80 hover:bg-white/10 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                <span>Halaman Utama</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold text-rose-300 hover:bg-rose-500/20 hover:text-rose-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    <span>KELUAR</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay Mobile -->
    <div id="sidebar-overlay-investor" onclick="toggleSidebarInvestor()" class="fixed inset-0 z-30 bg-black/50 backdrop-blur-sm hidden md:hidden"></div>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        <!-- Desktop Header Top Bar -->
        <header class="hidden md:flex bg-white border-b border-[#E8E6DF] px-8 py-4 items-center justify-between sticky top-0 z-20 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-[#0F433C]/10 text-[#0F433C]">
                    Dashboard Investor
                </span>
                <span class="text-xs text-gray-400 font-bold">&bull;</span>
                <span class="text-xs font-bold text-gray-600">
                    {{ ($activeTab ?? 'beranda') === 'portofolio' ? 'Portofolio Investasi Saya' : (($activeTab ?? 'beranda') === 'proposal' ? 'Katalog Proposal UMKM' : (($activeTab ?? 'beranda') === 'ruko' ? 'Katalog Ruko Strategis & Sewa Komersial' : (($activeTab ?? 'beranda') === 'keuangan' ? 'Laporan Keuangan & Riwayat Dividen' : (($activeTab ?? 'beranda') === 'kalkulator' ? 'Kalkulator Simulasi Investasi' : (($activeTab ?? 'beranda') === 'komunitas' ? 'Forum Komunitas Mitra' : 'Ringkasan Portofolio'))))) }}
                </span>
            </div>

            <div class="flex items-center gap-4">
                <!-- Badge Total Modal -->
                <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] text-xs">
                    <span class="text-gray-400 font-bold" data-i18n="dashboard.total_portfolio">Total Portofolio:</span>
                    <span class="font-black text-[#0F433C]">
                        Rp {{ number_format($totalModalDiinvestasikan ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                <!-- KYC Badge -->
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span data-i18n="dashboard.kyc_verified">KYC Terverifikasi</span>
                </span>
            </div>
        </header>

        <!-- Mobile Header Top Bar -->
        <header class="md:hidden bg-[#0F433C] text-white px-4 py-3 flex items-center justify-between shadow-sm sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebarInvestor()" class="p-2 rounded-lg bg-white/10 hover:bg-white/20 text-white focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <a href="{{ url('/') }}" class="bg-white/95 px-2.5 py-1 rounded-lg flex items-center">
                    <img src="{{ asset('images/TIKUM-Logo.png') }}" alt="TIKUM" class="h-6 w-auto object-contain">
                </a>
                <span class="font-extrabold text-xs tracking-wider uppercase text-teal-200">INVESTOR</span>
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

            <!-- Konten Halaman Spesifik Investor -->
            @yield('content')

        </main>
    </div>

    <!-- MODAL KONFIRMASI MODERN & ELEGAN (PENGGANTI NATIVE BROWSER CONFIRM/ALERT) -->
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
        function toggleSidebarInvestor() {
            const sidebar = document.getElementById('sidebar-investor');
            const overlay = document.getElementById('sidebar-overlay-investor');
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

    <!-- Multi-Language (i18n) Engine -->
    <script src="{{ asset('js/i18n.js') }}"></script>

    <!-- Komponen Modal Ubah Foto Profil -->
    @include('components.modal-edit-foto-profil')

    <!-- Komponen Aksesibilitas Disabilitas -->
    @include('components.accessibility-widget', ['isDashboardLayout' => true])
</body>
</html>
