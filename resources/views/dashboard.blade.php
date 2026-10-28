@extends('layouts.auth')

@section('title', 'Dashboard - Daya UMKM')

@section('content')
<div class="w-full max-w-4xl mx-auto px-4 sm:px-6 my-8">
    <div class="bg-white rounded-[12px] border border-[#e2e1d8] p-6 sm:p-8 space-y-6">
        
        <!-- Welcome Banner -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-6 border-b border-[#e2e1d8] gap-4">
            <div class="flex items-center gap-4">
                @if (Auth::user()->avatar_url)
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-14 h-14 rounded-full border border-[#e2e1d8] object-cover">
                @else
                    <div class="w-14 h-14 rounded-[6px] bg-[#d8ebe5] text-[#0b5a4a] flex items-center justify-center font-bold text-xl">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h1 class="text-[24px] font-bold text-[#161d1a] leading-tight">Selamat datang, {{ Auth::user()->name }}!</h1>
                    <p class="text-[13px] text-[#4b5551] mt-0.5">
                        {{ Auth::user()->email }} &bull; Peran: <span class="capitalize font-semibold text-[#0b5a4a]">{{ Auth::user()->role }}</span>
                    </p>
                </div>
            </div>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-3.5 py-2 border border-[#fca5a5] text-[#dc2626] hover:bg-[#fee2e2] text-[13px] font-medium rounded-[6px] transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>

        <!-- Status Badges -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-[10px] bg-[#f7f6f1] border border-[#e2e1d8]">
                <div class="text-[12px] font-medium text-[#4b5551]">Status akun</div>
                <div class="text-[16px] font-bold text-[#0b5a4a] mt-1 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#0b5a4a]"></span>
                    <span class="capitalize">{{ Auth::user()->status }}</span>
                </div>
            </div>

            <div class="p-4 rounded-[10px] bg-[#f7f6f1] border border-[#e2e1d8]">
                <div class="text-[12px] font-medium text-[#4b5551]">Verifikasi email</div>
                <div class="text-[16px] font-bold text-[#0b5a4a] mt-1 flex items-center gap-1.5">
                    @if (Auth::user()->email_verified_at)
                        <svg class="w-4 h-4 text-[#0b5a4a]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Terverifikasi</span>
                    @else
                        <span class="text-amber-700">Belum verifikasi</span>
                    @endif
                </div>
            </div>

            <div class="p-4 rounded-[10px] bg-[#f7f6f1] border border-[#e2e1d8]">
                <div class="text-[12px] font-medium text-[#4b5551]">Tipe akun</div>
                <div class="text-[16px] font-bold text-[#161d1a] mt-1 capitalize">
                    {{ Auth::user()->role === 'investor' ? 'Investor mitra' : 'Pengelola UMKM' }}
                </div>
            </div>
        </div>

        <!-- Banner Info Ekosistem -->
        <div class="p-4 bg-[#d8ebe5]/60 border border-[#b2d5cc] rounded-[6px] text-[13px] text-[#084539] leading-relaxed">
            <h3 class="font-bold text-[14px] mb-0.5 text-[#084539]">Akun Anda telah aktif di ekosistem Daya UMKM</h3>
            <p>Anda dapat mulai menjelajahi penawaran UMKM produktif untuk didanai atau mendaftarkan ruko usaha Anda.</p>
        </div>

    </div>
</div>
@endsection
