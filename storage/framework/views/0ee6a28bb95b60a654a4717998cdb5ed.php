<div class="space-y-8 animate-fade-in">
    <!-- BANNER UTAMA SPONSOR INFLUENCER INVESTOR (Desain Kontras Tinggi & Mewah) -->
    <div class="rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden"
         style="background: linear-gradient(135deg, #072622 0%, #0F433C 55%, #134E44 100%); border: 1px solid #1C695E;">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-black mb-3 shadow-xs"
                     style="background: rgba(251, 191, 36, 0.18); border: 1px solid rgba(251, 191, 36, 0.6); color: #FEF08A !important;">
                    <span>🚀</span>
                    <span>AKSELERASI BISNIS & DIVIDEN UMKM</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight"
                    style="color: #ffffff !important; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                    Sponsori Influencer untuk UMKM Binaan Anda
                </h1>
                <p class="text-xs sm:text-sm mt-2 font-medium leading-relaxed"
                   style="color: #E2F1EE !important;">
                    Bantu UMKM yang Anda modali mendatangkan antrean pembeli dengan mendanai kreator & vlogger lokal. <strong style="color: #FDE047 !important;">Omzet naik = Bagi hasil (dividen) yang Anda terima semakin besar & cepat kembali modal!</strong>
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
                <a href="#katalog-sponsor-section" 
                   class="px-5 py-3 rounded-2xl text-xs font-black shadow-md transition text-center flex items-center justify-center gap-2 hover:brightness-105"
                   style="background-color: #F59E0B !important; color: #111827 !important; border: 1px solid #FBBF24;">
                    <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Sponsori Langsung</span>
                </a>
                <a href="#riwayat-sponsor-section" 
                   class="px-5 py-3 rounded-2xl text-xs font-bold transition text-center hover:bg-white/20"
                   style="background-color: rgba(255, 255, 255, 0.15) !important; border: 1px solid rgba(255, 255, 255, 0.35) !important; color: #ffffff !important;">
                    Riwayat Sponsor (<?php echo e($sponsorPromosiSaya->count()); ?>)
                </a>
                <button type="button" onclick="openModalDaftarInfluencer()"
                        class="px-5 py-3 rounded-2xl text-xs font-bold transition text-center hover:bg-emerald-500/30 flex items-center justify-center gap-1.5"
                        style="background-color: rgba(16, 185, 129, 0.22) !important; border: 1px solid rgba(52, 211, 153, 0.5) !important; color: #A7F3D0 !important;">
                    <span>✨</span>
                    <span>Daftar Jadi Influencer</span>
                </button>
            </div>
        </div>
    </div>

    <!-- NOTIFIKASI PERMINTAAN SPONSOR MASUK DARI UMKM BINAAN (FITUR SKEMA B) -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($pengajuanSponsorMasuk) && $pengajuanSponsorMasuk->isNotEmpty()): ?>
        <div class="bg-amber-50/90 border-2 border-amber-300 rounded-3xl p-6 sm:p-7 shadow-sm space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-400 text-amber-950 flex items-center justify-center font-bold text-lg shadow-sm">
                    🔔
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-black text-amber-950">
                        Permohonan Sponsor Promosi Masuk dari UMKM Binaan Anda (<?php echo e($pengajuanSponsorMasuk->count()); ?>)
                    </h2>
                    <p class="text-xs text-amber-800">
                        UMKM yang Anda danai membutuhkan dukungan dana marketing untuk menyewa kreator lokal.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pengajuanSponsorMasuk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="bg-white rounded-2xl p-5 border border-amber-200 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-mono font-bold text-gray-400">#<?php echo e($req->kode_order); ?></span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-900 border border-amber-300">
                                    Menunggu Persetujuan Anda
                                </span>
                            </div>

                            <h3 class="text-base font-black text-[#1A202C]"><?php echo e($req->nama_campaign); ?></h3>
                            <p class="text-xs font-bold text-teal-800 mt-0.5">
                                Diajukan oleh: <?php echo e($req->umkm->nama_usaha ?? 'UMKM'); ?>

                            </p>

                            <div class="p-3 bg-[#F9F8F3] rounded-xl my-3 space-y-1.5 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-500">Influencer Dipilih:</span>
                                    <span class="font-bold text-gray-900"><?php echo e($req->influencer->nama_panggung ?? 'Kreator'); ?> (<?php echo e($req->influencer->kota ?? ''); ?>)</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-500">Paket Promosi:</span>
                                    <span class="font-bold text-emerald-700"><?php echo e($req->paket_label); ?></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-500">Kebutuhan Dana Sponsor:</span>
                                    <span class="font-black text-base text-[#0F433C]">Rp <?php echo e(number_format($req->biaya, 0, ',', '.')); ?></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Brief dari UMKM:</span>
                                <p class="text-xs text-gray-700 bg-gray-50 p-2.5 rounded-xl border border-gray-100 italic">
                                    "<?php echo e(Str::limit($req->catatan_brief, 120)); ?>"
                                </p>
                            </div>
                        </div>

                        <!-- Tombol Setujui / Tolak -->
                        <div class="grid grid-cols-2 gap-2 pt-3 border-t border-gray-100">
                            <form action="<?php echo e(route('dashboard.investor.influencer.approve', $req->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                    ✓ Setujui & Danai
                                </button>
                            </form>
                            <button type="button" onclick="document.getElementById('modal-tolak-sponsor-<?php echo e($req->id); ?>').classList.remove('hidden')" 
                                    class="w-full py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                                ✕ Tolak
                            </button>
                        </div>
                    </div>

                    <!-- MODAL TOLAK PENGAJUAN SPONSOR -->
                    <div id="modal-tolak-sponsor-<?php echo e($req->id); ?>" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
                        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-xl border border-gray-100">
                            <h3 class="text-base font-black text-gray-900 mb-1">Tolak Permohonan Sponsor</h3>
                            <p class="text-xs text-gray-500 mb-4">Berikan catatan penolakan untuk UMKM <?php echo e($req->umkm->nama_usaha ?? ''); ?>.</p>
                            <form action="<?php echo e(route('dashboard.investor.influencer.reject', $req->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <textarea name="alasan_penolakan" rows="3" required placeholder="Contoh: Fokuskan anggaran ke stok bahan baku terlebih dahulu..."
                                          class="w-full p-3 rounded-xl border border-gray-200 text-xs focus:ring-[#0F433C] focus:border-[#0F433C]"></textarea>
                                <div class="flex items-center justify-end gap-2 mt-4">
                                    <button type="button" onclick="document.getElementById('modal-tolak-sponsor-<?php echo e($req->id); ?>').classList.add('hidden')" 
                                            class="px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                                    <button type="submit" class="px-5 py-2 text-xs font-bold bg-rose-600 text-white rounded-xl hover:bg-rose-700">Tolak Permohonan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- BAGIAN 2: SPONSORI LANGSUNG (SKEMA A - Inisiatif Investor) -->
    <div id="katalog-sponsor-section" class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-black text-[#1A202C]">Pilih Kreator untuk Disponsori (Inisiatif Investor)</h2>
                <p class="text-xs text-gray-500">Pilih influencer lokal, tentukan UMKM binaan yang ingin Anda bantu promosinya, dan bayarkan jasanya langsung.</p>
            </div>
        </div>

        <!-- Grid Influencer untuk Investor -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $influencerList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-lg transition flex flex-col justify-between">
                    <div>
                        <!-- Header Kartu -->
                        <div class="flex items-start gap-4 mb-4">
                            <img src="<?php echo e($inf->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($inf->nama_panggung).'&background=0F433C&color=fff'); ?>" 
                                 alt="<?php echo e($inf->nama_panggung); ?>" 
                                 class="w-16 h-16 rounded-2xl object-cover border border-emerald-400/60 shadow-sm shrink-0">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-1.5">
                                    <h3 class="text-base font-black text-[#1A202C] truncate"><?php echo e($inf->nama_panggung); ?></h3>
                                    <span class="text-emerald-600">✓</span>
                                </div>
                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <?php echo e($inf->kategori); ?>

                                </span>
                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <span><?php echo e($inf->kota); ?></span>
                                </p>
                            </div>
                        </div>

                        <!-- Bio -->
                        <p class="text-xs text-gray-600 line-clamp-3 mb-4 leading-relaxed italic">
                            "<?php echo e($inf->bio ?? 'Kreator lokal siap membantu memperluas pasar UMKM binaan Anda.'); ?>"
                        </p>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-2 p-3 bg-[#F9F8F3] rounded-2xl mb-4 text-xs">
                            <div>
                                <span class="text-[10px] text-gray-400 font-bold uppercase block">Followers</span>
                                <span class="font-black text-[#1A202C]"><?php echo e(number_format($inf->followers_count, 0, ',', '.')); ?></span>
                            </div>
                            <div class="cursor-pointer hover:bg-amber-100/70 p-1 -m-1 rounded-xl transition group"
                                 onclick="openInfluencerReviewsModal('<?php echo e($inf->id); ?>', '<?php echo e(addslashes($inf->nama_panggung)); ?>', '<?php echo e(number_format($inf->average_rating, 1)); ?>', '<?php echo e($inf->total_reviews); ?>')"
                                 title="Klik untuk melihat ulasan mitra">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] text-gray-400 font-bold uppercase block">Rating</span>
                                    <span class="text-[9px] text-[#0F433C] font-extrabold group-hover:underline">Lihat &rarr;</span>
                                </div>
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="font-black text-amber-600">★ <?php echo e(number_format($inf->average_rating, 1)); ?></span>
                                    <span class="text-[10px] text-gray-500 font-medium">(<?php echo e($inf->total_reviews); ?> ulasan)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Rates -->
                        <div class="space-y-1.5 text-xs border-t border-gray-100 pt-3 mb-4">
                            <div class="flex items-center justify-between text-gray-600">
                                <span>Story IG 24 Jam:</span>
                                <span class="font-bold text-gray-900">Rp <?php echo e(number_format($inf->rate_story, 0, ',', '.')); ?></span>
                            </div>
                            <div class="flex items-center justify-between text-gray-600">
                                <span>TikTok / Reels Review:</span>
                                <span class="font-bold text-[#0F433C]">Rp <?php echo e(number_format($inf->rate_reels_tiktok, 0, ',', '.')); ?></span>
                            </div>
                            <div class="flex items-center justify-between text-gray-600">
                                <span>Visit Toko / Ruko:</span>
                                <span class="font-bold text-[#0F433C]">Rp <?php echo e(number_format($inf->rate_visit_store, 0, ',', '.')); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Review & Sponsori Modal -->
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                onclick="openInfluencerReviewsModal('<?php echo e($inf->id); ?>', '<?php echo e(addslashes($inf->nama_panggung)); ?>', '<?php echo e(number_format($inf->average_rating, 1)); ?>', '<?php echo e($inf->total_reviews); ?>')"
                                class="px-3.5 py-3 bg-[#EFF5F1] hover:bg-[#DCEEE5] text-[#0F433C] border border-[#b2d5cc] text-xs font-bold rounded-2xl transition flex items-center justify-center gap-1.5 cursor-pointer shrink-0"
                                title="Lihat review ulasan untuk <?php echo e($inf->nama_panggung); ?>">
                            <span class="text-amber-500 text-sm">★</span>
                            <span>Review (<?php echo e($inf->total_reviews); ?>)</span>
                        </button>
                        <button type="button" 
                                onclick="openInvestorSponsorModal('<?php echo e($inf->id); ?>', '<?php echo e($inf->nama_panggung); ?>', '<?php echo e($inf->kota); ?>', '<?php echo e($inf->rate_story); ?>', '<?php echo e($inf->rate_reels_tiktok); ?>', '<?php echo e($inf->rate_visit_store); ?>')"
                                class="flex-1 py-3 bg-[#0F433C] hover:bg-[#1A5C52] text-white text-xs font-bold rounded-2xl transition shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Sponsori untuk UMKM Binaan</span>
                        </button>
                    </div>

                    <!-- Template Review Kreator untuk Modal -->
                    <template id="influencer-reviews-tmpl-<?php echo e($inf->id); ?>">
                        <div class="space-y-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_2 = true; $__currentLoopData = $inf->reviewedOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div class="p-4 rounded-2xl bg-[#F8F6F0] border border-[#E8E6DF] space-y-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-full bg-[#0F433C] text-white flex items-center justify-center font-bold text-xs shrink-0">
                                                <?php echo e(strtoupper(substr($rev->umkm->nama_usaha ?? ($rev->pemesan->name ?? 'M'), 0, 1))); ?>

                                            </div>
                                            <div>
                                                <div class="flex items-center gap-1.5 flex-wrap">
                                                    <span class="text-xs font-bold text-gray-900">
                                                        <?php echo e($rev->umkm->nama_usaha ?? ($rev->pemesan->name ?? 'Mitra Usaha')); ?>

                                                    </span>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rev->investor_id): ?>
                                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-blue-100 text-blue-800 border border-blue-200">
                                                            🤝 Disponsori Investor
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                            ✓ Mitra UMKM
                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                                <span class="text-[10px] text-gray-400 font-medium">
                                                    Order #<?php echo e($rev->kode_order); ?> &bull; <?php echo e($rev->updated_at ? $rev->updated_at->format('d M Y') : '-'); ?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1 text-amber-500 font-black text-xs bg-white px-2.5 py-1 rounded-xl border border-gray-100 shadow-xs shrink-0">
                                            <span>★</span>
                                            <span><?php echo e($rev->rating); ?>.0</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between gap-2 text-[10px]">
                                        <span class="px-2 py-0.5 rounded-lg bg-white text-gray-600 border border-gray-200 font-semibold">
                                            Paket: <strong class="text-[#0F433C]"><?php echo e($rev->paket_label); ?></strong>
                                        </span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rev->link_bukti_konten): ?>
                                            <a href="<?php echo e($rev->link_bukti_konten); ?>" target="_blank" rel="noopener noreferrer" 
                                               class="text-[#0F433C] hover:underline font-bold inline-flex items-center gap-0.5">
                                                <span>Lihat Video Konten</span> &rarr;
                                            </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <div class="p-3 rounded-xl bg-white border border-gray-100 text-xs text-gray-700 italic">
                                        "<?php echo e($rev->ulasan); ?>"
                                    </div>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <div class="p-8 text-center text-xs text-gray-400">
                                    <span class="text-3xl block mb-2">⭐</span>
                                    <p class="font-bold text-gray-700 mb-1">Belum Ada Ulasan Masuk</p>
                                    <p>Kreator ini belum memiliki ulasan dari pesanan sebelumnya. Jadilah mitra pertama yang bekerja sama!</p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </template>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="col-span-3 bg-white rounded-3xl p-12 text-center text-gray-400 text-sm">
                    Belum ada kreator terdaftar.
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- BAGIAN 3: RIWAYAT SEMUA PROMOSI YANG DISPONSORI INVESTOR -->
    <div id="riwayat-sponsor-section" class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E8E6DF] shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div>
                <h2 class="text-lg font-black text-[#1A202C]">Riwayat Kampanye yang Saya Sponsori</h2>
                <p class="text-xs text-gray-500">Lihat hasil karya kreator dan dampaknya bagi UMKM binaan Anda.</p>
            </div>
            <span class="text-xs font-bold text-gray-400"><?php echo e($sponsorPromosiSaya->count()); ?> Kampanye</span>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sponsorPromosiSaya->isEmpty()): ?>
            <div class="p-8 text-center text-gray-400 text-xs">
                Anda belum pernah mensponsori promosi influencer untuk UMKM. Mulai dukung promosi UMKM binaan Anda melalui katalog di atas!
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sponsorPromosiSaya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="p-5 rounded-2xl border border-gray-100 bg-[#F9F8F3] hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <div>
                                    <span class="text-[11px] font-mono font-bold text-gray-400">#<?php echo e($order->kode_order); ?></span>
                                    <h3 class="text-sm font-black text-[#1A202C] mt-0.5"><?php echo e($order->nama_campaign); ?></h3>
                                </div>
                                <?php $badge = $order->status_badge; ?>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold 
                                    <?php echo e($order->status === 'menunggu_respon_influencer' ? 'bg-blue-100 text-blue-900' : ''); ?>

                                    <?php echo e($order->status === 'menunggu_pembayaran_escrow' ? 'bg-amber-100 text-amber-900 border border-amber-300 animate-pulse' : ''); ?>

                                    <?php echo e($order->status === 'sedang_dikerjakan' ? 'bg-purple-100 text-purple-900' : ''); ?>

                                    <?php echo e($order->status === 'menunggu_verifikasi' ? 'bg-orange-100 text-orange-900 animate-pulse' : ''); ?>

                                    <?php echo e($order->status === 'selesai' ? 'bg-emerald-100 text-emerald-900' : ''); ?>

                                    <?php echo e(str_contains($order->status, 'ditolak') ? 'bg-rose-100 text-rose-900' : ''); ?>">
                                    <?php echo e($badge['label']); ?>

                                </span>
                            </div>

                            <div class="space-y-1 text-xs text-gray-600 mb-3">
                                <div class="flex items-center justify-between">
                                    <span>UMKM Penerima Sponsor:</span>
                                    <span class="font-bold text-[#0F433C]"><?php echo e($order->umkm->nama_usaha ?? 'UMKM'); ?></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Influencer Pelaksana:</span>
                                    <span class="font-semibold text-gray-800"><?php echo e($order->influencer->nama_panggung ?? 'Kreator'); ?></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Dana Sponsor:</span>
                                    <span class="font-black text-sm text-[#0F433C]">Rp <?php echo e(number_format($order->biaya, 0, ',', '.')); ?></span>
                                </div>
                            </div>

                            <!-- Box Status Pembayaran Escrow -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status_pembayaran !== 'lunas_escrow' && in_array($order->status, ['menunggu_pembayaran_escrow', 'menunggu_respon_influencer'])): ?>
                                <div class="p-4 rounded-2xl my-2 space-y-3 border"
                                     style="background-color: <?php echo e($order->status === 'menunggu_pembayaran_escrow' ? '#FFFBEB' : '#F0FDF4'); ?> !important; border-color: <?php echo e($order->status === 'menunggu_pembayaran_escrow' ? '#FCD34D' : '#86EFAC'); ?> !important;">
                                    <div class="flex items-start gap-2.5">
                                        <div class="w-7 h-7 rounded-lg text-white flex items-center justify-center text-xs shrink-0 shadow-xs font-bold"
                                             style="background-color: <?php echo e($order->status === 'menunggu_pembayaran_escrow' ? '#D97706' : '#0F433C'); ?> !important;">
                                            <?php echo e($order->status === 'menunggu_pembayaran_escrow' ? '⚡' : '💳'); ?>

                                        </div>
                                        <div class="text-[11px] leading-snug"
                                             style="color: <?php echo e($order->status === 'menunggu_pembayaran_escrow' ? '#78350F' : '#064E3B'); ?> !important;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'menunggu_pembayaran_escrow'): ?>
                                                <strong>Kreator Telah Menyetujui!</strong> Silakan setor dana sponsor sebesar <strong>Rp <?php echo e(number_format($order->biaya, 0, ',', '.')); ?></strong> ke Rekber Titik-UMKM agar kreator dapat segera memproduksi konten promosi.
                                            <?php else: ?>
                                                <strong>Tawaran Sponsor Terkirim ke Kreator:</strong> Sedang ditinjau oleh <?php echo e($order->influencer->nama_panggung ?? 'Kreator'); ?>. Anda dapat <strong>langsung menyetorkan dana sponsor ke Rekber Escrow sekarang</strong> agar produksi langsung berjalan saat kreator konfirmasi.
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <button type="button" onclick="openModalBayarEscrowInvestor('<?php echo e($order->id); ?>', '<?php echo e($order->kode_order); ?>', '<?php echo e($order->influencer->nama_panggung ?? 'Kreator'); ?>', '<?php echo e((int)$order->biaya); ?>')"
                                            class="w-full py-2.5 rounded-xl shadow-md transition flex items-center justify-center gap-2 cursor-pointer hover:opacity-90 active:scale-[0.99]"
                                            style="background: <?php echo e($order->status === 'menunggu_pembayaran_escrow' ? 'linear-gradient(135deg, #D97706 0%, #B45309 100%)' : 'linear-gradient(135deg, #0F433C 0%, #165E54 100%)'); ?> !important; color: #FFFFFF !important; border: 1px solid <?php echo e($order->status === 'menunggu_pembayaran_escrow' ? '#D97706' : '#0F433C'); ?> !important;">
                                        <svg class="w-4 h-4 shrink-0" style="color: #FFFFFF !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                        <span style="color: #FFFFFF !important; font-weight: 800; font-size: 13px; text-shadow: 0 1px 2px rgba(0,0,0,0.25);">Setor Dana Sponsor &amp; Unggah Bukti (Escrow)</span>
                                    </button>
                                </div>
                            <?php elseif($order->status_pembayaran === 'lunas_escrow'): ?>
                                <div class="p-3 bg-emerald-50/90 border border-emerald-300 rounded-2xl my-2 text-xs flex items-center justify-between gap-2 shadow-xs">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0 animate-pulse"></span>
                                        <div class="truncate text-[11px]">
                                            <span class="font-extrabold text-emerald-950 block">✓ Dana Sponsor Diamankan di Rekber Escrow</span>
                                            <span class="text-emerald-800 text-[10px]">Via Bank <?php echo e($order->bank_pengirim ?? '-'); ?> &bull; Rp <?php echo e(number_format($order->biaya, 0, ',', '.')); ?></span>
                                        </div>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->bukti_transfer_pemesan): ?>
                                        <a href="<?php echo e($order->bukti_transfer_pemesan_url); ?>" target="_blank" rel="noopener noreferrer"
                                           class="px-2.5 py-1.5 bg-white hover:bg-emerald-100 border border-emerald-300 text-[11px] font-bold text-emerald-800 rounded-xl shrink-0 flex items-center gap-1 transition shadow-2xs">
                                            <span>Lihat Bukti</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <!-- Link Video Hasil Konten -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->link_bukti_konten): ?>
                                <div class="p-3 bg-white rounded-xl border border-emerald-200 my-2">
                                    <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block mb-1">Video Konten yang Diposting:</span>
                                    <a href="<?php echo e($order->link_bukti_konten); ?>" target="_blank" rel="noopener noreferrer" 
                                       class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0F433C] hover:underline">
                                        <span>▶ Tonton Hasil Video di Medsos</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->rating): ?>
                                <div class="p-2.5 bg-amber-50 rounded-xl border border-amber-200 text-xs">
                                    <span class="font-bold text-amber-600">Rating: ★ <?php echo e($order->rating); ?>.0</span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->ulasan): ?>
                                        <p class="text-gray-600 italic mt-0.5">"<?php echo e($order->ulasan); ?>"</p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- Verifikasi selesai oleh investor jika status menunggu_verifikasi -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'menunggu_verifikasi'): ?>
                            <div class="pt-3 border-t border-gray-200 mt-2">
                                <button type="button" onclick="openModalReviewInvestorOrder('<?php echo e($order->id); ?>', '<?php echo e($order->kode_order); ?>', '<?php echo e($order->influencer->nama_panggung ?? ''); ?>')"
                                        class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                    ✓ Konfirmasi Tayang & Nilai Kreator
                                </button>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL SPONSORI LANGSUNG OLEH INVESTOR                                     -->
