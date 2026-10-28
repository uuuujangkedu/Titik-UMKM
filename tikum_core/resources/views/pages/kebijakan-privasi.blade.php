@extends('layouts.auth')

@section('title', 'Kebijakan Privasi')

@section('content')
<main class="max-w-4xl mx-auto px-5 sm:px-8 py-12 sm:py-16 text-[#15241C]">
    <a href="{{ route('home') }}" class="inline-block text-sm font-semibold text-[#1A5B36] underline underline-offset-4">Kembali ke beranda</a>
    <h1 class="mt-8 text-3xl sm:text-4xl font-bold">Kebijakan Privasi</h1>
    <p class="mt-4 rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm text-amber-950">Status: draf. Kebijakan ini perlu ditinjau dan disahkan pemilik layanan sebelum diberlakukan.</p>

    <div class="mt-8 space-y-6 leading-7">
        <section>
            <h2 class="text-xl font-bold">Informasi yang diproses</h2>
            <p class="mt-2">Layanan dapat memproses informasi yang Anda berikan saat mendaftar, mengelola profil, mengajukan atau meninjau pendanaan, menghubungi dukungan, dan menggunakan fitur platform. Informasi dapat mencakup identitas, kontak, data usaha, dokumen yang diunggah, serta aktivitas akun.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold">Penggunaan informasi</h2>
            <p class="mt-2">Informasi digunakan untuk menyediakan dan mengamankan layanan, memverifikasi akun dan pengajuan, menghubungkan investor dengan pelaku UMKM, memenuhi kewajiban hukum, serta menanggapi permintaan dukungan.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold">Pembagian dan penyimpanan</h2>
            <p class="mt-2">Informasi hanya dibagikan sejauh diperlukan untuk menjalankan fitur yang Anda gunakan, memenuhi kewajiban hukum, atau melindungi layanan dan penggunanya. Jangka waktu penyimpanan, penyedia pemroses, serta mekanisme penghapusan masih perlu ditetapkan sebelum kebijakan ini diberlakukan.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold">Pilihan dan pertanyaan</h2>
            <p class="mt-2">Untuk meminta akses, koreksi, atau penghapusan informasi, maupun mengajukan pertanyaan privasi, hubungi <a class="font-semibold text-[#1A5B36] underline underline-offset-4" href="mailto:fauza@titik-umkm.id">fauza@titik-umkm.id</a>. Permintaan dapat dibatasi oleh kewajiban hukum dan kebutuhan operasional yang sah.</p>
        </section>
    </div>
</main>
@endsection
