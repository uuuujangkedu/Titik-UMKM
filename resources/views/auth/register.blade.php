@extends('layouts.auth')

@section('title', 'Daftar Akun')

@section('content')
<div class="w-full max-w-[500px] mx-auto my-6 px-4">
    <div class="bg-white rounded-3xl border border-[#C8BFB0]/70 p-7 sm:p-9 text-left space-y-6 shadow-[0_16px_40px_rgba(45,107,34,0.12)]">
        
        <!-- Header -->
        <div class="space-y-1">
            <h1 class="text-[24px] font-bold text-[#15241C] leading-tight" 
                @if (request('role') === 'investor')
                    data-i18n="auth.register_title_investor"
                @elseif (request('role') === 'umkm')
                    data-i18n="auth.register_title_umkm"
                @elseif (request('role') === 'influencer')
                    data-i18n="auth.register_title_influencer"
                @else
                    data-i18n="auth.register_title"
                @endif>
                @if (request('role') === 'investor')
                    Daftar sebagai mitra investor
                @elseif (request('role') === 'umkm')
                    Daftar sebagai pelaku UMKM
                @elseif (request('role') === 'influencer')
                    Daftar sebagai mitra influencer
                @else
                    Daftar akun baru
                @endif
            </h1>
            <p class="text-[14px] text-[#3E5445]"
                @if (request('role') === 'investor')
                    data-i18n="auth.register_subtitle_investor"
                @elseif (request('role') === 'umkm')
                    data-i18n="auth.register_subtitle_umkm"
                @elseif (request('role') === 'influencer')
                    data-i18n="auth.register_subtitle_influencer"
                @else
                    data-i18n="auth.register_subtitle"
                @endif>
                @if (request('role') === 'investor')
                    Salurkan permodalan produktif dan pantau bagi hasil secara berkala.
                @elseif (request('role') === 'umkm')
                    Dapatkan akses modal usaha dan direktori sewa ruko strategis.
                @elseif (request('role') === 'influencer')
                    Promosikan UMKM lokal dan raih honor profesional dari pesanan endorse & sponsor.
                @else
                    Pilih peran dan lengkapi data untuk mulai bergabung di Titik UMKM.
                @endif
            </p>
        </div>

        <!-- Alert Messages -->
        @if (session('error'))
            <div class="p-3.5 rounded-xl bg-[#fee2e2] border border-[#fca5a5] text-[#991b1b] text-[14px]">
                {{ session('error') }}
            </div>
        @endif

        <!-- 1. Tombol Sign Up With Google -->
        <a href="{{ route('google.redirect', ['role' => request('role', 'investor')]) }}"
           class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-[#C8BFB0]/80 hover:border-[#2D6B22] rounded-xl text-[14px] font-medium text-[#15241C] bg-white/90 hover:bg-white transition duration-150 shadow-sm">
            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
            </svg>
            <span data-i18n="auth.google_register">Daftar dengan Google</span>
        </a>

        <!-- Divider -->
        <div class="relative text-center">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-[#C8BFB0]/60"></div>
            </div>
            <div class="relative inline-block bg-white/95 px-3 text-[13px] text-[#3E5445] rounded-full">
                <span data-i18n="auth.or_email_register">atau formulir pendaftaran email</span>
            </div>
        </div>

        <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Pilihan Role (Investor vs Pelaku UMKM) -->
            <div>
                <label class="block text-[14px] font-semibold text-[#15241C] mb-2" data-i18n="auth.role_label">
                    Daftar sebagai
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @php
                        $defaultRole = request('role', 'investor');
                        if (!in_array($defaultRole, ['investor', 'umkm', 'influencer'])) {
                            $defaultRole = 'investor';
                        }
                        $selectedRole = old('role', $defaultRole);
                    @endphp
                    <label class="relative flex items-center p-3 rounded-xl border {{ $selectedRole === 'investor' ? 'border-[#2D6B22] bg-[#F2F8ED]' : 'border-[#C8BFB0]/80 bg-white' }} hover:border-[#2D6B22] cursor-pointer transition">
                        <input type="radio" name="role" value="investor" class="text-[#2D6B22] focus:ring-[#2D6B22]" {{ $selectedRole === 'investor' ? 'checked' : '' }}>
                        <div class="ml-2.5">
                            <span class="block text-[14px] font-semibold text-[#15241C]" data-i18n="auth.role_investor">Investor</span>
                            <span class="block text-[12px] text-[#3E5445]" data-i18n="auth.role_investor_desc">Pemodal usaha</span>
                        </div>
                    </label>
                    <label class="relative flex items-center p-3 rounded-xl border {{ $selectedRole === 'umkm' ? 'border-[#2D6B22] bg-[#F2F8ED]' : 'border-[#C8BFB0]/80 bg-white' }} hover:border-[#2D6B22] cursor-pointer transition">
                        <input type="radio" name="role" value="umkm" class="text-[#2D6B22] focus:ring-[#2D6B22]" {{ $selectedRole === 'umkm' ? 'checked' : '' }}>
                        <div class="ml-2.5">
                            <span class="block text-[14px] font-semibold text-[#15241C]" data-i18n="auth.role_umkm">Pelaku UMKM</span>
                            <span class="block text-[12px] text-[#3E5445]" data-i18n="auth.role_umkm_desc">Pencari modal</span>
                        </div>
                    </label>
                    <label class="relative flex items-center p-3 rounded-xl border {{ $selectedRole === 'influencer' ? 'border-[#2D6B22] bg-[#F2F8ED]' : 'border-[#C8BFB0]/80 bg-white' }} hover:border-[#2D6B22] cursor-pointer transition">
                        <input type="radio" name="role" value="influencer" class="text-[#2D6B22] focus:ring-[#2D6B22]" {{ $selectedRole === 'influencer' ? 'checked' : '' }}>
                        <div class="ml-2.5">
                            <span class="block text-[14px] font-semibold text-[#15241C]">Influencer</span>
                            <span class="block text-[12px] text-[#3E5445]">Kreator promosi</span>
                        </div>
                    </label>
                </div>
                @error('role')
                    <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto Profil (Opsional) -->
            <div>
                <label for="foto_profil" class="block text-[14px] font-semibold text-[#15241C] mb-1.5">
                    Foto Profil (Opsional)
                </label>
                <div class="flex items-center gap-3.5">
                    <div class="w-14 h-14 rounded-full bg-[#f7f6f1] border-2 border-dashed border-[#b2d5cc] overflow-hidden flex items-center justify-center shrink-0">
                        <img id="preview-foto-reg" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        <span id="placeholder-foto-reg" class="text-xl text-[#0b5a4a]">📷</span>
                    </div>
                    <div class="flex-1">
                        <input type="file" 
                               id="foto_profil" 
                               name="foto_profil" 
                               accept="image/png,image/jpeg,image/webp,image/jpg" 
                               onchange="previewImage(this, 'preview-foto-reg', 'placeholder-foto-reg')"
                               class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#d8ebe5] file:text-[#0b5a4a] hover:file:bg-[#b2d5cc] cursor-pointer">
                        <p class="text-[11px] text-gray-500 mt-0.5">Format JPG, PNG, atau WEBP. Maks 3MB.</p>
                    </div>
                </div>
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label for="nama" class="block text-[14px] font-semibold text-[#15241C] mb-1.5" data-i18n="auth.name_label">
                    Nama lengkap
                </label>
                <input type="text" 
                       name="nama" 
                       id="nama" 
                       value="{{ old('nama') }}" 
                       required 
                       placeholder="Nama lengkap Anda"
                       data-i18n-placeholder="auth.name_placeholder"
                       class="w-full px-3.5 py-2.5 bg-white border @error('nama') border-red-500 @else border-[#C8BFB0] @enderror rounded-xl text-[14px] text-[#15241C] focus:outline-none focus:border-[#2D6B22] focus:ring-1 focus:ring-[#2D6B22] transition">
                @error('nama')
                    <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email & Nomor Telepon (2 Kolom) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="email" class="block text-[14px] font-semibold text-[#15241C] mb-1.5" data-i18n="auth.email_label">
                        Alamat email
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}" 
                           required 
                           placeholder="nama@email.com"
                           data-i18n-placeholder="auth.email_placeholder"
                           class="w-full px-3.5 py-2.5 bg-white border @error('email') border-red-500 @else border-[#C8BFB0] @enderror rounded-xl text-[14px] text-[#15241C] focus:outline-none focus:border-[#2D6B22] focus:ring-1 focus:ring-[#2D6B22] transition">
                    @error('email')
                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nomor_telepon" class="block text-[14px] font-semibold text-[#15241C] mb-1.5" data-i18n="auth.phone_label">
                        Nomor WhatsApp / HP
                    </label>
                    <input type="text" 
                           name="nomor_telepon" 
                           id="nomor_telepon" 
                           value="{{ old('nomor_telepon') }}" 
                           placeholder="0812xxxxxxxx"
                           data-i18n-placeholder="auth.phone_placeholder"
                           class="w-full px-3.5 py-2.5 bg-white border @error('nomor_telepon') border-red-500 @else border-[#C8BFB0] @enderror rounded-xl text-[14px] text-[#15241C] focus:outline-none focus:border-[#2D6B22] focus:ring-1 focus:ring-[#2D6B22] transition">
                    @error('nomor_telepon')
                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Kata Sandi & Konfirmasi (2 Kolom) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="reg-password" class="block text-[14px] font-semibold text-[#15241C] mb-1.5" data-i18n="auth.password_label">
                        Kata sandi
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="password" 
                               id="reg-password" 
                               required 
                               placeholder="••••••••"
                               data-i18n-placeholder="auth.password_placeholder"
                               oninput="checkPasswordRequirements(this.value)"
                               class="w-full px-3.5 pr-10 py-2.5 bg-white border @error('password') border-red-500 @else border-[#C8BFB0] @enderror rounded-xl text-[14px] text-[#15241C] focus:outline-none focus:border-[#2D6B22] focus:ring-1 focus:ring-[#2D6B22] transition">
                        <button type="button" 
                                onclick="togglePasswordVisibility('reg-password', 'eye-icon-reg-pwd')" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#3E5445] hover:text-[#2D6B22] transition"
                                aria-label="Lihat kata sandi">
                            <svg id="eye-icon-reg-pwd" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-[12px] text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reg-confirm-password" class="block text-[14px] font-semibold text-[#15241C] mb-1.5" data-i18n="auth.confirm_password_label">
                        Konfirmasi kata sandi
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="password_confirmation" 
                               id="reg-confirm-password" 
                               required 
                               placeholder="••••••••"
                               data-i18n-placeholder="auth.password_placeholder"
                               class="w-full px-3.5 pr-10 py-2.5 bg-white border border-[#C8BFB0] rounded-xl text-[14px] text-[#15241C] focus:outline-none focus:border-[#2D6B22] focus:ring-1 focus:ring-[#2D6B22] transition">
                        <button type="button" 
                                onclick="togglePasswordVisibility('reg-confirm-password', 'eye-icon-reg-confirm')" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#3E5445] hover:text-[#2D6B22] transition"
                                aria-label="Lihat kata sandi konfirmasi">
                            <svg id="eye-icon-reg-confirm" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Persyaratan Kata Sandi -->
            <div class="p-3.5 bg-[#FAFBF9] border border-[#C8BFB0]/70 rounded-xl text-[12px] text-[#3E5445] space-y-1.5">
                <div class="font-semibold text-[#15241C]" data-i18n="auth.pwd_req_title">Persyaratan kata sandi:</div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                    <div id="rule-length" class="flex items-center gap-1.5 text-gray-500">
                        <span class="indicator-icon w-3.5 h-3.5 rounded-full border border-gray-400 flex items-center justify-center text-[9px] font-bold">&bull;</span>
                        <span data-i18n="auth.pwd_req_min">Minimal 8 karakter</span>
                    </div>
                    <div id="rule-case" class="flex items-center gap-1.5 text-gray-500">
                        <span class="indicator-icon w-3.5 h-3.5 rounded-full border border-gray-400 flex items-center justify-center text-[9px] font-bold">&bull;</span>
                        <span data-i18n="auth.pwd_req_case">Huruf besar & kecil (A-z)</span>
                    </div>
                    <div id="rule-number" class="flex items-center gap-1.5 text-gray-500">
                        <span class="indicator-icon w-3.5 h-3.5 rounded-full border border-gray-400 flex items-center justify-center text-[9px] font-bold">&bull;</span>
                        <span data-i18n="auth.pwd_req_num">Mengandung angka (0-9)</span>
                    </div>
                    <div id="rule-symbol" class="flex items-center gap-1.5 text-gray-500">
                        <span class="indicator-icon w-3.5 h-3.5 rounded-full border border-gray-400 flex items-center justify-center text-[9px] font-bold">&bull;</span>
                        <span data-i18n="auth.pwd_req_spec">Karakter khusus (!@#$%)</span>
                    </div>
                </div>
            </div>

            <!-- OTP Verification Info Card -->
            <div class="p-3.5 bg-[#F2F8ED] border border-[#2D6B22]/30 rounded-xl text-[13px] text-[#1E4A1A]" data-i18n="auth.otp_info_card">
                Kode verifikasi OTP 6-digit akan dikirimkan ke alamat email terdaftar untuk aktivasi akun resmi Anda.
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 px-4 bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-150" data-i18n="auth.register_btn">
                Daftar dan kirim kode OTP
            </button>
        </form>

        <!-- Bottom Link -->
        <div class="text-center text-[14px] text-[#3E5445] pt-2">
            <span data-i18n="auth.have_account">Sudah memiliki akun?</span>
            <a href="{{ route('login') }}" class="font-semibold text-[#2D6B22] hover:text-[#1E4A1A] hover:underline ml-1" data-i18n="auth.login_now">
                Masuk sekarang
            </a>
        </div>

    </div>
</div>

<script>
    function checkPasswordRequirements(value) {
        const rules = {
            'rule-length': value.length >= 8,
            'rule-case': /[a-z]/.test(value) && /[A-Z]/.test(value),
            'rule-number': /[0-9]/.test(value),
            'rule-symbol': /[^A-Za-z0-9]/.test(value)
        };

        for (const [id, valid] of Object.entries(rules)) {
            const el = document.getElementById(id);
            if (!el) continue;
            const icon = el.querySelector('.indicator-icon');

            if (valid) {
                el.classList.remove('text-gray-500');
                el.classList.add('text-[#2D6B22]', 'font-semibold');
                if (icon) {
                    icon.className = 'indicator-icon w-3.5 h-3.5 rounded-full bg-[#2D6B22] text-white flex items-center justify-center text-[9px] font-bold';
                    icon.textContent = '✓';
                }
            } else {
                el.classList.add('text-gray-500');
                el.classList.remove('text-[#2D6B22]', 'font-semibold');
                if (icon) {
                    icon.className = 'indicator-icon w-3.5 h-3.5 rounded-full border border-gray-400 flex items-center justify-center text-[9px] font-bold';
                    icon.textContent = '•';
                }
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

    document.addEventListener('DOMContentLoaded', function() {
        const pwdInput = document.getElementById('reg-password');
        if (pwdInput) {
            if (pwdInput.value) {
                checkPasswordRequirements(pwdInput.value);
            }
            pwdInput.addEventListener('input', function() {
                checkPasswordRequirements(this.value);
            });
            pwdInput.addEventListener('change', function() {
                checkPasswordRequirements(this.value);
            });
            pwdInput.addEventListener('keyup', function() {
                checkPasswordRequirements(this.value);
            });
        }
    });
</script>
@endsection

