@extends('layouts.auth')

@section('title', 'Syarat dan Ketentuan')

@section('content')
<main class="max-w-4xl mx-auto px-5 sm:px-8 py-12 sm:py-16 text-[#15241C]">
    <a href="{{ route('home') }}" class="inline-block text-sm font-semibold text-[#1A5B36] underline underline-offset-4">Kembali ke beranda</a>
    <h1 class="mt-8 text-3xl sm:text-4xl font-bold">Syarat dan Ketentuan</h1>
    <p class="mt-4 rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm text-amber-950">Status: draf. Syarat ini perlu ditinjau dan disahkan pemilik layanan sebelum diberlakukan.</p>

    <div class="mt-8 space-y-6 leading-7">
        <section>
            <h2 class="text-xl font-bold">Penggunaan layanan</h2>
            <p class="mt-2">Dengan menggunakan Titik UMKM, Anda setuju memberikan informasi yang benar, menjaga keamanan akun, dan menggunakan fitur sesuai hukum yang berlaku. Anda bertanggung jawab atas aktivitas yang dilakukan melalui akun Anda.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold">Informasi usaha dan pendanaan</h2>
            <p class="mt-2">Informasi usaha, penawaran pendanaan, dan proyeksi yang ditampilkan berasal dari data yang tersedia di platform dan dapat berubah. Pengguna perlu memeriksa informasi dan menyepakati ketentuan transaksi secara langsung sebelum mengambil keputusan.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold">Risiko</h2>
            <p class="mt-2">Pendanaan usaha memiliki risiko, termasuk keterlambatan pembayaran, perubahan kinerja usaha, dan kehilangan sebagian atau seluruh modal. Platform tidak menjamin keuntungan atau pengembalian modal. Pertimbangkan risiko dan kemampuan Anda sebelum bertransaksi.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold">Pembatasan dan perubahan</h2>
            <p class="mt-2">Akses dapat dibatasi bila terdapat dugaan pelanggaran hukum, penyalahgunaan, atau risiko keamanan. Ketentuan mengenai penyelesaian sengketa, pengakhiran layanan, batas tanggung jawab, dan tanggal berlaku perlu ditinjau serta ditetapkan sebelum dokumen ini diberlakukan.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold">Kontak</h2>
            <p class="mt-2">Pertanyaan tentang syarat penggunaan dapat dikirim ke <a class="font-semibold text-[#1A5B36] underline underline-offset-4" href="mailto:fauza@titik-umkm.id">fauza@titik-umkm.id</a>.</p>
        </section>
    </div>
</main>
@endsection
