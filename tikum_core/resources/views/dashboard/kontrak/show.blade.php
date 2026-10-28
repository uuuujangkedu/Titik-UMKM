<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akad Perjanjian Kemitraan #{{ $kontrak->nomor_kontrak }} - TIKUM</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Cinzel:wght@700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: #F4F3EE;
            color: #1A202C;
        }
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .page-sheet {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 10mm 15mm !important;
                width: 100% !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="py-6 sm:py-10 px-3 sm:px-6">

    <!-- FLOATING ACTION BAR (NO PRINT) -->
    <div class="no-print max-w-4xl mx-auto mb-6 flex flex-wrap items-center justify-between gap-3 bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition flex items-center gap-1.5">
                <span>←</span>
                <span>Kembali ke Dashboard</span>
            </a>
            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $kontrak->is_fully_signed ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                ● {{ $kontrak->is_fully_signed ? 'Kontrak Sah & Ditandatangani Kedua Pihak' : 'Menunggu Kelengkapan Tanda Tangan' }}
            </span>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-5 py-2 text-xs font-bold bg-[#0F433C] hover:bg-[#1A5C52] text-white rounded-xl shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak / Unduh PDF</span>
            </button>
        </div>
    </div>

    <!-- FLASH NOTIFICATION -->
    @if(session('success'))
        <div class="no-print max-w-4xl mx-auto mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center gap-2 shadow-sm">
            <span>✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(!empty($isPreview))
        <div class="no-print max-w-4xl mx-auto mb-6 p-4 rounded-2xl bg-teal-50 border border-teal-200 text-[#0F433C] text-xs font-semibold flex items-center gap-2.5 shadow-sm">
            <span class="text-xl">📌</span>
            <div>
                <strong class="font-bold block text-sm">Mode Salinan Transparansi Publik:</strong>
                <span>Anda sedang meninjau dokumen legal Akad Kemitraan resmi platform TIKUM. Tanda tangan aktif dikhususkan bagi pihak Investor ({{ $kontrak->investor->name }}) dan Pengelola UMKM ({{ $kontrak->umkm->pemilik }}).</span>
            </div>
        </div>
    @endif

    <!-- LEMBAR DOKUMEN PERJANJIAN HUKUM (A4 LEGAL SHEET) -->
    <div class="page-sheet max-w-4xl mx-auto bg-white rounded-3xl p-8 sm:p-14 border border-gray-200 shadow-xl text-gray-900 text-sm leading-relaxed">
        
        <!-- KOP DOKUMEN RESMI TIKUM -->
        <div class="border-b-2 border-gray-900 pb-5 mb-8 text-center relative">
            <div class="flex items-center justify-between mb-3">
                <img src="{{ asset('images/TIKUM-Logo.png') }}" alt="TIKUM" class="h-10 w-auto object-contain">
                <div class="text-right">
                    <span class="text-[10px] font-mono uppercase tracking-widest text-gray-400 block">NOMOR REGISTER AKAD</span>
                    <span class="text-xs font-mono font-bold text-gray-900">{{ $kontrak->nomor_kontrak }}</span>
                </div>
            </div>
            
            <h1 class="text-lg sm:text-xl font-black uppercase tracking-wider text-gray-900 mt-2">
                SURAT PERJANJIAN KEMITRAAN INVESTASI & BAGI HASIL
            </h1>
            <p class="text-xs text-gray-600 font-semibold mt-0.5">
                (AKAD MUSYARAKAH PENYERTAAN MODAL USAHA SEKTOR RIIL)
            </p>
            <p class="text-[11px] text-gray-400 mt-1 font-mono">
                Platform TIKUM (Titik Usaha Mikro, Kecil, dan Menengah)
            </p>
        </div>

        <!-- PEMBUKA PERJANJIAN -->
        <div class="space-y-4 mb-6 text-justify text-xs sm:text-sm">
            <p>
                Pada hari ini, <strong>{{ ($kontrak->created_at ?? now())->translatedFormat('l, d F Y') }}</strong>, bertempat di sistem elektronik platform <strong>TIKUM (Titik UMKM)</strong>, telah dibuat dan disepakati Akad Perjanjian Kemitraan Modal Usaha oleh dan antara pihak-pihak di bawah ini:
            </p>

            <!-- KOMPARISI PIHAK PERTAMA (INVESTOR) -->
            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200 space-y-1">
                <div class="flex items-start gap-2">
                    <span class="font-bold w-24 shrink-0">1. Nama Lengkap</span>
                    <span class="font-bold text-gray-900">: {{ $kontrak->investor->name }}</span>
                </div>
                <div class="flex items-start gap-2">
                    <span class="font-bold w-24 shrink-0">   Email / No. HP</span>
                    <span>: {{ $kontrak->investor->email }} / {{ $kontrak->investor->phone_number ?? '-' }}</span>
                </div>
                <div class="flex items-start gap-2">
                    <span class="font-bold w-24 shrink-0">   Domisili</span>
                    <span>: {{ $kontrak->investor->provinsi_kota ?? $kontrak->investor->kota ?? 'Indonesia' }}</span>
                </div>
                <p class="text-[11px] text-gray-500 pt-1 italic">
                    Bertindak selaku Pemodal dalam kemitraan ini, untuk selanjutnya disebut sebagai <strong>"PIHAK PERTAMA" (Mitra Investor)</strong>.
                </p>
            </div>

            <!-- KOMPARISI PIHAK KEDUA (UMKM) -->
            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200 space-y-1">
                <div class="flex items-start gap-2">
                    <span class="font-bold w-24 shrink-0">2. Nama Usaha</span>
                    <span class="font-bold text-gray-900">: {{ $kontrak->umkm->nama_usaha }}</span>
                </div>
                <div class="flex items-start gap-2">
                    <span class="font-bold w-24 shrink-0">   Pengelola / NIK</span>
                    <span>: {{ $kontrak->umkm->pemilik }} (NIK: {{ $kontrak->umkm->nik_penanggung_jawab ?? 'Terdaftar Terverifikasi' }})</span>
                </div>
                <div class="flex items-start gap-2">
                    <span class="font-bold w-24 shrink-0">   Lokasi Usaha</span>
                    <span>: {{ $kontrak->umkm->provinsi_kota ?? $kontrak->umkm->kota ?? '-' }}</span>
                </div>
                <p class="text-[11px] text-gray-500 pt-1 italic">
                    Bertindak selaku Pengelola Usaha yang mengoperasikan modal, untuk selanjutnya disebut sebagai <strong>"PIHAK KEDUA" (Pelaku UMKM)</strong>.
                </p>
            </div>

            <p>
                Kedua belah pihak secara sadar, cakap bertindak di hadapan hukum, tanpa paksaan dari pihak mana pun, sepakat mengikatkan diri dalam Akad Perjanjian Kemitraan dengan klausul pasal-pasal sebagai berikut:
            </p>
        </div>

        <!-- PASAL-PASAL PERJANJIAN RESMI -->
        <div class="space-y-6 text-xs sm:text-sm">
            
            <!-- PASAL 1 -->
            <div>
                <h3 class="font-black text-center uppercase tracking-wider text-gray-900 border-b border-gray-200 pb-1 mb-2">
                    PASAL 1<br><span class="text-xs font-bold text-gray-600">KETENTUAN UMUM & OBJEK KEMITRAAN</span>
                </h3>
                <ol class="list-decimal list-outside pl-5 space-y-1.5 text-justify">
                    <li>PIHAK PERTAMA sepakat menempatkan sejumlah modal investasi pada usaha komersial yang dikelola oleh PIHAK KEDUA, yaitu <strong>"{{ $kontrak->umkm->nama_usaha }}"</strong> yang bergerak pada sektor <strong>{{ $kontrak->umkm->jenis_usaha }}</strong>.</li>
                    <li>Akad kemitraan ini berlandaskan asas musyarakah/kepercayaan, keterbukaan informasi, dan keadilan bagi hasil sektor riil non-riba.</li>
                    <li>Modal yang diserahkan dipergunakan secara sah semata-mata untuk modal kerja produktif, pengadaan persediaan bahan baku, biaya operasional, dan pengembangan usaha PIHAK KEDUA.</li>
                </ol>
            </div>

            <!-- PASAL 2 -->
            <div>
                <h3 class="font-black text-center uppercase tracking-wider text-gray-900 border-b border-gray-200 pb-1 mb-2">
                    PASAL 2<br><span class="text-xs font-bold text-gray-600">NILAI INVESTASI & PENYETORAN MODAL</span>
                </h3>
                <ol class="list-decimal list-outside pl-5 space-y-1.5 text-justify">
                    <li>Nilai modal investasi yang disalurkan oleh PIHAK PERTAMA kepada PIHAK KEDUA adalah sebesar:
                        <div class="my-2 p-2.5 bg-emerald-50 border border-emerald-200 rounded-xl text-center font-black text-sm text-[#0F433C]">
                            Rp {{ number_format($kontrak->nominal_modal, 0, ',', '.') }}
                        </div>
                    </li>
                    <li>Penyerahan modal dilakukan secara elektronik dan tercatat resmi dalam buku besar platform TIKUM.</li>
                </ol>
            </div>

            <!-- PASAL 3 -->
            <div>
                <h3 class="font-black text-center uppercase tracking-wider text-gray-900 border-b border-gray-200 pb-1 mb-2">
                    PASAL 3<br><span class="text-xs font-bold text-gray-600">NISBAH BAGI HASIL & JADWAL PEMBAGIAN DIVIDEN</span>
                </h3>
                <ol class="list-decimal list-outside pl-5 space-y-1.5 text-justify">
                    <li>PIHAK KEDUA berkewajiban membayarkan bagi hasil (dividen) kepada PIHAK PERTAMA sebesar <strong>{{ $kontrak->persentase_bagi_hasil }}%</strong> sesuai dengan kinerja perolehan laba kotor/bersih usaha.</li>
                    <li>Pembagian dividen didistribusikan secara <strong>{{ $kontrak->periode_dividen }}</strong>, paling lambat pada tanggal <strong>25 setiap bulannya</strong> melalui mekanisme transfer resmi platform TIKUM.</li>
                    <li>Apabila PIHAK KEDUA mengalami kendala penurunan omzet atau force majeure, PIHAK KEDUA wajib mengirimkan formulir klarifikasi resmi ke sistem paling lambat H-3 sebelum tanggal jatuh tempo.</li>
                </ol>
            </div>

            <!-- PASAL 4 -->
            <div>
                <h3 class="font-black text-center uppercase tracking-wider text-gray-900 border-b border-gray-200 pb-1 mb-2">
                    PASAL 4<br><span class="text-xs font-bold text-gray-600">TRANSPARANSI KEUANGAN & AUDIT KEPATUHAN</span>
                </h3>
                <ol class="list-decimal list-outside pl-5 space-y-1.5 text-justify">
                    <li>PIHAK KEDUA wajib mencatatkan laporan laba rugi dan arus kas usaha secara berkala pada menu Analisis Keuangan TIKUM.</li>
                    <li>PIHAK PERTAMA berhak memantau ringkasan laporan keuangan dan rekapitulasi dividen berkala melalui dashboard investor secara transparan.</li>
                </ol>
            </div>

            <!-- PASAL 5 -->
            <div>
                <h3 class="font-black text-center uppercase tracking-wider text-gray-900 border-b border-gray-200 pb-1 mb-2">
                    PASAL 5<br><span class="text-xs font-bold text-gray-600">JANGKA WAKTU KEMITRAAN (TENOR)</span>
                </h3>
                <p class="text-justify">
                    Akad kemitraan ini berlaku efektif selama <strong>{{ $kontrak->tenor_bulan }} Bulan</strong> terhitung sejak tanggal penandatanganan akad ini secara sah oleh kedua belah pihak.
                </p>
            </div>

            <!-- PASAL 6 -->
            <div>
                <h3 class="font-black text-center uppercase tracking-wider text-gray-900 border-b border-gray-200 pb-1 mb-2">
                    PASAL 6<br><span class="text-xs font-bold text-gray-600">PENYELESAIAN SENGKETA & KETENTUAN PENUTUP</span>
                </h3>
                <ol class="list-decimal list-outside pl-5 space-y-1.5 text-justify">
                    <li>Segala perselisihan yang timbul akan diselesaikan terlebih dahulu melalui musyawarah untuk mufakat dengan mediasi platform TIKUM.</li>
                    <li>Dokumen ini ditandatangani secara elektronik (Digital Signature) yang memiliki kekuatan hukum yang sah dan mengikat kedua belah pihak sebagaimana diatur dalam Undang-Undang Informasi dan Transaksi Elektronik (UU ITE).</li>
                </ol>
            </div>
        </div>

        <!-- AREA TANDA TANGAN DIGITAL DUA PIHAK -->
        <div class="mt-12 pt-8 border-t-2 border-gray-900 grid grid-cols-1 sm:grid-cols-2 gap-8 text-center text-xs">
            
            <!-- KOLOM PIHAK PERTAMA (INVESTOR) -->
            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-200 flex flex-col justify-between min-h-[260px]">
                <div>
                    <span class="text-[10px] font-bold uppercase text-gray-400 block mb-1">PIHAK PERTAMA (INVESTOR)</span>
                    <span class="font-black text-gray-900 block">{{ $kontrak->investor->name }}</span>
                </div>

                <div class="my-4 flex flex-col items-center justify-center">
                    @if($kontrak->signature_investor)
                        <img src="{{ $kontrak->signature_investor }}" alt="Tanda Tangan Investor" class="h-20 object-contain mx-auto filter contrast-125">
                        <span class="text-[10px] text-emerald-700 font-bold mt-1">✓ Ditandatangani Elektronik</span>
                        <span class="text-[9px] text-gray-400 font-mono">{{ $kontrak->signed_at_investor ? $kontrak->signed_at_investor->translatedFormat('d F Y, H:i') : '' }}</span>
                    @else
                        @if($isInvestor)
                            <button type="button" onclick="openEsignPad('investor')" 
                                    class="no-print px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                                ✍️ Bubuhkan Tanda Tangan Saya
                            </button>
                            <span class="no-print text-[10px] text-gray-400 mt-2 block">Klik untuk tanda tangan di layar</span>
                        @else
                            <div class="p-3 border border-dashed border-gray-300 rounded-xl text-gray-400 text-xs italic">
                                Menunggu Tanda Tangan Digital Investor
                            </div>
                        @endif
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-2">
                    <span class="font-bold text-gray-800 text-xs block underline">{{ $kontrak->investor->name }}</span>
                    <span class="text-[10px] text-gray-500">Mitra Investor TIKUM</span>
                </div>
            </div>

            <!-- KOLOM PIHAK KEDUA (UMKM) -->
            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-200 flex flex-col justify-between min-h-[260px]">
                <div>
                    <span class="text-[10px] font-bold uppercase text-gray-400 block mb-1">PIHAK KEDUA (PENGELOLA UMKM)</span>
                    <span class="font-black text-gray-900 block">{{ $kontrak->umkm->nama_usaha }}</span>
                </div>

                <div class="my-4 flex flex-col items-center justify-center">
                    @if($kontrak->signature_umkm)
                        <img src="{{ $kontrak->signature_umkm }}" alt="Tanda Tangan UMKM" class="h-20 object-contain mx-auto filter contrast-125">
                        <span class="text-[10px] text-emerald-700 font-bold mt-1">✓ Ditandatangani Elektronik</span>
                        <span class="text-[9px] text-gray-400 font-mono">{{ $kontrak->signed_at_umkm ? $kontrak->signed_at_umkm->translatedFormat('d F Y, H:i') : '' }}</span>
                    @else
                        @if($isUmkm)
                            <button type="button" onclick="openEsignPad('umkm')" 
                                    class="no-print px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                                ✍️ Bubuhkan Tanda Tangan Saya
                            </button>
                            <span class="no-print text-[10px] text-gray-400 mt-2 block">Klik untuk tanda tangan di layar</span>
                        @else
                            <div class="p-3 border border-dashed border-gray-300 rounded-xl text-gray-400 text-xs italic">
                                Menunggu Tanda Tangan Digital UMKM
                            </div>
                        @endif
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-2">
                    <span class="font-bold text-gray-800 text-xs block underline">{{ $kontrak->umkm->pemilik }}</span>
                    <span class="text-[10px] text-gray-500">Penanggung Jawab Usaha</span>
                </div>
            </div>
        </div>

        <!-- SEGEL KEABSAHAN & QR CODE VERIFIKASI RESMI -->
        <div class="mt-8 pt-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-200 flex items-center justify-center font-black text-xl text-[#0F433C]">
                    ⚖️
                </div>
                <div>
                    <span class="font-bold text-gray-900 block text-xs">Keabsahan Tanda Tangan Digital Tersertifikasi</span>
                    <span class="text-[10px] text-gray-400 block font-mono">HASH: {{ substr($kontrak->kode_keabsahan_qr, 0, 32) }}...</span>
                </div>
            </div>

            <div class="text-center sm:text-right">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">STATUS KONTRAK</span>
                <span class="text-xs font-black text-[#0F433C] uppercase">{{ str_replace('_', ' ', $kontrak->status) }}</span>
            </div>
        </div>
    </div>

    <!-- MODAL E-SIGN PAD CANVAS INTERAKTIF (NO PRINT) -->
    <div id="modal-esign-pad" class="no-print fixed inset-0 z-50 bg-black/70 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                <div>
                    <h3 class="text-base font-black text-[#1A202C]">Bubuhkan Tanda Tangan Digital</h3>
                    <p class="text-xs text-gray-500">Tanda tangan pada kotak kanvas di bawah menggunakan mouse atau jari Anda.</p>
                </div>
                <button type="button" onclick="closeEsignPad()" class="text-gray-400 hover:text-gray-600 font-bold">✕</button>
            </div>

            <form action="{{ route('kontrak.sign', $kontrak->id) }}" method="POST" onsubmit="return submitEsign(event)">
                @csrf
                <input type="hidden" name="signature_data" id="signature_data">

                <!-- KOTAK KANVAS TANDA TANGAN -->
                <div class="relative border-2 border-dashed border-gray-300 rounded-2xl bg-gray-50/70 overflow-hidden mb-3">
                    <canvas id="signature-canvas" width="460" height="200" class="w-full h-48 cursor-crosshair touch-none"></canvas>
                    <div id="canvas-placeholder" class="pointer-events-none absolute inset-0 flex items-center justify-center text-gray-400 text-xs italic">
                        Tanda tangani di area ini...
                    </div>
                </div>

                <div class="flex items-center justify-between mb-4">
                    <button type="button" onclick="clearSignatureCanvas()" class="text-xs text-rose-600 hover:underline font-bold">
                        ✕ Bersihkan Kanvas
                    </button>
                    <span class="text-[11px] text-gray-400">Tanda tangan tersimpan secara terenkripsi</span>
                </div>

                <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-[11px] text-amber-900 mb-4">
                    <strong>Pernyataan:</strong> Dengan membubuhkan tanda tangan ini, saya menyatakan telah membaca, menyetujui, dan mematuhi seluruh pasal pada Akad Kemitraan #{{ $kontrak->nomor_kontrak }}.
                </div>

                <div class="flex items-center justify-end gap-2">
                    <button type="button" onclick="closeEsignPad()" class="px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-xs font-bold bg-[#0F433C] text-white rounded-xl hover:bg-[#1A5C52] shadow-sm">
                        ✓ Sahkan & Simpan Tanda Tangan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('signature-canvas');
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let hasDrawn = false;

        ctx.strokeStyle = '#0F433C';
        ctx.lineWidth = 2.5;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        function getPos(e) {
            const rect = canvas.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            return {
                x: (clientX - rect.left) * (canvas.width / rect.width),
                y: (clientY - rect.top) * (canvas.height / rect.height)
            };
        }

        function startDrawing(e) {
            isDrawing = true;
            hasDrawn = true;
            document.getElementById('canvas-placeholder').classList.add('hidden');
            const pos = getPos(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
            e.preventDefault();
        }

        function draw(e) {
            if (!isDrawing) return;
            const pos = getPos(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            e.preventDefault();
        }

        function stopDrawing() {
            isDrawing = false;
        }

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseleave', stopDrawing);

        canvas.addEventListener('touchstart', startDrawing);
        canvas.addEventListener('touchmove', draw);
        canvas.addEventListener('touchend', stopDrawing);

        function clearSignatureCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            hasDrawn = false;
            document.getElementById('canvas-placeholder').classList.remove('hidden');
        }

        function openEsignPad(role) {
            clearSignatureCanvas();
            document.getElementById('modal-esign-pad').classList.remove('hidden');
        }

        function closeEsignPad() {
            document.getElementById('modal-esign-pad').classList.add('hidden');
        }

        function submitEsign(e) {
            if (!hasDrawn) {
                alert('Silakan buat tanda tangan Anda terlebih dahulu pada kotak kanvas!');
                return false;
            }
            const dataUrl = canvas.toDataURL('image/png');
            document.getElementById('signature_data').value = dataUrl;
            return true;
        }
    </script>
</body>
</html>
