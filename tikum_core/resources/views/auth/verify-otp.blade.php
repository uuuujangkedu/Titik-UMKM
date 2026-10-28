@extends('layouts.auth')

@section('title', 'Verifikasi Kode OTP')

@section('content')
<div class="w-full max-w-[500px] mx-auto my-6 px-4">
    <div class="bg-white rounded-3xl border border-[#C8BFB0]/70 p-7 sm:p-9 text-left space-y-6 shadow-[0_16px_40px_rgba(45,107,34,0.12)]">
        
        <!-- Header -->
        <div class="space-y-1">
            <h1 class="text-[24px] font-bold text-[#15241C] leading-tight" data-i18n="auth.otp_title">
                Verifikasi email Anda
            </h1>
            <p class="text-[14px] text-[#3E5445]" data-i18n="auth.otp_subtitle">
                Masukkan 6 digit kode OTP yang telah dikirimkan ke alamat email terdaftar.
            </p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="p-3.5 rounded-xl bg-[#F2F8ED] border border-[#2D6B22]/30 text-[#1E4A1A] text-[14px]">
                {{ session('success') }}
            </div>
        @endif

        <!-- Info Email Tujuan -->
        <div class="p-3.5 bg-[#FAFBF9] border border-[#C8BFB0]/70 rounded-xl text-[13px] text-[#3E5445]">
            <span data-i18n="auth.otp_sent_to">Kode dikirimkan ke:</span>
            <div class="font-bold text-[#2D6B22] text-[14px] mt-0.5 break-all">
                {{ $email }}
            </div>
        </div>

        <!-- Form Verifikasi OTP -->
        <form action="{{ route('otp.verify.post') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="otp" class="block text-[14px] font-semibold text-center text-[#15241C] mb-2" data-i18n="auth.otp_input_label">
                    Kode verifikasi 6 digit
                </label>
                <div class="flex justify-center">
                    <input type="text" 
                           name="otp" 
                           id="otp" 
                           maxlength="6" 
                           pattern="[0-9]{6}" 
                           inputmode="numeric" 
                           required 
                           autofocus
                           placeholder="123456"
                           autocomplete="one-time-code"
                           class="w-48 text-center tracking-[10px] text-[24px] font-bold py-2.5 bg-white border @error('otp') border-red-500 @else border-[#C8BFB0] @enderror rounded-xl text-[#2D6B22] focus:outline-none focus:border-[#2D6B22] focus:ring-1 focus:ring-[#2D6B22] transition">
                </div>
                @error('otp')
                    <p class="mt-2 text-center text-[12px] text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Timer Expired Display -->
            <div class="text-center text-[13px] text-[#3E5445]">
                <span data-i18n="auth.otp_expires_in">Kode kedaluwarsa dalam:</span> <span id="countdown" class="font-bold text-[#2D6B22]">05:00</span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 px-4 bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15px] rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-150" data-i18n="auth.otp_verify_btn">
                Verifikasi dan masuk
            </button>
        </form>

        <!-- Kirim Ulang OTP -->
        <div class="pt-4 border-t border-[#C8BFB0]/60 text-center text-[14px] text-[#3E5445]">
            <span data-i18n="auth.otp_no_code">Belum menerima kode OTP?</span> 
            <form action="{{ route('otp.resend') }}" method="POST" class="inline">
                @csrf
                <button type="submit" id="resend-btn" class="font-semibold text-[#2D6B22] hover:text-[#1E4A1A] hover:underline ml-1" data-i18n="auth.otp_resend_btn">
                    Kirim ulang kode
                </button>
            </form>
        </div>

        <!-- Ganti Akun -->
        <div class="text-center text-[13px]">
            <a href="{{ route('login') }}" class="text-[#3E5445] hover:text-[#2D6B22] hover:underline transition" data-i18n="auth.otp_switch_account">
                Gunakan akun atau email lain
            </a>
        </div>

    </div>
</div>

<script>
    // Validasi ketat input OTP: hanya angka dan maksimal 6 digit
    const otpInput = document.getElementById('otp');
    if (otpInput) {
        otpInput.addEventListener('keydown', function(e) {
            // Izinkan: backspace, delete, tab, escape, enter, panah kiri/kanan
            const allowedKeys = ['Backspace', 'Delete', 'Tab', 'Escape', 'Enter', 'ArrowLeft', 'ArrowRight', 'Home', 'End'];
            if (allowedKeys.includes(e.key) || (e.ctrlKey || e.metaKey)) {
                return;
            }
            // Cegah jika bukan angka 0-9
            if (!/^[0-9]$/.test(e.key)) {
                e.preventDefault();
            }
            // Cegah jika panjang sudah 6 dan teks tidak diblok/seleksi
            if (this.value.length >= 6 && this.selectionStart === this.selectionEnd) {
                e.preventDefault();
            }
        });

        otpInput.addEventListener('input', function() {
            // Hapus semua karakter non-angka dan potong max 6 digit
            this.value = this.value.replace(/\D/g, '').slice(0, 6);
        });

        otpInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text') || '';
            const numbersOnly = text.replace(/\D/g, '').slice(0, 6);
            this.value = numbersOnly;
        });
    }

    // Countdown timer 5 menit
    let timeLeft = 300;
    const countdownEl = document.getElementById('countdown');
    const timer = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(timer);
            if (countdownEl) {
                countdownEl.textContent = 'Kedaluwarsa';
                countdownEl.classList.add('text-red-600');
            }
        } else {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            if (countdownEl) {
                countdownEl.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            }
            timeLeft--;
        }
    }, 1000);
</script>
@endsection

