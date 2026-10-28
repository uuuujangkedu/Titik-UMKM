@extends('layouts.auth')

@section('title', 'Formulir Pendaftaran Mitra Influencer - Daya UMKM')

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
               class="px-4 py-2 rounded-[6px] text-[13px] font-medium bg-[#f7f6f1] text-[#4b5551] hover:text-[#0b5a4a] hover:bg-[#d8ebe5] transition border border-[#e2e1d8] flex items-center gap-2">
                <span>Investor</span>
            </a>
            <a href="{{ route('register.influencer') }}" 
               class="px-4 py-2 rounded-[6px] text-[13px] font-semibold bg-[#0b5a4a] text-white flex items-center gap-2 transition">
                <span>Mitra Influencer</span>
            </a>
        </div>
    </div>

    <!-- Title Header -->
    <div class="flex items-start sm:items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-[26px] sm:text-[30px] font-bold text-[#161d1a] leading-tight">
                Formulir pendaftaran mitra influencer
            </h1>
            <p class="text-[14px] text-[#4b5551] mt-1">
                Daftarkan akun kreator Anda untuk mempromosikan produk UMKM lokal dengan jaminan honor aman & terpercaya.
            </p>
        </div>

        <a href="{{ route('google.redirect', ['role' => 'influencer']) }}"
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
        <input type="hidden" name="role" value="influencer">

        <!-- CARD 1: INFORMASI AKUN & KREDENSIAL -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5">
                <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 1</span>
                <h3 class="text-[18px] font-bold text-[#161d1a]">Data diri & kontak kreator</h3>
            </div>

            <!-- Foto Profil -->
            <div>
                <label for="foto_profil" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                    Foto Profil Kreator (Opsional)
                </label>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#f7f6f1] border-2 border-dashed border-[#b2d5cc] overflow-hidden flex items-center justify-center shrink-0">
                        <img id="preview-foto-inf" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        <span id="placeholder-foto-inf" class="text-2xl text-[#0b5a4a]">📷</span>
                    </div>
                    <div class="space-y-1">
                        <input type="file" id="foto_profil" name="foto_profil" accept="image/*" class="text-[13px] text-[#4b5551] file:mr-3 file:py-1.5 file:px-3.5 file:rounded-[6px] file:border-0 file:text-[12px] file:font-semibold file:bg-[#d8ebe5] file:text-[#0b5a4a] hover:file:bg-[#b2d5cc] cursor-pointer">
                        <p class="text-[11px] text-[#4b5551]">Format JPG, PNG, atau WebP. Maksimal 3 MB.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Nama Lengkap / Nama Panggung <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" required value="{{ old('nama') }}" placeholder="Contoh: Cindy Foodie / Bima Explore"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>

                <div>
                    <label for="nomor_telepon" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="nomor_telepon" name="nomor_telepon" required value="{{ old('nomor_telepon') }}" placeholder="08123456789"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="kreator@gmail.com"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                    <p class="text-[11px] text-[#4b5551] mt-1">Kode OTP verifikasi akan dikirimkan ke email ini.</p>
                </div>

                <div>
                    <label for="kategori_diminati" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Niche / Kategori Konten <span class="text-rose-500">*</span>
                    </label>
                    <select id="kategori_diminati" name="kategori_diminati" required
                            class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                        <option value="Kuliner" {{ old('kategori_diminati') == 'Kuliner' ? 'selected' : '' }}>Kuliner & Minuman (F&B)</option>
                        <option value="Fashion" {{ old('kategori_diminati') == 'Fashion' ? 'selected' : '' }}>Fashion & Hijab</option>
                        <option value="Lifestyle" {{ old('kategori_diminati') == 'Lifestyle' ? 'selected' : '' }}>Lifestyle & Wisata</option>
                        <option value="Jasa" {{ old('kategori_diminati') == 'Jasa' ? 'selected' : '' }}>Jasa & Kreatif</option>
                        <option value="Agribisnis" {{ old('kategori_diminati') == 'Agribisnis' ? 'selected' : '' }}>Kerajinan & Produk Lokal</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                    <p class="text-[11px] text-[#4b5551] mt-1">Gunakan kombinasi huruf besar, kecil, angka, dan simbol.</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Konfirmasi Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi kata sandi"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
            </div>
        </div>

        <!-- CARD 2: DOMISILI & WILAYAH JANGKAUAN -->
        <div class="bg-white rounded-[12px] p-6 sm:p-7 border border-[#e2e1d8] space-y-5 shadow-xs">
            <div class="border-b border-[#e2e1d8] pb-3.5">
                <span class="text-[12px] font-semibold text-[#0b5a4a]">Bagian 2</span>
                <h3 class="text-[18px] font-bold text-[#161d1a]">Domisili & jangkauan audiens</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="kota" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Kota / Kabupaten Domisili <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="kota" name="kota" required value="{{ old('kota', 'Surabaya') }}" placeholder="Contoh: Surabaya"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>

                <div>
                    <label for="provinsi" class="block text-[13px] font-semibold text-[#161d1a] mb-1.5">
                        Provinsi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="provinsi" name="provinsi" required value="{{ old('provinsi', 'Jawa Timur') }}" placeholder="Contoh: Jawa Timur"
                           class="w-full bg-[#f7f6f1] border border-[#e2e1d8] rounded-[6px] text-[13px] text-[#161d1a] px-3.5 py-2.5 focus:border-[#0b5a4a] focus:ring-1 focus:ring-[#0b5a4a] focus:bg-white transition">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="bg-white rounded-[12px] p-5 border border-[#e2e1d8] flex items-center justify-between flex-wrap gap-4 shadow-xs">
            <div class="text-[13px] text-[#4b5551]">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-bold text-[#0b5a4a] hover:underline">Masuk ke akun</a>
            </div>

            <button type="submit" 
                    class="px-8 py-3 rounded-[6px] bg-[#0b5a4a] hover:bg-[#084539] text-white text-[14px] font-medium transition flex items-center gap-2 shadow-sm">
                <span>Daftar Akun Influencer</span>
                <span>&rarr;</span>
            </button>
        </div>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputFoto = document.getElementById('foto_profil');
        const previewEl = document.getElementById('preview-foto-inf');
        const placeholderEl = document.getElementById('placeholder-foto-inf');

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
