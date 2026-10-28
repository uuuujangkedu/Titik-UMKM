@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi')

@section('content')
<div class="w-full max-w-[500px] mx-auto my-6 px-4">
    <div class="bg-white rounded-3xl border border-[#C8BFB0]/70 p-7 sm:p-9 text-left space-y-6 shadow-[0_16px_40px_rgba(45,107,34,0.12)]">
        
        <div class="space-y-1">
            <h1 class="text-[24px] font-bold text-[#15241C] leading-tight" data-i18n="auth.forgot_title">
                Lupa kata sandi
            </h1>
            <p class="text-[14px] text-[#3E5445]" data-i18n="auth.forgot_subtitle">
                Masukkan alamat email akun Anda. Kami akan mengirimkan kode verifikasi OTP untuk menyetel ulang kata sandi.
            </p>
        </div>

        @if (session('error'))
            <div class="p-3.5 rounded-xl bg-[#fee2e2] border border-[#fca5a5] text-[#991b1b] text-[14px]">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-[14px] font-semibold text-[#15241C] mb-1.5" data-i18n="auth.forgot_email_label">
                    Alamat email terdaftar
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

            <div class="p-3.5 bg-[#F2F8ED] border border-[#2D6B22]/30 rounded-xl text-[13px] text-[#1E4A1A]" data-i18n="auth.forgot_info">
                Kode verifikasi OTP 6-digit akan dikirimkan ke email untuk memastikan kepemilikan akun Anda.
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-150" data-i18n="auth.send_reset_btn">
                Kirim kode pemulihan
            </button>
        </form>

        <div class="text-center text-[14px] text-[#3E5445] pt-2">
            <span data-i18n="auth.remember_password">Ingat kata sandi Anda?</span>
            <a href="{{ route('login') }}" class="font-semibold text-[#2D6B22] hover:text-[#1E4A1A] hover:underline ml-1" data-i18n="auth.back_to_login">
                Kembali masuk
            </a>
        </div>

    </div>
</div>
@endsection

