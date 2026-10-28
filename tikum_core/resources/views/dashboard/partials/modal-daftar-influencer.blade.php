<!-- MODAL PENDAFTARAN MITRA INFLUENCER TIKUM -->
<div id="modal-daftar-influencer" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm hidden flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div class="bg-white rounded-[12px] max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-[#e2e1d8] animate-scale-up my-8 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-[#e2e1d8] mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-[6px] bg-[#d8ebe5] text-[#0b5a4a] flex items-center justify-center text-xl font-black shrink-0">
                    ✨
                </div>
                <div>
                    <h3 class="text-[18px] font-bold text-[#161d1a]">Formulir Pendaftaran Mitra Influencer</h3>
                    <p class="text-[12px] text-[#4b5551]">Bantu promosikan UMKM lokal & hasilkan honor profesional dari setiap pesanan kampanye.</p>
                </div>
            </div>
            <button type="button" onclick="closeModalDaftarInfluencer()" class="text-[#4b5551] hover:text-[#161d1a] font-bold text-lg p-1.5 rounded-[6px]">✕</button>
        </div>

        <form action="{{ route('influencer.daftar') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Notifikasi Pengantar -->
            <div class="p-3 bg-[#d8ebe5]/60 rounded-[6px] border border-[#b2d5cc] text-[12px] text-[#084539] flex items-center gap-2">
                <span>📢</span>
                <span>Setelah mendaftar, profil Anda langsung tampil di Katalog Influencer yang dapat di-order oleh pelaku UMKM maupun disponsori oleh Investor!</span>
            </div>

            <!-- Baris 1: Nama Panggung & Kategori -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Nama Panggung / Akun *</label>
                    <input type="text" name="nama_panggung" required placeholder="Contoh: Dimas Kulineran / Cindy OOTD"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Niche / Kategori Konten *</label>
                    <select name="kategori" required class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                        <option value="Kuliner">Kuliner & Minuman (F&B)</option>
                        <option value="Fashion">Fashion, Hijab & Beauty</option>
                        <option value="Lifestyle">Lifestyle, Tempat Nongkrong & Kafe</option>
                        <option value="Jasa">Jasa, Kreatif & Edukasi</option>
                        <option value="Agribisnis">Agribisnis & Kerajinan Tangan</option>
                    </select>
                </div>
            </div>

            <!-- Baris 2: Akun Medsos & Followers -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Instagram (@)</label>
                    <input type="text" name="instagram_handle" placeholder="@username"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">TikTok (@)</label>
                    <input type="text" name="tiktok_handle" placeholder="@username"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Total Followers *</label>
                    <input type="number" name="jumlah_followers" required min="100" placeholder="Contoh: 15000"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
            </div>

            <!-- Baris 3: Domisili / Lokasi Jangkauan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Kota / Domisili *</label>
                    <input type="text" name="kota" required placeholder="Contoh: Surabaya / Malang / Jakarta"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Provinsi</label>
                    <input type="text" name="provinsi" placeholder="Contoh: Jawa Timur"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
            </div>

            <!-- Baris 4: Tarif Jasa Promosi (Pricing Card) -->
            <div class="p-4 bg-[#f7f6f1] rounded-[8px] border border-[#e2e1d8] space-y-3">
                <span class="text-[12px] font-bold text-[#0b5a4a] uppercase tracking-wider block">Atur Tarif Honor Jasa Anda (Rp):</span>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-[#161d1a] mb-1">Story IG 24 Jam</label>
                        <input type="number" name="rate_story" required min="10000" step="5000" value="75000"
                               class="w-full bg-white border border-[#e2e1d8] rounded-[6px] text-[13px] font-bold text-[#0b5a4a] px-3 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-[#161d1a] mb-1">Reels / TikTok Review</label>
                        <input type="number" name="rate_reels_tiktok" required min="20000" step="10000" value="200000"
                               class="w-full bg-white border border-[#e2e1d8] rounded-[6px] text-[13px] font-bold text-[#0b5a4a] px-3 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-[#161d1a] mb-1">Visit Kedai / Toko</label>
                        <input type="number" name="rate_visit_store" required min="50000" step="10000" value="350000"
                               class="w-full bg-white border border-[#e2e1d8] rounded-[6px] text-[13px] font-bold text-[#0b5a4a] px-3 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                    </div>
                </div>
            </div>

            <!-- Baris 5: Bio & Portofolio -->
            <div>
                <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Bio Kreator & Konsep Konten *</label>
                <textarea name="bio" rows="2" required placeholder="Ceritakan konsep video Anda, gaya pembawaan, kebiasaan interaksi dengan followers..."
                          class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Link Portofolio (Opsional)</label>
                    <input type="url" name="link_portofolio" placeholder="https://instagram.com/reel/..."
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">Foto Profil</label>
                    <input type="file" name="foto_profil" accept="image/*"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[12px] text-[#4b5551] px-3 py-1.5 focus:border-[#0b5a4a] file:mr-3 file:py-1 file:px-3 file:rounded-[4px] file:border-0 file:text-[11px] file:font-semibold file:bg-[#d8ebe5] file:text-[#0b5a4a]">
                </div>
            </div>

            @guest
                <!-- Jika Pengunjung Belum Login: Buat Kredensial Akun Baru -->
                <div class="p-4 bg-amber-50/70 rounded-[8px] border border-amber-200 space-y-3">
                    <span class="text-[12px] font-bold text-amber-950 uppercase tracking-wider block">Kredensial Akun Baru:</span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#161d1a] mb-1">Email Aktif *</label>
                            <input type="email" name="email" required placeholder="email@gmail.com"
                                   class="w-full bg-white border border-amber-300 rounded-[6px] text-[13px] text-[#161d1a] px-3 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#161d1a] mb-1">Kata Sandi Baru *</label>
                            <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter"
                                   class="w-full bg-white border border-amber-300 rounded-[6px] text-[13px] text-[#161d1a] px-3 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                        </div>
                    </div>
                </div>
            @endguest

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#e2e1d8]">
                <button type="button" onclick="closeModalDaftarInfluencer()" class="px-5 py-2.5 rounded-[6px] border border-[#e2e1d8] text-[#4b5551] text-[13px] font-medium hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-[6px] bg-[#0b5a4a] hover:bg-[#084539] text-white text-[13px] font-medium shadow-sm transition flex items-center gap-1.5">
                    <span>✓</span>
                    <span>Daftarkan Profil Sekarang</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalDaftarInfluencer() {
        const modal = document.getElementById('modal-daftar-influencer');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }
    function closeModalDaftarInfluencer() {
        const modal = document.getElementById('modal-daftar-influencer');
        if (modal) {
            modal.classList.add('hidden');
        }
    }
</script>
