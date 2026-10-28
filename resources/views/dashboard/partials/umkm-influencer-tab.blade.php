<div class="space-y-8 animate-fade-in">
    <!-- HEADER FITUR INFLUENCER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#1A202C]">MARKETPLACE INFLUENCER</h1>
            <p class="text-xs sm:text-sm text-[#555555] mt-1 font-medium">
                Pilih kreator lokal untuk mempromosikan usaha Anda, didanai mandiri atau diajukan sponsor ke investor.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5 self-start sm:self-auto">
            <button type="button" onclick="openModalDaftarInfluencer()"
                    class="px-4 py-2.5 rounded-xl border border-emerald-300 text-emerald-800 bg-emerald-50 hover:bg-emerald-100 text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                <span>✨</span>
                <span>Daftar Jadi Influencer</span>
            </button>
            <a href="#katalog-influencer-section"
               class="px-4 py-2.5 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold shadow-sm transition flex items-center gap-1.5">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Cari Influencer</span>
            </a>
        </div>
    </div>

    <!-- STATISTIK KAMPANYE PROMOSI UMKM -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-3xl p-5 border border-[#E8E6DF] shadow-sm">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Total Kampanye</span>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-black text-[#1A202C]">{{ $influencerOrdersUmkm->count() }}</span>
                <span class="text-xs text-gray-500">promosi</span>
            </div>
            <span class="text-[11px] text-teal-700 font-semibold mt-1 block">● Total pesanan terdaftar</span>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-[#E8E6DF] shadow-sm">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Sedang Berjalan</span>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-black text-amber-600">
                    {{ $influencerOrdersUmkm->whereIn('status', ['menunggu_persetujuan_investor', 'menunggu_respon_influencer', 'menunggu_pembayaran_escrow', 'sedang_dikerjakan', 'menunggu_verifikasi'])->count() }}
                </span>
                <span class="text-xs text-gray-500">kampanye</span>
            </div>
            <span class="text-[11px] text-amber-700 font-semibold mt-1 block">● Menunggu respon, deposit & produksi</span>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-[#E8E6DF] shadow-sm">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Disponsori Investor</span>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-black text-emerald-700">
                    {{ $influencerOrdersUmkm->whereNotNull('investor_id')->count() }}
                </span>
                <span class="text-xs text-gray-500">kampanye</span>
            </div>
            <span class="text-[11px] text-emerald-700 font-semibold mt-1 block">● Didanai oleh mitra investor</span>
        </div>
    </div>

    <!-- BAGIAN 1: RIWAYAT / STATUS KAMPANYE AKTIF (JIKA ADA) -->
    <div id="riwayat-promosi-section" class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E8E6DF] shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div>
                <h2 class="text-lg font-black text-[#1A202C]">Status Kampanye Promosi Saya</h2>
                <p class="text-xs text-gray-500">Pantau proses pembuatan konten dan tonton video hasil promosi dari influencer.</p>
            </div>
            <span class="text-xs font-bold text-gray-400">{{ $influencerOrdersUmkm->count() }} Terdaftar</span>
        </div>

        @if($influencerOrdersUmkm->isEmpty())
            <div class="p-8 text-center text-gray-400 text-xs">
                Belum ada kampanye promosi aktif. Pilih kreator di katalog bawah untuk mulai mempromosikan produk Anda!
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($influencerOrdersUmkm as $order)
                    <div class="p-5 rounded-2xl border border-gray-100 bg-[#F9F8F3] hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <div>
                                    <span class="text-[11px] font-mono font-bold text-gray-400">#{{ $order->kode_order }}</span>
                                    <h3 class="text-sm font-black text-[#1A202C] mt-0.5">{{ $order->nama_campaign }}</h3>
                                </div>
                                @php $badge = $order->status_badge; @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold 
                                    {{ $order->status === 'menunggu_persetujuan_investor' ? 'bg-amber-100 text-amber-900 border border-amber-300' : '' }}
                                    {{ $order->status === 'menunggu_respon_influencer' ? 'bg-blue-100 text-blue-900' : '' }}
                                    {{ $order->status === 'menunggu_pembayaran_escrow' ? 'bg-amber-100 text-amber-900 border border-amber-300 animate-pulse' : '' }}
                                    {{ $order->status === 'sedang_dikerjakan' ? 'bg-purple-100 text-purple-900' : '' }}
                                    {{ $order->status === 'menunggu_verifikasi' ? 'bg-orange-100 text-orange-900 animate-pulse' : '' }}
                                    {{ $order->status === 'selesai' ? 'bg-emerald-100 text-emerald-900' : '' }}
                                    {{ str_contains($order->status, 'ditolak') ? 'bg-rose-100 text-rose-900' : '' }}">
                                    {{ $badge['label'] }}
                                </span>
                            </div>

                            <div class="space-y-1.5 text-xs text-gray-600 mb-3">
                                <div class="flex items-center justify-between">
                                    <span>Influencer:</span>
                                    <span class="font-bold text-[#1A202C]">{{ $order->influencer->nama_panggung ?? 'Kreator' }} ({{ $order->influencer->kota ?? '' }})</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Paket:</span>
                                    <span class="font-semibold text-emerald-800">{{ $order->paket_label }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Biaya:</span>
                                    <span class="font-black text-sm text-[#0F433C]">Rp {{ number_format($order->biaya, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Skema:</span>
                                    @if($order->investor)
                                        <span class="font-bold text-amber-700 bg-amber-100/70 px-2 py-0.5 rounded-md text-[11px]">
                                            Disponsori Investor: {{ $order->investor->name }}
                                        </span>
                                    @else
                                        <span class="font-semibold text-gray-700 bg-gray-200 px-2 py-0.5 rounded-md text-[11px]">
                                            Mandiri UMKM
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- BOX STATUS PEMBAYARAN ESCROW (REKBER) -->
                            @if($order->status_pembayaran !== 'lunas_escrow' && in_array($order->status, ['menunggu_pembayaran_escrow', 'menunggu_respon_influencer']))
                                @if($order->investor_id)
                                    <div class="p-3 bg-blue-50 border border-blue-200 rounded-2xl my-2 text-xs flex items-center gap-2.5">
                                        <span class="text-base">🤝</span>
                                        <div class="text-[11px] text-blue-900 leading-snug">
                                            <strong>Disponsori Investor ({{ $order->investor->name ?? 'Investor' }}):</strong> Biaya promosi sebesar <strong>Rp {{ number_format($order->biaya, 0, ',', '.') }}</strong> sepenuhnya ditanggung oleh mitra investor melalui sistem Rekber Escrow platform.
                                        </div>
                                    </div>
                                @else
                                    <div class="p-4 rounded-2xl my-2 space-y-3 border"
                                         style="background-color: {{ $order->status === 'menunggu_pembayaran_escrow' ? '#FFFBEB' : '#F0FDF4' }} !important; border-color: {{ $order->status === 'menunggu_pembayaran_escrow' ? '#FCD34D' : '#86EFAC' }} !important;">
                                        <div class="flex items-start gap-2.5">
                                            <div class="w-7 h-7 rounded-lg text-white flex items-center justify-center text-xs shrink-0 shadow-xs font-bold"
                                                 style="background-color: {{ $order->status === 'menunggu_pembayaran_escrow' ? '#D97706' : '#0F433C' }} !important;">
                                                {{ $order->status === 'menunggu_pembayaran_escrow' ? '⚡' : '💳' }}
                                            </div>
                                            <div class="text-[11px] leading-snug"
                                                 style="color: {{ $order->status === 'menunggu_pembayaran_escrow' ? '#78350F' : '#064E3B' }} !important;">
                                                @if($order->status === 'menunggu_pembayaran_escrow')
                                                    <strong>Pesanan Disetujui Kreator!</strong> Silakan transfer deposit garansi sebesar <strong>Rp {{ number_format($order->biaya, 0, ',', '.') }}</strong> ke Rekber Titik-UMKM agar kreator dapat segera memproduksi konten.
                                                @else
                                                    <strong>Pesanan Terkirim ke Kreator:</strong> Sedang ditinjau oleh {{ $order->influencer->nama_panggung ?? 'Kreator' }}. Anda dapat <strong>langsung menyetorkan deposit ke Rekber Escrow sekarang</strong> atau menunggu konfirmasi terlebih dahulu.
                                                @endif
                                            </div>
                                        </div>
                                        <button type="button" onclick="openModalBayarEscrow('{{ $order->id }}', '{{ $order->kode_order }}', '{{ $order->influencer->nama_panggung ?? 'Kreator' }}', '{{ (int)$order->biaya }}')"
                                                class="w-full py-2.5 rounded-xl shadow-md transition flex items-center justify-center gap-2 cursor-pointer hover:opacity-90 active:scale-[0.99]"
                                                style="background: {{ $order->status === 'menunggu_pembayaran_escrow' ? 'linear-gradient(135deg, #D97706 0%, #B45309 100%)' : 'linear-gradient(135deg, #0F433C 0%, #165E54 100%)' }} !important; color: #FFFFFF !important; border: 1px solid {{ $order->status === 'menunggu_pembayaran_escrow' ? '#D97706' : '#0F433C' }} !important;">
                                            <svg class="w-4 h-4 shrink-0" style="color: #FFFFFF !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                            <span style="color: #FFFFFF !important; font-weight: 800; font-size: 13px; text-shadow: 0 1px 2px rgba(0,0,0,0.25);">Bayar &amp; Unggah Bukti Transfer (Escrow)</span>
                                        </button>
                                    </div>
                                @endif
                            @elseif($order->status_pembayaran === 'lunas_escrow' && $order->status !== 'selesai')
                                <div class="p-3 bg-emerald-50/90 border border-emerald-300 rounded-2xl my-2 text-xs flex items-center justify-between gap-2 shadow-xs">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0 animate-pulse"></span>
                                        <div class="truncate text-[11px]">
                                            <span class="font-extrabold text-emerald-950 block">✓ Dana Terjamin di Rekber Escrow Platform</span>
                                            <span class="text-emerald-800 text-[10px]">Via {{ $order->bank_pengirim ?? 'Bank' }} &bull; Rp {{ number_format($order->biaya, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    @if($order->bukti_transfer_pemesan)
                                        <a href="{{ $order->bukti_transfer_pemesan_url }}" target="_blank" rel="noopener noreferrer"
                                           class="px-2.5 py-1.5 bg-white hover:bg-emerald-100 border border-emerald-300 text-[11px] font-bold text-emerald-800 rounded-xl shrink-0 flex items-center gap-1 transition shadow-2xs">
                                            <span>Lihat Bukti</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <!-- Link Video Hasil Konten -->
                            @if($order->link_bukti_konten)
                                <div class="p-3 bg-white rounded-xl border border-emerald-200 my-2">
                                    <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block mb-1">Bukti Publikasi Konten:</span>
                                    <a href="{{ $order->link_bukti_konten }}" target="_blank" rel="noopener noreferrer" 
                                       class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0F433C] hover:underline">
                                        <span>▶ Tonton Video Review di Medsos</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                            @endif

                            <!-- Status Pembayaran & Pencairan Honor -->
                            @if($order->status === 'selesai')
                                <div class="p-3 bg-emerald-50/80 border border-emerald-200/90 rounded-2xl my-2 space-y-2 text-xs">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            <span>Status Honor: Terbayar (Lunas)</span>
                                        </span>
                                        <span class="font-black text-[#0F433C]">Rp {{ number_format($order->biaya, 0, ',', '.') }}</span>
                                    </div>
                                    <p class="text-[11px] text-emerald-900/80 leading-relaxed">
                                        Honor telah dicairkan otomatis oleh sistem platform ke saldo dompet kreator <strong>{{ $order->influencer->nama_panggung ?? 'Influencer' }}</strong>.
                                    </p>
                                    <div class="pt-1.5 border-t border-emerald-200/70 text-[11px] space-y-1">
                                        <div class="flex items-center justify-between flex-wrap gap-1">
                                            <span class="text-gray-500 font-medium">Metode Pembayaran:</span>
                                            <span class="font-bold text-gray-900">Rekber Escrow Platform ({{ $order->bank_pengirim ?? 'BCA' }})</span>
                                        </div>
                                        @if(!empty($order->influencer->nomor_rekening))
                                            <div class="flex items-center justify-between flex-wrap gap-1">
                                                <span class="text-gray-500 font-medium">Rekening Pencairan Kreator:</span>
                                                <span class="font-bold text-gray-900">
                                                    {{ $order->influencer->bank_name ?? 'Bank' }} {{ $order->influencer->nomor_rekening }}
                                                    @if(!empty($order->influencer->nama_rekening))
                                                        (a.n {{ $order->influencer->nama_rekening }})
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    @if($order->bukti_transfer_pemesan)
                                        <div class="pt-1.5 border-t border-emerald-200/60 flex items-center justify-between">
                                            <span class="text-[10px] text-emerald-800 font-semibold">Bukti Setor Escrow UMKM:</span>
                                            <a href="{{ $order->bukti_transfer_pemesan_url }}" target="_blank" rel="noopener noreferrer" 
                                               class="inline-flex items-center gap-1 text-[11px] font-bold text-[#0F433C] hover:underline">
                                                <span>Lihat Struk Transfer</span>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if($order->alasan_penolakan)
                                <div class="p-2.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-800">
                                    <strong>Alasan:</strong> {{ $order->alasan_penolakan }}
                                </div>
                            @endif
                        </div>

                        <!-- Tombol Verifikasi Selesai jika menunggu_verifikasi -->
                        @if($order->status === 'menunggu_verifikasi')
                            <div class="pt-3 border-t border-gray-200 mt-2">
                                <button type="button" onclick="openModalReviewOrder('{{ $order->id }}', '{{ $order->kode_order }}', '{{ $order->influencer->nama_panggung ?? '' }}')"
                                        class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center justify-center gap-1.5">
                                    <span>✓ Verifikasi Tayang & Beri Ulasan</span>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- BAGIAN 2: KATALOG INFLUENCER TERVERIFIKASI -->
    <div id="katalog-influencer-section" class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-black text-[#1A202C]">Katalog Kreator & Influencer Lokal</h2>
                <p class="text-xs text-gray-500">Pilih influencer yang paling cocok dengan kategori produk dan target audiens kota Anda.</p>
            </div>
        </div>

        <!-- Grid Influencer Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($influencerList as $inf)
                <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-lg transition flex flex-col justify-between">
                    <div>
                        <!-- Header Kartu -->
                        <div class="flex items-start gap-4 mb-4">
                            <img src="{{ $inf->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($inf->nama_panggung).'&background=0F433C&color=fff' }}" 
                                 alt="{{ $inf->nama_panggung }}" 
                                 class="w-16 h-16 rounded-2xl object-cover border border-emerald-400/60 shadow-sm shrink-0">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-1.5">
                                    <h3 class="text-base font-black text-[#1A202C] truncate">{{ $inf->nama_panggung }}</h3>
                                    <span class="text-emerald-600" title="Terverifikasi">✓</span>
                                </div>
                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    {{ $inf->kategori }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <span>{{ $inf->kota }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Bio -->
                        <p class="text-xs text-gray-600 line-clamp-3 mb-4 leading-relaxed italic">
                            "{{ $inf->bio ?? 'Kreator digital siap bantu promosi produk UMKM Anda.' }}"
                        </p>

                        <!-- Social Stats & Follower -->
                        <div class="grid grid-cols-2 gap-2 p-3 bg-[#F9F8F3] rounded-2xl mb-4 text-xs">
                            <div>
                                <span class="text-[10px] text-gray-400 font-bold uppercase block">Jangkauan</span>
                                <span class="font-black text-[#1A202C]">{{ number_format($inf->followers_count, 0, ',', '.') }}</span>
                                <span class="text-[10px] text-gray-500">followers</span>
                            </div>
                            <div class="cursor-pointer hover:bg-amber-100/70 p-1 -m-1 rounded-xl transition group"
                                 onclick="openInfluencerReviewsModal('{{ $inf->id }}', '{{ addslashes($inf->nama_panggung) }}', '{{ number_format($inf->average_rating, 1) }}', '{{ $inf->total_reviews }}')"
                                 title="Klik untuk melihat ulasan mitra">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] text-gray-400 font-bold uppercase block">Rating</span>
                                    <span class="text-[9px] text-[#0F433C] font-extrabold group-hover:underline">Lihat &rarr;</span>
                                </div>
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="font-black text-amber-600">★ {{ number_format($inf->average_rating, 1) }}</span>
                                    <span class="text-[10px] text-gray-500 font-medium">({{ $inf->total_reviews }} ulasan)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Price Rates -->
                        <div class="space-y-1.5 text-xs border-t border-gray-100 pt-3 mb-4">
                            <div class="flex items-center justify-between text-gray-600">
                                <span>Story IG 24 Jam:</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($inf->rate_story, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-gray-600">
                                <span>TikTok / Reels Review:</span>
                                <span class="font-bold text-[#0F433C]">Rp {{ number_format($inf->rate_reels_tiktok, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-gray-600">
                                <span>Visit Toko / Ruko:</span>
                                <span class="font-bold text-[#0F433C]">Rp {{ number_format($inf->rate_visit_store, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Review & Booking Modal -->
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                onclick="openInfluencerReviewsModal('{{ $inf->id }}', '{{ addslashes($inf->nama_panggung) }}', '{{ number_format($inf->average_rating, 1) }}', '{{ $inf->total_reviews }}')"
                                class="px-3.5 py-3 bg-[#EFF5F1] hover:bg-[#DCEEE5] text-[#0F433C] border border-[#b2d5cc] text-xs font-bold rounded-2xl transition flex items-center justify-center gap-1.5 cursor-pointer shrink-0"
                                title="Lihat review ulasan untuk {{ $inf->nama_panggung }}">
                            <span class="text-amber-500 text-sm">★</span>
                            <span>Review ({{ $inf->total_reviews }})</span>
                        </button>
                        <button type="button" 
                                onclick="openBookingModal('{{ $inf->id }}', '{{ $inf->nama_panggung }}', '{{ $inf->kota }}', '{{ $inf->rate_story }}', '{{ $inf->rate_reels_tiktok }}', '{{ $inf->rate_visit_store }}')"
                                class="flex-1 py-3 bg-[#0F433C] hover:bg-[#1A5C52] text-white text-xs font-bold rounded-2xl transition shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            <span>Sewa / Ajukan Promosi</span>
                        </button>
                    </div>

                    <!-- Template Review Kreator untuk Modal -->
                    <template id="influencer-reviews-tmpl-{{ $inf->id }}">
                        <div class="space-y-3">
                            @forelse($inf->reviewedOrders as $rev)
                                <div class="p-4 rounded-2xl bg-[#F8F6F0] border border-[#E8E6DF] space-y-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-full bg-[#0F433C] text-white flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ strtoupper(substr($rev->umkm->nama_usaha ?? ($rev->pemesan->name ?? 'M'), 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-1.5 flex-wrap">
                                                    <span class="text-xs font-bold text-gray-900">
                                                        {{ $rev->umkm->nama_usaha ?? ($rev->pemesan->name ?? 'Mitra Usaha') }}
                                                    </span>
                                                    @if($rev->investor_id)
                                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-blue-100 text-blue-800 border border-blue-200">
                                                            🤝 Disponsori Investor
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                            ✓ Mitra UMKM
                                                        </span>
                                                    @endif
                                                </div>
                                                <span class="text-[10px] text-gray-400 font-medium">
                                                    Order #{{ $rev->kode_order }} &bull; {{ $rev->updated_at ? $rev->updated_at->format('d M Y') : '-' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1 text-amber-500 font-black text-xs bg-white px-2.5 py-1 rounded-xl border border-gray-100 shadow-xs shrink-0">
                                            <span>★</span>
                                            <span>{{ $rev->rating }}.0</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between gap-2 text-[10px]">
                                        <span class="px-2 py-0.5 rounded-lg bg-white text-gray-600 border border-gray-200 font-semibold">
                                            Paket: <strong class="text-[#0F433C]">{{ $rev->paket_label }}</strong>
                                        </span>
                                        @if($rev->link_bukti_konten)
                                            <a href="{{ $rev->link_bukti_konten }}" target="_blank" rel="noopener noreferrer" 
                                               class="text-[#0F433C] hover:underline font-bold inline-flex items-center gap-0.5">
                                                <span>Lihat Video Konten</span> &rarr;
                                            </a>
                                        @endif
                                    </div>

                                    <div class="p-3 rounded-xl bg-white border border-gray-100 text-xs text-gray-700 italic">
                                        "{{ $rev->ulasan }}"
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center text-xs text-gray-400">
                                    <span class="text-3xl block mb-2">⭐</span>
                                    <p class="font-bold text-gray-700 mb-1">Belum Ada Ulasan Masuk</p>
                                    <p>Kreator ini belum memiliki ulasan dari pesanan sebelumnya. Jadilah mitra pertama yang bekerja sama!</p>
                                </div>
                            @endforelse
                        </div>
                    </template>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-3xl p-12 text-center text-gray-400 text-sm">
                    Belum ada kreator terdaftar.
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL BOOKING INFLUENCER UNTUK UMKM (Mandiri ATAU Minta Sponsor Investor)  -->
<!-- ========================================================================= -->
<div id="modal-booking-influencer" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-5">
            <div>
                <h3 class="text-lg font-black text-[#1A202C]">Formulir Pengajuan Promosi</h3>
                <p class="text-xs text-gray-500">Pilih paket dan tentukan apakah membayar mandiri atau meminta sponsor investor.</p>
            </div>
            <button type="button" onclick="closeBookingModal()" class="text-gray-400 hover:text-gray-600 font-bold text-lg">✕</button>
        </div>

        <form id="form-booking-influencer" action="{{ route('dashboard.umkm.influencer.order') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="influencer_id" id="booking_influencer_id">

            <!-- Target Influencer Card Preview -->
            <div class="p-3.5 bg-emerald-50/70 border border-emerald-200/80 rounded-2xl flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-emerald-800 font-bold uppercase tracking-wider block">Kreator Terpilih:</span>
                    <span id="booking_influencer_nama" class="font-black text-[#0F433C] text-sm">Nama Kreator</span>
                    <span id="booking_influencer_kota" class="text-xs text-gray-500 block">Kota</span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-gray-500 block">Estimasi Biaya</span>
                    <span id="booking_preview_harga" class="text-base font-black text-[#0F433C]">Rp 0</span>
                </div>
            </div>

            <!-- Pilih Paket Promosi -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Pilih Paket Konten Promosi *</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                    <label class="flex items-start gap-2.5 p-3 rounded-xl border border-gray-200 hover:border-[#0F433C] cursor-pointer bg-white">
                        <input type="radio" name="paket_konten" value="story" onchange="updateBookingPrice()" class="mt-0.5 text-[#0F433C] focus:ring-[#0F433C]">
                        <div>
                            <span class="font-bold text-gray-900 block">Instagram Story</span>
                            <span id="price_label_story" class="text-[11px] text-emerald-700 font-semibold block">Rp 0</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-2.5 p-3 rounded-xl border border-gray-200 hover:border-[#0F433C] cursor-pointer bg-white">
                        <input type="radio" name="paket_konten" value="reels_tiktok" checked onchange="updateBookingPrice()" class="mt-0.5 text-[#0F433C] focus:ring-[#0F433C]">
                        <div>
                            <span class="font-bold text-gray-900 block">TikTok / Reels Video</span>
                            <span id="price_label_reels" class="text-[11px] text-emerald-700 font-semibold block">Rp 0</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-2.5 p-3 rounded-xl border border-gray-200 hover:border-[#0F433C] cursor-pointer bg-white">
                        <input type="radio" name="paket_konten" value="visit_store" onchange="updateBookingPrice()" class="mt-0.5 text-[#0F433C] focus:ring-[#0F433C]">
                        <div>
                            <span class="font-bold text-gray-900 block">Visit Toko / Ruko</span>
                            <span id="price_label_visit" class="text-[11px] text-emerald-700 font-semibold block">Rp 0</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-2.5 p-3 rounded-xl border border-gray-200 hover:border-[#0F433C] cursor-pointer bg-white">
                        <input type="radio" name="paket_konten" value="paket_komplit" onchange="updateBookingPrice()" class="mt-0.5 text-[#0F433C] focus:ring-[#0F433C]">
                        <div>
                            <span class="font-bold text-gray-900 block">Paket Komplit (Visit + Video)</span>
                            <span id="price_label_komplit" class="text-[11px] text-emerald-700 font-semibold block">Rp 0</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Pilih Produk UMKM -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Produk yang Mau Direview (Opsional)</label>
                <select name="produk_id" class="w-full px-3.5 py-2 text-xs rounded-xl border border-gray-200 focus:ring-[#0F433C]">
                    <option value="">-- Promosi Usaha / Seluruh Menu --</option>
                    @if(isset($allProduks))
                        @foreach($allProduks as $p)
                            <option value="{{ $p->id_produk }}">{{ $p->nama_produk }} (Rp {{ number_format($p->harga, 0, ',', '.') }})</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Nama Campaign & Brief -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Judul / Tema Promosi *</label>
                <input type="text" name="nama_campaign" required placeholder="Contoh: Launching Menu Baru / Review Kopi Susu Aren"
                       class="w-full px-3.5 py-2 text-xs rounded-xl border border-gray-200 focus:ring-[#0F433C]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Brief & Arahan Konten *</label>
                <textarea name="catatan_brief" rows="3" required placeholder="Jelaskan poin penting: rasa unggulan, promo diskon yang ada, alamat ruko jika visit, dan pesan yang ingin disampaikan..."
                          class="w-full p-3 text-xs rounded-xl border border-gray-200 focus:ring-[#0F433C]"></textarea>
            </div>

            <!-- METODE PENDANAAN: MANDIRI VS MINTA SPONSOR INVESTOR -->
            <div class="p-4 bg-amber-50/70 border border-amber-200 rounded-2xl space-y-3">
                <span class="text-xs font-black text-amber-950 uppercase tracking-wider block">Skema Pembayaran / Pendanaan:</span>
                
                <div class="space-y-2 text-xs">
                    <label class="flex items-center gap-2 cursor-pointer font-bold text-gray-900">
                        <input type="radio" name="skema_bayar" value="mandiri" checked onchange="toggleSkemaBayar('mandiri')" class="text-[#0F433C] focus:ring-[#0F433C]">
                        <span>Bayar Mandiri (Menggunakan Anggaran Kas UMKM)</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer font-bold text-amber-900">
                        <input type="radio" name="skema_bayar" value="investor" onchange="toggleSkemaBayar('investor')" class="text-[#0F433C] focus:ring-[#0F433C]">
                        <span>Ajukan Permohonan Sponsor ke Investor Pendana Saya</span>
                    </label>
                </div>

                <!-- Dropdown Investor jika pilih minta sponsor -->
                <div id="wrapper-select-investor" class="hidden pt-2 border-t border-amber-200/60">
                    <label class="block text-[11px] font-bold text-amber-950 mb-1">Pilih Investor Mitra Anda *</label>
                    @if(isset($investorMitraUmkm) && $investorMitraUmkm->isNotEmpty())
                        <select name="investor_id" id="select_investor_id" class="w-full px-3 py-2 text-xs rounded-xl border border-amber-300 bg-white">
                            @foreach($investorMitraUmkm as $inv)
                                <option value="{{ $inv->id }}">{{ $inv->name }} ({{ $inv->email }})</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-amber-800 mt-1">
                            * Investor terpilih akan menerima notifikasi tiket pengajuan dan dapat menyetujui serta mendanai promosi ini.
                        </p>
                    @else
                        <div class="p-2.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-800 font-semibold">
                            ⚠️ Anda belum memiliki investor pendana yang terhubung di akun ini. Silakan gunakan opsi Bayar Mandiri atau ajukan proposal pendanaan terlebih dahulu di menu Profil.
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeBookingModal()" class="px-5 py-2.5 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" id="btn-submit-booking" class="px-6 py-2.5 text-xs font-bold bg-[#0F433C] text-white rounded-xl hover:bg-[#1A5C52] shadow-sm">
                    Kirim Permohonan Promosi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL REVIEW & VERIFIKASI SELESAI OLEH UMKM -->
<div id="modal-review-order" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-gray-100">
        <h3 class="text-base font-black text-[#1A202C] mb-1">Verifikasi & Beri Rating Kreator</h3>
        <p class="text-xs text-gray-500 mb-4" id="review_order_subtitle">Order #</p>

        <form id="form-review-order" action="" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Beri Nilai Rating (1 - 5 Bintang) *</label>
                <select name="rating" required class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 font-bold text-amber-600">
                    <option value="5">★★★★★ (5.0 - Sangat Puas & Berdampak)</option>
                    <option value="4">★★★★☆ (4.0 - Bagus & Tepat Waktu)</option>
                    <option value="3">★★★☆☆ (3.0 - Cukup Baik)</option>
                    <option value="2">★★☆☆☆ (2.0 - Kurang Sesuai Brief)</option>
                    <option value="1">★☆☆☆☆ (1.0 - Tidak Memuaskan)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Ulasan / Testimoni Anda (Opsional)</label>
                <textarea name="ulasan" rows="3" placeholder="Ceritakan kepuasan Anda terhadap video promosi kreator ini..." 
                          class="w-full p-3 text-xs rounded-xl border border-gray-200"></textarea>
            </div>

            <p class="text-[11px] text-gray-500 leading-relaxed bg-gray-50 p-2.5 rounded-xl">
                Setelah Anda memverifikasi, status pesanan akan ditandai selesai dan honor promosi akan diteruskan ke saldo kreator.
            </p>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('modal-review-order').classList.add('hidden')" class="px-4 py-2 text-xs font-bold text-gray-600">Batal</button>
                <button type="submit" class="px-5 py-2 text-xs font-bold bg-[#0F433C] text-white rounded-xl hover:bg-[#1A5C52]">Konfirmasi Selesai</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL BAYAR & UNGGAH BUKTI TRANSFER ESCROW REKBER -->
<div id="modal-bayar-escrow" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-[#E8E6DF] my-8 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-[#E8E6DF] mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#1A202C]">Pembayaran Rekber (Escrow)</h3>
                    <p id="escrow_modal_subtitle" class="text-xs text-gray-500">Order #INF-XXXX &bull; Kreator: -</p>
                </div>
            </div>
            <button type="button" onclick="closeModalBayarEscrow()" class="text-gray-400 hover:text-gray-600 text-lg">✕</button>
        </div>

        <form id="form-bayar-escrow" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Total Biaya Tagihan -->
            <div class="p-3.5 bg-gradient-to-r from-[#EFF5F1] to-[#E3EFE8] rounded-2xl border border-emerald-200 flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-gray-600 block">Total Tagihan Deposit Escrow</span>
                    <span id="escrow_modal_biaya" class="text-xl font-black text-[#0F433C]">Rp 0</span>
                </div>
                <span class="px-2.5 py-1 text-[10px] font-extrabold bg-emerald-800 text-white rounded-lg shadow-xs">Dana Ditahan Aman</span>
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
                <p class="text-[11px] text-gray-500 italic">
                    ℹ️ Dana Anda akan diamankan di rekening penampung resmi platform dan hanya akan dicairkan ke kreator setelah Anda memverifikasi video tayang.
                </p>
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
                        <input type="text" name="nama_pengirim" required placeholder="Nama di rekening pengirim"
                               class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-xl text-xs px-3 py-2.5 focus:border-[#0b5a4a] focus:bg-white">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nomor Rekening Pengirim (Opsional)</label>
                    <input type="text" name="nomor_rekening_pengirim" placeholder="Contoh: 1234567890"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-xl text-xs px-3 py-2.5 focus:border-[#0b5a4a] focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Unggah Foto Struk Bukti Transfer *</label>
                    <input type="file" name="bukti_transfer" required accept="image/*"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-xl text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0F433C] file:text-white cursor-pointer">
                    <span class="text-[10px] text-gray-400 mt-1 block">Format: JPG, PNG, atau WEBP. Maksimal ukuran 5MB.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan_pembayaran" rows="2" placeholder="Catatan transaksi..."
                              class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-xl text-xs p-2.5 focus:border-[#0b5a4a] focus:bg-white"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#E8E6DF]">
                <button type="button" onclick="closeModalBayarEscrow()" class="px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold bg-[#0F433C] hover:bg-[#19584F] text-white rounded-xl shadow-sm flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Kirim Bukti Pembayaran Escrow</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentRates = { story: 0, reels: 0, visit: 0 };

    function openBookingModal(id, nama, kota, rateStory, rateReels, rateVisit) {
        document.getElementById('booking_influencer_id').value = id;
        document.getElementById('booking_influencer_nama').innerText = nama;
        document.getElementById('booking_influencer_kota').innerText = kota;

        currentRates.story = parseFloat(rateStory) || 0;
        currentRates.reels = parseFloat(rateReels) || 0;
        currentRates.visit = parseFloat(rateVisit) || 0;

        document.getElementById('price_label_story').innerText = 'Rp ' + Number(currentRates.story).toLocaleString('id-ID');
        document.getElementById('price_label_reels').innerText = 'Rp ' + Number(currentRates.reels).toLocaleString('id-ID');
        document.getElementById('price_label_visit').innerText = 'Rp ' + Number(currentRates.visit).toLocaleString('id-ID');
        document.getElementById('price_label_komplit').innerText = 'Rp ' + Number(currentRates.reels + currentRates.visit).toLocaleString('id-ID');

        updateBookingPrice();
        document.getElementById('modal-booking-influencer').classList.remove('hidden');
    }

    function closeBookingModal() {
        document.getElementById('modal-booking-influencer').classList.add('hidden');
    }

    function updateBookingPrice() {
        const selected = document.querySelector('input[name="paket_konten"]:checked')?.value || 'reels_tiktok';
        let harga = currentRates.reels;
        if (selected === 'story') harga = currentRates.story;
        if (selected === 'visit_store') harga = currentRates.visit;
        if (selected === 'paket_komplit') harga = currentRates.reels + currentRates.visit;

        document.getElementById('booking_preview_harga').innerText = 'Rp ' + Number(harga).toLocaleString('id-ID');
    }

    function toggleSkemaBayar(tipe) {
        const wrapper = document.getElementById('wrapper-select-investor');
        const form = document.getElementById('form-booking-influencer');
        const btn = document.getElementById('btn-submit-booking');

        if (tipe === 'investor') {
            wrapper.classList.remove('hidden');
            form.action = "{{ route('dashboard.umkm.influencer.ajukan-sponsor') }}";
            btn.innerText = "Ajukan Sponsor ke Investor";
        } else {
            wrapper.classList.add('hidden');
            form.action = "{{ route('dashboard.umkm.influencer.order') }}";
            btn.innerText = "Sewa & Bayar Mandiri";
        }
    }

    function openModalReviewOrder(orderId, kodeOrder, influencerName) {
        const form = document.getElementById('form-review-order');
        form.action = "/dashboard/influencer/order/" + orderId + "/selesai";
        document.getElementById('review_order_subtitle').innerText = "Order #" + kodeOrder + " • Kreator: " + influencerName;
        document.getElementById('modal-review-order').classList.remove('hidden');
    }

    function openModalBayarEscrow(orderId, kodeOrder, influencerName, biaya) {
        const form = document.getElementById('form-bayar-escrow');
        form.action = "/dashboard/influencer/order/" + orderId + "/bayar-escrow";
        document.getElementById('escrow_modal_subtitle').innerText = "Order #" + kodeOrder + " • Kreator: " + influencerName;
        document.getElementById('escrow_modal_biaya').innerText = "Rp " + Number(biaya).toLocaleString('id-ID');
        document.getElementById('modal-bayar-escrow').classList.remove('hidden');
    }

    function closeModalBayarEscrow() {
        document.getElementById('modal-bayar-escrow').classList.add('hidden');
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

@include('dashboard.partials.modal-daftar-influencer')