<!-- ========================================================================= -->
<div id="modal-investor-sponsor-influencer" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-5">
            <div>
                <h3 class="text-lg font-black text-[#1A202C]">Sponsori Promosi Influencer</h3>
                <p class="text-xs text-gray-500">Tentukan UMKM binaan yang ingin Anda bantu promosinya.</p>
            </div>
            <button type="button" onclick="closeInvestorSponsorModal()" class="text-gray-400 hover:text-gray-600 font-bold text-lg">✕</button>
        </div>

        <form action="<?php echo e(route('dashboard.investor.influencer.sponsor-langsung')); ?>" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="influencer_id" id="inv_sponsor_influencer_id">

            <!-- Target Influencer Card Preview -->
            <div class="p-3.5 bg-emerald-50/70 border border-emerald-200/80 rounded-2xl flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-emerald-800 font-bold uppercase tracking-wider block">Kreator Terpilih:</span>
                    <span id="inv_sponsor_influencer_nama" class="font-black text-[#0F433C] text-sm">Nama Kreator</span>
                    <span id="inv_sponsor_influencer_kota" class="text-xs text-gray-500 block">Kota</span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-gray-500 block">Biaya Sponsor</span>
                    <span id="inv_sponsor_preview_harga" class="text-base font-black text-[#0F433C]">Rp 0</span>
                </div>
            </div>

            <!-- Pilih UMKM Binaan yang Ingin Disponsori -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Pilih UMKM Binaan yang Menerima Sponsor *</label>
                <select name="umkm_id" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-gray-200 font-semibold text-gray-800 focus:ring-[#0F433C]">
                    <option value="">-- Pilih UMKM Binaan Anda --</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($mitraUmkmTersedia)): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $mitraUmkmTersedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($u->id_umkm); ?>"><?php echo e($u->nama_usaha); ?> (<?php echo e($u->jenis_usaha); ?> - <?php echo e($u->kota ?? 'Lokal'); ?>)</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>

            <!-- Pilih Paket Promosi -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Pilih Paket Konten Promosi *</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                    <label class="flex items-start gap-2.5 p-3 rounded-xl border border-gray-200 hover:border-[#0F433C] cursor-pointer bg-white">
                        <input type="radio" name="paket_konten" value="story" onchange="updateInvestorSponsorPrice()" class="mt-0.5 text-[#0F433C] focus:ring-[#0F433C]">
                        <div>
                            <span class="font-bold text-gray-900 block">Instagram Story</span>
                            <span id="inv_price_label_story" class="text-[11px] text-emerald-700 font-semibold block">Rp 0</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-2.5 p-3 rounded-xl border border-gray-200 hover:border-[#0F433C] cursor-pointer bg-white">
                        <input type="radio" name="paket_konten" value="reels_tiktok" checked onchange="updateInvestorSponsorPrice()" class="mt-0.5 text-[#0F433C] focus:ring-[#0F433C]">
                        <div>
                            <span class="font-bold text-gray-900 block">TikTok / Reels Video</span>
                            <span id="inv_price_label_reels" class="text-[11px] text-emerald-700 font-semibold block">Rp 0</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-2.5 p-3 rounded-xl border border-gray-200 hover:border-[#0F433C] cursor-pointer bg-white">
                        <input type="radio" name="paket_konten" value="visit_store" onchange="updateInvestorSponsorPrice()" class="mt-0.5 text-[#0F433C] focus:ring-[#0F433C]">
                        <div>
                            <span class="font-bold text-gray-900 block">Visit Toko / Ruko</span>
                            <span id="inv_price_label_visit" class="text-[11px] text-emerald-700 font-semibold block">Rp 0</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-2.5 p-3 rounded-xl border border-gray-200 hover:border-[#0F433C] cursor-pointer bg-white">
                        <input type="radio" name="paket_konten" value="paket_komplit" onchange="updateInvestorSponsorPrice()" class="mt-0.5 text-[#0F433C] focus:ring-[#0F433C]">
                        <div>
                            <span class="font-bold text-gray-900 block">Paket Komplit (Visit + Video)</span>
                            <span id="inv_price_label_komplit" class="text-[11px] text-emerald-700 font-semibold block">Rp 0</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Nama Campaign & Catatan Sponsor -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Judul Kampanye Promosi *</label>
                <input type="text" name="nama_campaign" required placeholder="Contoh: Sponsor Pemasaran Digital - Akselerasi Penjualan UMKM"
                       class="w-full px-3.5 py-2 text-xs rounded-xl border border-gray-200 focus:ring-[#0F433C]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Pesan & Arahan untuk Kreator *</label>
                <textarea name="catatan_brief" rows="3" required placeholder="Sampaikan poin penting yang harus disorot untuk UMKM binaan ini..."
                          class="w-full p-3 text-xs rounded-xl border border-gray-200 focus:ring-[#0F433C]"></textarea>
            </div>

            <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-2xl text-xs text-emerald-900">
                <strong>Catatan Investor:</strong> Dana sponsor akan ditahan dengan aman oleh sistem TIKUM dan baru dicairkan ke kreator setelah Anda memverifikasi link konten video yang diunggah.
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeInvestorSponsorModal()" class="px-5 py-2.5 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-6 py-2.5 text-xs font-bold bg-[#0F433C] text-white rounded-xl hover:bg-[#1A5C52] shadow-sm">
                    Konfirmasi & Salurkan Sponsor
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL REVIEW INVESTOR -->
<div id="modal-review-investor-order" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-gray-100">
        <h3 class="text-base font-black text-[#1A202C] mb-1">Konfirmasi & Ulasan Kreator</h3>
        <p class="text-xs text-gray-500 mb-4" id="inv_review_order_subtitle">Order #</p>

        <form id="form-review-investor-order" action="" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Rating Kreator (1 - 5 Bintang) *</label>
                <select name="rating" required class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 font-bold text-amber-600">
                    <option value="5">★★★★★ (5.0 - Sangat Memuaskan)</option>
                    <option value="4">★★★★☆ (4.0 - Bagus)</option>
                    <option value="3">★★★☆☆ (3.0 - Cukup)</option>
                    <option value="2">★★☆☆☆ (2.0 - Kurang)</option>
                    <option value="1">★☆☆☆☆ (1.0 - Buruk)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Feedback Anda untuk Kreator</label>
                <textarea name="ulasan" rows="3" placeholder="Tuliskan testimoni mengenai hasil video dan engagement konten..." 
                          class="w-full p-3 text-xs rounded-xl border border-gray-200"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('modal-review-investor-order').classList.add('hidden')" class="px-4 py-2 text-xs font-bold text-gray-600">Batal</button>
                <button type="submit" class="px-5 py-2 text-xs font-bold bg-[#0F433C] text-white rounded-xl hover:bg-[#1A5C52]">Selesaikan & Beri Ulasan</button>
            </div>
        </form>
    </div>
</div>

<script>
    let invCurrentRates = { story: 0, reels: 0, visit: 0 };

    function openInvestorSponsorModal(id, nama, kota, rateStory, rateReels, rateVisit) {
        document.getElementById('inv_sponsor_influencer_id').value = id;
        document.getElementById('inv_sponsor_influencer_nama').innerText = nama;
        document.getElementById('inv_sponsor_influencer_kota').innerText = kota;

        invCurrentRates.story = parseFloat(rateStory) || 0;
        invCurrentRates.reels = parseFloat(rateReels) || 0;
        invCurrentRates.visit = parseFloat(rateVisit) || 0;

        document.getElementById('inv_price_label_story').innerText = 'Rp ' + Number(invCurrentRates.story).toLocaleString('id-ID');
        document.getElementById('inv_price_label_reels').innerText = 'Rp ' + Number(invCurrentRates.reels).toLocaleString('id-ID');
        document.getElementById('inv_price_label_visit').innerText = 'Rp ' + Number(invCurrentRates.visit).toLocaleString('id-ID');
        document.getElementById('inv_price_label_komplit').innerText = 'Rp ' + Number(invCurrentRates.reels + invCurrentRates.visit).toLocaleString('id-ID');

        updateInvestorSponsorPrice();
        document.getElementById('modal-investor-sponsor-influencer').classList.remove('hidden');
    }

    function closeInvestorSponsorModal() {
        document.getElementById('modal-investor-sponsor-influencer').classList.add('hidden');
    }

    function updateInvestorSponsorPrice() {
        const selected = document.querySelector('#modal-investor-sponsor-influencer input[name="paket_konten"]:checked')?.value || 'reels_tiktok';
        let harga = invCurrentRates.reels;
        if (selected === 'story') harga = invCurrentRates.story;
        if (selected === 'visit_store') harga = invCurrentRates.visit;
        if (selected === 'paket_komplit') harga = invCurrentRates.reels + invCurrentRates.visit;

        document.getElementById('inv_sponsor_preview_harga').innerText = 'Rp ' + Number(harga).toLocaleString('id-ID');
    }

    function openModalReviewInvestorOrder(orderId, kodeOrder, influencerName) {
        const form = document.getElementById('form-review-investor-order');
        form.action = "/dashboard/influencer/order/" + orderId + "/selesai";
        document.getElementById('inv_review_order_subtitle').innerText = "Order #" + kodeOrder + " • Kreator: " + influencerName;
        document.getElementById('modal-review-investor-order').classList.remove('hidden');
    }

    function openModalBayarEscrowInvestor(orderId, kodeOrder, influencerName, biaya) {
        const form = document.getElementById('form-bayar-escrow-investor');
        form.action = "/dashboard/influencer/order/" + orderId + "/bayar-escrow";
        document.getElementById('inv_escrow_modal_subtitle').innerText = "Order #" + kodeOrder + " • Kreator: " + influencerName;
        document.getElementById('inv_escrow_modal_biaya').innerText = "Rp " + Number(biaya).toLocaleString('id-ID');
        document.getElementById('modal-bayar-escrow-investor').classList.remove('hidden');
    }

    function closeModalBayarEscrowInvestor() {
        document.getElementById('modal-bayar-escrow-investor').classList.add('hidden');
    }

    function openInfluencerReviewsModal(influencerId, namaPanggung, avgRating, totalReviews) {
        document.getElementById('influencer-reviews-modal-title').innerText = 'Ulasan ' + namaPanggung;
        document.getElementById('influencer-reviews-modal-score').innerText = '★ ' + avgRating + ' / 5.0';
        document.getElementById('influencer-reviews-modal-count').innerText = totalReviews + ' Ulasan Mitra Terverifikasi';
        
        const tmpl = document.getElementById('influencer-reviews-tmpl-' + influencerId);
        const container = document.getElementById('influencer-reviews-modal-body');
        if (tmpl && container) {
            container.innerHTML = tmpl.innerHTML;
        } else if (container) {
            container.innerHTML = '<div class="p-8 text-center text-xs text-gray-400">Belum ada ulasan untuk kreator ini.</div>';
        }
        const modal = document.getElementById('modal-influencer-reviews-list');
        if (modal) {
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }
    }

    function closeInfluencerReviewsModal() {
        const modal = document.getElementById('modal-influencer-reviews-list');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
    }
</script>

<!-- MODAL BAYAR ESCROW INVESTOR -->
<div id="modal-bayar-escrow-investor" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-[#E8E6DF] my-8 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-[#E8E6DF] mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#1A202C]">Penyetoran Dana Sponsor (Escrow)</h3>
                    <p id="inv_escrow_modal_subtitle" class="text-xs text-gray-500">Order #INF-XXXX &bull; Kreator: -</p>
                </div>
            </div>
            <button type="button" onclick="closeModalBayarEscrowInvestor()" class="text-gray-400 hover:text-gray-600 text-lg">✕</button>
        </div>

        <form id="form-bayar-escrow-investor" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php echo csrf_field(); ?>

            <!-- Total Biaya Tagihan -->
            <div class="p-3.5 bg-gradient-to-r from-[#EFF5F1] to-[#E3EFE8] rounded-2xl border border-emerald-200 flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-gray-600 block">Total Dana Sponsor yang Disetorkan</span>
                    <span id="inv_escrow_modal_biaya" class="text-xl font-black text-[#0F433C]">Rp 0</span>
                </div>
                <span class="px-2.5 py-1 text-[10px] font-extrabold bg-emerald-800 text-white rounded-lg shadow-xs">Rekber Resmi</span>
            </div>

            <!-- Rekening Resmi Platform Titik UMKM -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-700">Rekening Resmi Rekber Titik-UMKM:</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                    <div class="p-2.5 bg-gray-50 border border-gray-200 rounded-xl space-y-0.5">
                        <div class="flex items-center justify-between font-bold text-gray-900">
                            <span>Bank BCA</span>
                            <span class="text-[10px] bg-blue-100 text-blue-800 px-1.5 py-0.5 rounded font-bold">BCA</span>
                        </div>
                        <div class="font-mono font-bold text-emerald-800 select-all">8735-0921-22</div>
                        <div class="text-[10px] text-gray-500">a.n PT Titik UMKM Indonesia</div>
                    </div>

                    <div class="p-2.5 bg-gray-50 border border-gray-200 rounded-xl space-y-0.5">
                        <div class="flex items-center justify-between font-bold text-gray-900">
                            <span>Bank Mandiri</span>
                            <span class="text-[10px] bg-amber-100 text-amber-800 px-1.5 py-0.5 rounded font-bold">Mandiri</span>
                        </div>
                        <div class="font-mono font-bold text-emerald-800 select-all">142-00-1928374-1</div>
                        <div class="text-[10px] text-gray-500">a.n PT Titik UMKM Indonesia</div>
                    </div>
                </div>
            </div>

            <!-- Formulir Konfirmasi Transfer -->
            <div class="pt-2 border-t border-gray-100 space-y-3">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Bank Pengirim Anda *</label>
                        <select name="bank_pengirim" required class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-xl text-xs px-3 py-2.5 focus:border-[#0b5a4a] focus:bg-white font-semibold">
                            <option value="">-- Pilih Bank --</option>
                            <option value="BCA">BCA (Bank Central Asia)</option>
                            <option value="Mandiri">Bank Mandiri</option>
                            <option value="BRI">Bank BRI</option>
                            <option value="BNI">Bank BNI</option>
                            <option value="BSI">BSI (Bank Syariah Indonesia)</option>
                            <option value="Bank Jatim">Bank Jatim</option>
                            <option value="CIMB Niaga">CIMB Niaga</option>
                            <option value="Lainnya">Bank Lainnya / E-Wallet</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Pemilik Rekening *</label>
                        <input type="text" name="nama_pengirim" required placeholder="Nama di rekening Anda"
                               class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-xl text-xs px-3 py-2.5 focus:border-[#0b5a4a] focus:bg-white">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Unggah Foto Struk Bukti Transfer *</label>
                    <input type="file" name="bukti_transfer" required accept="image/*"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-xl text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0F433C] file:text-white cursor-pointer">
                    <span class="text-[10px] text-gray-400 mt-1 block">Format: JPG, PNG, atau WEBP. Maksimal 5MB.</span>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#E8E6DF]">
                <button type="button" onclick="closeModalBayarEscrowInvestor()" class="px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold bg-[#0F433C] hover:bg-[#19584F] text-white rounded-xl shadow-sm flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Kirim Bukti Setoran Sponsor</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL DAFTAR ULASAN / REVIEW INFLUENCER -->
<div id="modal-influencer-reviews-list" onclick="if(event.target === this) closeInfluencerReviewsModal()" class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-gray-100 animate-scale-up max-h-[85vh] flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-xl shrink-0">
                        ⭐
                    </div>
                    <div>
                        <h3 class="text-base font-black text-[#1A202C]" id="influencer-reviews-modal-title">Ulasan Kreator</h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Rating Rata-rata: <strong id="influencer-reviews-modal-score" class="text-amber-600 font-black"></strong> &bull; <span id="influencer-reviews-modal-count" class="text-gray-500 font-medium"></span>
                        </p>
                    </div>
                </div>
                <button type="button" onclick="closeInfluencerReviewsModal()" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition text-lg">✕</button>
            </div>

            <!-- Kontainer Scroll Ulasan -->
            <div id="influencer-reviews-modal-body" class="overflow-y-auto max-h-[50vh] pr-1 space-y-3">
                <!-- Diisi via JavaScript dari template terkait -->
            </div>
        </div>

        <div class="mt-5 pt-3 border-t border-gray-100">
            <button type="button" onclick="closeInfluencerReviewsModal()" class="w-full py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold transition">
                Tutup Jendela Ulasan
            </button>
        </div>
    </div>
</div>

<?php echo $__env->make('dashboard.partials.modal-daftar-influencer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH C:\laragon\laragon\www\Titik-UMKM\resources\views/dashboard/partials/investor-influencer-tab.blade.php ENDPATH**/ ?>