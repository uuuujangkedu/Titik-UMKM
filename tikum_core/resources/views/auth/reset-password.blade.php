@extends('layouts.auth')

@section('title', 'Atur Kata Sandi Baru - Daya UMKM')

@section('content')
<div class="w-full max-w-[500px] mx-auto my-6 px-4">
    <div class="bg-white rounded-3xl border border-[#C8BFB0]/70 p-7 sm:p-9 text-left space-y-6 shadow-[0_16px_40px_rgba(45,107,34,0.12)]">
        
        <div class="space-y-1">
            <h1 class="text-[24px] font-bold text-[#15241C] leading-tight" data-i18n="auth.reset_title">
                Atur kata sandi baru
            </h1>
            <p class="text-[14px] text-[#3E5445]" data-i18n="auth.reset_subtitle">
                Buat kata sandi baru yang aman untuk akun Anda.
            </p>
        </div>

        @if (session('success'))
            <div class="p-3.5 rounded-xl bg-[#F2F8ED] border border-[#2D6B22]/30 text-[#1E4A1A] text-[14px]">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="reset-password" class="block text-[14px] font-semibold text-[#15241C] mb-1.5" data-i18n="auth.reset_pwd_label">
                    Kata sandi baru
                </label>
                <div class="relative">
                    <input type="password" 
                           name="password" 
                           id="reset-password" 
                           required 
                           placeholder="Minimal 8 karakter"
                           data-i18n-placeholder="auth.reset_pwd_placeholder"
                           oninput="checkResetRequirements(this.value)"
                           class="w-full px-3.5 pr-10 py-2.5 bg-white border @error('password') border-red-500 @else border-[#C8BFB0] @enderror rounded-xl text-[14px] text-[#15241C] focus:outline-none focus:border-[#2D6B22] focus:ring-1 focus:ring-[#2D6B22] transition">
                    <button type="button" 
                            onclick="togglePasswordVisibility('reset-password', 'eye-icon-reset')" 
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#3E5445] hover:text-[#2D6B22] transition"
                            aria-label="Lihat kata sandi">
                        <svg id="eye-icon-reset" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
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
                <label for="reset-confirm" class="block text-[14px] font-semibold text-[#15241C] mb-1.5" data-i18n="auth.reset_confirm_label">
                    Konfirmasi kata sandi baru
                </label>
                <div class="relative">
                    <input type="password" 
                           name="password_confirmation" 
                           id="reset-confirm" 
                           required 
                           placeholder="Ulangi kata sandi baru"
                           data-i18n-placeholder="auth.reset_confirm_placeholder"
                           class="w-full px-3.5 pr-10 py-2.5 bg-white border border-[#C8BFB0] rounded-xl text-[14px] text-[#15241C] focus:outline-none focus:border-[#2D6B22] focus:ring-1 focus:ring-[#2D6B22] transition">
                    <button type="button" 
                            onclick="togglePasswordVisibility('reset-confirm', 'eye-icon-confirm-reset')" 
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#3E5445] hover:text-[#2D6B22] transition"
                            aria-label="Lihat kata sandi konfirmasi">
                        <svg id="eye-icon-confirm-reset" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Persyaratan Kata Sandi -->
            <div class="p-3.5 bg-[#FAFBF9] border border-[#C8BFB0]/70 rounded-xl text-[12px] text-[#3E5445] space-y-1.5">
                <div class="font-semibold text-[#15241C] mb-1" data-i18n="auth.pwd_req_title">Persyaratan kata sandi:</div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                    <div id="reset-rule-length" class="flex items-center gap-1.5 text-gray-500">
                        <span class="indicator-icon w-3.5 h-3.5 rounded-full border border-gray-400 flex items-center justify-center text-[9px] font-bold">&bull;</span>
                        <span data-i18n="auth.pwd_req_min">Minimal 8 karakter</span>
                    </div>
                    <div id="reset-rule-case" class="flex items-center gap-1.5 text-gray-500">
                        <span class="indicator-icon w-3.5 h-3.5 rounded-full border border-gray-400 flex items-center justify-center text-[9px] font-bold">&bull;</span>
                        <span data-i18n="auth.pwd_req_case">Huruf besar & kecil (A-z)</span>
                    </div>
                    <div id="reset-rule-number" class="flex items-center gap-1.5 text-gray-500">
                        <span class="indicator-icon w-3.5 h-3.5 rounded-full border border-gray-400 flex items-center justify-center text-[9px] font-bold">&bull;</span>
                        <span data-i18n="auth.pwd_req_num">Mengandung angka (0-9)</span>
                    </div>
                    <div id="reset-rule-symbol" class="flex items-center gap-1.5 text-gray-500">
                        <span class="indicator-icon w-3.5 h-3.5 rounded-full border border-gray-400 flex items-center justify-center text-[9px] font-bold">&bull;</span>
                        <span data-i18n="auth.pwd_req_spec">Karakter khusus (!@#$%)</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-150" data-i18n="auth.reset_submit_btn">
                Simpan kata sandi baru
            </button>
        </form>

        <div class="text-center text-[14px] text-[#3E5445] pt-2">
            <span data-i18n="auth.reset_back_label">Sudah selesai atau ingin login?</span>
            <a href="{{ route('login') }}" class="font-semibold text-[#2D6B22] hover:text-[#1E4A1A] hover:underline ml-1" data-i18n="auth.back_to_login">
                Kembali masuk
            </a>
        </div>

    </div>
</div>

<script>
    function checkResetRequirements(value) {
        const rules = {
            'reset-rule-length': value.length >= 8,
            'reset-rule-case': /[a-z]/.test(value) && /[A-Z]/.test(value),
            'reset-rule-number': /[0-9]/.test(value),
            'reset-rule-symbol': /[^A-Za-z0-9]/.test(value)
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

    document.addEventListener('DOMContentLoaded', function() {
        const pwdInput = document.getElementById('reset-password');
        if (pwdInput) {
            if (pwdInput.value) {
                checkResetRequirements(pwdInput.value);
            }
            pwdInput.addEventListener('input', function() {
                checkResetRequirements(this.value);
            });
            pwdInput.addEventListener('change', function() {
                checkResetRequirements(this.value);
            });
            pwdInput.addEventListener('keyup', function() {
                checkResetRequirements(this.value);
            });
        }
    });
</script>
@endsection
