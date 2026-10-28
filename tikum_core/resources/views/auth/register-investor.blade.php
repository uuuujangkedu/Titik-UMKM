@extends('layouts.auth')

@section('title', 'Formulir Pendaftaran Investor - Daya UMKM')

@section('content')
<div class="w-full max-w-5xl mx-auto px-4 sm:px-8 py-10 space-y-7">

    <!-- Top Role Tab Switcher -->
    <div class="flex items-center justify-between flex-wrap gap-4 bg-white p-3 rounded-[12px] border border-[#e2e1d8]">
        <span class="text-[13px] font-semibold text-[#4b5551] px-2">Pilih jenis pendaftaran:</span>
        <div class="flex items-center gap-2">
            <a href="{{ route('register.umkm') }}" 
               class="px-4 py-2 rounded-[6px] text-[13px] font-medium bg-[#f7f6f1] text-[#4b5551] hover:text-[#0b5a4a] hover:bg-[#d8ebe5] transition border border-[#e2e1d8] flex items-center gap-2">
                <span>Pelaku UMKM</span>
            </a>
            <a href="{{ route('register.investor') }}" 
               class="px-4 py-2 rounded-[6px] text-[13px] font-semibold bg-[#0b5a4a] text-white flex items-center gap-2 transition">
                <span>Investor</span>
            </a>
            <a href="{{ route('register.influencer') }}" 
               class="px-4 py-2 rounded-[6px] text-[13px] font-medium bg-[#f7f6f1] text-[#4b5551] hover:text-[#0b5a4a] hover:bg-[#d8ebe5] transition border border-[#e2e1d8] flex items-center gap-2">
                <span>Mitra Influencer</span>
            </a>
        </div>
    </div>

    <!-- Title Header -->
    <div class="flex items-start sm:items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-[26px] sm:text-[30px] font-bold text-[#161d1a] leading-tight">
                Formulir pendaftaran investor
            </h1>
            <p class="text-[14px] text-[#4b5551] mt-1">
                Daftarkan diri Anda sebagai pemodal mitra untuk mendanai usaha produktif dengan sistem bagi hasil yang transparan.
            </p>
        </div>

        <a href="{{ route('google.redirect', ['role' => 'investor']) }}"
           class="inline-flex items-center gap-2.5 px-4 py-2.5 border border-[#e2e1d8] hover:border-[#0b5a4a] rounded-[6px] text-[13px] font-medium text-[#161d1a] bg-white hover:bg-[#f7f6f1] transition">
            <svg class="w-4 h-4" viewBox="0 0 24 24" aria-hidden="true">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
            </svg>
            <span>Daftar dengan Google</span>
        </a>
    </div>

    <!-- Alert Errors -->
    @if ($errors->any())
        <div class="p-4 rounded-[6px] bg-[#fee2e2] border border-[#fca5a5] text-[#991b1b] text-[13px] space-y-1">
            <div class="font-semibold">Mohon periksa kembali formulir Anda:</div>
            <ul class="list-disc list-inside pl-1 text-[12px] space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="role" value="investor">

        <!-- CARD 1: ALUR VERIFIKASI INVESTOR -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] shadow-xs">
            <h2 class="text-[16px] font-bold text-[#161d1a] mb-3">
                Alur verifikasi investor
            </h2>
            <ol class="space-y-2 text-[14px] text-[#4b5551] leading-relaxed">
                <li class="flex items-start gap-2.5">
                    <span class="font-bold text-[#0b5a4a]">1.</span>
                    <span>Isi formulir identitas penanggung jawab dan preferensi investasi di bawah ini.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="font-bold text-[#0b5a4a]">2.</span>
                    <span>Admin akan mengonfirmasi data akun dan verifikasi email via kode OTP.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="font-bold text-[#0b5a4a]">3.</span>
                    <span>Setelah verifikasi selesai, akun investor Anda aktif dan siap mulai menanamkan modal pada UMKM pilihan.</span>
                </li>
            </ol>
        </div>

        <!-- CARD 2: BAGIAN 1 - IDENTITAS PENDAFTAR INVESTOR -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5">
                <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 1</span>
                <h3 class="text-[18px] font-bold text-[#161d1a]">Identitas pendaftar investor</h3>
            </div>

            <!-- Foto Profil Investor -->
            <div>
                <label for="foto_profil" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                    Foto Profil Investor (Opsional)
                </label>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#f7f6f1] border-2 border-dashed border-[#b2d5cc] overflow-hidden flex items-center justify-center shrink-0">
                        <img id="preview-foto-reg-investor" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        <span id="placeholder-foto-reg-investor" class="text-2xl text-[#0b5a4a]">📷</span>
                    </div>
                    <div class="flex-1">
                        <input type="file" 
                               id="foto_profil" 
                               name="foto_profil" 
                               accept="image/png,image/jpeg,image/webp,image/jpg" 
                               onchange="previewImage(this, 'preview-foto-reg-investor', 'placeholder-foto-reg-investor')"
                               class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#d8ebe5] file:text-[#0b5a4a] hover:file:bg-[#b2d5cc] cursor-pointer">
                        <p class="text-[11px] text-gray-500 mt-1">Format JPG, PNG, atau WEBP. Maksimal 3MB.</p>
                    </div>
                </div>
            </div>

            <!-- Nama Lengkap Investor -->
            <div>
                <label for="nama" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                    Nama lengkap investor <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama" 
                       name="nama" 
                       value="{{ old('nama') }}" 
                       required
                       placeholder="Contoh: Raka Wibian" 
                       class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
            </div>

            <!-- Nomor WhatsApp -->
            <div>
                <label for="nomor_telepon" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                    Nomor WhatsApp <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nomor_telepon" 
                       name="nomor_telepon" 
                       value="{{ old('nomor_telepon') }}" 
                       required
                       placeholder="Contoh: 081234567890" 
                       class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
            </div>

            <!-- Wilayah Domisili / Kantor -->
            <x-wilayah-domisili 
                label="Wilayah domisili / kantor"
                :provinsi="old('provinsi')"
                :kota="old('kota')"
                :provinsi-kota="old('provinsi_kota')"
                :kecamatan="old('kecamatan')"
                :kelurahan="old('kelurahan')"
                :rt="old('rt')"
                :rw="old('rw')"
                :required="false"
                id-prefix="reg_inv_domisili"
            />

            <!-- Kredensial Akun -->
            <div class="pt-4 border-t border-[#e2e1d8] space-y-4">
                <div>
                    <label for="email" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        Alamat email akun <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required
                           placeholder="investor@email.com (Untuk masuk akun dan menerima kode OTP)" 
                           class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <div>
                        <label for="password" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                            Kata sandi akun <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               placeholder="Minimal 8 karakter" 
                               class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                            Konfirmasi kata sandi <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required
                               placeholder="Ulangi kata sandi Anda" 
                               class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 3: BAGIAN 2 - INFORMASI UMKM / MINAT INVESTASI -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5 flex items-center justify-between flex-wrap gap-2">
                <div>
                    <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 2</span>
                    <h3 class="text-[18px] font-bold text-[#161d1a]">Katalog minat pendanaan</h3>
                </div>
                <span class="text-[13px] text-[#4b5551]">Pilih kategori sektor yang ingin Anda danai</span>
            </div>

            <!-- Kategori Filter Tabs -->
            <input type="hidden" name="kategori_diminati" id="kategori_diminati" value="{{ old('kategori_diminati', 'Semua') }}">
            <div class="flex items-center gap-2 flex-wrap">
                <button type="button" 
                        onclick="selectCategory('Semua', this)"
                        class="cat-filter-btn h-10 px-4 rounded-[6px] text-[13px] font-semibold bg-[#0b5a4a] text-white transition">
                    Semua
                </button>
                <button type="button" 
                        onclick="selectCategory('Makanan', this)"
                        class="cat-filter-btn h-10 px-4 rounded-[6px] text-[13px] font-medium bg-[#f7f6f1] text-[#4b5551] hover:bg-[#d8ebe5] hover:text-[#0b5a4a] border border-[#e2e1d8] transition">
                    Makanan & minuman
                </button>
                <button type="button" 
                        onclick="selectCategory('Jasa', this)"
                        class="cat-filter-btn h-10 px-4 rounded-[6px] text-[13px] font-medium bg-[#f7f6f1] text-[#4b5551] hover:bg-[#d8ebe5] hover:text-[#0b5a4a] border border-[#e2e1d8] transition">
                    Jasa layanan
                </button>
                <button type="button" 
                        onclick="selectCategory('Fashion', this)"
                        class="cat-filter-btn h-10 px-4 rounded-[6px] text-[13px] font-medium bg-[#f7f6f1] text-[#4b5551] hover:bg-[#d8ebe5] hover:text-[#0b5a4a] border border-[#e2e1d8] transition">
                    Fashion
                </button>
                <button type="button" 
                        onclick="selectCategory('Agribisnis', this)"
                        class="cat-filter-btn h-10 px-4 rounded-[6px] text-[13px] font-medium bg-[#f7f6f1] text-[#4b5551] hover:bg-[#d8ebe5] hover:text-[#0b5a4a] border border-[#e2e1d8] transition">
                    Agribisnis
                </button>
            </div>

            <!-- Search Bar UMKM -->
            <div class="relative flex items-center">
                <svg class="w-4 h-4 text-[#4b5551] absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" 
                       id="umkm-search" 
                       onkeyup="filterUmkmCards()" 
                       placeholder="Telusuri UMKM berdasarkan nama atau bidang..." 
                       class="w-full h-11 pl-10 pr-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] outline-none transition">
            </div>

            <!-- UMKM Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-1" id="umkm-grid">
                @forelse ($umkms as $index => $umkm)
                    <div class="umkm-card block group" data-category="{{ $umkm->jenis_usaha }}">
                        <div class="rounded-[10px] border border-[#e2e1d8] bg-white p-3 transition flex flex-col h-full shadow-2xs hover:border-[#0b5a4a] hover:shadow-sm">
                            <div class="w-full aspect-[4/3] rounded-[6px] bg-[#d8ebe5] flex flex-col items-center justify-center p-3 text-center">
                                <svg class="w-6 h-6 text-[#0b5a4a] mb-1" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span class="font-bold text-[12px] leading-tight text-[#0b5a4a]">{{ $umkm->nama_usaha }}</span>
                            </div>

                            <!-- Detail UMKM -->
                            <div class="mt-2 text-left space-y-1">
                                <div class="text-[13px] font-bold text-[#161d1a] line-clamp-1 umkm-title">{{ $umkm->nama_usaha }}</div>
                                <div class="flex items-center gap-1.5">
                                    <span class="inline-block px-2 py-0.5 rounded-[6px] text-[11px] font-medium bg-[#f7f6f1] border border-[#e2e1d8] text-[#4b5551] umkm-cat">
                                        {{ $umkm->jenis_usaha }}
                                    </span>
                                </div>
                                <div class="text-[12px] text-[#4b5551] line-clamp-1">Pemilik: {{ $umkm->pemilik }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 p-6 text-center text-[14px] text-[#4b5551] bg-[#f7f6f1] rounded-[6px] border border-dashed border-[#e2e1d8]">
                        Belum ada data UMKM terdaftar saat ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Submit Button & Login Link -->
        <div class="pt-2 space-y-4">
            <button type="submit" class="btn-primary w-full h-12 rounded-[8px] text-[15px] font-bold shadow-xs flex items-center justify-center">
                Daftar sebagai investor dan kirim kode OTP
            </button>

            <div class="text-center text-[14px] text-[#4b5551]">
                Sudah memiliki akun Daya UMKM? 
                <a href="{{ route('login') }}" class="font-semibold text-[#0b5a4a] hover:underline ml-1">Masuk di sini</a>
            </div>
        </div>

    </form>

</div>

<script>
    let currentSelectedCategory = 'Semua';

    function selectCategory(category, btnElement) {
        currentSelectedCategory = category;
        document.getElementById('kategori_diminati').value = category;

        document.querySelectorAll('.cat-filter-btn').forEach(btn => {
            btn.classList.remove('bg-[#0b5a4a]', 'text-white');
            btn.classList.add('bg-[#f7f6f1]', 'text-[#4b5551]', 'border', 'border-[#e2e1d8]');
        });

        btnElement.classList.remove('bg-[#f7f6f1]', 'text-[#4b5551]', 'border', 'border-[#e2e1d8]');
        btnElement.classList.add('bg-[#0b5a4a]', 'text-white');

        filterUmkmCards();
    }

    function filterUmkmCards() {
        const query = document.getElementById('umkm-search').value.toLowerCase();
        const cards = document.querySelectorAll('.umkm-card');

        cards.forEach(card => {
            const title = card.querySelector('.umkm-title').innerText.toLowerCase();
            const cat = card.getAttribute('data-category');
            
            const matchesQuery = title.includes(query);
            const matchesCat = (currentSelectedCategory === 'Semua' || cat.toLowerCase() === currentSelectedCategory.toLowerCase());

            if (matchesQuery && matchesCat) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function previewImage(input, previewId, placeholderId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
