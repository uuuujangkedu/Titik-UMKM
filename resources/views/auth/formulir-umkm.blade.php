@extends('layouts.auth')

@section('title', 'Formulir Pendaftaran Pelaku UMKM - Daya UMKM')

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
                <span class="text-[13px] font-bold text-[#0b5a4a] block">Langkah 2: Formulir UMKM & ruko</span>
                <span class="text-[11px] text-[#4b5551]">Lengkapi profil usaha & dokumen</span>
            </div>
        </div>

        <div class="hidden sm:block w-12 h-px bg-[#e2e1d8]"></div>

        <div class="flex items-center gap-3 opacity-60">
            <span class="w-7 h-7 rounded-[6px] bg-[#f7f6f1] text-[#4b5551] border border-[#e2e1d8] flex items-center justify-center font-bold text-[12px]">
                3
            </span>
            <div>
                <span class="text-[13px] font-bold text-[#161d1a] block">Langkah 3: Verifikasi admin & tayang</span>
                <span class="text-[11px] text-[#4b5551]">Siap menerima modal investor</span>
            </div>
        </div>
    </div>

    <!-- Title Header -->
    <div class="flex items-start sm:items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-[26px] sm:text-[30px] font-bold text-[#161d1a] leading-tight">
                Formulir pendaftaran pelaku UMKM
            </h1>
            <p class="text-[14px] text-[#4b5551] mt-1">
                Lengkapi data diri, profil usaha, dan preferensi lokasi ruko untuk diverifikasi oleh tim Daya UMKM.
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

    <form action="{{ route('formulir.umkm.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf        <!-- CARD 1: ALUR VERIFIKASI UMKM -->
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
                        @if($user->avatar)
                            <img id="preview-foto-umkm" src="{{ $user->avatar }}" alt="Preview" class="w-full h-full object-cover">
                        @else
                            <img id="preview-foto-umkm" src="" alt="Preview" class="w-full h-full object-cover hidden">
                            <span id="placeholder-foto-umkm" class="text-2xl text-[#0b5a4a]">📷</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" 
                               id="foto_profil" 
                               name="foto_profil" 
                               accept="image/png,image/jpeg,image/webp,image/jpg" 
                               onchange="previewImage(this, 'preview-foto-umkm', 'placeholder-foto-umkm')"
                               class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#d8ebe5] file:text-[#0b5a4a] hover:file:bg-[#b2d5cc] cursor-pointer">
                        <p class="text-[11px] text-gray-500 mt-1">Format JPG, PNG, atau WEBP. Maksimal 3MB.</p>
                    </div>
                </div>
            </div>

            <!-- Nama Lengkap Pemilik -->
            <div>
                <label for="pemilik" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                    Nama lengkap pemilik / pengelola usaha <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="pemilik" 
                       name="pemilik" 
                       value="{{ old('pemilik', $umkm->pemilik ?? $user->name) }}" 
                       required
                       placeholder="Contoh: Raka Wibian" 
                       class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
            </div>

            <!-- NIK KTP & Nomor WhatsApp Usaha -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div>
                    <label for="nik_penanggung_jawab" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        NIK KTP penanggung jawab
                    </label>
                    <input type="text" 
                           id="nik_penanggung_jawab" 
                           name="nik_penanggung_jawab" 
                           value="{{ old('nik_penanggung_jawab', $umkm->nik_penanggung_jawab) }}" 
                           placeholder="16 digit NIK KTP" 
                           maxlength="20"
                           class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
                </div>

                <div>
                    <label for="nomor_whatsapp" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        Nomor WhatsApp usaha aktif <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nomor_whatsapp" 
                           name="nomor_whatsapp" 
                           value="{{ old('nomor_whatsapp', $umkm->nomor_whatsapp ?? $user->phone_number) }}" 
                           required
                           placeholder="Contoh: 081234567890" 
                           class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
                </div>
            </div>

            <!-- Wilayah Usaha -->
            <x-wilayah-domisili 
                label="Wilayah domisili usaha"
                :provinsi="old('provinsi', $umkm->provinsi ?? $user->provinsi)"
                :kota="old('kota', $umkm->kota ?? $user->kota)"
                :provinsi-kota="old('provinsi_kota', $umkm->provinsi_kota ?? $user->provinsi_kota)"
                :kecamatan="old('kecamatan', $umkm->kecamatan ?? $user->kecamatan)"
                :kelurahan="old('kelurahan', $umkm->kelurahan ?? $user->kelurahan)"
                :rt="old('rt', $umkm->rt ?? $user->rt)"
                :rw="old('rw', $umkm->rw ?? $user->rw)"
                id-prefix="umkm_domisili"
            />
        </div>

        <!-- CARD 3: BAGIAN 2 - INFORMASI USAHA & PRODUK -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5">
                <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 2</span>
                <h3 class="text-[18px] font-bold text-[#161d1a]">Informasi usaha & produk</h3>
            </div>

            <!-- Nama Usaha & Jenis Usaha -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div>
                    <label for="nama_usaha" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        Nama usaha / merk dagang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama_usaha" 
                           name="nama_usaha" 
                           value="{{ old('nama_usaha', $umkm->nama_usaha) }}" 
                           placeholder="Contoh: Kopi Muria Sejahtera" 
                           class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none">
                </div>

                <div>
                    <label for="jenis_usaha" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        Kategori sektor usaha <span class="text-red-500">*</span>
                    </label>
                    @php $kategoriCurrent = old('jenis_usaha', $umkm->jenis_usaha ?? 'Makanan'); @endphp
                    <select id="jenis_usaha" 
                            name="jenis_usaha" 
                            class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] transition outline-none cursor-pointer">
                        <option value="Makanan" {{ $kategoriCurrent === 'Makanan' ? 'selected' : '' }}>Makanan & minuman</option>
                        <option value="Jasa" {{ $kategoriCurrent === 'Jasa' ? 'selected' : '' }}>Jasa & layanan</option>
                        <option value="Fashion" {{ $kategoriCurrent === 'Fashion' ? 'selected' : '' }}>Fashion & pakaian</option>
                        <option value="Agribisnis" {{ $kategoriCurrent === 'Agribisnis' ? 'selected' : '' }}>Agribisnis & pertanian</option>
                        <option value="Retail" {{ $kategoriCurrent === 'Retail' ? 'selected' : '' }}>Retail & toko kelontong</option>
                        <option value="Kerajinan" {{ $kategoriCurrent === 'Kerajinan' ? 'selected' : '' }}>Kerajinan tangan / kriya</option>
                    </select>
                </div>
            </div>

            <!-- Target Modal & Estimasi Bagi Hasil -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div>
                    <label for="modal_dibutuhkan_display" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        Kebutuhan permodalan (Rp)
                    </label>
                    <input type="text" 
                           inputmode="numeric" 
                           id="modal_dibutuhkan_display" 
                           data-format-rupiah="true" 
                           data-target-hidden="modal_dibutuhkan" 
                           value="{{ old('modal_dibutuhkan', $umkm->modal_dibutuhkan) ? number_format((float) preg_replace('/\D/', '', old('modal_dibutuhkan', $umkm->modal_dibutuhkan)), 0, ',', '.') : '' }}" 
                           placeholder="Contoh: 25.000.000" 
                           class="format-rupiah w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] outline-none transition" 
                           autocomplete="off">
                    <input type="hidden" 
                           name="modal_dibutuhkan" 
                           id="modal_dibutuhkan" 
                           value="{{ old('modal_dibutuhkan', $umkm->modal_dibutuhkan) ? preg_replace('/\D/', '', old('modal_dibutuhkan', $umkm->modal_dibutuhkan)) : '' }}">
                </div>

                <div>
                    <label for="estimasi_bagi_hasil" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        Estimasi bagi hasil bulanan
                    </label>
                    <input type="text" 
                           id="estimasi_bagi_hasil" 
                           name="estimasi_bagi_hasil" 
                           value="{{ old('estimasi_bagi_hasil', $umkm->estimasi_bagi_hasil ?? '15% per bulan') }}" 
                           placeholder="Contoh: 15% dari laba bersih per bulan" 
                           class="w-full h-11 px-3.5 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] outline-none transition">
                </div>
            </div>

            <!-- Upload Foto & Proposal Usaha -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 items-start">
                <div>
                    <label class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        Foto produk / usaha
                    </label>
                    @if ($umkm->foto_produk)
                        <div class="mb-2 flex items-center gap-2 p-2 bg-[#d8ebe5]/60 rounded-[6px] border border-[#b2d5cc]">
                            <img src="{{ asset('storage/' . $umkm->foto_produk) }}" class="w-10 h-10 rounded-[6px] object-cover">
                            <span class="text-[12px] text-[#084539] font-medium truncate">Foto saat ini terpasang</span>
                        </div>
                    @endif
                    <input type="file" 
                           id="foto_produk" 
                           name="foto_produk" 
                           accept="image/*" 
                           class="hidden" 
                           onchange="updateFileName(this, 'foto_produk_label')">
                    <label for="foto_produk" 
                           id="foto_produk_label" 
                           class="w-full h-11 px-3.5 bg-[#f7f6f1] hover:bg-[#d8ebe5] text-[#0b5a4a] border border-dashed border-[#0b5a4a] rounded-[6px] text-[13px] font-medium text-center cursor-pointer transition flex items-center justify-center gap-2">
                        <span>{{ $umkm->foto_produk ? 'Ganti file foto produk' : 'Pilih file foto produk' }}</span>
                    </label>
                    <span class="text-[12px] text-[#4b5551] mt-1.5 block">Format: JPG, PNG, WEBP (Maks. 5MB)</span>
                </div>

                <div>
                    <label class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                        File proposal usaha (.PDF / .DOC)
                    </label>
                    @if ($umkm->file_proposal)
                        <div class="mb-2 flex items-center justify-between p-2 bg-[#d8ebe5]/60 rounded-[6px] border border-[#b2d5cc] text-[12px] text-[#084539]">
                            <span class="truncate font-medium">Proposal telah diunggah</span>
                            <a href="{{ asset('storage/' . $umkm->file_proposal) }}" target="_blank" class="text-[#0b5a4a] font-semibold hover:underline">Unduh</a>
                        </div>
                    @endif
                    <input type="file" 
                           id="file_proposal" 
                           name="file_proposal" 
                           accept=".pdf,.doc,.docx,.zip" 
                           class="hidden" 
                           onchange="updateFileName(this, 'file_proposal_label')">
                    <label for="file_proposal" 
                           id="file_proposal_label" 
                           class="w-full h-11 px-3.5 bg-[#f7f6f1] hover:bg-[#d8ebe5] text-[#0b5a4a] border border-dashed border-[#0b5a4a] rounded-[6px] text-[13px] font-medium text-center cursor-pointer transition flex items-center justify-center gap-2">
                        <span>{{ $umkm->file_proposal ? 'Ganti file proposal' : 'Pilih file proposal' }}</span>
                    </label>
                    <span class="text-[12px] text-[#4b5551] mt-1.5 block">Format: PDF, DOC, DOCX, ZIP (Maks. 10MB)</span>
                </div>
            </div>

            <!-- Deskripsi Singkat Usaha -->
            <div>
                <label for="deskripsi" class="block text-[14px] font-semibold text-[#161d1a] mb-1.5">
                    Deskripsi singkat usaha
                </label>
                <textarea id="deskripsi" 
                          name="deskripsi" 
                          rows="3" 
                          placeholder="Jelaskan jenis produk, keunikan usaha, dan target pasar Anda..." 
                          class="w-full px-3.5 py-3 bg-white border border-[#e2e1d8] focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] rounded-[6px] text-[14px] text-[#161d1a] outline-none transition min-h-[96px] resize-y">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
            </div>
        </div>

        <!-- CARD 4: BAGIAN 3 - LOKASI RUKO -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5 flex items-center justify-between flex-wrap gap-2">
                <div>
                    <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 3</span>
                    <h3 class="text-[18px] font-bold text-[#161d1a]">Lokasi ruko (pilihan minat sewa)</h3>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" id="clear-ruko-selection" class="h-9 px-3 text-[13px] font-semibold text-[#0b5a4a] hover:bg-[#d8ebe5]/50 rounded-[6px] underline underline-offset-2 hover:text-[#083f35] transition">Hapus pilihan</button>
                    <span class="text-[13px] text-[#4b5551]">Opsional: Pilih jika Anda membutuhkan tempat ruko</span>
                </div>
            </div>

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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-1" id="ruko-grid">
                @php
                    $selectedRukoId = old('id_ruko_diminati', $umkm->id_ruko_diminati);
                @endphp

                @forelse ($rukos as $index => $ruko)
                    <label class="ruko-card block rounded-[10px] border {{ $selectedRukoId == $ruko->id_ruko ? 'border-[#0b5a4a] ring-2 ring-[#0b5a4a]' : 'border-[#e2e1d8] hover:border-[#0b5a4a]' }} p-3 cursor-pointer transition bg-white relative group shadow-2xs hover:shadow-sm">
                        <input type="radio" 
                               name="id_ruko_diminati" 
                               value="{{ $ruko->id_ruko }}" 
                               {{ $selectedRukoId == $ruko->id_ruko ? 'checked' : '' }} 
                               class="absolute top-3 right-3 text-[#0b5a4a] focus:ring-[#0b5a4a]">
                        
                        <div class="w-full aspect-[16/10] rounded-[8px] overflow-hidden mb-2.5 bg-[#f2f8ed] relative border border-[#e2e1d8]">
                            <img src="{{ $ruko->foto_url }}" 
                                 alt="{{ $ruko->nama_ruko }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300" 
                                 loading="lazy">
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-black/60 backdrop-blur-xs text-white text-[10px] font-bold">
                                Daya Ruko
                            </span>
                        </div>

                        <div class="space-y-1">
                            <h4 class="ruko-title text-[13px] font-bold text-[#161d1a] truncate">
                                {{ $ruko->nama_ruko }}
                            </h4>
                            <p class="ruko-loc text-[11px] text-[#4b5551] line-clamp-2">
                                {{ $ruko->lokasi }}
                            </p>
                            <div class="pt-1 text-[12px] font-semibold text-[#0b5a4a]">
                                Rp {{ number_format($ruko->harga_sewa_per_bulan, 0, ',', '.') }} / bln
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

        <!-- Tombol Aksi: Simpan Draf & Kirim Pengajuan -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-[13px] text-[#4b5551]">
                Data tersimpan otomatis dalam akun Anda. Anda dapat kembali melengkapinya kapan saja.
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button type="submit" 
                        name="aksi" 
                        value="simpan_draf" 
                        class="btn-secondary w-full sm:w-auto h-11 px-5 text-[14px] font-semibold flex items-center justify-center">
                    Simpan draf
                </button>

                <button type="submit" 
                        name="aksi" 
                        value="kirim_pengajuan" 
                        class="btn-primary w-full sm:w-auto h-11 px-6 text-[14px] font-semibold flex items-center justify-center shadow-xs">
                    Kirim pengajuan ke admin
                </button>
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

    document.getElementById('clear-ruko-selection').addEventListener('click', () => {
        document.querySelectorAll('input[name="id_ruko_diminati"]').forEach(input => {
            input.checked = false;
            input.dispatchEvent(new Event('change', { bubbles: true }));
        });
    });

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

    // Highlight kartu ruko terpilih (pakai inline style, tidak bergantung CSS build)
    function highlightSelectedRuko() {
        document.querySelectorAll('.ruko-card').forEach(card => {
            const box = card.querySelector('div');
            const input = card.querySelector('input[type="radio"]');
            if (!box || !input) return;

            if (input.checked) {
                box.style.borderColor = '#0b5a4a';
                box.style.boxShadow = '0 0 0 2px #0b5a4a';
            } else {
                box.style.borderColor = '#e2e1d8';
                box.style.boxShadow = '';
            }
        });
    }

    document.addEventListener('change', event => {
        if (event.target && event.target.name === 'id_ruko_diminati') {
            highlightSelectedRuko();
        }
    });

    highlightSelectedRuko();
</script>
@endsection
