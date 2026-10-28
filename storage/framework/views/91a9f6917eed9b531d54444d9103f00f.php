<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title><?php echo $__env->yieldContent('title', 'Dashboard Kreator & Influencer'); ?> - DAYA UMKM</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/favicon.png')); ?>">

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

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-dark': '#0F433C',
                        'brand-pill': '#20675D',
                        'brand-sage': '#7BAE91',
                        'brand-bg': '#F9F8F3',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F9F8F3] min-h-screen text-[#1A202C] flex">

    <!-- SIDEBAR INFLUENCER (Sesuai Desain Standar TIKUM) -->
    <aside id="sidebar-influencer" class="fixed inset-y-0 left-0 z-40 w-64 bg-[#0F433C] text-white flex flex-col justify-between transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 md:sticky md:top-0 md:h-screen md:shrink-0 overflow-y-auto shadow-2xl md:shadow-none"
           style="background-color: #0F433C !important; height: 100vh; min-height: 100vh;">
        
        <div>
            <!-- Brand Logo TIKUM -->
            <div class="px-5 pt-5 pb-1">
                <a href="<?php echo e(url('/')); ?>" class="bg-white/95 hover:bg-white px-3 py-2 rounded-xl flex items-center justify-center transition shadow-sm" title="Kembali ke Beranda TIKUM">
                    <img src="<?php echo e(asset('images/TIKUM-Logo.png')); ?>" alt="TIKUM - Titik UMKM" class="h-8 w-auto object-contain">
                </a>
            </div>

            <!-- Profil Influencer Top Left -->
            <div class="px-4 pt-4 pb-4 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="relative group cursor-pointer" onclick="openModalEditFotoProfil()" title="Klik untuk ubah foto profil">
                        <div class="user-avatar-target w-10 h-10 rounded-full bg-[#D1D5DB] text-[#0F433C] font-bold text-base flex items-center justify-center shrink-0 border-2 border-white/20 overflow-hidden">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty(Auth::user()->avatar)): ?>
                                <img src="<?php echo e(Auth::user()->avatar); ?>" alt="<?php echo e(Auth::user()->name); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <?php echo e(strtoupper(substr(Auth::user()->name ?? 'K', 0, 2))); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-[#0F433C] text-white border border-white flex items-center justify-center text-[8px] shadow group-hover:bg-[#20675D] transition" title="Ubah Foto Profil">
                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-[13px] font-bold tracking-wide text-white truncate leading-tight">
                            <?php echo e($profile->nama_panggung ?? (Auth::user()->name ?? 'KREATOR INFLUENCER')); ?>

                        </h2>
                        <p class="text-[11px] text-teal-200/70 truncate font-medium">
                            <?php echo e($profile->kategori ?? 'Kuliner'); ?> &bull; <?php echo e($profile->kota ?? 'Indonesia'); ?>

                        </p>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[9px] font-semibold uppercase tracking-[0.06em] bg-teal-500/20 text-teal-300 border border-teal-400/30 truncate max-w-full">
                            Mitra Influencer
                        </span>
                    </div>
                </div>
            </div>

            <!-- Navigation Links Influencer -->
            <?php
                $activeTab = request('tab', 'beranda');
                $activeOrdersCount = isset($activeOrders) ? $activeOrders->count() : 0;
            ?>
            <nav class="mt-5 px-3 space-y-1">
                <!-- 1. BERANDA -->
                <a href="<?php echo e(route('dashboard', ['tab' => 'beranda'])); ?>" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-[11px] font-semibold tracking-[0.08em] uppercase sidebar-link <?php echo e($activeTab === 'beranda' ? 'bg-[#20675D] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white'); ?>">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 <?php echo e($activeTab === 'beranda' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>BERANDA</span>
                    </div>
                </a>

                <!-- 2. PESANAN MASUK -->
                <a href="<?php echo e(route('dashboard', ['tab' => 'pesanan'])); ?>" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-[11px] font-semibold tracking-[0.08em] uppercase sidebar-link <?php echo e($activeTab === 'pesanan' ? 'bg-[#20675D] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white'); ?>">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 <?php echo e($activeTab === 'pesanan' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>PESANAN MASUK</span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeOrdersCount > 0): ?>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-teal-950 shadow-sm animate-pulse">
                            <?php echo e($activeOrdersCount); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </a>

                <!-- 3. RIWAYAT & ULASAN -->
                <a href="<?php echo e(route('dashboard', ['tab' => 'riwayat'])); ?>" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-[11px] font-semibold tracking-[0.08em] uppercase sidebar-link <?php echo e($activeTab === 'riwayat' ? 'bg-[#20675D] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white'); ?>">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 <?php echo e($activeTab === 'riwayat' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>RIWAYAT & ULASAN</span>
                    </div>
                </a>

                <!-- 4. PROFIL & RATE CARD -->
                <a href="<?php echo e(route('dashboard', ['tab' => 'profil'])); ?>" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-[11px] font-semibold tracking-[0.08em] uppercase sidebar-link <?php echo e($activeTab === 'profil' ? 'bg-[#20675D] text-white' : 'text-teal-100/80 hover:bg-white/[0.06] hover:text-white'); ?>">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 <?php echo e($activeTab === 'profil' ? 'text-teal-300' : 'text-teal-400/70 group-hover:text-white'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>PROFIL & RATE CARD</span>
                    </div>
                </a>
            </nav>
        </div>

        <!-- Bawah Sidebar: Aksesibilitas, Tautan Web & Keluar -->
        <div class="p-4 border-t border-white/10 space-y-2 mt-auto shrink-0 bg-[#0F433C]"
             style="background-color: #0F433C !important;">
            
            <!-- Tombol Aksesibilitas Disabilitas -->
            <button type="button" 
                    class="a11y-trigger w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-teal-200/90 hover:bg-white/[0.08] hover:text-white sidebar-link transition cursor-pointer group text-left"
                    aria-label="Aksesibilitas & Disabilitas"
                    title="Buka menu aksesibilitas disabilitas">
                <svg class="w-4 h-4 text-teal-300 group-hover:text-white transition shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM20.5 6.5C19.8 5.8 18.7 5.7 17.9 6.2L13.8 8.7C13.3 9 12.7 9.2 12 9.2C11.3 9.2 10.7 9 10.2 8.7L6.1 6.2C5.3 5.7 4.2 5.8 3.5 6.5C2.7 7.2 2.7 8.3 3.3 9.1L6.5 13.3C6.8 13.7 7 14.3 7 14.8V21C7 21.6 7.4 22 8 22H10C10.6 22 11 21.6 11 21V16H13V21C13 21.6 13.4 22 14 22H16C16.6 22 17 21.6 17 21V14.8C17 14.3 17.2 13.7 17.5 13.3L20.7 9.1C21.3 8.3 21.3 7.2 20.5 6.5Z"/>
                </svg>
                <span>Aksesibilitas</span>
            </button>

            <!-- Halaman Utama TIKUM -->
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-teal-200/80 hover:bg-white/[0.06] hover:text-white sidebar-link">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                <span>Halaman Utama</span>
            </a>

            <!-- Tombol Keluar -->
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
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
    <div id="sidebar-overlay-influencer" onclick="toggleSidebarInfluencer()" class="fixed inset-0 z-30 bg-black/50 backdrop-blur-sm hidden md:hidden"></div>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        <!-- Mobile Header Top Bar -->
        <header class="md:hidden bg-[#0F433C] text-white px-4 py-3 flex items-center justify-between shadow-sm sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebarInfluencer()" class="p-2 rounded-lg bg-white/10 hover:bg-white/20 text-white focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <a href="<?php echo e(url('/')); ?>" class="bg-white/95 px-2.5 py-1 rounded-lg flex items-center">
                    <img src="<?php echo e(asset('images/TIKUM-Logo.png')); ?>" alt="TIKUM" class="h-6 w-auto object-contain">
                </a>
            </div>
            <div class="flex items-center gap-2.5">
                <button type="button" 
                        class="a11y-trigger p-2 rounded-lg bg-white/10 hover:bg-white/20 text-white cursor-pointer transition flex items-center justify-center"
                        aria-label="Aksesibilitas & Disabilitas"
                        title="Buka menu aksesibilitas disabilitas">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM20.5 6.5C19.8 5.8 18.7 5.7 17.9 6.2L13.8 8.7C13.3 9 12.7 9.2 12 9.2C11.3 9.2 10.7 9 10.2 8.7L6.1 6.2C5.3 5.7 4.2 5.8 3.5 6.5C2.7 7.2 2.7 8.3 3.3 9.1L6.5 13.3C6.8 13.7 7 14.3 7 14.8V21C7 21.6 7.4 22 8 22H10C10.6 22 11 21.6 11 21V16H13V21C13 21.6 13.4 22 14 22H16C16.6 22 17 21.6 17 21V14.8C17 14.3 17.2 13.7 17.5 13.3L20.7 9.1C21.3 8.3 21.3 7.2 20.5 6.5Z"/>
                    </svg>
                </button>
                <div class="text-xs text-teal-200 font-semibold truncate max-w-[120px]">
                    <?php echo e($profile->nama_panggung ?? Auth::user()->name); ?>

                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 px-4 sm:px-8 py-8 lg:px-10 lg:py-10 max-w-[1280px] w-full mx-auto">
            
            <!-- Alert Flash Notifications -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-900 text-xs sm:text-sm font-semibold flex items-center justify-between shadow-sm animate-fade-in">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">
                            ✓
                        </div>
                        <div><?php echo e(session('success')); ?></div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('info')): ?>
                <div class="mb-6 p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-900 text-xs sm:text-sm font-semibold flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div><?php echo e(session('info')); ?></div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($errors) && $errors->any()): ?>
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-bold">Mohon periksa kembali formulir:</p>
                        <ul class="list-disc list-inside text-xs mt-1 space-y-0.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <li><?php echo e($err); ?></li>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <!-- Toggle Sidebar Mobile JS -->
    <script>
        function toggleSidebarInfluencer() {
            const sidebar = document.getElementById('sidebar-influencer');
            const overlay = document.getElementById('sidebar-overlay-influencer');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }
    </script>

    <!-- Komponen Modal Ubah Foto Profil -->
    <?php echo $__env->make('components.modal-edit-foto-profil', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Komponen Aksesibilitas Disabilitas -->
    <?php echo $__env->make('components.accessibility-widget', ['isDashboardLayout' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Multi-Language (i18n) Engine -->
    <script src="<?php echo e(asset('js/i18n.js')); ?>"></script>

</body>
</html>
<?php /**PATH C:\laragon\laragon\www\Titik-UMKM\resources\views/layouts/influencer.blade.php ENDPATH**/ ?>