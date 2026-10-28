@extends('layouts.auth')

@section('title', 'Formulir Pendaftaran Mitra Influencer - DAYA UMKM')

@section('content')
<div class="w-full max-w-5xl mx-auto px-4 sm:px-8 py-10 space-y-7">

    <!-- Progress Indicator Stepper (Identik dengan formulir-umkm & formulir-investor) -->
    <div class="bg-white rounded-[12px] p-4 sm:p-5 border border-[#e2e1d8] flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-3">
            <span class="w-7 h-7 rounded-[6px] bg-[#d8ebe5] text-[#0b5a4a] flex items-center justify-center font-bold text-[12px]">
                ✓
            </span>
            <div>
                <span class="text-[13px] font-bold text-[#161d1a] block">Langkah 1: Akun & verifikasi email</span>
                <span class="text-[11px] text-[#0b5a4a] font-medium">Selesai terverifikasi</span>
            </div>
        </div>

        <div class="hidden sm:block w-12 h-px bg-[#e2e1d8]"></div>

        <div class="flex items-center gap-3">
            <span class="w-7 h-7 rounded-[6px] bg-[#0b5a4a] text-white flex items-center justify-center font-bold text-[12px]">
                2
            </span>
            <div>
                <span class="text-[13px] font-bold text-[#0b5a4a] block">Langkah 2: Formulir kreator & tarif</span>
                <span class="text-[11px] text-[#4b5551]">Media sosial, bio & rate card</span>
            </div>
        </div>

        <div class="hidden sm:block w-12 h-px bg-[#e2e1d8]"></div>

        <div class="flex items-center gap-3 opacity-60">
            <span class="w-7 h-7 rounded-[6px] bg-[#f7f6f1] text-[#4b5551] border border-[#e2e1d8] flex items-center justify-center font-bold text-[12px]">
                3
            </span>
            <div>
                <span class="text-[13px] font-bold text-[#161d1a] block">Langkah 3: Tayang di katalog</span>
                <span class="text-[11px] text-[#4b5551]">Siap menerima endorse & sponsor</span>
            </div>
        </div>
    </div>

    <!-- Title Header -->
    <div class="flex items-start sm:items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-[26px] sm:text-[30px] font-bold text-[#161d1a] leading-tight">
                Formulir pendaftaran mitra influencer
            </h1>
            <p class="text-[14px] text-[#4b5551] mt-1">
                Lengkapi data profil kreator, akun sosial media, dan tarif promosi untuk bermitra dengan UMKM & investor TIKUM.
            </p>
        </div>

        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-[6px] bg-[#d8ebe5]/60 text-[#0b5a4a] text-[13px] font-medium border border-[#b2d5cc]">
            <span>Akun {{ $user->email }} (Terverifikasi)</span>
        </div>
    </div>

    @if (session('success'))
        <div class="p-3.5 rounded-[6px] bg-[#d8ebe5]/60 border border-[#b2d5cc] text-[#084539] text-[14px] flex items-center gap-2">
            <span>✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('info'))
        <div class="p-3.5 rounded-[6px] bg-[#EFF5F1] border border-[#b2d5cc] text-[#084539] text-[14px]">
            {{ session('info') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 rounded-[6px] bg-[#fee2e2] border border-[#fca5a5] text-[#991b1b] text-[13px] space-y-1">
            <div class="font-semibold">Mohon periksa kembali formulir Anda:</div>
            <ul class="list-disc list-inside text-[12px] space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('formulir.influencer.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- CARD 1: ALUR KEMITRAAN KREATOR -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] shadow-xs">
            <h2 class="text-[16px] font-bold text-[#161d1a] mb-3">
                Alur kemitraan kreator & influencer TIKUM
            </h2>
            <ol class="space-y-2 text-[14px] text-[#4b5551] leading-relaxed">
                <li class="flex items-start gap-2.5">
                    <span class="font-bold text-[#0b5a4a]">1.</span>
                    <span>Lengkapi profil kreator, akun media sosial, serta tentukan tarif jasa promosi Anda secara mandiri di bawah ini.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="font-bold text-[#0b5a4a]">2.</span>
                    <span>Profil Anda langsung terdaftar di katalog promosi dan dapat disewa oleh pelaku UMKM maupun disponsori langsung oleh investor binaan.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="font-bold text-[#0b5a4a]">3.</span>
                    <span>Kerjakan konten, serahkan tautan publikasi, dan honor dicairkan aman ke saldo rekening Anda dengan sistem garansi escrow.</span>
                </li>
            </ol>
        </div>

        <!-- CARD 2: BAGIAN 1 - IDENTITAS & PROFIL KREATOR -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5">
                <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 1</span>
                <h3 class="text-[18px] font-bold text-[#161d1a]">Identitas & profil kreator</h3>
            </div>

            <!-- Foto Profil Kreator -->
            <div>
                <label for="foto_profil" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                    Foto Profil Kreator (Opsional)
                </label>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#f7f6f1] border-2 border-dashed border-[#b2d5cc] overflow-hidden flex items-center justify-center shrink-0">
                        @if($user->avatar)
                            <img id="preview-foto-influencer" src="{{ $user->avatar }}" alt="Preview" class="w-full h-full object-cover">
                        @else
                            <img id="preview-foto-influencer" src="" alt="Preview" class="w-full h-full object-cover hidden">
                            <span id="placeholder-foto-influencer" class="text-2xl text-[#0b5a4a]">📷</span>
                        @endif
                    </div>
                    <div class="space-y-1">
                        <input type="file" id="foto_profil" name="foto_profil" accept="image/*" class="text-[13px] text-[#4b5551] file:mr-3 file:py-1.5 file:px-3.5 file:rounded-[6px] file:border-0 file:text-[12px] file:font-semibold file:bg-[#d8ebe5] file:text-[#0b5a4a] hover:file:bg-[#b2d5cc] cursor-pointer">
                        <p class="text-[11px] text-[#4b5551]">Format JPG, PNG, atau WebP. Maksimal 4 MB.</p>
                    </div>
                </div>
            </div>

            <!-- Nama Panggung & Kategori Niche -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama_panggung" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Nama Panggung / Channel Publik <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="nama_panggung" name="nama_panggung" required 
                           value="{{ old('nama_panggung', $profile->nama_panggung ?? $user->name) }}"
                           placeholder="Contoh: Dimas Kulineran / Cindy OOTD"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                    <p class="text-[11px] text-[#4b5551] mt-1">Nama yang akan tampil pada kartu katalog promosi UMKM.</p>
                </div>

                <div>
                    <label for="kategori" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Niche / Kategori Konten Utama <span class="text-rose-500">*</span>
                    </label>
                    <select id="kategori" name="kategori" required
                            class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                        @foreach(['Kuliner' => 'Kuliner & Minuman (F&B)', 'Fashion' => 'Fashion, Hijab & Beauty', 'Lifestyle' => 'Lifestyle, Wisata & Tempat Nongkrong', 'Jasa' => 'Jasa, Desain & Edukasi', 'Agribisnis' => 'Agribisnis & Kerajinan UMKM'] as $kVal => $kLabel)
                            <option value="{{ $kVal }}" {{ old('kategori', $profile->kategori ?? 'Kuliner') === $kVal ? 'selected' : '' }}>{{ $kLabel }}</option>
                        @endforeach
                    </select>
                    <p class="text-[11px] text-[#4b5551] mt-1">Sektor usaha yang paling cocok dengan karakter audiens Anda.</p>
                </div>
            </div>

            <!-- Domisili Kota & Provinsi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="kota" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Kota / Domisili Utama <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="kota" name="kota" required
                           value="{{ old('kota', $profile->kota ?? ($user->kota ?? 'Surabaya')) }}"
                           placeholder="Contoh: Surabaya / Malang / Jakarta Selatan"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>

                <div>
                    <label for="provinsi" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Provinsi (Opsional)
                    </label>
                    <input type="text" id="provinsi" name="provinsi"
                           value="{{ old('provinsi', $profile->provinsi ?? ($user->provinsi ?? 'Jawa Timur')) }}"
                           placeholder="Contoh: Jawa Timur"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
            </div>

            <!-- Bio Kreator -->
            <div>
                <label for="bio" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                    Bio Kreator & Gaya Promosi <span class="text-rose-500">*</span>
                </label>
                <textarea id="bio" name="bio" rows="3" required
                          placeholder="Jelaskan karakteristik konten Anda, tipe audiens, dan kelebihan promosi Anda (misal: Food vlogger spesialis kuliner legendaris Surabaya, penyampaian santai dan interaktif)."
                          class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">{{ old('bio', $profile->bio) }}</textarea>
                <p class="text-[11px] text-[#4b5551] mt-1">Deskripsi singkat ini membantu UMKM memahami keunikan ulasan Anda.</p>
            </div>
        </div>

        <!-- CARD 3: BAGIAN 2 - MEDIA SOSIAL & AUDIENS -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5">
                <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 2</span>
                <h3 class="text-[18px] font-bold text-[#161d1a]">Media sosial & jangkauan audiens</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="instagram_handle" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Username Instagram (@)
                    </label>
                    <input type="text" id="instagram_handle" name="instagram_handle"
                           value="{{ old('instagram_handle', $profile->username_instagram) }}"
                           placeholder="misal: @dimas_food"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>

                <div>
                    <label for="tiktok_handle" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Username TikTok (@)
                    </label>
                    <input type="text" id="tiktok_handle" name="tiktok_handle"
                           value="{{ old('tiktok_handle', $profile->username_tiktok) }}"
                           placeholder="misal: @dimaskuliner"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>

                <div>
                    <label for="jumlah_followers" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Total Followers Utama <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" id="jumlah_followers" name="jumlah_followers" required min="100"
                           value="{{ old('jumlah_followers', $profile->followers_count ?? 15000) }}"
                           placeholder="Contoh: 25000"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
            </div>

            <div>
                <label for="link_portofolio" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                    Link Contoh Video / Portofolio Viral (Opsional)
                </label>
                <input type="url" id="link_portofolio" name="link_portofolio"
                       value="{{ old('link_portofolio', $profile->sample_video_url_1) }}"
                       placeholder="https://www.instagram.com/reel/... atau https://www.tiktok.com/@..."
                       class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                <p class="text-[11px] text-[#4b5551] mt-1">Tautan video contoh konten terbaik Anda untuk dilihat calon pemesan.</p>
            </div>
        </div>

        <!-- CARD 4: BAGIAN 3 - RATE CARD & TARIF JASA -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5">
                <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 3</span>
                <h3 class="text-[18px] font-bold text-[#161d1a]">Tarif jasa promosi (Rate Card)</h3>
            </div>

            <p class="text-[13px] text-[#4b5551]">
                Tentukan honor bersih yang Anda inginkan untuk masing-masing jenis paket kampanye endorsement:
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="p-4 rounded-[8px] bg-[#f7f6f1] border border-[#e2e1d8] space-y-2">
                    <label for="rate_story" class="block text-[12px] font-bold text-[#161d1a]">
                        Story IG 24 Jam <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-[13px] font-bold text-[#4b5551]">Rp</span>
                        <input type="number" id="rate_story" name="rate_story" required min="10000" step="5000"
                               value="{{ old('rate_story', $profile->rate_story ?? 75000) }}"
                               class="w-full bg-white border border-[#e2e1d8] rounded-[6px] text-[13px] font-bold text-[#0b5a4a] pl-9 pr-3 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                    </div>
                    <p class="text-[11px] text-[#4b5551]">1-3 slide Instagram Story aktif 24 jam dengan link & tag usaha.</p>
                </div>

                <div class="p-4 rounded-[8px] bg-[#f7f6f1] border border-[#e2e1d8] space-y-2">
                    <label for="rate_reels_tiktok" class="block text-[12px] font-bold text-[#161d1a]">
                        Reels / Video TikTok <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-[13px] font-bold text-[#4b5551]">Rp</span>
                        <input type="number" id="rate_reels_tiktok" name="rate_reels_tiktok" required min="20000" step="10000"
                               value="{{ old('rate_reels_tiktok', $profile->rate_reels_tiktok ?? 200000) }}"
                               class="w-full bg-white border border-[#e2e1d8] rounded-[6px] text-[13px] font-bold text-[#0b5a4a] pl-9 pr-3 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                    </div>
                    <p class="text-[11px] text-[#4b5551]">Video review produk (30-60 detik) tayang di feed Instagram / TikTok.</p>
                </div>

                <div class="p-4 rounded-[8px] bg-[#f7f6f1] border border-[#e2e1d8] space-y-2">
                    <label for="rate_visit_store" class="block text-[12px] font-bold text-[#161d1a]">
                        Visit Kedai / Ruko <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-[13px] font-bold text-[#4b5551]">Rp</span>
                        <input type="number" id="rate_visit_store" name="rate_visit_store" required min="50000" step="10000"
                               value="{{ old('rate_visit_store', $profile->rate_visit_store ?? 350000) }}"
                               class="w-full bg-white border border-[#e2e1d8] rounded-[6px] text-[13px] font-bold text-[#0b5a4a] pl-9 pr-3 py-2 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a]">
                    </div>
                    <p class="text-[11px] text-[#4b5551]">Kunjungan langsung ke lokasi kedai/toko fisik + liputan video.</p>
                </div>
            </div>
        </div>

        <!-- CARD 5: BAGIAN 4 - REKENING BANK PENCAIRAN HONOR -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5">
                <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 4</span>
                <h3 class="text-[18px] font-bold text-[#161d1a]">Rekening bank pencairan honor</h3>
            </div>

            <div class="p-4 bg-[#EFF5F1] rounded-[8px] border border-[#b2d5cc]">
                <p class="text-[12px] text-[#084539]">
                    Dana honor endorsement dari UMKM/Investor akan dikunci oleh sistem dan langsung cair ke rekening ini setelah konten Anda disetujui.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="bank_name" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Nama Bank
                    </label>
                    <input type="text" id="bank_name" name="bank_name"
                           value="{{ old('bank_name', $profile->bank_name) }}"
                           placeholder="BCA / Mandiri / BNI / BRI"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>

                <div>
                    <label for="nomor_rekening" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Nomor Rekening
                    </label>
                    <input type="text" id="nomor_rekening" name="nomor_rekening"
                           value="{{ old('nomor_rekening', $profile->nomor_rekening) }}"
                           placeholder="Contoh: 1234567890"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>

                <div>
                    <label for="nama_rekening" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Atas Nama Rekening
                    </label>
                    <input type="text" id="nama_rekening" name="nama_rekening"
                           value="{{ old('nama_rekening', $profile->nama_rekening ?? $user->name) }}"
                           placeholder="Nama pemilik buku tabungan"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
            </div>
        </div>

        <!-- Bottom Action Bar -->
        <div class="bg-white rounded-[12px] p-5 border border-[#e2e1d8] flex items-center justify-between flex-wrap gap-4 shadow-xs">
            <a href="{{ route('dashboard') }}" class="text-[13px] font-semibold text-[#4b5551] hover:text-[#161d1a] transition">
                &larr; Ke Dashboard
            </a>

            <button type="submit" 
                    class="px-8 py-3 rounded-[6px] bg-[#0b5a4a] hover:bg-[#084539] text-white text-[14px] font-medium transition flex items-center gap-2 shadow-sm">
                <span>Simpan & Aktifkan Profil Influencer</span>
                <span>&rarr;</span>
            </button>
        </div>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputFoto = document.getElementById('foto_profil');
        const previewEl = document.getElementById('preview-foto-influencer');
        const placeholderEl = document.getElementById('placeholder-foto-influencer');

        if (inputFoto && previewEl) {
            inputFoto.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        previewEl.src = event.target.result;
                        previewEl.classList.remove('hidden');
                        if (placeholderEl) {
                            placeholderEl.classList.add('hidden');
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endsection
