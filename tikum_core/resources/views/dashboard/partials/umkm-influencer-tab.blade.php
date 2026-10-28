<div class="space-y-8 animate-fade-in">
    <!-- BANNER UTAMA FITUR SEWA INFLUENCER (Desain Kontras Tinggi & Mewah) -->
    <div class="rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden"
         style="background: linear-gradient(135deg, #072622 0%, #0F433C 55%, #134E44 100%); border: 1px solid #1C695E;">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-black mb-3 shadow-xs"
                     style="background: rgba(251, 191, 36, 0.18); border: 1px solid rgba(251, 191, 36, 0.6); color: #FEF08A !important;">
                    <span>📢</span>
                    <span>FITUR PEMASARAN DIGITAL UMKM</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight"
                    style="color: #ffffff !important; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                    Sewa Influencer Lokal untuk Promosikan Usaha Anda
                </h1>
                <p class="text-xs sm:text-sm mt-2 font-medium leading-relaxed"
                   style="color: #E2F1EE !important;">
                    Tingkatkan kunjungan pembeli ke ruko dan penjualan produk Anda dengan bantuan Nano & Micro Influencer terverifikasi. Anda bisa <strong style="color: #FDE047 !important;">bayar mandiri</strong> atau <strong style="color: #FDE047 !important;">ajukan permohonan sponsor ke Investor pendana</strong> Anda!
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
                <a href="#katalog-influencer-section" 
                   class="px-5 py-3 rounded-2xl text-xs font-black shadow-md transition text-center flex items-center justify-center gap-2 hover:brightness-105"
                   style="background-color: #F59E0B !important; color: #111827 !important; border: 1px solid #FBBF24;">
                    <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Cari Influencer</span>
                </a>
                <a href="#riwayat-promosi-section" 
                   class="px-5 py-3 rounded-2xl text-xs font-bold transition text-center hover:bg-white/20"
                   style="background-color: rgba(255, 255, 255, 0.15) !important; border: 1px solid rgba(255, 255, 255, 0.35) !important; color: #ffffff !important;">
                    Status Promosi ({{ $influencerOrdersUmkm->count() }})
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
                    {{ $influencerOrdersUmkm->whereIn('status', ['menunggu_persetujuan_investor', 'menunggu_respon_influencer', 'sedang_dikerjakan', 'menunggu_verifikasi'])->count() }}
                </span>
                <span class="text-xs text-gray-500">kampanye</span>
            </div>
            <span class="text-[11px] text-amber-700 font-semibold mt-1 block">● Menunggu respon & produksi</span>
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
                            <div>
                                <span class="text-[10px] text-gray-400 font-bold uppercase block">Rating</span>
                                <span class="font-black text-amber-600">★ {{ number_format($inf->average_rating, 1) }}</span>
                                <span class="text-[10px] text-gray-500">({{ $inf->total_reviews }} ulasan)</span>
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

                    <!-- Tombol Booking Modal -->
                    <button type="button" 
                            onclick="openBookingModal('{{ $inf->id }}', '{{ $inf->nama_panggung }}', '{{ $inf->kota }}', '{{ $inf->rate_story }}', '{{ $inf->rate_reels_tiktok }}', '{{ $inf->rate_visit_store }}')"
                            class="w-full py-3 bg-[#0F433C] hover:bg-[#1A5C52] text-white text-xs font-bold rounded-2xl transition shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <span>Sewa / Ajukan Promosi</span>
                    </button>
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
</script>

@include('dashboard.partials.modal-daftar-influencer')
