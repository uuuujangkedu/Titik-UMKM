@extends('layouts.auth')

@section('title', 'Formulir Pendaftaran UMKM - Daya UMKM')

@section('content')
<div class="w-full max-w-4xl mx-auto px-4 sm:px-6 py-8 space-y-6">

    <!-- Top Role Tab Switcher -->
    <div class="flex items-center justify-between flex-wrap gap-4 bg-white p-3 rounded-[12px] border border-[#e2e1d8]">
        <span class="text-[13px] font-semibold text-[#4b5551] px-2">Pilih jenis pendaftaran:</span>
        <div class="flex items-center gap-2">
            <a href="{{ route('register.umkm') }}" 
               class="px-4 py-2 rounded-[6px] text-[13px] font-semibold bg-[#0b5a4a] text-white flex items-center gap-2 transition">
                <span>Pelaku UMKM</span>
            </a>
            <a href="{{ route('register.investor') }}" 
               class="px-4 py-2 rounded-[6px] text-[13px] font-medium bg-[#f7f6f1] text-[#4b5551] hover:text-[#0b5a4a] hover:bg-[#d8ebe5] transition border border-[#e2e1d8] flex items-center gap-2">
                <span>Investor</span>
            </a>
        </div>
    </div>

    <!-- Title Header -->
    <div class="flex items-start sm:items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-[26px] sm:text-[30px] font-bold text-[#161d1a] leading-tight">
                Formulir pendaftaran UMKM
            </h1>
            <p class="text-[14px] text-[#4b5551] mt-1">
                Lengkapi data diri, profil usaha, dan preferensi lokasi ruko untuk diverifikasi oleh tim Daya UMKM.
            </p>
        </div>

        <a href="{{ route('google.redirect', ['role' => 'umkm']) }}"
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
        <input type="hidden" name="role" value="umkm">

        <!-- CARD 1: ALUR VERIFIKASI UMKM -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] shadow-xs">
            <h2 class="text-[16px] font-bold text-[#161d1a] mb-3">
                Alur verifikasi UMKM
            </h2>
            <ol class="space-y-2 text-[14px] text-[#4b5551] leading-relaxed">
                <li class="flex items-start gap-2.5">
                    <span class="font-bold text-[#0b5a4a]">1.</span>
                    <span>Isi formulir identitas penanggung jawab dan detail produk di bawah ini.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="font-bold text-[#0b5a4a]">2.</span>
                    <span>Admin akan mengonfirmasi data dan verifikasi keabsahan profil usaha.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="font-bold text-[#0b5a4a]">3.</span>
                    <span>Setelah verifikasi selesai, profil usaha Anda otomatis tayang di katalog investor dan siap menerima modal atau sewa ruko.</span>
                </li>
            </ol>
        </div>

        <!-- CARD 2: BAGIAN 1 - IDENTITAS PENGAJU UMKM -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5">
                <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 1</span>
                <h3 class="text-[18px] font-bold text-[#161d1a]">Identitas pengaju UMKM</h3>
            </div>

            <!-- Foto Profil Pemilik Usaha -->
            <div>
                <label for="foto_profil" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                    Foto Profil Pemilik Usaha (Opsional)
                </label>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#f7f6f1] border-2 border-dashed border-[#b2d5cc] overflow-hidden flex items-center justify-center shrink-0">
                        <img id="preview-foto-reg-umkm" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        <span id="placeholder-foto-reg-umkm" class="text-2xl text-[#0b5a4a]">📷</span>
                    </div>
                    <div class="flex-1">
                        <input type="file" 
                               id="foto_profil" 
                               name="foto_profil" 
                               accept="image/png,image/jpeg,image/webp,image/jpg" 
                               onchange="previewImage(this, 'preview-foto-reg-umkm', 'placeholder-foto-reg-umkm')"
                               class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#d8ebe5] file:text-[#0b5a4a] hover:file:bg-[#b2d5cc] cursor-pointer">
                        <p class="text-[11px] text-gray-500 mt-1">Format JPG, PNG, atau WEBP. Maksimal 3MB.</p>
                    </div>
                </div>
            </div>

            <!-- Nama Lengkap Pemilik -->
            <div>
                <label for="nama" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                    Nama lengkap pemilik / pengelola usaha <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama" 
                       name="nama" 
                       value="{{ old('nama') }}" 
                       required
                       placeholder="Contoh: Raka Wibian" 
                       class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
            </div>

            <!-- Nomor WhatsApp Usaha -->
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

            <!-- Wilayah Domisili Usaha -->
            <x-wilayah-domisili 
                label="Wilayah domisili usaha"
                :provinsi="old('provinsi')"
                :kota="old('kota')"
                :provinsi-kota="old('provinsi_kota')"
                :kecamatan="old('kecamatan')"
                :kelurahan="old('kelurahan')"
                :rt="old('rt')"
                :rw="old('rw')"
                :required="true"
                id-prefix="reg_umkm_domisili"
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
                           placeholder="usaha@email.com (Digunakan untuk masuk dan menerima OTP)" 
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

        <!-- CARD 3: BAGIAN 2 - INFORMASI USAHA & PRODUK -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5">
                <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 2</span>
                <h3 class="text-[18px] font-bold text-[#161d1a]">Informasi usaha & produk</h3>
            </div>

            <!-- Nama Usaha -->
            <div>
                <label for="nama_usaha" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                    Nama usaha <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama_usaha" 
                       name="nama_usaha" 
                       value="{{ old('nama_usaha') }}" 
                       required
                       placeholder="Contoh: Kopi Muria Sejahtera" 
                       class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
            </div>

            <!-- Kategori Usaha & Foto Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 items-start">
                <div>
                    <label for="kategori_usaha" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        Kategori usaha <span class="text-red-500">*</span>
                    </label>
                    <select id="kategori_usaha" 
                            name="kategori_usaha" 
                            required
                            class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none cursor-pointer">
                        <option value="">Pilih kategori usaha</option>
                        <option value="Makanan" {{ old('kategori_usaha') === 'Makanan' ? 'selected' : '' }}>Makanan & minuman</option>
                        <option value="Jasa" {{ old('kategori_usaha') === 'Jasa' ? 'selected' : '' }}>Jasa layanan</option>
                        <option value="Fashion" {{ old('kategori_usaha') === 'Fashion' ? 'selected' : '' }}>Fashion & pakaian</option>
                        <option value="Agribisnis" {{ old('kategori_usaha') === 'Agribisnis' ? 'selected' : '' }}>Agribisnis & pertanian</option>
                        <option value="Retail" {{ old('kategori_usaha') === 'Retail' ? 'selected' : '' }}>Retail & toko kelontong</option>
                        <option value="Kreatif" {{ old('kategori_usaha') === 'Kreatif' ? 'selected' : '' }}>Industri kreatif & kerajinan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        Foto produk / banner usaha
                    </label>
                    <div class="relative flex items-center">
                        <input type="file" 
                               id="foto_produk" 
                               name="foto_produk" 
                               accept="image/*"
                               class="hidden" 
                               onchange="updateFileName(this, 'foto_produk_label')">
                        <label for="foto_produk" 
                               id="foto_produk_label"
                               class="w-full h-11 px-3.5 bg-[#f7f6f1] hover:bg-[#d8ebe5] text-[#0b5a4a] border border-dashed border-[#0b5a4a] rounded-[6px] text-[13px] font-medium text-center cursor-pointer transition flex items-center justify-center gap-2">
                            <span>Pilih file foto</span>
                        </label>
                    </div>
                    <span class="text-[12px] text-[#4b5551] mt-1.5 block">Format: JPG, PNG, WEBP (Maks. 5MB)</span>
                </div>
            </div>

            <!-- Deskripsi Usaha & File Proposal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 items-start">
                <div>
                    <label for="deskripsi" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        Deskripsi singkat usaha
                    </label>
                    <textarea id="deskripsi" 
                              name="deskripsi" 
                              rows="3" 
                              placeholder="Jelaskan jenis produk, keunikan usaha, dan target pasar Anda..."
                              class="w-full px-3.5 py-3 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none min-h-[96px] resize-y">{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-[14px] font-semibold text-[#161d1a]">
                            File proposal usaha
                        </label>
                        <a href="#" onclick="alert('Format proposal meliputi profil usaha, rencana penggunaan modal, dan estimasi bagi hasil bulanan.'); return false;" class="text-[12px] text-[#0b5a4a] hover:underline font-medium">
                            Format panduan
                        </a>
                    </div>
                    <div class="relative flex items-center">
                        <input type="file" 
                               id="file_proposal" 
                               name="file_proposal" 
                               accept=".pdf,.doc,.docx,.zip"
                               class="hidden" 
                               onchange="updateFileName(this, 'file_proposal_label')">
                        <label for="file_proposal" 
                               id="file_proposal_label"
                               class="w-full h-11 px-3.5 bg-[#f7f6f1] hover:bg-[#d8ebe5] text-[#0b5a4a] border border-dashed border-[#0b5a4a] rounded-[6px] text-[13px] font-medium text-center cursor-pointer transition flex items-center justify-center gap-2">
                            <span>Pilih file dokumen</span>
                        </label>
                    </div>
                    <span class="text-[12px] text-[#4b5551] mt-1.5 block">Format: PDF, DOC, DOCX, ZIP (Maks. 10MB)</span>
                </div>
            </div>
        </div>

        <!-- CARD 4: BAGIAN 3 - LOKASI RUKO -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5 flex items-center justify-between flex-wrap gap-2">
                <div>
                    <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 3</span>
                    <h3 class="text-[18px] font-bold text-[#161d1a]">Lokasi ruko (pilihan minat sewa)</h3>
                </div>
                <span class="text-[13px] text-[#4b5551]">Opsional: Pilih jika Anda membutuhkan tempat ruko</span>
            </div>

            <!-- Search Bar Ruko -->
            <div class="relative flex items-center">
                <svg class="w-4 h-4 text-[#4b5551] absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" 
                       id="ruko-search" 
                       onkeyup="filterRukoCards()" 
                       placeholder="Telusuri ruko berdasarkan nama atau lokasi..." 
                       class="w-full h-11 pl-10 pr-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] outline-none transition">
            </div>

            <!-- Grid Ruko -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-1" id="ruko-grid">
                @forelse ($rukos as $index => $ruko)
                    <label class="ruko-card cursor-pointer block group">
                        <input type="radio" 
                               name="id_ruko" 
                               value="{{ $ruko->id_ruko }}" 
                               class="hidden peer"
                               {{ old('id_ruko') == $ruko->id_ruko ? 'checked' : '' }}>
                        
                        <div class="rounded-[10px] border border-[#e2e1d8] peer-checked:border-[#0b5a4a] peer-checked:ring-2 peer-checked:ring-[#0b5a4a] bg-white p-3 transition flex flex-col h-full shadow-2xs hover:border-[#0b5a4a] hover:shadow-sm">
                            <div class="w-full aspect-[16/10] rounded-[8px] overflow-hidden mb-2.5 bg-[#f2f8ed] relative border border-[#e2e1d8]">
                                <img src="{{ $ruko->foto_url }}" 
                                     alt="{{ $ruko->nama_ruko }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                     loading="lazy">
                                <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-black/60 backdrop-blur-xs text-white text-[10px] font-bold">
                                    Daya Ruko
                                </span>
                            </div>

                            <!-- Detail Ruko -->
                            <div class="mt-2 text-left space-y-1">
                                <div class="text-[13px] font-bold text-[#161d1a] line-clamp-1 ruko-title">{{ $ruko->nama_ruko }}</div>
                                <div class="text-[12px] text-[#4b5551] line-clamp-1 ruko-loc">{{ $ruko->lokasi }}</div>
                                <div class="text-[12px] font-semibold text-[#0b5a4a]">
                                    Rp {{ number_format($ruko->harga_sewa_per_bulan, 0, ',', '.') }} / bln
                                </div>
                            </div>
                        </div>
                    </label>
                @empty
                    <div class="col-span-4 p-6 text-center text-[14px] text-[#4b5551] bg-[#f7f6f1] rounded-[6px] border border-dashed border-[#e2e1d8]">
                        Belum ada unit ruko yang terdaftar saat ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Submit Button & Login Link -->
        <div class="pt-2 space-y-4">
            <button type="submit" class="btn-primary w-full h-12 rounded-[8px] text-[15px] font-bold shadow-xs flex items-center justify-center">
                Daftar pelaku UMKM dan kirim kode OTP
            </button>

            <div class="text-center text-[14px] text-[#4b5551]">
                Sudah memiliki akun Daya UMKM? 
                <a href="{{ route('login') }}" class="font-semibold text-[#0b5a4a] hover:underline ml-1">Masuk di sini</a>
            </div>
        </div>

    </form>

</div>

<script>
    function updateFileName(input, labelId) {
        const label = document.getElementById(labelId);
        if (input.files && input.files.length > 0) {
            label.innerHTML = `
                <span class="truncate max-w-[200px] text-[#0b5a4a] font-semibold">${input.files[0].name}</span>
            `;
            label.classList.add('bg-[#d8ebe5]', 'border-[#0b5a4a]');
        }
    }

    function filterRukoCards() {
        const query = document.getElementById('ruko-search').value.toLowerCase();
        const cards = document.querySelectorAll('.ruko-card');
        cards.forEach(card => {
            const title = card.querySelector('.ruko-title').innerText.toLowerCase();
            const loc = card.querySelector('.ruko-loc').innerText.toLowerCase();
            if (title.includes(query) || loc.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
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
