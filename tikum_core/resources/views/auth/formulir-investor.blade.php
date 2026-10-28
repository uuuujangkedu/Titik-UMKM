@extends('layouts.auth')

@section('title', 'Formulir Pendaftaran Investor - Daya UMKM')

@section('content')
<div class="w-full max-w-5xl mx-auto px-4 sm:px-8 py-10 space-y-7">

    <!-- Progress Indicator Stepper -->
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
                <span class="text-[13px] font-bold text-[#0b5a4a] block">Langkah 2: Formulir investor</span>
                <span class="text-[11px] text-[#4b5551]">Lengkapi identitas & preferensi minat</span>
            </div>
        </div>

        <div class="hidden sm:block w-12 h-px bg-[#e2e1d8]"></div>

        <div class="flex items-center gap-3 opacity-60">
            <span class="w-7 h-7 rounded-[6px] bg-[#f7f6f1] text-[#4b5551] border border-[#e2e1d8] flex items-center justify-center font-bold text-[12px]">
                3
            </span>
            <div>
                <span class="text-[13px] font-bold text-[#161d1a] block">Langkah 3: Dashboard & mulai danai</span>
                <span class="text-[11px] text-[#4b5551]">Katalog siap diakses</span>
            </div>
        </div>
    </div>

    <!-- Title Header -->
    <div class="flex items-start sm:items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-[26px] sm:text-[30px] font-bold text-[#161d1a] leading-tight">
                Formulir pendaftaran investor
            </h1>
            <p class="text-[14px] text-[#4b5551] mt-1">
                Lengkapi data profil pemodal dan preferensi sektor UMKM yang ingin Anda biayai.
            </p>
        </div>

        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-[6px] bg-[#d8ebe5]/60 text-[#0b5a4a] text-[13px] font-medium border border-[#b2d5cc]">
            <span>Akun {{ $user->email }} (Aktif)</span>
        </div>
    </div>

    @if (session('success'))
        <div class="p-3.5 rounded-[6px] bg-[#d8ebe5]/60 border border-[#b2d5cc] text-[#084539] text-[14px]">
            {{ session('success') }}
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

    <form action="{{ route('formulir.investor.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf        <!-- CARD 1: ALUR VERIFIKASI INVESTOR -->
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
                    <span>Admin akan mengonfirmasi profil preferensi akun Anda.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="font-bold text-[#0b5a4a]">3.</span>
                    <span>Setelah selesai, Anda dapat langsung mulai mendanai UMKM produktif pilihan di katalog.</span>
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
                        @if($user->avatar)
                            <img id="preview-foto-investor" src="{{ $user->avatar }}" alt="Preview" class="w-full h-full object-cover">
                        @else
                            <img id="preview-foto-investor" src="" alt="Preview" class="w-full h-full object-cover hidden">
                            <span id="placeholder-foto-investor" class="text-2xl text-[#0b5a4a]">📷</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" 
                               id="foto_profil" 
                               name="foto_profil" 
                               accept="image/png,image/jpeg,image/webp,image/jpg" 
                               onchange="previewImage(this, 'preview-foto-investor', 'placeholder-foto-investor')"
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
                       value="{{ old('nama', $user->name) }}" 
                       required
                       placeholder="Contoh: Raka Wibian" 
                       class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
            </div>

            <!-- Nomor WhatsApp & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div>
                    <label for="nomor_telepon" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        Nomor WhatsApp aktif <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nomor_telepon" 
                           name="nomor_telepon" 
                           value="{{ old('nomor_telepon', $user->phone_number) }}" 
                           required
                           placeholder="Contoh: 081234567890" 
                           class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
                </div>

                <div>
                    <label class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        Alamat email akun
                    </label>
                    <input type="email" 
                           value="{{ $user->email }}" 
                           disabled
                           class="w-full h-11 px-3.5 bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[14px] text-[#4b5551] outline-none cursor-not-allowed">
                    <span class="text-[12px] text-[#0b5a4a] font-medium mt-1.5 block">Email telah terverifikasi</span>
                </div>
            </div>

            <!-- Wilayah Domisili -->
            <x-wilayah-domisili 
                label="Wilayah domisili / kantor"
                :provinsi="old('provinsi', $user->provinsi)"
                :kota="old('kota', $user->kota)"
                :provinsi-kota="old('provinsi_kota', $user->provinsi_kota)"
                :kecamatan="old('kecamatan', $user->kecamatan)"
                :kelurahan="old('kelurahan', $user->kelurahan)"
                :rt="old('rt', $user->rt)"
                :rw="old('rw', $user->rw)"
                id-prefix="investor_domisili"
            />
        </div>

        <!-- CARD 3: BAGIAN 2 - INFORMASI UMKM / MINAT INVESTASI -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5 flex items-center justify-between flex-wrap gap-2">
                <div>
                    <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 2</span>
                    <h3 class="text-[18px] font-bold text-[#161d1a]">Katalog minat pendanaan</h3>
                </div>
                <div class="text-[13px] text-[#4b5551]" id="umkm-count-container">
                    Pilih kategori atau <span class="font-semibold text-[#0b5a4a]">klik kartu UMKM</span> yang diminati (<span id="umkm-count-label" class="font-bold text-[#0b5a4a]">0 dipilih</span>)
                </div>
            </div>

            <!-- Kategori Filter Tabs -->
            <input type="hidden" name="kategori_diminati" id="kategori_diminati" value="{{ old('kategori_diminati', $user->kategori_diminati ?? 'Semua') }}">
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

            <!-- UMKM Grid (Interaktif & Dapat Diklik/Dipilih) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-1" id="umkm-grid">
                @forelse ($umkms as $index => $umkm)
                    <label class="umkm-card cursor-pointer block group select-none relative" data-category="{{ $umkm->jenis_usaha }}">
                        <input type="checkbox" 
                               name="umkm_diminati[]" 
                               value="{{ $umkm->id_umkm }}" 
                               class="hidden peer" 
                               onchange="updateSelectedUmkmCount()">

                        <div class="rounded-[10px] border border-[#e2e1d8] peer-checked:border-[#0b5a4a] peer-checked:ring-2 peer-checked:ring-[#0b5a4a] peer-checked:bg-[#f2f8ed]/40 bg-white p-3 transition flex flex-col h-full shadow-2xs hover:border-[#0b5a4a] hover:shadow-sm relative">
                            
                            <!-- Indikator Checkmark Terpilih di Pojok Kanan Atas -->
                            <div class="absolute top-2.5 right-2.5 z-10">
                                <span class="w-6 h-6 rounded-full bg-white/90 border border-gray-300 peer-checked:bg-[#0b5a4a] peer-checked:border-[#0b5a4a] flex items-center justify-center transition shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-gray-300 peer-checked:text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                            </div>

                            <!-- Foto Asli Produk / Usaha UMKM -->
                            <div class="w-full aspect-[4/3] rounded-[8px] overflow-hidden mb-2.5 bg-[#d8ebe5] relative border border-[#e2e1d8]">
                                <img src="{{ $umkm->foto_url }}" 
                                     alt="{{ $umkm->nama_usaha }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300" 
                                     loading="lazy">
                                <span class="absolute bottom-2 left-2 px-2 py-0.5 rounded-md bg-black/60 backdrop-blur-xs text-white text-[10px] font-bold">
                                    {{ $umkm->jenis_usaha }}
                                </span>
                            </div>

                            <!-- Detail UMKM -->
                            <div class="mt-1 text-left space-y-1">
                                <div class="text-[13px] font-bold text-[#161d1a] line-clamp-1 umkm-title group-hover:text-[#0b5a4a] transition">
                                    {{ $umkm->nama_usaha }}
                                </div>
                                <div class="text-[11px] text-[#4b5551] line-clamp-1">Pemilik: {{ $umkm->pemilik }}</div>
                                <div class="pt-1 text-[11px] font-semibold text-[#0b5a4a] flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Peluang Investasi
                                </div>
                            </div>
                        </div>
                    </label>
                @empty
                    <div class="col-span-4 p-6 text-center text-[14px] text-[#4b5551] bg-[#f7f6f1] rounded-[6px] border border-dashed border-[#e2e1d8]">
                        Belum ada data UMKM terdaftar saat ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="btn-primary w-full h-12 rounded-[8px] text-[15px] font-bold shadow-xs flex items-center justify-center">
                Simpan formulir investor dan buka dashboard
            </button>
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

    function updateSelectedUmkmCount() {
        const checkedCount = document.querySelectorAll('input[name="umkm_diminati[]"]:checked').length;
        const label = document.getElementById('umkm-count-label');
        if (label) {
            if (checkedCount > 0) {
                label.textContent = `${checkedCount} UMKM dipilih ✓`;
            } else {
                label.textContent = '0 dipilih';
            }
        }
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
