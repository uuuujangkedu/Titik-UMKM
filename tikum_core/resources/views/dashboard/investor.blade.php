@extends('layouts.investor')

@section('title', 'Dashboard Mitra Investor - DAYA UMKM')

@section('content')
<div class="space-y-8">

    {{-- ========================================================================= --}}
    {{-- TAB 1: BERANDA INVESTOR (Executive Command Center)                         --}}
    {{-- ========================================================================= --}}
    @if(($activeTab ?? 'beranda') === 'beranda')

        <!-- PAGE HEADER DENGAN QUICK ACTIONS -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">BERANDA</h1>
                <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                    Halo, <span class="font-bold text-[#0F433C]">{{ $user->name }}</span> 👋. Pusat kendali eksekutif portofolio pendanaan & dividen UMKM Anda.
                </p>
            </div>
            
            <div class="flex items-center gap-2.5 self-start sm:self-auto">
                <a href="{{ route('dashboard', ['tab' => 'proposal']) }}" 
                   class="px-5 py-2.5 rounded-2xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Danai UMKM Baru</span>
                </a>
            </div>
        </div>

        <!-- 4 KARTU METRIK KPI UTAMA INVESTOR -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            
            <!-- KARTU 1: Total Modal Disalurkan -->
            <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-[#E0F7F6] text-[#00A389] flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-500">Total Modal Disalurkan</p>
                <h3 class="text-2xl sm:text-3xl font-black text-[#1A202C] mt-1 tracking-tight">
                    Rp {{ number_format($totalModalDiinvestasikan, 0, ',', '.') }}
                </h3>
                <div class="mt-2 flex flex-col gap-0.5 text-[11px]">
                    <div class="flex items-center gap-1.5 text-emerald-600 font-bold">
                        <span>●</span>
                        <span>Portofolio aktif terkelola</span>
                    </div>
                    @if(($realTotalModalSewa ?? 0) > 0)
                        <div class="text-[10px] text-gray-400 font-medium">
                            Usaha: Rp {{ number_format($realTotalModalUsaha, 0, ',', '.') }} &bull; Ruko: Rp {{ number_format($realTotalModalSewa, 0, ',', '.') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- KARTU 2: Jumlah UMKM Didanai -->
            <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-[#FEF9E7] text-[#F1C40F] flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-500">Mitra UMKM Didanai</p>
                <h3 class="text-2xl sm:text-3xl font-black text-[#1A202C] mt-1 tracking-tight">
                    {{ $umkmDidanaiCount }} Usaha
                </h3>
                <div class="mt-2 flex items-center gap-1.5 text-[11px] text-gray-400 font-medium">
                    <span>Bermitra produktif</span>
                </div>
            </div>

            <!-- KARTU 3: Rata-Rata Bagi Hasil -->
            <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-[#FDECEB] text-[#E74C3C] flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-500">Rata-Rata Bagi Hasil</p>
                <h3 class="text-2xl sm:text-3xl font-black text-[#1A202C] mt-1 tracking-tight">
                    {{ $rataRataBagiHasil }}% <span class="text-sm font-bold text-gray-400">p.a.</span>
                </h3>
                <div class="mt-2 flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold">
                    <span>Imbal hasil kompetitif</span>
                </div>
            </div>

            <!-- KARTU 4: Proyeksi Dividen Bulan Ini -->
            <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-[#EDF2FE] text-[#4F73D9] flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-500">Estimasi Dividen Bulan Ini</p>
                <h3 class="text-2xl sm:text-3xl font-black text-[#1A202C] mt-1 tracking-tight">
                    Rp {{ number_format($proyeksiDividenBulanIni, 0, ',', '.') }}
                </h3>
                <a href="{{ route('dashboard', ['tab' => 'keuangan']) }}" class="mt-2 inline-block text-[11px] font-bold text-blue-600 hover:underline">
                    Rincian dividen &rarr;
                </a>
            </div>

        </div>

        <!-- ROW UTAMA: GRAFIK TREN BAGI HASIL BULANAN & JADWAL DIVIDEN TERDEKAT -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- KOLOM KIRI (2/3): GRAFIK TREN BAGI HASIL BULANAN (MURNI DATA RIIL) -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                        <div>
                            <h2 class="text-lg font-black text-[#1A202C]">Tren Pembagian Bagi Hasil Bulanan</h2>
                            <p class="text-xs text-gray-400 font-medium mt-0.5">Akumulasi realisasi dividen riil yang disalurkan mitra UMKM dari tabel bagi hasil</p>
                        </div>
                        <span class="text-xs font-extrabold text-[#0F433C] bg-teal-50 px-3 py-1.5 rounded-xl border border-teal-200 self-start sm:self-auto">
                            Realisasi Riil
                        </span>
                    </div>

                    <!-- KONTEN GRAFIK (HANYA MENAMPILKAN DATA JIKA ADA DI DATABASE) -->
                    @if($riwayatBagiHasil->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($riwayatBagiHasil as $log)
                                <div class="p-3.5 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] flex items-center justify-between text-xs">
                                    <div>
                                        <span class="font-extrabold text-[#1A202C]">{{ $log->investasi->umkm->nama_usaha ?? 'Mitra UMKM' }}</span>
                                        <p class="text-[11px] text-gray-400 mt-0.5">{{ $log->tanggal_distribusi ? $log->tanggal_distribusi->format('d M Y') : '-' }}</p>
                                    </div>
                                    <span class="font-black text-emerald-700">Rp {{ number_format($log->nominal_diterima, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- State Riil Jika Belum Ada Catatan Bagi Hasil di Database -->
                        <div class="py-12 px-4 text-center rounded-2xl bg-[#F9F8F3] border border-dashed border-[#E8E6DF] my-2">
                            <div class="w-12 h-12 rounded-2xl bg-teal-100 text-[#0F433C] flex items-center justify-center font-black text-xl mx-auto mb-3 shadow-inner">
                                📈
                            </div>
                            <h3 class="text-sm font-extrabold text-[#1A202C]">Belum Ada Riwayat Realisasi Dividen</h3>
                            <p class="text-xs text-gray-500 max-w-md mx-auto mt-1 leading-relaxed">
                                Grafik dan riwayat dividen akan otomatis tercatat di sini saat UMKM mitra atau admin mencairkan bagi hasil riil ke akun Anda.
                            </p>
                            @if(!$hasRealInvestments)
                                <div class="mt-4">
                                    <a href="{{ route('dashboard', ['tab' => 'proposal']) }}" 
                                       class="px-5 py-2.5 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm inline-flex items-center gap-2">
                                        <span>Jelajahi Proposal & Mulai Investasi</span> &rarr;
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- KOLOM KANAN (1/3): JADWAL DIVIDEN TERDEKAT (MURNI DATA RIIL DARI INVESTASI) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-lg font-black text-[#1A202C]">Jadwal Dividen</h2>
                            <p class="text-xs text-gray-400 font-medium">Estimasi bagi hasil investasi aktif Anda</p>
                        </div>
                        <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-black text-xs">
                            📅
                        </span>
                    </div>

                    <div class="space-y-3 mt-4">
                        @forelse($semuaInvestasiSaya->take(3) as $inv)
                            <div class="p-4 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] hover:border-teal-300 transition">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-[10px] font-black uppercase text-gray-400 tracking-wider">
                                        {{ $inv->tanggal_investasi ? $inv->tanggal_investasi->format('d M Y') : 'Terjadwal' }}
                                    </span>
                                    @if($inv->status === 'aktif' || $inv->status === 'disetujui')
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-emerald-100 text-emerald-800">
                                            Aktif Didanai
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-amber-100 text-amber-800">
                                            Menunggu Konfirmasi
                                        </span>
                                    @endif
                                </div>
                                <div class="font-extrabold text-[#1A202C] text-xs mt-1 truncate">{{ $inv->umkm->nama_usaha ?? 'Usaha UMKM' }}</div>
                                <div class="text-sm font-black text-emerald-700 mt-1">
                                    Rp {{ number_format(round(($inv->jumlah_modal * ($inv->persentase_bagi_hasil / 100)) / 12), 0, ',', '.') }}
                                    <span class="text-[10px] font-normal text-gray-400">/ bln ({{ $inv->persentase_bagi_hasil }}%)</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-xs text-gray-400 bg-[#F9F8F3] rounded-2xl border border-dashed border-[#E8E6DF]">
                                Belum ada jadwal dividen aktif karena Anda belum memiliki investasi.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="{{ route('dashboard', ['tab' => 'keuangan']) }}" class="text-xs font-bold text-[#0F433C] hover:underline flex items-center justify-between">
                        <span>Lihat Rekonsiliasi Keuangan Lengkap</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- ALOKASI SEKTOR MODAL (100% DIHITUNG DARI DATABASE) -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-lg font-black text-[#1A202C]">Alokasi Sektor Modal</h2>
                    <p class="text-xs text-gray-400 font-medium">Diversifikasi investasi riil Anda</p>
                </div>
                <a href="{{ route('dashboard', ['tab' => 'portofolio']) }}" class="text-xs font-bold text-[#0F433C] hover:underline self-start sm:self-auto">
                    Buka Portofolio &rarr;
                </a>
            </div>

            @if(!empty($alokasiSektor) && count($alokasiSektor) > 0)
                <!-- Visual Segmented Bar Riil -->
                <div class="w-full h-3.5 rounded-full bg-gray-100 flex overflow-hidden my-4 shadow-inner">
                    @foreach($alokasiSektor as $sek)
                        <div class="h-full transition-all duration-300" 
                             style="width: {{ $sek['persentase'] }}%; background-color: {{ $sek['color'] }};" 
                             title="{{ $sek['nama'] }}: {{ $sek['persentase'] }}% (Rp {{ number_format($sek['nominal'], 0, ',', '.') }})"></div>
                    @endforeach
                </div>

                <!-- Legend Riil -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs font-medium mt-4">
                    @foreach($alokasiSektor as $sek)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF]">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $sek['color'] }};"></span>
                                <div>
                                    <span class="text-gray-700 font-semibold block">{{ $sek['nama'] }}</span>
                                    <span class="text-[10px] text-gray-400 block">{{ $sek['jumlah_proyek'] }} Usaha</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-black text-[#1A202C]">{{ $sek['persentase'] }}%</span>
                                <span class="text-[10px] text-gray-400 block">Rp {{ number_format($sek['nominal'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- State Kosong Riil Jika Investor Belum Menanam Modal -->
                <div class="py-8 px-4 text-center rounded-2xl bg-[#F9F8F3] border border-dashed border-[#E8E6DF] my-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#0F433C] flex items-center justify-center font-bold mx-auto mb-2 text-sm">
                        📊
                    </div>
                    <p class="text-xs font-extrabold text-gray-700">Belum Ada Alokasi Sektor</p>
                    <p class="text-[11px] text-gray-400 mt-1 max-w-[320px] mx-auto leading-relaxed">
                        Proporsi sektor usaha akan dihitung secara otomatis berdasarkan modal yang Anda salurkan ke UMKM.
                    </p>
                </div>
            @endif

            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-end">
                <a href="{{ route('dashboard', ['tab' => 'portofolio']) }}" 
                   class="py-2.5 px-4 rounded-xl bg-[#F9F8F3] hover:bg-gray-100 text-[#0F433C] text-xs font-bold transition border border-[#E8E6DF]">
                    Kelola Detail Investasi di Portofolio Saya &rarr;
                </a>
            </div>
        </div>

        <!-- SEKSI KATALOG PELUANG INVESTASI (Preview Proposal Pilihan) -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black text-[#1A202C]">Peluang Investasi Pilihan</h2>
                    <p class="text-xs text-gray-400 font-medium">Proposal usaha pilihan yang siap menerima pendanaan</p>
                </div>
                <a href="{{ route('dashboard', ['tab' => 'proposal']) }}" class="text-xs font-bold text-[#0F433C] hover:underline">
                    Buka PROPOSAL LIST Lengkap &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @forelse($availableProposals->take(3) as $umkm)
                    <div class="bg-white rounded-3xl p-5 border border-[#E8E6DF] shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full bg-teal-50 text-teal-800 border border-teal-200">
                                    {{ $umkm->jenis_usaha }}
                                </span>
                                <span class="text-xs font-black text-emerald-700">
                                    {{ $umkm->persentase_bagi_hasil ?: ($umkm->estimasi_bagi_hasil ?: '15% p.a.') }}
                                </span>
                            </div>
                            <h3 class="text-sm font-black text-[#1A202C] truncate">{{ $umkm->nama_usaha }}</h3>
                            <p class="text-[11px] text-gray-500 mt-0.5">Pemilik: {{ $umkm->pemilik }} &bull; {{ $umkm->provinsi_kota ?? '-' }}</p>
                            @if($umkm->total_ulasan > 0)
                                <div class="mt-1 flex items-center gap-1.5">
                                    <span class="text-amber-500 font-black text-xs">★ {{ number_format($umkm->rating_rata_rata, 1) }}</span>
                                    <span class="text-gray-400 text-[10px]">({{ $umkm->total_ulasan }} ulasan investor)</span>
                                </div>
                            @endif
                            <p class="text-xs font-extrabold text-[#0F433C] mt-2">
                                Target: Rp {{ number_format($umkm->target_pendanaan ?: ($umkm->modal_dibutuhkan ?: 25000000), 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <button onclick="openInvestModal('{{ $umkm->id_umkm }}', '{{ addslashes($umkm->nama_usaha) }}', '{{ $umkm->target_pendanaan ?: ($umkm->modal_dibutuhkan ?: 25000000) }}', '{{ $umkm->persentase_bagi_hasil ?: 15 }}')"
                                    class="w-full py-2 px-3 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm">
                                Investasi Sekarang
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-6 text-center text-xs text-gray-400 bg-white rounded-3xl border border-[#E8E6DF]">
                        Belum ada proposal UMKM terverifikasi.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- SEKSI RUKO STRATEGIS SIAP DITEMPATI UMKM (Pilar Investasi Sewa Komersial) -->
        <div class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-teal-100 text-teal-800">
                            Pilar Investasi Komersial
                        </span>
                        <span class="text-xs text-gray-400 font-bold">&bull;</span>
                        <h2 class="text-lg font-black text-[#1A202C]">Ruko Strategis Siap Ditempati UMKM</h2>
                    </div>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">Danai sewa ruko komersial untuk ekspansi cabang gerai fisik mitra UMKM pilihan Anda.</p>
                </div>
                <a href="{{ route('dashboard', ['tab' => 'ruko']) }}" class="text-xs font-bold text-[#0F433C] hover:underline flex items-center gap-1 self-start sm:self-auto">
                    <span>Buka KATALOG RUKO Lengkap</span> &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @forelse($rukos->take(3) as $ruko)
                    <div class="bg-white rounded-3xl p-5 border border-[#E8E6DF] shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="w-full h-32 rounded-2xl text-white flex flex-col items-center justify-center p-3 mb-3 relative overflow-hidden"
                                 style="background: #0F433C; background: linear-gradient(135deg, #0F433C 0%, #20675D 100%) !important; color: #ffffff !important;">
                                <div class="absolute top-2.5 right-2.5">
                                    @if($ruko->status_ketersediaan === 'tersedia')
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-emerald-400 text-emerald-950">
                                            ✓ Tersedia
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-gray-200 text-gray-800">
                                            Tersewa
                                        </span>
                                    @endif
                                </div>
                                <svg class="w-8 h-8 text-teal-200/80 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span class="text-[11px] font-bold tracking-wider uppercase text-teal-100">Unit Ruko Komersial</span>
                            </div>

                            <h3 class="text-sm font-black text-[#1A202C] truncate">{{ $ruko->nama_ruko }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $ruko->lokasi }}</p>

                            <div class="mt-3 p-3 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] flex justify-between items-center text-xs">
                                <span class="text-gray-400 font-medium text-[11px]">Sewa / bln:</span>
                                <span class="font-black text-[#0F433C]">Rp {{ number_format($ruko->harga_sewa_per_bulan, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-gray-100">
                            @if($ruko->status_ketersediaan === 'tersedia')
                                <button onclick="openSponsorRukoModal('{{ $ruko->id_ruko }}', '{{ addslashes($ruko->nama_ruko) }}', '{{ $ruko->harga_sewa_per_bulan }}', '{{ addslashes($ruko->lokasi) }}')"
                                        class="w-full py-2 px-3 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm flex items-center justify-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Danai / Sponsori Sewa</span>
                                </button>
                            @else
                                <button disabled class="w-full py-2 px-3 rounded-xl bg-gray-100 text-gray-400 text-xs font-bold cursor-not-allowed">
                                    Unit Sedang Disewa
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-6 text-center text-xs text-gray-400 bg-white rounded-3xl border border-[#E8E6DF]">
                        Belum ada unit ruko terdaftar.
                    </div>
                @endforelse
            </div>
        </div>

    {{-- ========================================================================= --}}
    {{-- TAB BARU: PORTOFOLIO SAYA                                                  --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'portofolio')

        <!-- PAGE HEADER PORTOFOLIO -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">PORTOFOLIO SAYA</h1>
                <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                    Pantau kinerja bisnis, status komitmen dana, dan realisasi bagi hasil seluruh UMKM yang Anda modali.
                </p>
            </div>
            
            <a href="{{ route('dashboard', ['tab' => 'proposal']) }}" 
               class="px-5 py-2.5 rounded-2xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm inline-flex items-center gap-2 self-start sm:self-auto">
                <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>Tambah Portofolio Baru</span>
            </a>
        </div>

        <!-- 4 KARTU METRIK RINGKASAN PORTOFOLIO -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <div class="p-5 rounded-3xl bg-white border border-[#E8E6DF] shadow-sm">
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Modal Ditanam</div>
                <div class="text-xl sm:text-2xl font-black text-[#0F433C] mt-1">
                    Rp {{ number_format($totalModalDiinvestasikan, 0, ',', '.') }}
                </div>
            </div>

            <div class="p-5 rounded-3xl bg-white border border-[#E8E6DF] shadow-sm">
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Usaha Didanai</div>
                <div class="text-xl sm:text-2xl font-black text-[#1A202C] mt-1">
                    {{ $umkmDidanaiCount }} Mitra UMKM
                </div>
            </div>

            <div class="p-5 rounded-3xl bg-white border border-[#E8E6DF] shadow-sm">
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Rata-Rata Bagi Hasil</div>
                <div class="text-xl sm:text-2xl font-black text-emerald-700 mt-1">
                    {{ $rataRataBagiHasil }}% p.a.
                </div>
            </div>

            <div class="p-5 rounded-3xl bg-white border border-[#E8E6DF] shadow-sm">
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Proyeksi Dividen Bulanan</div>
                <div class="text-xl sm:text-2xl font-black text-blue-700 mt-1">
                    Rp {{ number_format($proyeksiDividenBulanIni, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- FILTER STATUS INVESTASI -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('dashboard', ['tab' => 'portofolio', 'status' => 'semua']) }}" 
               class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ ($statusFilter ?? 'semua') === 'semua' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                Semua Portofolio ({{ $semuaInvestasiSaya->count() }})
            </a>
            <a href="{{ route('dashboard', ['tab' => 'portofolio', 'status' => 'aktif']) }}" 
               class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ ($statusFilter ?? '') === 'aktif' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                Aktif Berjalan ({{ $semuaInvestasiSaya->whereIn('status', ['aktif', 'disetujui'])->count() }})
            </a>
            <a href="{{ route('dashboard', ['tab' => 'portofolio', 'status' => 'pending']) }}" 
               class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ ($statusFilter ?? '') === 'pending' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                Menunggu Konfirmasi ({{ $semuaInvestasiSaya->where('status', 'pending')->count() }})
            </a>
            <a href="{{ route('dashboard', ['tab' => 'portofolio', 'status' => 'selesai']) }}" 
               class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ ($statusFilter ?? '') === 'selesai' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                Kontrak Selesai ({{ $semuaInvestasiSaya->where('status', 'selesai')->count() }})
            </a>
        </div>

        <!-- DAFTAR KARTU PORTOFOLIO INVESTASI -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($investasiSaya as $inv)
                <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <!-- Header Kartu -->
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-teal-50 text-teal-800 border border-teal-200">
                                {{ $inv->umkm->jenis_usaha ?? 'UMKM Mitra' }}
                            </span>

                            @if($inv->status === 'aktif' || $inv->status === 'disetujui')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    ● Aktif Didanai
                                </span>
                            @elseif($inv->status === 'selesai')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-gray-100 text-gray-700 border border-gray-200">
                                    ✓ Selesai
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                    ⏳ Menunggu Konfirmasi
                                </span>
                            @endif
                        </div>

                        <!-- Nama Usaha & Pemilik -->
                        <h3 class="text-base font-black text-[#1A202C] leading-snug">
                            {{ $inv->umkm->nama_usaha ?? 'Usaha UMKM' }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Pengelola: <span class="font-bold text-gray-700">{{ $inv->umkm->pemilik ?? '-' }}</span> &bull; {{ $inv->umkm->provinsi_kota ?? '-' }}
                        </p>

                        <!-- Nilai Modal & Skema Bagi Hasil -->
                        <div class="mt-4 p-4 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] space-y-2 text-xs">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Modal Disalurkan:</span>
                                <span class="font-black text-[#0F433C] text-sm">
                                    Rp {{ number_format($inv->jumlah_modal, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Bagi Hasil:</span>
                                <span class="font-extrabold text-emerald-700">
                                    {{ $inv->persentase_bagi_hasil }}%
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Periode Pembagian:</span>
                                <span class="font-semibold text-gray-700">
                                    {{ $inv->periode_pembagian }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-gray-200/60">
                                <span class="text-gray-500 font-medium">Tanggal Investasi:</span>
                                <span class="text-gray-600 font-semibold">
                                    {{ $inv->tanggal_investasi ? $inv->tanggal_investasi->format('d M Y') : '-' }}
                                </span>
                            </div>
                        </div>

                        <!-- STATUS JATUH TEMPO & BAGI HASIL DIVIDEN BULAN BERJALAN -->
                        @php
                            $statusBulanIni = $inv->status_dividen_bulan_ini;
                            $klarifikasiAktif = $statusBulanIni['klarifikasi'] ?? null;
                        @endphp
                        <div class="mt-3.5 p-3 rounded-2xl border flex items-center justify-between gap-2 {{ $statusBulanIni['badge_class'] }}">
                            <div class="flex items-center gap-2">
                                <span class="text-base">{{ $statusBulanIni['icon'] }}</span>
                                <div>
                                    <span class="text-[11px] font-extrabold block leading-tight">{{ $statusBulanIni['badge_label'] }}</span>
                                    <span class="text-[10px] opacity-80">Jatuh tempo: 25 {{ $statusBulanIni['bulan_periode'] }}</span>
                                </div>
                            </div>
                            @if($statusBulanIni['code'] === 'lancar')
                                <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-emerald-600 text-white">Lunas</span>
                            @elseif($statusBulanIni['code'] === 'klarifikasi' && $klarifikasiAktif)
                                <button type="button"
                                        onclick="openLihatKlarifikasiModal('{{ addslashes($inv->umkm->nama_usaha ?? 'UMKM') }}', '{{ $klarifikasiAktif->bulan_periode }}', '{{ addslashes($klarifikasiAktif->kategori_label) }}', `{{ addslashes($klarifikasiAktif->alasan) }}`, `{{ addslashes($klarifikasiAktif->komitmen_solusi) }}`, '{{ $klarifikasiAktif->lampiran_bukti ? asset(ltrim($klarifikasiAktif->lampiran_bukti, '/')) : '' }}', '{{ $klarifikasiAktif->status }}', `{{ addslashes($klarifikasiAktif->catatan_admin ?? '') }}`)"
                                        class="px-2.5 py-1 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-[10px] font-black transition shadow-sm shrink-0 flex items-center gap-1">
                                    <span>Lihat Kendala</span>
                                    <span>↗</span>
                                </button>
                            @endif
                        </div>

                        <!-- Catatan Komitmen -->
                        @if(!empty($inv->catatan))
                            <div class="mt-3 p-3 rounded-xl bg-gray-50 border border-gray-100 text-[11px] text-gray-600 italic">
                                "{{ $inv->catatan }}"
                            </div>
                        @endif
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-5 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-2">
                        <!-- Tombol Buka Ruang Chat -->
                        <a href="{{ route('dashboard', ['tab' => 'pesan', 'investasi_id' => $inv->id_investasi]) }}"
                           class="py-2.5 px-3.5 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold text-center transition flex items-center justify-center gap-1.5 shadow-sm">
                            <svg class="w-3.5 h-3.5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span>💬 Ruang Obrolan</span>
                        </a>

                        <!-- Tombol Akad Kontrak Digital & E-Sign -->
                        <a href="{{ route('kontrak.show', $inv->id_investasi) }}" 
                           class="py-2.5 px-3.5 rounded-xl hover:opacity-90 transition flex items-center justify-center gap-2 shadow-sm"
                           style="background-color: #0F433C !important; color: #ffffff !important; border: 1px solid #165E54 !important;">
                            <svg class="w-4 h-4 text-amber-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span style="color: #ffffff !important; font-weight: 800; font-size: 12px;">Akad Digital & E-Sign</span>
                        </a>

                        <!-- Tombol Beri / Edit Ulasan Kredibilitas Mitra UMKM -->
                        @if($inv->status === 'aktif' || $inv->status === 'disetujui' || $inv->status === 'selesai')
                            @if($inv->ulasan)
                                <button type="button" 
                                    onclick="openModalReview('{{ $inv->id_investasi }}', '{{ addslashes($inv->umkm->nama_usaha ?? 'Mitra UMKM') }}', '{{ $inv->ulasan->rating }}', '{{ $inv->ulasan->rating_transparansi ?? 5 }}', '{{ $inv->ulasan->rating_dividen ?? 5 }}', `{{ addslashes($inv->ulasan->ulasan) }}`)"
                                    class="py-2.5 px-3 rounded-xl text-xs font-bold text-center transition flex items-center justify-center gap-1.5 shadow-sm hover:opacity-90"
                                    style="background-color: #FEF3C7; border: 1px solid #FCD34D; color: #78350F;">
                                    <svg class="w-4 h-4 text-amber-500 fill-amber-500 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-amber-900 font-bold">Nilai Anda: {{ $inv->ulasan->rating }}/5</span>
                                    <span class="text-[10px] text-amber-700 underline font-normal">(Edit)</span>
                                </button>
                            @else
                                <button type="button" 
                                    onclick="openModalReview('{{ $inv->id_investasi }}', '{{ addslashes($inv->umkm->nama_usaha ?? 'Mitra UMKM') }}', 5, 5, 5, '')"
                                    class="py-2.5 px-3.5 rounded-xl text-white text-xs font-bold text-center transition flex items-center justify-center gap-1.5 shadow-sm hover:opacity-95"
                                    style="background-color: #D97706; background-image: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); color: #ffffff !important; box-shadow: 0 2px 6px rgba(217, 119, 6, 0.35);">
                                    <svg class="w-4 h-4 text-white fill-amber-200 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-white font-bold">Beri Ulasan Mitra</span>
                                </button>
                            @endif
                        @endif

                        @if(!empty($inv->umkm->nomor_whatsapp))
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inv->umkm->nomor_whatsapp) }}?text=Halo%20{{ urlencode($inv->umkm->pemilik) }},%20saya%20investor%20dari%20platform%20DAYA%20UMKM." 
                               target="_blank"
                               class="py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold text-center transition flex items-center justify-center gap-1.5 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                                </svg>
                                <span>WA</span>
                            </a>
                        @endif

                        <a href="{{ route('dashboard', ['tab' => 'proposal', 'q' => $inv->umkm->nama_usaha ?? '']) }}" 
                           class="py-2.5 px-3 rounded-xl border border-[#E8E6DF] hover:bg-gray-50 text-gray-700 text-xs font-bold text-center transition">
                            Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-[#E8E6DF]">
                    <div class="w-16 h-16 rounded-full bg-teal-50 text-[#0F433C] mx-auto flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-black text-gray-800">Tidak ada investasi di status ini</h3>
                    <p class="text-xs text-gray-500 mt-1 max-w-md mx-auto">
                        Anda belum memiliki portofolio investasi pada filter ini. Jelajahi katalog proposal UMKM dan mulailah mendanai usaha potensial.
                    </p>
                    <div class="mt-5">
                        <a href="{{ route('dashboard', ['tab' => 'proposal']) }}" 
                           class="px-6 py-2.5 rounded-2xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm inline-flex items-center gap-2">
                            <span>Jelajahi Proposal UMKM</span> &rarr;
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- SEKSI PORTOFOLIO SEWA RUKO KOMERSIAL -->
        @if(isset($sewaDisponsoriSaya) && $sewaDisponsoriSaya->count() > 0)
            <div class="mt-12 pt-8 border-t border-[#E8E6DF] space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-teal-100 text-teal-800">
                                Portofolio Properti
                            </span>
                            <h2 class="text-lg font-black text-[#1A202C]">Sewa Ruko Komersial yang Saya Danai</h2>
                        </div>
                        <p class="text-xs text-gray-400 font-medium mt-0.5">Kontrak sewa tempat usaha komersial yang Anda sponsori untuk ekspansi cabang fisik mitra UMKM.</p>
                    </div>
                    <a href="{{ route('dashboard', ['tab' => 'ruko']) }}" class="text-xs font-bold text-[#0F433C] hover:underline flex items-center gap-1 self-start sm:self-auto">
                        <span>Kelola di Katalog Ruko</span> &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sewaDisponsoriSaya as $sewa)
                        <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-teal-50 text-teal-800 border border-teal-200">
                                        Sewa Ruko Komersial
                                    </span>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $sewa->status_pembayaran === 'dibayar' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                                        ● {{ strtoupper($sewa->status_pembayaran) }}
                                    </span>
                                </div>

                                <h3 class="text-base font-black text-[#1A202C] leading-snug">
                                    {{ $sewa->ruko->nama_ruko ?? 'Unit Ruko' }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Mitra UMKM: <strong class="text-gray-800">{{ $sewa->umkm->nama_usaha ?? 'UMKM Mitra' }}</strong>
                                </p>

                                <div class="mt-4 p-4 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] space-y-2 text-xs">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-500 font-medium">Dana Sewa Disalurkan:</span>
                                        <span class="font-black text-[#0F433C] text-sm">
                                            Rp {{ number_format($sewa->total_harga, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-500 font-medium">Lokasi Ruko:</span>
                                        <span class="font-semibold text-gray-700 truncate max-w-[150px]">
                                            {{ $sewa->ruko->lokasi ?? '-' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2 border-t border-gray-200/60">
                                        <span class="text-gray-500 font-medium">Periode Sewa:</span>
                                        <span class="text-gray-600 font-semibold">
                                            {{ $sewa->tanggal_mulai ? $sewa->tanggal_mulai->format('d M Y') : '-' }} s/d {{ $sewa->tanggal_selesai ? $sewa->tanggal_selesai->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                </div>

                                @if(!empty($sewa->catatan_sponsor))
                                    <div class="mt-3 p-3 rounded-xl bg-gray-50 border border-gray-100 text-[11px] text-gray-600 italic">
                                        "{{ $sewa->catatan_sponsor }}"
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    {{-- ========================================================================= --}}
    {{-- TAB: OBROLAN KEMITRAAN (RUANG CHAT INVESTOR DENGAN PENGELOLA UMKM)         --}}
    {{-- ========================================================================= --}}
    @elseif(in_array(($activeTab ?? ''), ['pesan', 'inbox']))

        <!-- PAGE HEADER OBROLAN -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">OBROLAN KEMITRAAN</h1>
                <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                    Ruang diskusi resmi dan komunikasi dua arah langsung dengan seluruh mitra pengelola UMKM yang Anda danai.
                </p>
            </div>

            <div class="flex items-center gap-2.5 self-start sm:self-auto">
                <a href="{{ route('dashboard', ['tab' => 'proposal']) }}" 
                   class="px-5 py-2.5 rounded-2xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>Danai UMKM Baru</span>
                </a>
            </div>
        </div>

        @if($investasiSayaWithChat->isEmpty())
            <!-- EMPTY STATE INVESTOR BELUM PUNYA OBROLAN -->
            <div class="bg-white rounded-3xl p-10 sm:p-14 text-center border border-[#E8E6DF] shadow-sm max-w-2xl mx-auto my-6">
                <div class="w-20 h-20 rounded-3xl bg-teal-50 text-[#0F433C] mx-auto flex items-center justify-center mb-5 shadow-inner">
                    <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-teal-100 text-teal-900 border border-teal-200 mb-3">
                    Belum Ada Obrolan Kemitraan
                </span>
                <h3 class="text-xl sm:text-2xl font-black text-[#1A202C]">Mulai Pendanaan untuk Membuka Ruang Chat</h3>
                <p class="text-xs sm:text-sm text-gray-500 mt-2 max-w-lg mx-auto leading-relaxed">
                    Anda belum mengajukan minat pendanaan ke UMKM mana pun. Setelah Anda mengajukan penawaran modal dari <strong>Proposal List</strong>, ruang obrolan langsung dan lembar negosiasi kemitraan akan otomatis aktif di sini.
                </p>
                <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('dashboard', ['tab' => 'proposal']) }}" 
                       class="px-6 py-3 rounded-2xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-md inline-flex items-center gap-2">
                        <span>Jelajahi Proposal UMKM Terverifikasi</span> &rarr;
                    </a>
                </div>
            </div>
        @else
            <!-- GRID 2 KOLOM: DAFTAR UMKM (KIRI) & RUANG CHAT (KANAN) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- KOLOM KIRI (5 COLS): DAFTAR MITRA UMKM YG DIDANAI -->
                <div class="lg:col-span-5 bg-white rounded-3xl p-5 sm:p-6 border border-[#E8E6DF] shadow-sm">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div>
                            <h2 class="text-sm font-black uppercase tracking-wider text-[#1A202C]">Daftar Mitra Usaha</h2>
                            <p class="text-[11px] text-gray-400">Pilih mitra untuk membuka ruang obrolan</p>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-teal-100 text-[#0F433C]">
                            {{ $investasiSayaWithChat->count() }} Usaha
                        </span>
                    </div>

                    <div class="mt-4 space-y-2.5 max-h-[620px] overflow-y-auto pr-1">
                        @foreach($investasiSayaWithChat as $invItem)
                            @php
                                $isSelected = ($selectedChatInvestasi && $selectedChatInvestasi->id_investasi === $invItem->id_investasi);
                                $lastMsg = $invItem->pesanInvestasi->last();
                            @endphp
                            <a href="{{ route('dashboard', ['tab' => 'pesan', 'investasi_id' => $invItem->id_investasi]) }}"
                               class="block p-4 rounded-2xl transition border {{ $isSelected ? 'border-2 border-[#0F433C] bg-teal-50/60 shadow-sm' : 'border-[#E8E6DF] hover:bg-gray-50 bg-white' }}">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-xs font-black text-[#1A202C] truncate">
                                                {{ $invItem->umkm->nama_usaha ?? 'Usaha UMKM' }}
                                            </h4>
                                            @if($invItem->status === 'aktif')
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase bg-emerald-100 text-emerald-800">
                                                    Aktif
                                                </span>
                                            @elseif($invItem->status === 'ditolak')
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase bg-gray-100 text-gray-600">
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase bg-amber-100 text-amber-800">
                                                    Pending
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-[11px] text-gray-500 truncate mt-0.5">
                                            {{ $invItem->umkm->jenis_usaha ?? 'UMKM' }} &bull; Pengelola: <strong>{{ $invItem->umkm->pemilik ?? 'Mitra' }}</strong>
                                        </p>
                                    </div>
                                    <span class="text-[10px] text-gray-400 shrink-0 font-medium">
                                        {{ $invItem->tanggal_investasi ? $invItem->tanggal_investasi->format('d/m/y') : '-' }}
                                    </span>
                                </div>

                                <!-- Detail Modal & Bagi Hasil -->
                                <div class="mt-2.5 text-xs flex justify-between items-center bg-white/80 p-2 rounded-xl border border-gray-100">
                                    <span class="text-[11px] text-gray-500">Komitmen Dana:</span>
                                    <span class="font-extrabold text-[#0F433C]">Rp {{ number_format($invItem->jumlah_modal, 0, ',', '.') }}</span>
                                </div>

                                <!-- Cuplikan Pesan Terakhir -->
                                <p class="text-[11px] text-gray-600 mt-2 line-clamp-1 italic">
                                    @if($lastMsg)
                                        <span class="font-bold {{ $lastMsg->id_pengirim === Auth::id() ? 'text-[#0F433C]' : 'text-gray-800' }}">
                                            {{ $lastMsg->id_pengirim === Auth::id() ? 'Anda:' : 'UMKM:' }}
                                        </span>
                                        "{{ $lastMsg->pesan }}"
                                    @else
                                        "{{ $invItem->catatan ?? 'Mulai obrolan...' }}"
                                    @endif
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- KOLOM KANAN (7 COLS): RUANG DISKUSI CHAT & LEMBAR KEMITRAAN DENGAN UMKM -->
                <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-7 border border-[#E8E6DF] shadow-sm flex flex-col justify-between min-h-[620px]">
                    @if($selectedChatInvestasi)
                        <div>
                            <!-- HEADER OBROLAN & PROFIL UMKM -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-gray-100">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-12 h-12 rounded-2xl bg-[#0F433C] text-white flex items-center justify-center font-black text-sm shrink-0 shadow-sm">
                                        {{ strtoupper(substr($selectedChatInvestasi->umkm->nama_usaha ?? 'U', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-base font-black text-[#1A202C]">
                                                {{ $selectedChatInvestasi->umkm->nama_usaha ?? 'Mitra Usaha' }}
                                            </h3>
                                            @if($selectedChatInvestasi->status === 'aktif')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800">
                                                    🟢 Kemitraan Aktif
                                                </span>
                                            @elseif($selectedChatInvestasi->status === 'ditolak')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-gray-100 text-gray-600">
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-amber-100 text-amber-800">
                                                    Menunggu Persetujuan UMKM
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 font-medium mt-0.5">
                                            Pengelola: <strong class="text-gray-800">{{ $selectedChatInvestasi->umkm->pemilik ?? '-' }}</strong> &bull; {{ $selectedChatInvestasi->umkm->provinsi_kota ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Aksi Kontak & WhatsApp -->
                                <div class="flex items-center gap-2 self-start sm:self-auto">
                                    @if(!empty($selectedChatInvestasi->umkm->nomor_whatsapp))
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $selectedChatInvestasi->umkm->nomor_whatsapp) }}?text=Halo%20{{ urlencode($selectedChatInvestasi->umkm->pemilik) }},%20saya%20investor%20dari%20platform%20DAYA%20UMKM."
                                           target="_blank"
                                           class="px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5"
                                           title="Lanjutkan Diskusi ke WhatsApp">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.99.54 2.012.85 2.796.85 3.177 0 5.766-2.587 5.766-5.766 0-3.18-2.586-5.767-5.766-5.767zm7.55 5.766c0 4.164-3.393 7.552-7.55 7.552-1.312 0-2.539-.344-3.61-.951l-4.043 1.059 1.082-3.947c-.707-1.144-1.116-2.483-1.116-3.713 0-4.165 3.39-7.553 7.55-7.553 4.163 0 7.687 3.388 7.687 7.552z"/>
                                            </svg>
                                            <span>Lanjut ke WA</span>
                                        </a>
                                    @endif

                                    <a href="{{ route('dashboard', ['tab' => 'proposal', 'q' => $selectedChatInvestasi->umkm->nama_usaha ?? '']) }}" 
                                       class="px-3 py-2 rounded-xl border border-[#E8E6DF] hover:bg-gray-50 text-gray-700 text-xs font-bold transition">
                                        Profil UMKM
                                    </a>
                                </div>
                            </div>

                            <!-- LEMBAR PARAMETER KOMITMEN DANA -->
                            <div class="mt-4 p-4 rounded-2xl bg-teal-50/70 border border-teal-200/80 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-[#0F433C]">Parameter Kemitraan Anda:</span>
                                    <span class="text-[11px] text-teal-800 font-bold">
                                        Tanggal: {{ $selectedChatInvestasi->tanggal_investasi ? $selectedChatInvestasi->tanggal_investasi->format('d M Y') : '-' }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1 text-xs">
                                    <div class="bg-white/80 p-2.5 rounded-xl border border-teal-100">
                                        <span class="text-[10px] text-gray-500 block">Komitmen Modal</span>
                                        <span class="font-extrabold text-[#0F433C] text-sm">Rp {{ number_format($selectedChatInvestasi->jumlah_modal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="bg-white/80 p-2.5 rounded-xl border border-teal-100">
                                        <span class="text-[10px] text-gray-500 block">Target Bagi Hasil</span>
                                        <span class="font-bold text-emerald-800">{{ $selectedChatInvestasi->persentase_bagi_hasil }}% p.a.</span>
                                    </div>
                                    <div class="bg-white/80 p-2.5 rounded-xl border border-teal-100">
                                        <span class="text-[10px] text-gray-500 block">Jadwal Dividen</span>
                                        <span class="font-bold text-gray-800">{{ $selectedChatInvestasi->periode_pembagian }}</span>
                                    </div>
                                </div>

                                <!-- Rekening Tujuan Dividen Anda -->
                                <div class="mt-2 pt-2 border-t border-teal-200/50 flex flex-wrap items-center justify-between text-[11px] text-gray-600 gap-2">
                                    <span>Rekening Penerimaan Dividen Anda: <strong class="text-teal-950">{{ $user->bank_name ?? 'Belum Diatur' }} - {{ $user->nomor_rekening ?? '-' }} (a.n. {{ $user->nama_pemilik_rekening ?? $user->name }})</strong></span>
                                    <a href="{{ route('dashboard', ['tab' => 'keuangan']) }}" class="text-[#0F433C] font-bold hover:underline">Ubah Rekening &rarr;</a>
                                </div>
                            </div>

                            <!-- RUANG CHAT / PERCAKAPAN IN-APP LANGSUNG -->
                            <div class="mt-4">
                                <span class="text-[10px] font-black uppercase tracking-wider text-gray-400 block mb-2">Riwayat Percakapan Langsung:</span>
                                <div class="space-y-3 max-h-[300px] overflow-y-auto p-4 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF]">
                                    @forelse($selectedChatInvestasi->pesanInvestasi as $msg)
                                        @php
                                            $isMe = ($msg->id_pengirim === Auth::id());
                                        @endphp
                                        <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                                            <div class="max-w-[80%] rounded-2xl p-3 text-xs shadow-sm {{ $isMe ? 'bg-[#0F433C] text-white rounded-br-sm' : 'bg-white text-gray-800 border border-gray-200 rounded-bl-sm' }}">
                                                <div class="flex items-center justify-between gap-2 mb-1">
                                                    <span class="font-bold text-[10px] {{ $isMe ? 'text-teal-200' : 'text-[#0F433C]' }}">
                                                        {{ $isMe ? 'Anda (Investor)' : ($selectedChatInvestasi->umkm->nama_usaha ?? 'Pemilik UMKM') }}
                                                    </span>
                                                    <span class="text-[9px] {{ $isMe ? 'text-teal-200/70' : 'text-gray-400' }}">
                                                        {{ $msg->created_at ? $msg->created_at->format('H:i') : '' }}
                                                    </span>
                                                </div>
                                                <p class="leading-relaxed whitespace-pre-wrap">{{ $msg->pesan }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-6 text-center text-xs text-gray-400">
                                            Belum ada pesan obrolan. Tulis pesan di bawah untuk memulai diskusi kemitraan.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- INPUT KIRIM PESAN CHAT -->
                        <div>
                            <!-- Quick Chips Pilihan Pertanyaan -->
                            <div class="mt-3 flex flex-wrap items-center gap-1.5 text-[11px]">
                                <span class="text-gray-400 text-[10px] font-bold">Cepat:</span>
                                <button type="button" 
                                        onclick="document.getElementById('input-pesan-investor').value = 'Halo, bagaimana perkembangan penjualan dan stok usaha minggu ini?';" 
                                        class="px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-teal-50 text-gray-600 hover:text-[#0F433C] transition">
                                    💡 Tanya progres penjualan
                                </button>
                                <button type="button" 
                                        onclick="document.getElementById('input-pesan-investor').value = 'Apakah laporan keuangan dan pembagian dividen periode ini sudah siap dibagikan?';" 
                                        class="px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-teal-50 text-gray-600 hover:text-[#0F433C] transition">
                                    💰 Jadwal dividen
                                </button>
                                <button type="button" 
                                        onclick="document.getElementById('input-pesan-investor').value = 'Saya siap menambah dukungan permodalan atau sewa ruko jika usaha Anda membutuhkan ekspansi.';" 
                                        class="px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-teal-50 text-gray-600 hover:text-[#0F433C] transition">
                                    🏢 Penawaran ekspansi
                                </button>
                            </div>

                            <form action="{{ route('dashboard.investasi.pesan', $selectedChatInvestasi->id_investasi) }}" method="POST" class="mt-3 pt-3 border-t border-gray-100 flex items-center gap-2">
                                @csrf
                                <input type="text" 
                                       id="input-pesan-investor"
                                       name="pesan" 
                                       required
                                       placeholder="Tulis pesan atau pertanyaan resmi untuk pengelola UMKM..." 
                                       class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-[#0F433C] focus:border-transparent outline-none">
                                <button type="submit" 
                                        class="px-5 py-2.5 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5 shrink-0">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4l19 8-19 8 3-8-3-8zm3 8h10"/>
                                    </svg>
                                    <span>Kirim</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="h-full flex flex-col items-center justify-center p-8 text-center text-gray-400">
                            <p class="text-xs">Pilih salah satu mitra UMKM di sebelah kiri untuk melihat rincian diskusi.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

    {{-- ========================================================================= --}}
    {{-- TAB 2: PROPOSAL LIST (Fitur Inti Permintaan User)                         --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'proposal')

        <div>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">PROPOSAL LIST</h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                Pilih proposal usaha UMKM terverifikasi dan ajukan komitmen investasi untuk mendorong pertumbuhan bisnis mereka.
            </p>
        </div>

        <!-- SEARCH BAR & FILTER KATEGORI -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <input type="hidden" name="tab" value="proposal">

                <!-- Search -->
                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari usaha / pemilik..."
                           class="w-56 sm:w-72 px-4 py-2.5 rounded-2xl bg-white border border-[#E8E6DF] text-xs font-semibold placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                </div>

                <!-- Kategori Buttons -->
                <a href="{{ route('dashboard', ['tab' => 'proposal', 'kategori' => 'semua']) }}" 
                   class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ (request('kategori') === 'semua' || !request('kategori')) ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                    Semua
                </a>
                <a href="{{ route('dashboard', ['tab' => 'proposal', 'kategori' => 'Makanan']) }}" 
                   class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ request('kategori') === 'Makanan' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                    Kuliner & Makanan
                </a>
                <a href="{{ route('dashboard', ['tab' => 'proposal', 'kategori' => 'Fashion']) }}" 
                   class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ request('kategori') === 'Fashion' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                    Fashion & Busana
                </a>
                <a href="{{ route('dashboard', ['tab' => 'proposal', 'kategori' => 'Jasa']) }}" 
                   class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ request('kategori') === 'Jasa' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                    Jasa
                </a>
            </form>
        </div>

        <!-- GRID DAFTAR PROPOSAL UMKM -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
            @forelse($availableProposals as $umkm)
                <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <!-- Header Kartu -->
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-teal-50 text-teal-800 border border-teal-200">
                                {{ $umkm->jenis_usaha }}
                            </span>
                            @if($umkm->status_pengajuan === 'terverifikasi')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                    ✓ Terverifikasi
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800">
                                    Ditinjau
                                </span>
                            @endif
                        </div>

                        <!-- Foto & Nama Usaha -->
                        <div class="w-full h-44 rounded-2xl bg-[#6B9E8A] text-white flex items-center justify-center font-black text-xl mb-4 overflow-hidden shadow-inner">
                            @if(!empty($umkm->foto_produk))
                                <img src="{{ asset('storage/' . $umkm->foto_produk) }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center">
                                    <svg class="w-10 h-10 mx-auto opacity-80 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span class="text-xs font-bold uppercase">{{ $umkm->nama_usaha }}</span>
                                </div>
                            @endif
                        </div>

                        <h3 class="text-base font-black text-[#1A202C] leading-snug">
                            {{ $umkm->nama_usaha }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Pemilik: <span class="font-bold text-gray-700">{{ $umkm->pemilik }}</span> &bull; {{ $umkm->provinsi_kota ?? 'Lokasi belum diisi' }}
                        </p>

                        <!-- Rating Kredibilitas Mitra UMKM -->
                        <div class="mt-2.5 flex items-center justify-between gap-2">
                            @if($umkm->total_ulasan > 0)
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 border border-amber-200 text-amber-900 text-xs font-black">
                                        <span class="text-amber-500">★</span>
                                        <span>{{ number_format($umkm->rating_rata_rata, 1) }}</span>
                                    </span>
                                    <button type="button" 
                                            onclick="openReviewsModal('{{ $umkm->id_umkm }}', '{{ addslashes($umkm->nama_usaha) }}', '{{ number_format($umkm->rating_rata_rata, 1) }}', '{{ $umkm->total_ulasan }}')"
                                            class="text-[11px] font-bold text-[#0F433C] hover:underline flex items-center gap-1">
                                        <span>{{ $umkm->total_ulasan }} Ulasan Investor</span> &rarr;
                                    </button>
                                </div>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full bg-teal-50 border border-teal-200 text-teal-800 text-[10px] font-semibold">
                                    ✨ Mitra Baru (Belum ada ulasan)
                                </span>
                            @endif
                        </div>

                        @if($umkm->total_ulasan > 0)
                            <!-- Template Data Ulasan Investor untuk Modal -->
                            <template id="reviews-tmpl-{{ $umkm->id_umkm }}">
                                <div class="space-y-3.5">
                                    @foreach($umkm->ulasanUmkm as $rev)
                                        <div class="p-4 rounded-2xl bg-[#F8F6F0] border border-[#E8E6DF] space-y-2.5">
                                            <div class="flex items-center justify-between gap-2">
                                                <div class="flex items-center gap-2.5">
                                                    <div class="w-8 h-8 rounded-full bg-[#0F433C] text-white flex items-center justify-center font-bold text-xs shrink-0">
                                                        {{ strtoupper(substr($rev->investor->name ?? 'I', 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="flex items-center gap-1.5 flex-wrap">
                                                            <span class="text-xs font-bold text-gray-800">{{ $rev->nama_investor_tersensor }}</span>
                                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                                ✓ Investor Terverifikasi
                                                            </span>
                                                        </div>
                                                        <span class="text-[10px] text-gray-400 font-medium">{{ $rev->created_at ? $rev->created_at->format('d M Y') : '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-1 text-amber-500 font-black text-xs bg-white px-2.5 py-1 rounded-xl border border-gray-100 shadow-sm shrink-0">
                                                    <span>★</span>
                                                    <span>{{ $rev->rating }}/5</span>
                                                </div>
                                            </div>

                                            <div class="flex flex-wrap gap-2 text-[10px]">
                                                <span class="px-2 py-0.5 rounded-lg bg-white text-gray-600 border border-gray-100 font-medium">
                                                    Transparansi: <strong class="text-emerald-700">{{ $rev->rating_transparansi ?? 5 }}/5</strong>
                                                </span>
                                                <span class="px-2 py-0.5 rounded-lg bg-white text-gray-600 border border-gray-100 font-medium">
                                                    Dividen: <strong class="text-emerald-700">{{ $rev->rating_dividen ?? 5 }}/5</strong>
                                                </span>
                                            </div>

                                            <div class="p-3 rounded-xl bg-white/80 border border-gray-100 text-xs text-gray-700 italic">
                                                "{{ $rev->ulasan }}"
                                            </div>

                                            @if(!empty($rev->balasan_umkm))
                                                <div class="p-3 rounded-xl bg-teal-50 border border-teal-100 text-xs text-teal-900 mt-2">
                                                    <div class="flex items-center gap-1 font-bold text-teal-900 text-[11px] mb-1">
                                                        <span>💬 Tanggapan Pemilik UMKM:</span>
                                                    </div>
                                                    <p class="text-teal-800 text-[11px]">{{ $rev->balasan_umkm }}</p>
                                                    <span class="text-[9px] text-teal-600 block mt-1">{{ $rev->tanggal_balasan ? $rev->tanggal_balasan->diffForHumans() : '' }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </template>
                        @endif

                        <!-- Sindikasi Crowdfunding & Nilai Pendanaan -->
                        <div class="mt-4 p-4 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] space-y-2.5 text-xs">
                            <!-- Sindikasi Header Badge -->
                            <div class="flex items-center justify-between">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-bold">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>👥 Sindikasi Crowdfunding</span>
                                </div>
                                <span class="text-[11px] font-extrabold text-[#0F433C]">
                                    {{ $umkm->persentase_sindikasi }}% Terpenuhi
                                </span>
                            </div>

                            <!-- Progress Bar Sindikasi -->
                            <div>
                                <div class="w-full h-2.5 rounded-full bg-gray-200 overflow-hidden shadow-inner flex">
                                    <div class="h-full bg-gradient-to-r from-emerald-500 to-[#0F433C] rounded-full transition-all duration-700 relative"
                                         style="width: {{ max(5, $umkm->persentase_sindikasi) }}%">
                                    </div>
                                </div>
                                <div class="flex justify-between items-center text-[10px] text-gray-500 mt-1.5 font-medium">
                                    <span>Terkumpul: <strong class="text-emerald-700 font-bold">Rp {{ number_format($umkm->total_modal_terkumpul, 0, ',', '.') }}</strong></span>
                                    <span>Target: <strong class="text-gray-800 font-bold">Rp {{ number_format($umkm->target_pendanaan_final, 0, ',', '.') }}</strong></span>
                                </div>
                            </div>

                            <!-- Mini Metrics Box -->
                            <div class="grid grid-cols-2 gap-2 pt-1.5 border-t border-gray-200/60 text-[11px]">
                                <div class="bg-white/80 p-2 rounded-xl border border-gray-100">
                                    <span class="text-gray-400 block text-[9px] uppercase tracking-wider font-semibold">Sisa Slot Pendanaan</span>
                                    <span class="font-extrabold text-amber-800 text-xs">
                                        Rp {{ number_format($umkm->sisa_kebutuhan_modal, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="bg-white/80 p-2 rounded-xl border border-gray-100">
                                    <span class="text-gray-400 block text-[9px] uppercase tracking-wider font-semibold">Investor Bergabung</span>
                                    <span class="font-extrabold text-[#0F433C] text-xs">
                                        {{ $umkm->jumlah_investor_sindikasi }} Co-Investor
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-1 text-xs">
                                <span class="text-gray-500 font-medium">Bagi Hasil Ditawarkan:</span>
                                <span class="font-bold text-emerald-700">
                                    {{ $umkm->persentase_bagi_hasil ?: ($umkm->estimasi_bagi_hasil ?: '15% p.a.') }}
                                </span>
                            </div>
                            @if($umkm->ruko)
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-500 font-medium">Pilihan Ruko:</span>
                                    <span class="font-semibold text-gray-800 truncate max-w-[130px]">
                                        {{ $umkm->ruko->nama_ruko }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Tautan Dokumen Proposal PDF -->
                        @if(!empty($umkm->file_proposal))
                            <div class="mt-3">
                                <a href="{{ route('proposal.download', $umkm->id_umkm) }}" target="_blank" 
                                   class="flex items-center gap-2 p-2.5 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-900 border border-teal-200 text-xs font-bold transition">
                                    <svg class="w-4 h-4 text-teal-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="truncate">Baca Berkas Proposal Lengkap (PDF)</span>
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- TOMBOL INVESTASI SEKARANG (Fitur Sindikasi & Mandiri) -->
                    <div class="mt-5 pt-4 border-t border-gray-100">
                        <button onclick="openInvestModal('{{ $umkm->id_umkm }}', '{{ addslashes($umkm->nama_usaha) }}', '{{ $umkm->sisa_kebutuhan_modal > 0 ? $umkm->sisa_kebutuhan_modal : $umkm->target_pendanaan_final }}', '{{ $umkm->persentase_bagi_hasil ?: 15 }}')"
                                class="w-full py-3 px-4 rounded-2xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-black shadow-md transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <span>Ikut Sindikasi / Danai Sekarang</span>
                        </button>
                    </div>

                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-[#E8E6DF]">
                    <div class="w-16 h-16 rounded-full bg-gray-100 text-gray-400 mx-auto flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Tidak ada proposal UMKM yang cocok</h3>
                    <p class="text-xs text-gray-500 mt-1">Coba ubah kata kunci atau pilih kategori lain.</p>
                </div>
            @endforelse
        </div>

    {{-- ========================================================================= --}}
    {{-- TAB 3: KOMUNITAS INVESTOR & UMKM (Sesuai Gambar 3)                        --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'komunitas')

        <div>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">KOMUNITAS</h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                Jejaring kemitraan, forum diskusi, dan berbagi pengalaman investasi UMKM.
            </p>
        </div>

        <div class="bg-white rounded-3xl p-8 border border-[#E8E6DF] shadow-sm max-w-2xl">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-teal-100 text-[#0F433C] flex items-center justify-center font-bold">
                    👥
                </div>
                <div>
                    <h3 class="text-base font-black text-[#1A202C]">Forum Investor Daya UMKM</h3>
                    <p class="text-xs text-gray-500">Beranggotakan 240+ mitra investor dan kurator bisnis.</p>
                </div>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed mb-6">
                Terhubung dengan sesama investor untuk berdiskusi mengenai skema sindikasi pendanaan, evaluasi kinerja UMKM, dan peluang pembukaan gerai ruko baru.
            </p>
            <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20ingin%20bergabung%20dengan%20Grup%20Komunitas%20Investor%20DAYA%20UMKM." target="_blank"
               class="px-5 py-2.5 rounded-2xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm inline-flex items-center gap-2">
                <span>Gabung Grup WhatsApp Komunitas</span> &rarr;
            </a>
        </div>

    {{-- ========================================================================= --}}
    {{-- TAB 4: LAPORAN KEUANGAN & RIWAYAT DIVIDEN (Fitur 1 & Fitur 3)             --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'keuangan')

        <div class="screen-only space-y-6">
        <!-- PAGE HEADER KEUANGAN -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">LAPORAN KEUANGAN & DIVIDEN</h1>
                <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                    Rekapitulasi riil pembagian dividen bagi hasil, status pengembalian modal (payback), dan rekening pencairan.
                </p>
            </div>

            <div class="flex items-center gap-3 self-start sm:self-auto shrink-0 flex-wrap sm:flex-nowrap">
                <button onclick="window.print()" 
                        class="h-11 px-5 rounded-2xl bg-white border border-[#E8E6DF] hover:bg-gray-50 text-gray-700 text-xs font-bold transition shadow-sm inline-flex items-center justify-center gap-2.5 whitespace-nowrap shrink-0">
                    <svg class="w-4 h-4 text-gray-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Cetak Rekap</span>
                </button>

                <button onclick="openBankModal()" 
                        class="h-11 px-5 rounded-2xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm inline-flex items-center justify-center gap-2.5 whitespace-nowrap shrink-0">
                    <svg class="w-4 h-4 text-teal-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span>Atur Rekening Bank</span>
                </button>
            </div>
        </div>

        <!-- 4 KARTU METRIK KEUANGAN RIIL -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <!-- 1. Total Dividen Diterima -->
            <div class="p-6 rounded-3xl bg-white border border-[#E8E6DF] shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Dividen Diterima</span>
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">💰</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-emerald-700 tracking-tight">
                    Rp {{ number_format($totalDividenDiterima, 0, ',', '.') }}
                </div>
                <p class="text-[11px] text-gray-400 mt-2 font-medium">
                    Tercatat dari {{ $riwayatBagiHasil->count() }} transaksi bagi hasil
                </p>
            </div>

            <!-- 2. Proyeksi Dividen Bulan Ini -->
            <div class="p-6 rounded-3xl bg-white border border-[#E8E6DF] shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Proyeksi Dividen Bulan Ini</span>
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">📈</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-[#0F433C] tracking-tight">
                    Rp {{ number_format($proyeksiDividenBulanIni, 0, ',', '.') }}
                </div>
                <p class="text-[11px] text-gray-400 mt-2 font-medium">
                    Rata-rata bagi hasil: {{ $rataRataBagiHasil }}% p.a.
                </p>
            </div>

            <!-- 3. Total Modal Aktif Disalurkan -->
            <div class="p-6 rounded-3xl bg-white border border-[#E8E6DF] shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Modal Berjalan</span>
                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm">🤝</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-[#1A202C] tracking-tight">
                    Rp {{ number_format($totalModalDiinvestasikan, 0, ',', '.') }}
                </div>
                <p class="text-[11px] text-gray-400 mt-2 font-medium">
                    Pada {{ $umkmDidanaiCount }} mitra usaha UMKM
                </p>
            </div>

            <!-- 4. Payback Progress Tracker -->
            <div class="p-6 rounded-3xl bg-white border border-[#E8E6DF] shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pengembalian Modal</span>
                        <span class="text-xs font-black text-emerald-700">{{ $persentasePengembalianModal }}%</span>
                    </div>
                    <div class="w-full h-3 rounded-full bg-gray-100 overflow-hidden mt-1">
                        <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 transition-all duration-500"
                             style="width: {{ min(100, $persentasePengembalianModal) }}%;"></div>
                    </div>
                </div>
                <p class="text-[11px] text-gray-500 mt-3 font-medium">
                    Tercapai Rp {{ number_format($totalDividenDiterima, 0, ',', '.') }} dari pokok Rp {{ number_format($totalModalDiinvestasikan, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- FITUR 3: KARTU PENGATURAN REKENING BANK INVESTOR -->
        <div class="rounded-3xl p-6 sm:p-7 shadow-xl border border-emerald-950/20"
             style="background: #0F433C !important; background: linear-gradient(135deg, #0F433C 0%, #16534A 100%) !important; color: #ffffff !important;">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0"
                         style="background: rgba(255, 255, 255, 0.15) !important; border: 1px solid rgba(255, 255, 255, 0.25) !important;">
                        🏦
                    </div>
                    <div>
                        <div class="flex items-center gap-2.5">
                            <h2 class="text-lg font-black tracking-tight" style="color: #ffffff !important;">Rekening Bank Tujuan Pencairan Dividen</h2>
                            @if(!empty($user->nomor_rekening))
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-400 text-emerald-950">
                                    Aktif & Terverifikasi
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-amber-950">
                                    Perlu Dilengkapi
                                </span>
                            @endif
                        </div>
                        <p class="text-xs mt-1 max-w-xl" style="color: #D1FAE5 !important;">
                            Setiap keuntungan dan bagi hasil dari UMKM mitra disalurkan otomatis ke nomor rekening bank di bawah ini.
                        </p>

                        <div class="mt-4 flex flex-wrap items-center gap-6 text-xs">
                            <div>
                                <span class="block text-[10px] font-bold uppercase tracking-wider" style="color: #A7F3D0 !important;">Nama Bank</span>
                                <span class="text-sm font-black" style="color: #ffffff !important;">{{ $user->bank_name ?? 'Belum Diatur' }}</span>
                            </div>
                            <div class="border-l border-white/20 pl-6">
                                <span class="block text-[10px] font-bold uppercase tracking-wider" style="color: #A7F3D0 !important;">Nomor Rekening</span>
                                <span class="text-sm font-black font-mono tracking-wider" style="color: #F1C40F !important;">
                                    {{ $user->nomor_rekening ?? 'Belum Ada Nomor Rekening' }}
                                </span>
                            </div>
                            <div class="border-l border-white/20 pl-6">
                                <span class="block text-[10px] font-bold uppercase tracking-wider" style="color: #A7F3D0 !important;">Nama Pemilik Rekening</span>
                                <span class="text-sm font-black" style="color: #ffffff !important;">{{ $user->nama_pemilik_rekening ?? ($user->name ?? '-') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="self-start md:self-center shrink-0">
                    <button onclick="openBankModal()" 
                            class="px-5 py-3 rounded-2xl text-xs font-black shadow-md transition flex items-center gap-2 hover:opacity-90"
                            style="background-color: #ffffff !important; color: #0F433C !important;">
                        <svg class="w-4 h-4" fill="none" stroke="#0F433C" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>{{ !empty($user->nomor_rekening) ? 'Ubah Rekening Bank' : 'Daftarkan Rekening Bank' }}</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- FITUR 1: TABEL RIWAYAT PEMBAGIAN DIVIDEN REAL (Tabel bagi_hasil_log) -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-gray-100">
                <div>
                    <h2 class="text-lg font-black text-[#1A202C]">Buku Riwayat Penyaluran Dividen</h2>
                    <p class="text-xs text-gray-500 font-medium">Daftar transaksi bagi hasil dividen nyata yang disetor oleh pelaku UMKM ke akun Anda.</p>
                </div>
                <div class="text-xs font-bold text-gray-400">
                    Total Transaksi: <span class="text-[#0F433C] font-black">{{ $riwayatBagiHasil->count() }} Data</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-[#E8E6DF] text-gray-400 uppercase tracking-wider text-[10px]">
                            <th class="py-3 px-3">No</th>
                            <th class="py-3 px-3">Tanggal Distribusi</th>
                            <th class="py-3 px-3">Mitra UMKM</th>
                            <th class="py-3 px-3">Bagi Hasil Ref</th>
                            <th class="py-3 px-3">Nominal Dividen</th>
                            <th class="py-3 px-3">Bukti Transfer</th>
                            <th class="py-3 px-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($riwayatBagiHasil as $log)
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="py-3.5 px-3 font-bold text-gray-400">{{ $loop->iteration }}</td>
                                <td class="py-3.5 px-3 font-semibold text-gray-800">
                                    {{ $log->tanggal_distribusi ? $log->tanggal_distribusi->format('d M Y, H:i') : '-' }} WIB
                                </td>
                                <td class="py-3.5 px-3">
                                    <div class="font-bold text-[#1A202C]">
                                        {{ $log->investasi->umkm->nama_usaha ?? 'UMKM Mitra' }}
                                    </div>
                                    <div class="text-[10px] text-gray-400">
                                        Pemilik: {{ $log->investasi->umkm->pemilik ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-3.5 px-3 text-gray-600">
                                    {{ $log->investasi->persentase_bagi_hasil ?? 15 }}% p.a. ({{ $log->investasi->periode_pembagian ?? 'Bulanan' }})
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="text-sm font-black text-emerald-700">
                                        + Rp {{ number_format($log->nominal_diterima, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-3">
                                    @if(!empty($log->bukti_transfer))
                                        <button onclick="previewStruk('{{ asset(ltrim($log->bukti_transfer, '/')) }}', '{{ $log->investasi->umkm->nama_usaha ?? 'UMKM' }}', '{{ number_format($log->nominal_diterima, 0, ',', '.') }}')"
                                                class="px-2.5 py-1 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200 text-[10px] font-black transition inline-flex items-center gap-1.5 shadow-xs active:scale-95">
                                            <svg class="w-3 h-3 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <span>Lihat Struk</span>
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-[11px] font-medium">Transfer Otomatis</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                        ✓ Masuk Rekening
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 px-4 text-center">
                                    <div class="w-14 h-14 rounded-2xl bg-[#F9F8F3] text-gray-400 mx-auto flex items-center justify-center text-2xl mb-3 border border-[#E8E6DF]">
                                        📜
                                    </div>
                                    <h3 class="text-sm font-bold text-gray-700">Belum ada riwayat pembagian dividen</h3>
                                    <p class="text-xs text-gray-400 mt-1 max-w-md mx-auto">
                                        Data riwayat dividen riil dari tabel database akan muncul secara otomatis ketika mitra UMKM menyetorkan bagi hasil sesuai jadwal periodik.
                                    </p>
                                    @if(isset($realInvestasiCount) && $realInvestasiCount === 0)
                                        <div class="mt-4">
                                            <a href="{{ route('dashboard', ['tab' => 'proposal']) }}" 
                                               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#0F433C] text-white text-xs font-bold hover:bg-[#19584F] transition shadow-sm">
                                                <span>Mulai Danai UMKM Pertama</span> &rarr;
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        </div>

        <!-- CETAK REKAP LAPORAN KEUANGAN & DIVIDEN (LAYOUT INVOICE BERSIH KHUSUS CETAK) -->
        <div class="print-only font-sans text-gray-900 bg-white">
            <!-- HEADER / KOP INVOICE -->
            <div class="border-b-2 border-gray-900 pb-4 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-black tracking-tight text-gray-900 uppercase">TIKUM &bull; DAYA UMKM</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">Platform Ekosistem Akselerasi Modal & Kemitraan Sektor Riil UMKM</p>
                        <p class="text-[11px] text-gray-500">Universitas Maria Kudus &bull; Gondangmanis, Bae, Kudus, Jawa Tengah</p>
                        <p class="text-[11px] text-gray-500">Email: halo@dayaumkm.id | Website: dayaumkm.id</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-3 py-1 bg-gray-100 border border-gray-300 text-gray-800 text-[11px] font-black uppercase tracking-wider rounded mb-1.5">
                            Faktur Rekapitulasi Dividen
                        </span>
                        <div class="text-xs text-gray-600 mt-1">
                            <span class="font-bold">No. Dokumen:</span> <span class="font-mono">INV-DIV/{{ date('Ymd') }}/{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="text-xs text-gray-600">
                            <span class="font-bold">Tanggal Cetak:</span> {{ now()->translatedFormat('d F Y, H:i') }} WIB
                        </div>
                        <div class="text-xs text-gray-600">
                            <span class="font-bold">Status Dokumen:</span> <span class="font-bold text-gray-900">Resmi Terverifikasi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DETAIL INVESTOR & REKENING PENCAIRAN (2 KOLOM BERSIH) -->
            <div class="grid grid-cols-2 gap-6 mb-6 text-xs">
                <div class="border border-gray-300 rounded p-4 bg-gray-50/50">
                    <span class="block text-[10px] font-black uppercase tracking-wider text-gray-500 mb-2 border-b border-gray-200 pb-1">
                        Informasi Mitra Investor
                    </span>
                    <table class="w-full">
                        <tr class="py-1">
                            <td class="text-gray-600 w-28 py-0.5 font-medium">Nama Investor</td>
                            <td class="font-bold text-gray-900 py-0.5">: {{ $user->name }}</td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-0.5 font-medium">ID Pengguna</td>
                            <td class="font-mono py-0.5">: USR-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-0.5 font-medium">Email / Telepon</td>
                            <td class="py-0.5">: {{ $user->email }} / {{ $user->phone_number ?? '-' }}</td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-0.5 font-medium">Domisili</td>
                            <td class="py-0.5">: {{ $user->provinsi_kota ?? ($user->kota ?? 'Indonesia') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="border border-gray-300 rounded p-4 bg-gray-50/50">
                    <span class="block text-[10px] font-black uppercase tracking-wider text-gray-500 mb-2 border-b border-gray-200 pb-1">
                        Rekening Bank Penerima Dividen
                    </span>
                    <table class="w-full">
                        <tr class="py-1">
                            <td class="text-gray-600 w-28 py-0.5 font-medium">Nama Bank</td>
                            <td class="font-bold text-gray-900 py-0.5">: {{ $user->bank_name ?? 'Belum Diatur' }}</td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-0.5 font-medium">Nomor Rekening</td>
                            <td class="font-mono font-bold text-gray-900 py-0.5">: {{ $user->nomor_rekening ?? '-' }}</td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-0.5 font-medium">Atas Nama</td>
                            <td class="py-0.5">: {{ $user->nama_pemilik_rekening ?? ($user->name ?? '-') }}</td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-0.5 font-medium">Status Rekening</td>
                            <td class="py-0.5">: {{ !empty($user->nomor_rekening) ? 'Aktif & Terverifikasi' : 'Perlu Dilengkapi' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- RINGKASAN POSISI KEUANGAN (TABEL KOTAK MINIMALIS INVOICE) -->
            <div class="mb-6">
                <span class="block text-[10px] font-black uppercase tracking-wider text-gray-500 mb-2">
                    Ringkasan Posisi Finansial Portofolio
                </span>
                <table class="w-full border-collapse border border-gray-300 text-xs">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-[10px] tracking-wider border-b border-gray-300">
                            <th class="border border-gray-300 py-2 px-3 text-left">Total Modal Berjalan</th>
                            <th class="border border-gray-300 py-2 px-3 text-left">Total Dividen Diterima</th>
                            <th class="border border-gray-300 py-2 px-3 text-left">Proyeksi Dividen Bulan Ini</th>
                            <th class="border border-gray-300 py-2 px-3 text-left">Rata-Rata Bagi Hasil</th>
                            <th class="border border-gray-300 py-2 px-3 text-left">Pengembalian Pokok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 py-2.5 px-3 font-bold text-gray-900">
                                Rp {{ number_format($totalModalDiinvestasikan, 0, ',', '.') }}
                            </td>
                            <td class="border border-gray-300 py-2.5 px-3 font-bold text-gray-900">
                                Rp {{ number_format($totalDividenDiterima, 0, ',', '.') }}
                            </td>
                            <td class="border border-gray-300 py-2.5 px-3 font-medium text-gray-800">
                                Rp {{ number_format($proyeksiDividenBulanIni, 0, ',', '.') }}
                            </td>
                            <td class="border border-gray-300 py-2.5 px-3 font-medium text-gray-800">
                                {{ $rataRataBagiHasil }}% p.a.
                            </td>
                            <td class="border border-gray-300 py-2.5 px-3 font-bold text-gray-900">
                                {{ $persentasePengembalianModal }}%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- TABEL RINCIAN MUTASI PENYALURAN DIVIDEN -->
            <div class="mb-6 page-break-avoid">
                <span class="block text-[10px] font-black uppercase tracking-wider text-gray-500 mb-2">
                    Rincian Riwayat Penyaluran Dividen & Bagi Hasil Riil
                </span>
                <table class="w-full border-collapse border border-gray-300 text-xs">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-[10px] tracking-wider border-b border-gray-300">
                            <th class="border border-gray-300 py-2 px-2.5 text-center w-10">No</th>
                            <th class="border border-gray-300 py-2 px-3 text-left">Tanggal Distribusi</th>
                            <th class="border border-gray-300 py-2 px-3 text-left">Mitra Usaha UMKM</th>
                            <th class="border border-gray-300 py-2 px-3 text-left">No. Referensi Bagi Hasil</th>
                            <th class="border border-gray-300 py-2 px-3 text-center">Status</th>
                            <th class="border border-gray-300 py-2 px-3 text-right">Nominal Dividen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($riwayatBagiHasil as $idx => $log)
                            <tr>
                                <td class="border border-gray-300 py-2 px-2.5 text-center text-gray-600">{{ $idx + 1 }}</td>
                                <td class="border border-gray-300 py-2 px-3 text-gray-700">
                                    {{ $log->tanggal_distribusi ? \Carbon\Carbon::parse($log->tanggal_distribusi)->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="border border-gray-300 py-2 px-3 font-semibold text-gray-900">
                                    {{ $log->umkm->nama_usaha ?? ($log->investasi->umkm->nama_usaha ?? 'Mitra Usaha UMKM') }}
                                </td>
                                <td class="border border-gray-300 py-2 px-3 font-mono text-[11px] text-gray-600">
                                    DIV-REF-{{ str_pad($log->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="border border-gray-300 py-2 px-3 text-center text-gray-700">
                                    {{ ucfirst($log->status ?? 'Berhasil') }}
                                </td>
                                <td class="border border-gray-300 py-2 px-3 text-right font-bold text-gray-900 font-mono">
                                    Rp {{ number_format($log->nominal_diterima, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border border-gray-300 py-4 px-3 text-center text-gray-500 italic">
                                    Belum ada transaksi bagi hasil dividen yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 border-t-2 border-gray-400 font-bold">
                            <td colspan="5" class="border border-gray-300 py-2.5 px-3 text-right uppercase tracking-wider text-gray-700">
                                Total Akumulasi Dividen Diterima:
                            </td>
                            <td class="border border-gray-300 py-2.5 px-3 text-right font-black font-mono text-gray-900 text-sm">
                                Rp {{ number_format($totalDividenDiterima, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- FOOTER, CATATAN & TANDA TANGAN ELEKTRONIK -->
            <div class="grid grid-cols-12 gap-6 pt-4 border-t border-gray-300 page-break-avoid text-xs">
                <div class="col-span-8 text-gray-600 space-y-1">
                    <span class="font-bold text-gray-800 block text-[11px] uppercase tracking-wider">Ketentuan & Catatan Resmi:</span>
                    <p class="text-[10px] leading-relaxed">
                        1. Faktur rekapitulasi ini merupakan catatan resmi mutasi bagi hasil dan pengembalian modal pada platform kemitraan TIKUM DAYA UMKM.
                    </p>
                    <p class="text-[10px] leading-relaxed">
                        2. Dividen telah diproses dan disalurkan langsung ke nomor rekening terdaftar mitra investor tanpa potongan biaya platform.
                    </p>
                    <p class="text-[10px] leading-relaxed">
                        3. Dokumen ini diterbitkan secara elektronik dan sah tanpa memerlukan stempel fisik atau tanda tangan basah.
                    </p>
                </div>
                <div class="col-span-4 text-center">
                    <p class="text-[11px] text-gray-600">Kudus, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="text-xs font-bold text-gray-900 mt-0.5">Sistem Finansial TIKUM</p>
                    <div class="my-3 py-2 border border-dashed border-gray-400 rounded inline-block px-4">
                        <span class="text-[10px] font-mono uppercase tracking-widest text-gray-500 block">TIKUM VERIFIED</span>
                        <span class="text-[9px] text-gray-400 block font-mono">{{ md5('TIKUM-DIV-'.$user->id) }}</span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-700">Divisi Audit Finansial & Kemitraan</p>
                    <p class="text-[9px] text-gray-400">Universitas Maria Kudus</p>
                </div>
            </div>
        </div>

    {{-- ========================================================================= --}}
    {{-- TAB 5: KATALOG RUKO STRATEGIS (Fitur 2: Pilar Sewa Komersial UMKM)         --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'ruko')

        <!-- PAGE HEADER KATALOG RUKO -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">KATALOG RUKO STRATEGIS</h1>
                <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                    Pilar sewa komersial TIKUM. Investor dapat mendanai/mensponsori sewa ruko bagi gerai fisik UMKM binaan atau merekomendasikan ruko baru.
                </p>
            </div>

            <button onclick="openRekomendasiRukoModal()" 
                    class="px-5 py-2.5 rounded-2xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm inline-flex items-center gap-2 self-start sm:self-auto">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Rekomendasikan Ruko Baru</span>
            </button>
        </div>

        <!-- 4 KARTU STATISTIK RUKO -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
            <div class="p-4 rounded-2xl bg-white border border-[#E8E6DF] shadow-sm">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Total Ruko di Sistem</span>
                <span class="text-xl sm:text-2xl font-black text-[#1A202C] mt-0.5 block">{{ $semuaRukos->count() }} Unit</span>
            </div>
            <div class="p-4 rounded-2xl bg-white border border-[#E8E6DF] shadow-sm">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Siap Ditempati</span>
                <span class="text-xl sm:text-2xl font-black text-emerald-700 mt-0.5 block">
                    {{ $semuaRukos->where('status_ketersediaan', 'tersedia')->count() }} Unit
                </span>
            </div>
            <div class="p-4 rounded-2xl bg-white border border-[#E8E6DF] shadow-sm">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Rekomendasi Saya</span>
                <span class="text-xl sm:text-2xl font-black text-blue-700 mt-0.5 block">{{ $rekomendasiSaya->count() }} Usulan</span>
            </div>
            <div class="p-4 rounded-2xl bg-white border border-[#E8E6DF] shadow-sm">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Sewa Disponsori</span>
                <span class="text-xl sm:text-2xl font-black text-[#0F433C] mt-0.5 block">{{ $sewaDisponsoriSaya->count() }} Kontrak</span>
            </div>
        </div>

        <!-- SEARCH BAR & FILTER STATUS RUKO -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <input type="hidden" name="tab" value="ruko">

                <!-- Search Input -->
                <div class="relative">
                    <input type="text" name="ruko_q" value="{{ request('ruko_q') }}" placeholder="Cari nama ruko / lokasi..."
                           class="w-56 sm:w-72 px-4 py-2.5 rounded-2xl bg-white border border-[#E8E6DF] text-xs font-semibold placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                </div>

                <!-- Filter Status -->
                <a href="{{ route('dashboard', ['tab' => 'ruko', 'ruko_status' => 'semua']) }}" 
                   class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ ($rukoFilter ?? 'semua') === 'semua' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                    Semua
                </a>
                <a href="{{ route('dashboard', ['tab' => 'ruko', 'ruko_status' => 'tersedia']) }}" 
                   class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ ($rukoFilter ?? '') === 'tersedia' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                    Tersedia
                </a>
                <a href="{{ route('dashboard', ['tab' => 'ruko', 'ruko_status' => 'tersewa']) }}" 
                   class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ ($rukoFilter ?? '') === 'tersewa' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
                    Tersewa
                </a>
            </form>
        </div>

        <!-- GRID KATALOG RUKO STRATEGIS -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-black text-[#1A202C]">Daftar Unit Ruko Komersial</h2>
                <span class="text-xs text-gray-400 font-semibold">{{ $semuaRukos->count() }} ruko terdaftar</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($semuaRukos as $ruko)
                    <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <!-- Visual Banner Ruko -->
                            <div class="w-full h-40 rounded-2xl bg-gray-100 mb-4 overflow-hidden shadow-inner border border-gray-100 relative">
                                @if(!empty($ruko->foto_ruko))
                                    <img src="{{ asset($ruko->foto_ruko) }}" alt="{{ $ruko->nama_ruko }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full text-white flex flex-col items-center justify-center p-4 relative"
                                         style="background: #0F433C; background: linear-gradient(135deg, #0F433C 0%, #20675D 100%) !important; color: #ffffff !important;">
                                        <svg class="w-12 h-12 text-teal-200/80 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span class="text-xs font-black tracking-wider uppercase text-teal-100">Unit Ruko Komersial</span>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3">
                                    @if($ruko->is_penuh)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-600 text-white shadow-sm flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Sudah Diisi (Penuh)
                                        </span>
                                    @elseif(($ruko->unit_terisi ?? 0) > 0)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500 text-white shadow-sm flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span> Sisa {{ $ruko->sisa_unit }} Unit
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-600 text-white shadow-sm flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span> Kosong (Sisa {{ $ruko->sisa_unit }} Unit)
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <h3 class="text-base font-black text-[#1A202C] leading-snug truncate">
                                {{ $ruko->nama_ruko }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-1 flex items-start gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $ruko->lokasi }}</span>
                            </p>

                            <!-- Penyedia & Harga Sewa & Kapasitas -->
                            <div class="mt-4 p-3.5 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] space-y-1.5 text-xs">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400 font-medium text-[11px]">Harga Sewa / Bulan:</span>
                                    <span class="text-sm font-black text-[#0F433C]">
                                        Rp {{ number_format($ruko->harga_sewa_per_bulan, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="text-gray-400 font-medium">Kondisi Lapak:</span>
                                    @if($ruko->is_penuh)
                                        <span class="font-bold text-rose-600">🔴 Sudah Diisi Penuh</span>
                                    @elseif(($ruko->unit_terisi ?? 0) > 0)
                                        <span class="font-bold text-amber-700">🟡 Terisi Sebagian ({{ $ruko->unit_terisi }}/{{ $ruko->total_unit }} Unit)</span>
                                    @else
                                        <span class="font-bold text-emerald-700">🟢 Kosong (Siap Huni)</span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="text-gray-400 font-medium">Sisa Unit Kosong:</span>
                                    <span class="font-black text-xs">
                                        <span class="{{ $ruko->sisa_unit > 0 ? 'text-emerald-700' : 'text-rose-600' }}">
                                            {{ $ruko->sisa_unit }} Unit
                                        </span>
                                        <span class="text-gray-400 font-normal text-[11px]">/ {{ $ruko->total_unit ?? 1 }} Total</span>
                                    </span>
                                </div>
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="text-gray-400 font-medium">Penyedia:</span>
                                    <span class="font-bold text-gray-700 truncate max-w-[130px]">
                                        {{ $ruko->penyedia->nama_penyedia ?? ($ruko->penyedia->nama_perusahaan ?? 'Mitra Komunitas') }}
                                    </span>
                                </div>
                                @if(!empty($ruko->kontak_pemilik))
                                    <div class="flex justify-between items-center text-[11px] pt-1.5 border-t border-gray-200/50">
                                        <span class="text-gray-400 font-medium">Kontak Pemilik:</span>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ruko->kontak_pemilik) }}" target="_blank" class="font-bold text-emerald-700 hover:underline">
                                            {{ $ruko->kontak_pemilik }} ↗
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- CTA BUTTON SPONSOR SEWA -->
                        <div class="mt-5 pt-3 border-t border-gray-100">
                            @if(!$ruko->is_penuh)
                                <button onclick="openSponsorRukoModal('{{ $ruko->id_ruko }}', '{{ addslashes($ruko->nama_ruko) }}', '{{ $ruko->harga_sewa_per_bulan }}', '{{ addslashes($ruko->lokasi) }}')"
                                        class="w-full py-2.5 px-4 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-black transition shadow-sm flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Danai / Sponsori (Sisa {{ $ruko->sisa_unit }} Unit)</span>
                                </button>
                            @else
                                <button disabled class="w-full py-2.5 px-4 rounded-xl bg-gray-100 text-gray-400 text-xs font-bold cursor-not-allowed">
                                    🔴 Unit Ruko Sudah Penuh (Terisi)
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-10 text-center bg-white rounded-3xl border border-[#E8E6DF]">
                        <p class="text-xs text-gray-400">Tidak ada unit ruko yang cocok dengan pencarian.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- SEKSI REKOMENDASI RUKO YANG SAYA AJUKAN -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h2 class="text-base font-black text-[#1A202C]">Rekomendasi Ruko yang Pernah Saya Ajukan</h2>
                    <p class="text-xs text-gray-500 font-medium">Usulan ruko strategis yang Anda kirimkan untuk dikurasi tim DAYA UMKM.</p>
                </div>
                <button onclick="openRekomendasiRukoModal()" class="text-xs font-bold text-[#0F433C] hover:underline">
                    + Ajukan Lokasi Baru
                </button>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($rekomendasiSaya as $rekom)
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-black text-[#1A202C] text-sm">{{ $rekom->nama_ruko }}</span>
                                @if($rekom->status === 'diverifikasi' || $rekom->status === 'disetujui')
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-emerald-100 text-emerald-800">
                                        ✓ Diverifikasi Admin
                                    </span>
                                @elseif($rekom->status === 'ditolak')
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-rose-100 text-rose-800">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-amber-100 text-amber-800">
                                        Menunggu Verifikasi
                                    </span>
                                @endif
                            </div>
                            <p class="text-gray-500 mt-0.5">{{ $rekom->lokasi }}</p>
                            @if(!empty($rekom->potensi_usaha))
                                <p class="text-[11px] text-teal-800 mt-1 bg-teal-50/70 p-2 rounded-xl">
                                    💡 <strong>Potensi:</strong> {{ $rekom->potensi_usaha }}
                                </p>
                            @endif
                        </div>

                        <div class="text-right sm:shrink-0">
                            <span class="text-gray-400 text-[10px] block font-bold uppercase">Estimasi Sewa</span>
                            <span class="font-black text-[#0F433C] text-sm">Rp {{ number_format($rekom->harga_sewa_per_bulan, 0, ',', '.') }} / bln</span>
                            <span class="text-[10px] text-gray-400 block mt-0.5">
                                {{ $rekom->siap_danai ? '✓ Siap Danai Sewa' : 'Hanya Rekomendasi' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-gray-400">
                        Anda belum pernah merekomendasikan ruko. Tahu lokasi komersial strategis yang berpotensi untuk UMKM?
                        <button onclick="openRekomendasiRukoModal()" class="text-[#0F433C] font-bold hover:underline block mx-auto mt-2">
                            Klik di sini untuk mengajukan usulan ruko baru
                        </button>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- SEKSI SEWA RUKO YANG SAYA SPONSORI -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm space-y-4">
            <div class="pb-3 border-b border-gray-100">
                <h2 class="text-base font-black text-[#1A202C]">Riwayat Sewa Ruko yang Saya Sponsori</h2>
                <p class="text-xs text-gray-500 font-medium">Daftar transaksi sewa komersial yang Anda danai untuk ekspansi gerai mitra UMKM.</p>
            </div>

            <div class="divide-y divide-gray-100 text-xs">
                @forelse($sewaDisponsoriSaya as $sewa)
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <span class="font-black text-[#1A202C] text-sm">{{ $sewa->ruko->nama_ruko ?? 'Ruko' }}</span>
                            <p class="text-gray-500 mt-0.5">
                                Penerima Sponsor: <strong class="text-gray-800">{{ $sewa->umkm->nama_usaha ?? 'UMKM Mitra' }}</strong>
                            </p>
                            <p class="text-[11px] text-gray-400 mt-0.5">
                                Periode: {{ $sewa->tanggal_mulai ? $sewa->tanggal_mulai->format('d M Y') : '-' }} s/d {{ $sewa->tanggal_selesai ? $sewa->tanggal_selesai->format('d M Y') : '-' }}
                            </p>
                        </div>
                        <div class="text-right sm:shrink-0">
                            <span class="text-gray-400 text-[10px] block font-bold uppercase">Total Dana Sewa</span>
                            <span class="font-black text-emerald-700 text-sm">Rp {{ number_format($sewa->total_harga, 0, ',', '.') }}</span>
                            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[9px] font-black {{ $sewa->status_pembayaran === 'dibayar' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ strtoupper($sewa->status_pembayaran) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-gray-400">
                        Belum ada ruko yang Anda sponsori. Buka katalog ruko di atas untuk memilih ruko dan UMKM penerima sponsor.
                    </div>
                @endforelse
            </div>
        </div>

    {{-- ========================================================================= --}}
    {{-- TAB 6: KALKULATOR SIMULASI INVESTASI (Fitur 4)                             --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'kalkulator')

        <div class="screen-only space-y-8">
        <!-- PAGE HEADER KALKULATOR -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">KALKULATOR SIMULASI INVESTASI</h1>
                <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                    Bukan sekadar hitungan angka — uji skenario bisnis, pantau jadwal arus kas bulanan, dan temukan proposal UMKM yang langsung cocok dengan simulasi Anda.
                </p>
            </div>

            <button onclick="window.print()" 
                    class="px-4 py-2.5 rounded-2xl bg-white border border-[#E8E6DF] hover:bg-gray-50 text-gray-700 text-xs font-bold transition shadow-sm inline-flex items-center gap-2 self-start sm:self-auto">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak Lembar Proyeksi</span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- PANEL KIRI: PARAMETER INPUT SIMULASI & SKENARIO (7 COLS) -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm space-y-6">
                
                <!-- FITUR TAMBAHAN 1: PILIHAN SKENARIO KINERJA BISNIS -->
                <div class="p-4 rounded-2xl bg-teal-50/70 border border-teal-200/80 space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-[#0F433C] uppercase tracking-wider flex items-center gap-1.5">
                            <span>🎯</span>
                            <span>Uji Skenario Performa Usaha:</span>
                        </span>
                        <span id="label-scenario-badge" class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-[#0F433C] text-white">
                            Realistis (Normal)
                        </span>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" onclick="setScenario('konservatif')" id="btn-scen-konservatif"
                                class="py-2.5 px-2 rounded-xl border border-gray-200 bg-white text-gray-700 text-xs font-bold hover:bg-gray-50 transition text-center flex flex-col items-center">
                            <span>🛡️ Konservatif</span>
                            <span class="text-[10px] font-normal text-gray-500 mt-0.5">Proteksi Pasar Lesu (11%)</span>
                        </button>
                        <button type="button" onclick="setScenario('realistis')" id="btn-scen-realistis"
                                class="py-2.5 px-2 rounded-xl border-2 border-[#0F433C] bg-[#0F433C] text-white text-xs font-black shadow-sm transition text-center flex flex-col items-center">
                            <span>🟢 Realistis</span>
                            <span class="text-[10px] font-normal text-teal-200 mt-0.5">Sesuai Target (15%)</span>
                        </button>
                        <button type="button" onclick="setScenario('optimis')" id="btn-scen-optimis"
                                class="py-2.5 px-2 rounded-xl border border-gray-200 bg-white text-gray-700 text-xs font-bold hover:bg-gray-50 transition text-center flex flex-col items-center">
                            <span>🚀 Optimis</span>
                            <span class="text-[10px] font-normal text-gray-500 mt-0.5">Pertumbuhan Tinggi (20%)</span>
                        </button>
                    </div>
                    <p id="scenario-note" class="text-[11px] text-gray-500 italic">
                        Skenario Realistis: Performa penjualan mitra UMKM berjalan stabil sesuai proyeksi proposal.
                    </p>
                </div>

                <!-- 1. NOMINAL INVESTASI -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-xs font-black text-gray-700 uppercase tracking-wider">Nominal Modal Investasi</label>
                        <span id="label-nominal" class="text-base font-black text-[#0F433C]">Rp 10.000.000</span>
                    </div>
                    <input type="range" id="input-range-nominal" min="1000000" max="100000000" step="500000" value="10000000"
                           class="w-full h-2.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#0F433C]"
                           oninput="onCalcChange()">
                    
                    <div class="flex flex-wrap gap-2 mt-3">
                        <button type="button" onclick="setNominalPreset(5000000)" class="px-3 py-1 rounded-xl text-xs font-bold border border-gray-200 hover:bg-gray-100 text-gray-700 transition">Rp 5 Jt</button>
                        <button type="button" onclick="setNominalPreset(10000000)" class="px-3 py-1 rounded-xl text-xs font-bold border border-[#0F433C] bg-teal-50 text-[#0F433C] transition">Rp 10 Jt</button>
                        <button type="button" onclick="setNominalPreset(25000000)" class="px-3 py-1 rounded-xl text-xs font-bold border border-gray-200 hover:bg-gray-100 text-gray-700 transition">Rp 25 Jt</button>
                        <button type="button" onclick="setNominalPreset(50000000)" class="px-3 py-1 rounded-xl text-xs font-bold border border-gray-200 hover:bg-gray-100 text-gray-700 transition">Rp 50 Jt</button>
                        <button type="button" onclick="setNominalPreset(100000000)" class="px-3 py-1 rounded-xl text-xs font-bold border border-gray-200 hover:bg-gray-100 text-gray-700 transition">Rp 100 Jt</button>
                    </div>
                </div>

                <!-- 2. TARGET BAGI HASIL (% PER TAHUN) -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-xs font-black text-gray-700 uppercase tracking-wider">Target Bagi Hasil (ROI p.a.)</label>
                        <span id="label-persen" class="text-base font-black text-emerald-700">15.0% per tahun</span>
                    </div>
                    <input type="range" id="input-range-persen" min="5" max="35" step="0.5" value="15"
                           class="w-full h-2.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-emerald-600"
                           oninput="onCalcChange()">
                    
                    <div class="flex flex-wrap gap-2 mt-3">
                        <button type="button" onclick="setPersenPreset(12)" class="px-3 py-1 rounded-xl text-xs font-bold border border-gray-200 hover:bg-gray-100 text-gray-700 transition">12%</button>
                        <button type="button" onclick="setPersenPreset(15)" class="px-3 py-1 rounded-xl text-xs font-bold border border-emerald-600 bg-emerald-50 text-emerald-800 transition">15%</button>
                        <button type="button" onclick="setPersenPreset(18)" class="px-3 py-1 rounded-xl text-xs font-bold border border-gray-200 hover:bg-gray-100 text-gray-700 transition">18%</button>
                        <button type="button" onclick="setPersenPreset(20)" class="px-3 py-1 rounded-xl text-xs font-bold border border-gray-200 hover:bg-gray-100 text-gray-700 transition">20%</button>
                    </div>
                </div>

                <!-- 3. TENOR / DURASI KEMITRAAN -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-xs font-black text-gray-700 uppercase tracking-wider">Tenor / Durasi Kemitraan</label>
                        <span id="label-tenor" class="text-base font-black text-[#1A202C]">12 Bulan (1.0 Tahun)</span>
                    </div>
                    <input type="range" id="input-range-tenor" min="3" max="36" step="1" value="12"
                           class="w-full h-2.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#1A202C]"
                           oninput="onCalcChange()">

                    <div class="flex flex-wrap gap-2 mt-3">
                        <button type="button" onclick="setTenorPreset(6)" class="px-3 py-1 rounded-xl text-xs font-bold border border-gray-200 hover:bg-gray-100 text-gray-700 transition">6 Bulan</button>
                        <button type="button" onclick="setTenorPreset(12)" class="px-3 py-1 rounded-xl text-xs font-bold border border-gray-800 bg-gray-100 text-gray-900 transition">12 Bulan</button>
                        <button type="button" onclick="setTenorPreset(24)" class="px-3 py-1 rounded-xl text-xs font-bold border border-gray-200 hover:bg-gray-100 text-gray-700 transition">24 Bulan</button>
                        <button type="button" onclick="setTenorPreset(36)" class="px-3 py-1 rounded-xl text-xs font-bold border border-gray-200 hover:bg-gray-100 text-gray-700 transition">36 Bulan</button>
                    </div>
                </div>

                <!-- 4. FREKUENSI PEMBAGIAN DIVIDEN -->
                <div>
                    <label class="text-xs font-black text-gray-700 uppercase tracking-wider block mb-2">Frekuensi Distribusi Dividen</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        <label class="flex items-center gap-2 p-3 rounded-2xl border border-teal-600 bg-teal-50/50 cursor-pointer text-xs font-bold text-[#0F433C]">
                            <input type="radio" name="freq" value="12" checked onchange="onCalcChange()" class="accent-[#0F433C]">
                            <span>Bulanan (12x)</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 rounded-2xl border border-gray-200 hover:bg-gray-50 cursor-pointer text-xs font-semibold text-gray-700">
                            <input type="radio" name="freq" value="4" onchange="onCalcChange()" class="accent-[#0F433C]">
                            <span>Triwulan (4x)</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 rounded-2xl border border-gray-200 hover:bg-gray-50 cursor-pointer text-xs font-semibold text-gray-700">
                            <input type="radio" name="freq" value="2" onchange="onCalcChange()" class="accent-[#0F433C]">
                            <span>Semesteran (2x)</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 rounded-2xl border border-gray-200 hover:bg-gray-50 cursor-pointer text-xs font-semibold text-gray-700">
                            <input type="radio" name="freq" value="1" onchange="onCalcChange()" class="accent-[#0F433C]">
                            <span>Tahunan (1x)</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- PANEL KANAN: HASIL PROYEKSI (DENGAN BACKGROUND PEKAT & TEKS KONTRAS TINGGI) -->
            <div class="lg:col-span-5 space-y-5">
                <div class="rounded-3xl p-6 sm:p-8 shadow-2xl border border-emerald-900/40"
                     style="background: #0F433C; background: linear-gradient(135deg, #0F433C 0%, #175249 100%) !important; color: #ffffff !important;">
                    <span class="text-[11px] font-black uppercase tracking-wider text-teal-300 block">Hasil Proyeksi Investasi</span>
                    <h3 class="text-2xl font-black mt-1 text-white">Estimasi Imbal Hasil</h3>

                    <div class="mt-6 space-y-4">
                        <!-- Estimasi Dividen Berkala -->
                        <div class="p-4 rounded-2xl bg-black/20 backdrop-blur-sm border border-white/20">
                            <span class="text-xs text-teal-200 block font-semibold">Estimasi Dividen Cair per Periode:</span>
                            <div class="text-3xl font-black mt-0.5" style="color: #F1C40F !important;">
                                <span id="res-dividen-periode">Rp 125.000</span>
                            </div>
                            <span id="res-periode-desc" class="text-[11px] text-teal-100 font-medium mt-1 block">Diterima setiap 1 bulan (Bulanan)</span>
                        </div>

                        <!-- Total Dividen (Net Profit) -->
                        <div class="flex justify-between items-center py-2.5 border-b border-white/15 text-xs">
                            <span class="text-teal-100 font-medium">Total Akumulasi Bagi Hasil:</span>
                            <span id="res-total-dividen" class="font-black text-white text-sm">Rp 1.500.000</span>
                        </div>

                        <!-- Total Pengembalian Modal + Dividen -->
                        <div class="flex justify-between items-center py-2.5 border-b border-white/15 text-xs">
                            <span class="text-teal-100 font-medium">Total Pengembalian Dana:</span>
                            <span id="res-total-pengembalian" class="font-black text-emerald-300 text-base">Rp 11.500.000</span>
                        </div>

                        <!-- Payback Period -->
                        <div class="flex justify-between items-center py-2.5 text-xs">
                            <span class="text-teal-100 font-medium">Estimasi Balik Modal (Payback):</span>
                            <span id="res-payback" class="font-bold text-white">6.7 Tahun (jika murni dividen)</span>
                        </div>
                    </div>

                    <!-- Tombol Aksi Langsung -->
                    <div class="mt-6 space-y-2.5">
                        <a href="#seksi-smart-match" 
                           class="w-full py-3.5 px-4 rounded-2xl font-black text-xs text-center transition shadow-lg flex items-center justify-center gap-2"
                           style="background-color: #F1C40F !important; color: #0F433C !important;">
                            <span>Lihat Proposal Sesuai Simulasi Ini</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                        <button type="button" onclick="toggleCashflowSchedule()"
                                class="w-full py-2.5 px-4 rounded-2xl bg-white/10 hover:bg-white/20 text-teal-100 text-xs font-bold transition flex items-center justify-center gap-1.5 border border-white/15">
                            <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span id="btn-toggle-cashflow-label">Buka Jadwal Arus Kas Dividen &darr;</span>
                        </button>
                    </div>
                </div>

                <!-- KOTAK KOMPARASI INSTRUMEN KEUANGAN -->
                <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm space-y-3.5 text-xs">
                    <h4 class="font-black text-[#1A202C] text-sm flex items-center gap-2">
                        <span>📊</span>
                        <span>Perbandingan Potensi Imbal Hasil</span>
                    </h4>

                    <!-- DAYA UMKM -->
                    <div>
                        <div class="flex justify-between font-bold mb-1">
                            <span class="text-[#0F433C]">DAYA UMKM (Bagi Hasil Sektor Riil)</span>
                            <span class="text-emerald-700 font-black">15% - 20% p.a.</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-gray-100 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full w-[85%]"></div>
                        </div>
                    </div>

                    <!-- Deposito Bank -->
                    <div>
                        <div class="flex justify-between font-bold mb-1 text-gray-500">
                            <span>Deposito Bank Konvensional</span>
                            <span>~3.5% p.a.</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-gray-100 overflow-hidden">
                            <div class="h-full bg-gray-400 rounded-full w-[25%]"></div>
                        </div>
                    </div>

                    <!-- Tabungan Biasa -->
                    <div>
                        <div class="flex justify-between font-bold mb-1 text-gray-500">
                            <span>Tabungan Reguler Bank</span>
                            <span>~0.5% - 1.0% p.a.</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-gray-100 overflow-hidden">
                            <div class="h-full bg-gray-300 rounded-full w-[10%]"></div>
                        </div>
                    </div>

                    <p class="text-[10px] text-gray-400 italic pt-2">
                        *Catatan: Imbal hasil DAYA UMKM berbasis bagi hasil kinerja produktif riil dan bukan bunga perbankan.
                    </p>
                </div>
            </div>

        </div>

        <!-- FITUR TAMBAHAN 2: TABEL JADWAL ARUS KAS DIVIDEN BULANAN (CASHFLOW TIMELINE) -->
        <div id="seksi-cashflow-table" class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-gray-100">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800">
                            Cashflow Timeline
                        </span>
                        <h2 class="text-lg font-black text-[#1A202C]">Jadwal Estimasi Arus Kas Masuk</h2>
                    </div>
                    <p class="text-xs text-gray-500 font-medium mt-0.5">Simulasi penerimaan dividen per periode dan waktu pengembalian dana pokok.</p>
                </div>
                <div class="text-xs font-bold text-gray-400">
                    Tenor: <span id="cf-tenor-badge" class="text-[#0F433C] font-black">12 Periode</span>
                </div>
            </div>

            <div class="overflow-x-auto max-h-80">
                <table class="w-full text-left text-xs">
                    <thead class="sticky top-0 bg-white">
                        <tr class="border-b border-[#E8E6DF] text-gray-400 uppercase tracking-wider text-[10px]">
                            <th class="py-2.5 px-3">Periode</th>
                            <th class="py-2.5 px-3">Dividen Masuk</th>
                            <th class="py-2.5 px-3">Pengembalian Pokok</th>
                            <th class="py-2.5 px-3">Total Kas Masuk</th>
                            <th class="py-2.5 px-3">Akumulasi Kas Diterima</th>
                        </tr>
                    </thead>
                    <tbody id="cashflow-tbody" class="divide-y divide-gray-100 font-medium">
                        <!-- Diisi secara dinamis oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FITUR TAMBAHAN 3: SMART MATCHING PROPOSAL UMKM (ACTIONABLE CTA) -->
        <div id="seksi-smart-match" class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-amber-100 text-amber-800">
                            Smart Matching Engine
                        </span>
                        <h2 class="text-lg font-black text-[#1A202C]">Peluang Proposal UMKM yang Cocok dengan Simulasi Ini</h2>
                    </div>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">
                        Anda dapat langsung mendanai proposal di bawah ini dengan nominal simulasi saat ini (<strong id="sm-match-nominal-label" class="text-[#0F433C]">Rp 10.000.000</strong>).
                    </p>
                </div>
                <a href="{{ route('dashboard', ['tab' => 'proposal']) }}" class="text-xs font-bold text-[#0F433C] hover:underline flex items-center gap-1 self-start sm:self-auto">
                    <span>Buka Seluruh Proposal</span> &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($availableProposals->take(3) as $umkm)
                    <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full bg-teal-50 text-teal-800 border border-teal-200">
                                    {{ $umkm->jenis_usaha }}
                                </span>
                                <span class="text-xs font-black text-emerald-700">
                                    {{ $umkm->persentase_bagi_hasil ?: 15 }}% p.a.
                                </span>
                            </div>

                            <h3 class="text-base font-black text-[#1A202C] truncate">{{ $umkm->nama_usaha }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Pengelola: {{ $umkm->pemilik }} &bull; {{ $umkm->provinsi_kota ?? '-' }}</p>
                            @if($umkm->total_ulasan > 0)
                                <div class="mt-1 flex items-center gap-1.5">
                                    <span class="text-amber-500 font-black text-xs">★ {{ number_format($umkm->rating_rata_rata, 1) }}</span>
                                    <span class="text-gray-400 text-[10px]">({{ $umkm->total_ulasan }} ulasan investor)</span>
                                </div>
                            @endif

                            <div class="mt-4 p-3.5 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] space-y-1.5 text-xs">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400 font-medium text-[11px]">Target Modal Usaha:</span>
                                    <span class="font-extrabold text-[#0F433C]">
                                        Rp {{ number_format($umkm->target_pendanaan ?: ($umkm->modal_dibutuhkan ?: 25000000), 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="text-gray-400 font-medium">Kesesuaian Anggaran:</span>
                                    <span class="font-bold text-emerald-700">✓ Cocok dengan Simulasi</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 pt-3 border-t border-gray-100">
                            <button onclick="openInvestModalWithCalc('{{ $umkm->id_umkm }}', '{{ addslashes($umkm->nama_usaha) }}', '{{ $umkm->persentase_bagi_hasil ?: 15 }}')"
                                    class="w-full py-2.5 px-3 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                </svg>
                                <span>Danai Sekarang (Sesuai Simulasi)</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-8 text-center text-xs text-gray-400 bg-white rounded-3xl border border-[#E8E6DF]">
                        Belum ada proposal UMKM terdaftar yang siap menerima pendanaan saat ini.
                    </div>
                @endforelse
            </div>
        </div>
        </div>

        <!-- CETAK LEMBAR SIMULASI & PROYEKSI INVESTASI (LAYOUT INVOICE BERSIH KHUSUS CETAK) -->
        <div class="print-only font-sans text-gray-900 bg-white">
            <!-- HEADER / KOP LEMBAR SIMULASI -->
            <div class="border-b-2 border-gray-900 pb-4 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-black tracking-tight text-gray-900 uppercase">TIKUM &bull; DAYA UMKM</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">Simulasi Proyeksi Portofolio & Arus Kas Kemitraan Sektor Riil UMKM</p>
                        <p class="text-[11px] text-gray-500">Universitas Maria Kudus &bull; Gondangmanis, Bae, Kudus, Jawa Tengah</p>
                        <p class="text-[11px] text-gray-500">Email: halo@dayaumkm.id | Website: dayaumkm.id</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-3 py-1 bg-gray-100 border border-gray-300 text-gray-800 text-[11px] font-black uppercase tracking-wider rounded mb-1.5">
                            Lembar Proyeksi Investasi
                        </span>
                        <div class="text-xs text-gray-600 mt-1">
                            <span class="font-bold">No. Simulasi:</span> <span class="font-mono">SIM-PROJ/{{ date('Ymd') }}/{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="text-xs text-gray-600">
                            <span class="font-bold">Tanggal Cetak:</span> {{ now()->translatedFormat('d F Y, H:i') }} WIB
                        </div>
                        <div class="text-xs text-gray-600">
                            <span class="font-bold">Pemohon Simulasi:</span> <span class="font-bold text-gray-900">{{ $user->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DETAIL PARAMETER INPUT SIMULASI & HASIL (2 BOX / 2 KOLOM BERSIH) -->
            <div class="grid grid-cols-2 gap-6 mb-6 text-xs">
                <!-- PARAMETER INPUT -->
                <div class="border border-gray-300 rounded p-4 bg-gray-50/50">
                    <span class="block text-[10px] font-black uppercase tracking-wider text-gray-500 mb-2 border-b border-gray-200 pb-1">
                        Parameter Input Simulasi
                    </span>
                    <table class="w-full">
                        <tr class="py-1">
                            <td class="text-gray-600 w-36 py-1 font-medium">Skenario Performa</td>
                            <td class="font-bold text-gray-900 py-1">: <span id="print-calc-scenario">Realistis (Normal)</span></td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-1 font-medium">Nominal Modal Investasi</td>
                            <td class="font-bold text-gray-900 py-1 font-mono">: <span id="print-calc-nominal">Rp 10.000.000</span></td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-1 font-medium">Target Bagi Hasil (ROI p.a.)</td>
                            <td class="font-bold text-gray-900 py-1">: <span id="print-calc-roi">15.0% per tahun</span></td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-1 font-medium">Tenor / Durasi Kemitraan</td>
                            <td class="py-1">: <span id="print-calc-tenor">12 Bulan (1.0 Tahun)</span></td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-1 font-medium">Frekuensi Distribusi</td>
                            <td class="py-1">: <span id="print-calc-freq">Bulanan (12x per tahun)</span></td>
                        </tr>
                    </table>
                </div>

                <!-- ESTIMASI HASIL IMBAL HASIL -->
                <div class="border border-gray-300 rounded p-4 bg-gray-50/50">
                    <span class="block text-[10px] font-black uppercase tracking-wider text-gray-500 mb-2 border-b border-gray-200 pb-1">
                        Estimasi Ringkasan Proyeksi
                    </span>
                    <table class="w-full">
                        <tr class="py-1">
                            <td class="text-gray-600 w-40 py-1 font-medium">Estimasi Dividen per Periode</td>
                            <td class="font-bold text-gray-900 py-1 font-mono">: <span id="print-calc-dividen-periode">Rp 125.000</span></td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-1 font-medium">Total Akumulasi Dividen</td>
                            <td class="font-bold text-gray-900 py-1 font-mono">: <span id="print-calc-total-dividen">Rp 1.500.000</span></td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-1 font-medium">Total Pengembalian Dana</td>
                            <td class="font-bold text-gray-900 py-1 font-mono">: <span id="print-calc-total-pengembalian">Rp 11.500.000</span></td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-1 font-medium">Estimasi Balik Modal</td>
                            <td class="py-1">: <span id="print-calc-payback">6.7 Tahun (jika murni dividen)</span></td>
                        </tr>
                        <tr class="py-1">
                            <td class="text-gray-600 py-1 font-medium">Metode Pelunasan Pokok</td>
                            <td class="py-1 text-gray-700">: Bullet Payment (Akhir Tenor)</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- TABEL JADWAL ESTIMASI ARUS KAS MASUK (CASHFLOW TIMELINE) -->
            <div class="mb-6 page-break-avoid">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-black uppercase tracking-wider text-gray-500">
                        Jadwal Estimasi Arus Kas Dividen & Pengembalian Modal
                    </span>
                    <span class="text-[10px] text-gray-400 italic">Disimulasikan berdasarkan parameter terpilih</span>
                </div>
                <table class="w-full border-collapse border border-gray-300 text-xs">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-[10px] tracking-wider border-b border-gray-300">
                            <th class="border border-gray-300 py-2 px-2.5 text-center w-12">Periode</th>
                            <th class="border border-gray-300 py-2 px-3 text-left">Waktu Jatuh Tempo</th>
                            <th class="border border-gray-300 py-2 px-3 text-right">Dividen Masuk</th>
                            <th class="border border-gray-300 py-2 px-3 text-right">Pengembalian Pokok</th>
                            <th class="border border-gray-300 py-2 px-3 text-right">Total Kas Masuk</th>
                            <th class="border border-gray-300 py-2 px-3 text-right">Akumulasi Kas Diterima</th>
                        </tr>
                    </thead>
                    <tbody id="print-cashflow-tbody" class="divide-y divide-gray-200 font-mono">
                        <!-- Diisi otomatis oleh JavaScript onCalcChange() -->
                    </tbody>
                </table>
            </div>

            <!-- FOOTER, PERNYATAAN PENYANGKALAN (DISCLAIMER) & TANDA TANGAN -->
            <div class="grid grid-cols-12 gap-6 pt-4 border-t border-gray-300 page-break-avoid text-xs">
                <div class="col-span-8 text-gray-600 space-y-1">
                    <span class="font-bold text-gray-800 block text-[11px] uppercase tracking-wider">Penyangkalan Finansial (Disclaimer):</span>
                    <p class="text-[10px] leading-relaxed">
                        1. Lembar simulasi ini bersifat estimasi proyeksi ilustratif berdasarkan parameter skenario yang dipilih oleh investor pada tanggal simulasi.
                    </p>
                    <p class="text-[10px] leading-relaxed">
                        2. Kemitraan modal pada DAYA UMKM menggunakan akad syirkah/bagi hasil sektor riil non-bunga. Realisasi dividen mengikuti performa riil laba kotor/bersih usaha mitra UMKM.
                    </p>
                    <p class="text-[10px] leading-relaxed">
                        3. Lembar proyeksi ini bukan merupakan surat perjanjian investasi definitif (MoU/Akad) dan tidak menjamin kepastian imbal hasil tetap (fixed return).
                    </p>
                </div>
                <div class="col-span-4 text-center">
                    <p class="text-[11px] text-gray-600">Kudus, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="text-xs font-bold text-gray-900 mt-0.5">Sistem Simulasi TIKUM</p>
                    <div class="my-3 py-2 border border-dashed border-gray-400 rounded inline-block px-4">
                        <span class="text-[10px] font-mono uppercase tracking-widest text-gray-500 block">SIMULATION REF</span>
                        <span class="text-[9px] text-gray-400 block font-mono">{{ md5('TIKUM-SIM-'.$user->id) }}</span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-700">Platform DAYA UMKM</p>
                    <p class="text-[9px] text-gray-400">Universitas Maria Kudus</p>
                </div>
            </div>
        </div>

    {{-- ========================================================================= --}}
    {{-- TAB 7: SPONSOR INFLUENCER & AKSELERASI PROMOSI                            --}}
    {{-- ========================================================================= --}}
    @elseif(($activeTab ?? '') === 'influencer')
        @include('dashboard.partials.investor-influencer-tab')

    @endif

</div>

{{-- ========================================================================= --}}
{{-- MODALS SEMUA FITUR (Bank, Sponsor Ruko, Rekomendasi Ruko, Struk, Invest)   --}}
{{-- ========================================================================= --}}

<!-- MODAL 1: PENGATURAN REKENING BANK INVESTOR (Fitur 3) -->
<div id="bank-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-2xl bg-teal-100 text-[#0F433C] flex items-center justify-center text-xl font-black shrink-0">
                🏦
            </div>
            <div>
                <h3 class="text-lg font-black text-[#1A202C]">Pengaturan Rekening Bank</h3>
                <p class="text-xs text-gray-500">Tujuan pencairan otomatis dividen bagi hasil Anda</p>
            </div>
        </div>

        <form action="{{ route('dashboard.investor.bank') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Bank *</label>
                <select name="bank_name" required class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                    <option value="BCA" {{ ($user->bank_name ?? '') === 'BCA' ? 'selected' : '' }}>Bank Central Asia (BCA)</option>
                    <option value="Bank Mandiri" {{ ($user->bank_name ?? '') === 'Bank Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                    <option value="BRI" {{ ($user->bank_name ?? '') === 'BRI' ? 'selected' : '' }}>Bank Rakyat Indonesia (BRI)</option>
                    <option value="BNI" {{ ($user->bank_name ?? '') === 'BNI' ? 'selected' : '' }}>Bank Negara Indonesia (BNI)</option>
                    <option value="BSI" {{ ($user->bank_name ?? '') === 'BSI' ? 'selected' : '' }}>Bank Syariah Indonesia (BSI)</option>
                    <option value="CIMB Niaga" {{ ($user->bank_name ?? '') === 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                    <option value="Permata Bank" {{ ($user->bank_name ?? '') === 'Permata Bank' ? 'selected' : '' }}>Permata Bank</option>
                    <option value="Bank Jago" {{ ($user->bank_name ?? '') === 'Bank Jago' ? 'selected' : '' }}>Bank Jago</option>
                    <option value="Bank Lainnya" {{ !in_array($user->bank_name ?? '', ['BCA', 'Bank Mandiri', 'BRI', 'BNI', 'BSI', 'CIMB Niaga', 'Permata Bank', 'Bank Jago', '']) ? 'selected' : '' }}>Bank Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nomor Rekening *</label>
                <input type="text" name="nomor_rekening" required value="{{ $user->nomor_rekening ?? '' }}" placeholder="Contoh: 8271928374"
                       class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-mono font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Pemilik Rekening *</label>
                <input type="text" name="nama_pemilik_rekening" required value="{{ $user->nama_pemilik_rekening ?? ($user->name ?? '') }}" placeholder="Sesuai nama di buku tabungan"
                       class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                <span class="text-[10px] text-gray-400 mt-1 block">Pastikan nama pemilik rekening sama dengan nama akun Anda untuk kelancaran verifikasi.</span>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3">
                <button type="button" onclick="closeBankModal()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm">
                    Simpan Rekening
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2: SPONSOR SEWA RUKO UNTUK UMKM (Fitur 2) -->
<div id="sponsor-ruko-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-2xl bg-teal-100 text-[#0F433C] flex items-center justify-center text-xl font-black shrink-0">
                🏢
            </div>
            <div>
                <h3 class="text-lg font-black text-[#1A202C]">Sponsori Sewa Ruko Komersial</h3>
                <p class="text-xs text-gray-500">Mendanai gerai fisik untuk UMKM mitra di ruko pilihan</p>
            </div>
        </div>

        <!-- Info Ruko Dipilih -->
        <div class="p-3.5 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] mb-4 text-xs">
            <div class="font-black text-[#0F433C] text-sm" id="sponsor-modal-nama-ruko">Nama Ruko</div>
            <div class="text-gray-500 text-[11px]" id="sponsor-modal-lokasi-ruko">Lokasi Ruko</div>
            <div class="mt-2 text-[11px] font-bold text-gray-700">
                Tarif Bulanan: <span id="sponsor-modal-tarif" class="text-emerald-700 font-black">Rp 0 / bln</span>
            </div>
        </div>

        <form id="form-sponsor-ruko" action="" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Pilih Mitra UMKM Penerima Sponsor *</label>
                <select name="id_umkm" required class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                    <option value="">-- Pilih Usaha UMKM Mitra --</option>
                    @foreach($mitraUmkmTersedia as $umk)
                        <option value="{{ $umk->id_umkm }}">
                            {{ $umk->nama_usaha }} ({{ $umk->jenis_usaha }} - {{ $umk->pemilik }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Durasi Sponsor Sewa *</label>
                <select id="sponsor-durasi-select" name="durasi_bulan" onchange="updateSponsorTotal()" class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                    <option value="3">3 Bulan</option>
                    <option value="6" selected>6 Bulan (Rekomendasi Awal)</option>
                    <option value="12">12 Bulan (1 Tahun)</option>
                    <option value="24">24 Bulan (2 Tahun)</option>
                </select>
            </div>

            <!-- Total Biaya Sponsor Terkalkulasi -->
            <div class="p-4 rounded-2xl bg-teal-50 border border-teal-200 flex justify-between items-center text-xs">
                <span class="font-bold text-teal-900">Total Komitmen Sponsor:</span>
                <span id="sponsor-modal-total-harga" class="text-base font-black text-[#0F433C]">Rp 0</span>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Pesan / Syarat Kemitraan (Opsional)</label>
                <textarea name="catatan_sponsor" rows="2" placeholder="Contoh: Sponsor dana sewa ruko ini diberikan dengan skema bagi hasil omzet offline 10%."
                          class="w-full p-3 rounded-2xl border border-[#E8E6DF] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3">
                <button type="button" onclick="closeSponsorRukoModal()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm">
                    Kirim Komitmen Sponsor
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 3: AJUKAN REKOMENDASI RUKO STRATEGIS BARU (Fitur 2) -->
<div id="rekomendasi-ruko-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-xl font-black shrink-0">
                📍
            </div>
            <div>
                <h3 class="text-lg font-black text-[#1A202C]">Ajukan Rekomendasi Ruko Baru</h3>
                <p class="text-xs text-gray-500">Usulkan lokasi ruko potensial di kota Anda ke tim DAYA UMKM</p>
            </div>
        </div>

        <form action="{{ route('dashboard.investor.ruko.rekomendasi') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Ruko / Kawasan *</label>
                <input type="text" name="nama_ruko" required placeholder="Contoh: Ruko Boulevard Gading Serpong No. 12"
                       class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat Lengkap & Kota *</label>
                <textarea name="lokasi" required rows="2" placeholder="Contoh: Jl. Boulevard Raya No. 12, Curug Sangereng, Kelapa Dua, Kab. Tangerang, Banten"
                          class="w-full p-3 rounded-2xl border border-[#E8E6DF] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
            </div>

            <!-- FOTO RUKO -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Foto Ruko / Tampak Depan</label>
                <input type="file" name="foto_ruko" accept="image/*"
                       class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0F433C] file:text-white cursor-pointer">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Harga Sewa / Bulan (Rp) *</label>
                    <input type="number" name="harga_sewa_per_bulan" required min="100000" step="100000" placeholder="5000000"
                           class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Jumlah Unit *</label>
                    <input type="number" name="total_unit" value="1" required min="1" max="50"
                           class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Kontak Pemilik / Agen (HP/WA)</label>
                <input type="text" name="kontak_pemilik" placeholder="081234567890"
                       class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Potensi Usaha & Target Pasar</label>
                <textarea name="potensi_usaha" rows="2" placeholder="Contoh: Sangat ramai mahasiswa dan pekerja, dekat kampus UMN, cocok untuk gerai kuliner / cafe / bakery."
                          class="w-full p-3 rounded-2xl border border-[#E8E6DF] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
            </div>

            <div class="p-3 bg-teal-50 rounded-2xl border border-teal-200">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-teal-950">
                    <input type="checkbox" name="siap_danai" value="1" checked class="w-4 h-4 rounded text-[#0F433C] focus:ring-[#0F433C]">
                    <span>Saya bersedia mendanai sewa ruko ini jika ada UMKM binaan yang cocok</span>
                </label>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <button type="button" onclick="closeRekomendasiRukoModal()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm">
                    Kirim Rekomendasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 4: LIHAT STRUK / BUKTI TRANSFER DIVIDEN -->
<div id="struk-modal" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 animate-scale-up">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <div>
                <h3 class="text-base font-black text-[#1A202C]">Struk / Bukti Transfer Dividen</h3>
                <p id="struk-modal-mitra" class="text-xs text-gray-500 font-medium"></p>
            </div>
            <button onclick="closeStrukModal()" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition">
                ✕
            </button>
        </div>

        <div class="w-full max-h-96 min-h-[160px] rounded-2xl overflow-hidden bg-gray-50 flex items-center justify-center mb-4 border border-[#E8E6DF] relative">
            <img id="struk-modal-img" src="" alt="Bukti Transfer" class="w-full max-h-96 object-contain">
        </div>

        <div class="flex justify-between items-center text-xs">
            <div>
                <span class="text-gray-500">Nominal Dividen:</span>
                <span id="struk-modal-nominal" class="text-base font-black text-emerald-700 ml-1"></span>
            </div>
            <a id="struk-modal-link" href="#" target="_blank" class="px-2.5 py-1 rounded-lg bg-teal-50 text-[#0F433C] text-[11px] font-bold hover:bg-teal-100 transition inline-flex items-center gap-1">
                <span>Buka Gambar Asli</span>
                <span>↗</span>
            </a>
        </div>

        <div class="mt-4 pt-3 border-t border-gray-100">
            <button type="button" onclick="closeStrukModal()" class="w-full py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- MODAL 5: MODAL PENGAJUAN MINAT INVESTASI (Fitur Kunci) -->
<div id="invest-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center font-black text-xl shrink-0">
                💰
            </div>
            <div>
                <h3 class="text-lg sm:text-xl font-black text-[#1A202C]">Ajukan Minat Investasi</h3>
                <p class="text-xs text-gray-500">Mendanai usaha <span id="invest-modal-nama-usaha" class="font-bold text-[#0F433C]"></span></p>
            </div>
        </div>

        <div class="mb-4 p-3 bg-emerald-50 rounded-2xl border border-emerald-200 text-xs text-emerald-900 flex items-center gap-2.5">
            <span class="text-xl">👥</span>
            <div>
                <strong class="font-bold block">Skema Sindikasi Pendanaan (Co-Investment)</strong>
                <span class="text-[11px] text-emerald-800">Anda dapat mendanai sebagian slot sesuai kesiapan modal Anda (mulai dari Rp 500.000) dan bergabung bersama investor lain hingga target terpenuhi.</span>
            </div>
        </div>

        <p class="text-xs text-gray-600 mb-5 bg-amber-50 p-3 rounded-2xl border border-amber-200">
            Setelah Anda mengirim formulir ini, <strong>Pelaku UMKM akan langsung menerima notifikasi resmi di dashboard mereka</strong> beserta kontak Anda untuk memulai koordinasi pendanaan dan penandatanganan akad.
        </p>

        <form id="form-invest-proposal" action="" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nominal Komitmen Modal (Rp) *</label>
                <input type="number" id="invest-modal-nominal" name="jumlah_modal" required min="500000" step="50000"
                       class="w-full px-4 py-3 rounded-2xl border border-[#E8E6DF] text-sm font-bold text-[#0F433C] focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                <span class="text-[10px] text-gray-400 mt-1 block">Minimal investasi Rp 500.000</span>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Periode Pembagian</label>
                    <select name="periode_pembagian" class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                        <option value="Bulanan">Setiap Bulan</option>
                        <option value="Triwulan">Setiap 3 Bulan (Triwulan)</option>
                        <option value="Semesteran">Setiap 6 Bulan (Semesteran)</option>
                        <option value="Tahunan">Tahunan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Bagi Hasil (%)</label>
                    <input type="number" id="invest-modal-persen" name="persentase_bagi_hasil" min="1" max="99" step="0.5"
                           class="w-full px-4 py-2.5 rounded-2xl border border-[#E8E6DF] text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Pesan / Catatan untuk Pelaku UMKM</label>
                <textarea name="catatan" rows="3" placeholder="Contoh: Halo, saya tertarik dengan prospek produk Anda. Kapan kita bisa mendiskusikan rencana penggunaan modal dan pencairan?"
                          class="w-full p-3 rounded-2xl border border-[#E8E6DF] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3">
                <button type="button" onclick="closeInvestModal()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm">
                    Kirim Minat Investasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 6: BERI ULASAN & RATING KREDIBILITAS UMKM OLEH INVESTOR -->
<div id="modal-review-investor" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-xl font-black shrink-0">
                    ⭐
                </div>
                <div>
                    <h3 class="text-lg font-black text-[#1A202C]">Beri Ulasan Mitra UMKM</h3>
                    <p class="text-xs text-gray-500">Kemitraan Usaha: <span id="review-modal-mitra-nama" class="font-bold text-[#0F433C]"></span></p>
                </div>
            </div>
            <button onclick="closeModalReview()" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition">✕</button>
        </div>

        <!-- Banner Privasi & Kredibilitas -->
        <div class="p-3 bg-teal-50 rounded-2xl border border-teal-200 text-xs text-teal-950 mb-4 flex items-start gap-2">
            <span class="text-base">🔒</span>
            <p class="leading-relaxed">
                <strong>Privasi Terlindungi:</strong> Identitas nama Anda akan disensor secara otomatis (contoh: <em>{{ substr(Auth::user()->name ?? 'Investor', 0, 1) }}***</em>) dengan lencana <strong>Investor Terverifikasi</strong> demi kebebasan berpendapat yang objektif.
            </p>
        </div>

        <form id="form-review-investor" action="" method="POST" class="space-y-4">
            @csrf
            
            <!-- Overall Star Rating (1 - 5) -->
            <div class="p-4 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] text-center space-y-2">
                <label class="block text-xs font-black text-gray-800 uppercase tracking-wider">
                    Rating Keseluruhan Kemitraan *
                </label>
                <input type="hidden" id="input-review-rating" name="rating" value="5" required>
                
                <div class="flex justify-center items-center gap-2 py-1">
                    @for($s = 1; $s <= 5; $s++)
                        <button type="button" 
                                onclick="setStarRating({{ $s }})" 
                                id="star-btn-{{ $s }}"
                                class="p-1 text-amber-400 hover:scale-125 transition-transform focus:outline-none">
                            <svg class="w-8 h-8 fill-current transition-colors" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </button>
                    @endfor
                </div>
                <div id="star-rating-label" class="text-xs font-extrabold text-amber-900">
                    5 / 5 - Sangat Memuaskan & Direkomendasikan
                </div>
            </div>

            <!-- Sub Rating 1: Transparansi Finansial -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="p-3.5 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF]">
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                        Transparansi Laporan Finansial
                    </label>
                    <select id="input-review-transparansi" name="rating_transparansi" class="w-full px-3 py-2 rounded-xl border border-[#E8E6DF] text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                        <option value="5">⭐⭐⭐⭐⭐ (Sangat Transparan)</option>
                        <option value="4">⭐⭐⭐⭐ (Transparan & Rapi)</option>
                        <option value="3">⭐⭐⭐ (Cukup Terbuka)</option>
                        <option value="2">⭐⭐ (Kurang Terbuka)</option>
                        <option value="1">⭐ (Tidak Transparan)</option>
                    </select>
                </div>

                <!-- Sub Rating 2: Ketepatan Pembagian Dividen -->
                <div class="p-3.5 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF]">
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                        Ketepatan Dividen Bagi Hasil
                    </label>
                    <select id="input-review-dividen" name="rating_dividen" class="w-full px-3 py-2 rounded-xl border border-[#E8E6DF] text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                        <option value="5">⭐⭐⭐⭐⭐ (Sangat Tepat Waktu)</option>
                        <option value="4">⭐⭐⭐⭐ (Tepat Waktu)</option>
                        <option value="3">⭐⭐⭐ (Cukup Tepat)</option>
                        <option value="2">⭐⭐ (Sering Terlambat)</option>
                        <option value="1">⭐ (Tidak Sesuai Akad)</option>
                    </select>
                </div>
            </div>

            <!-- Testimoni / Pengalaman Tertulis -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                    Pengalaman & Testimoni Anda (Wajib) *
                </label>
                <textarea id="input-review-text" name="ulasan" rows="4" required minlength="5" maxlength="1000"
                          placeholder="Ceritakan pengalaman Anda bermitra dengan UMKM ini, seperti keteraturan pelaporan keuangan, etika komunikasi pengelola, dan kelancaran pembayaran dividen..."
                          class="w-full p-3.5 rounded-2xl border border-[#E8E6DF] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
                <div class="flex justify-between items-center text-[10px] text-gray-400 mt-1">
                    <span>Minimal 5 karakter, maksimal 1.000 karakter</span>
                    <span>Tersimpan & Tayang di Publik</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <button type="button" onclick="closeModalReview()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm">
                    Simpan Ulasan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 7: DAFTAR ULASAN INVESTOR TERVERIFIKASI PADA PROPOSAL UMKM -->
<div id="modal-reviews-list" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up max-h-[85vh] flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xl">⭐</span>
                        <h3 class="text-lg font-black text-[#1A202C]" id="reviews-list-modal-nama-usaha">Ulasan Mitra UMKM</h3>
                    </div>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Rating Kredibilitas: <strong id="reviews-list-modal-score" class="text-amber-600 font-black"></strong> &bull; <span id="reviews-list-modal-count" class="text-gray-500"></span>
                    </p>
                </div>
                <button onclick="closeReviewsModal()" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition">✕</button>
            </div>

            <!-- Kontainer Scroll Ulasan -->
            <div id="reviews-modal-body" class="overflow-y-auto max-h-[50vh] pr-1 space-y-3">
                <!-- Diisi via JavaScript dari template proposal terkait -->
            </div>
        </div>

        <div class="mt-5 pt-3 border-t border-gray-100">
            <button type="button" onclick="closeReviewsModal()" class="w-full py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold transition">
                Tutup Jendela Ulasan
            </button>
        </div>
    </div>
</div>

<script>
    // -------------------------------------------------------------
    // MODAL BERI ULASAN KREDIBILITAS UMKM OLEH INVESTOR
    // -------------------------------------------------------------
    const ratingLabels = {
        1: '1 / 5 - Kurang Memuaskan & Perlu Perbaikan Komitmen',
        2: '2 / 5 - Di Bawah Ekspektasi Akad',
        3: '3 / 5 - Cukup Baik / Sesuai Standar',
        4: '4 / 5 - Bagus & Transparan',
        5: '5 / 5 - Sangat Memuaskan & Direkomendasikan'
    };

    function setStarRating(score) {
        score = parseInt(score) || 5;
        document.getElementById('input-review-rating').value = score;
        for (let i = 1; i <= 5; i++) {
            const btn = document.getElementById('star-btn-' + i);
            if (btn) {
                if (i <= score) {
                    btn.classList.add('text-amber-400');
                    btn.classList.remove('text-gray-300');
                } else {
                    btn.classList.remove('text-amber-400');
                    btn.classList.add('text-gray-300');
                }
            }
        }
        const lbl = document.getElementById('star-rating-label');
        if (lbl) {
            lbl.innerText = ratingLabels[score] || (score + ' / 5');
        }
    }

    function openModalReview(idInvestasi, namaMitra, initialRating, ratingTransparansi, ratingDividen, initialReview) {
        document.getElementById('review-modal-mitra-nama').innerText = namaMitra;
        document.getElementById('form-review-investor').action = '/dashboard/investor/ulasan/' + idInvestasi;
        setStarRating(initialRating || 5);
        document.getElementById('input-review-transparansi').value = ratingTransparansi || 5;
        document.getElementById('input-review-dividen').value = ratingDividen || 5;
        document.getElementById('input-review-text').value = initialReview || '';
        document.getElementById('modal-review-investor').classList.remove('hidden');
    }

    function closeModalReview() {
        document.getElementById('modal-review-investor').classList.add('hidden');
    }

    // -------------------------------------------------------------
    // MODAL DAFTAR ULASAN PROPOSAL UMKM (INSPEKSI INVESTOR)
    // -------------------------------------------------------------
    function openReviewsModal(idUmkm, namaUsaha, avgRating, totalReviews) {
        document.getElementById('reviews-list-modal-nama-usaha').innerText = 'Ulasan ' + namaUsaha;
        document.getElementById('reviews-list-modal-score').innerText = '★ ' + avgRating + ' / 5.0';
        document.getElementById('reviews-list-modal-count').innerText = totalReviews + ' Ulasan Investor Terverifikasi';
        
        const tmpl = document.getElementById('reviews-tmpl-' + idUmkm);
        const container = document.getElementById('reviews-modal-body');
        if (tmpl && container) {
            container.innerHTML = tmpl.innerHTML;
        } else if (container) {
            container.innerHTML = '<div class="p-6 text-center text-xs text-gray-400">Belum ada ulasan untuk proposal ini.</div>';
        }
        document.getElementById('modal-reviews-list').classList.remove('hidden');
    }

    function closeReviewsModal() {
        document.getElementById('modal-reviews-list').classList.add('hidden');
    }

    // -------------------------------------------------------------
    // MODAL INVESTASI PROPOSAL
    // -------------------------------------------------------------
    function openInvestModal(idUmkm, namaUsaha, target, persen) {
        document.getElementById('invest-modal-nama-usaha').innerText = namaUsaha;
        document.getElementById('invest-modal-nominal').value = target ? Math.min(target, 10000000) : 5000000;
        document.getElementById('invest-modal-persen').value = persen ? persen : 15;
        document.getElementById('form-invest-proposal').action = '/dashboard/investor/invest/' + idUmkm;
        document.getElementById('invest-modal').classList.remove('hidden');
    }
    function closeInvestModal() {
        document.getElementById('invest-modal').classList.add('hidden');
    }

    // -------------------------------------------------------------
    // MODAL REKENING BANK (Fitur 3)
    // -------------------------------------------------------------
    function openBankModal() {
        document.getElementById('bank-modal').classList.remove('hidden');
    }
    function closeBankModal() {
        document.getElementById('bank-modal').classList.add('hidden');
    }

    // -------------------------------------------------------------
    // MODAL REKOMENDASI RUKO (Fitur 2)
    // -------------------------------------------------------------
    function openRekomendasiRukoModal() {
        document.getElementById('rekomendasi-ruko-modal').classList.remove('hidden');
    }
    function closeRekomendasiRukoModal() {
        document.getElementById('rekomendasi-ruko-modal').classList.add('hidden');
    }

    // -------------------------------------------------------------
    // MODAL SPONSOR SEWA RUKO (Fitur 2)
    // -------------------------------------------------------------
    let currentRukoMonthlyPrice = 0;
    function openSponsorRukoModal(idRuko, namaRuko, hargaBulanan, lokasi) {
        currentRukoMonthlyPrice = parseFloat(hargaBulanan) || 0;
        document.getElementById('sponsor-modal-nama-ruko').innerText = namaRuko;
        document.getElementById('sponsor-modal-lokasi-ruko').innerText = lokasi;
        document.getElementById('sponsor-modal-tarif').innerText = 'Rp ' + Number(currentRukoMonthlyPrice).toLocaleString('id-ID') + ' / bln';
        document.getElementById('form-sponsor-ruko').action = '/dashboard/investor/sponsor-ruko/' + idRuko;
        updateSponsorTotal();
        document.getElementById('sponsor-ruko-modal').classList.remove('hidden');
    }
    function updateSponsorTotal() {
        const durasi = parseInt(document.getElementById('sponsor-durasi-select').value) || 1;
        const total = currentRukoMonthlyPrice * durasi;
        document.getElementById('sponsor-modal-total-harga').innerText = 'Rp ' + Number(total).toLocaleString('id-ID');
    }
    function closeSponsorRukoModal() {
        document.getElementById('sponsor-ruko-modal').classList.add('hidden');
    }

    // -------------------------------------------------------------
    // MODAL PREVIEW STRUK DIVIDEN (Fitur 1)
    // -------------------------------------------------------------
    function previewStruk(imageSrc, mitraNama, nominalStr) {
        if (imageSrc) {
            imageSrc = imageSrc.replace('/storage//uploads/', '/uploads/').replace('/storage/uploads/', '/uploads/');
        }
        const imgEl = document.getElementById('struk-modal-img');
        if (imgEl) {
            imgEl.src = imageSrc;
            imgEl.onerror = function() {
                if (this.src && this.src.includes('/storage/uploads/')) {
                    this.src = this.src.replace('/storage/uploads/', '/uploads/');
                } else if (this.src && this.src.includes('/storage//uploads/')) {
                    this.src = this.src.replace('/storage//uploads/', '/uploads/');
                }
            };
        }
        const linkEl = document.getElementById('struk-modal-link');
        if (linkEl) {
            linkEl.href = imageSrc;
        }
        document.getElementById('struk-modal-mitra').innerText = 'Penyetoran dari ' + mitraNama;
        document.getElementById('struk-modal-nominal').innerText = 'Rp ' + nominalStr;
        document.getElementById('struk-modal').classList.remove('hidden');
    }
    function closeStrukModal() {
        document.getElementById('struk-modal').classList.add('hidden');
    }

    // -------------------------------------------------------------
    // KALKULATOR SIMULASI INVESTASI (Fitur 4)
    // -------------------------------------------------------------
    function setScenario(type) {
        const btnKon = document.getElementById('btn-scen-konservatif');
        const btnReal = document.getElementById('btn-scen-realistis');
        const btnOpt = document.getElementById('btn-scen-optimis');
        const badge = document.getElementById('label-scenario-badge');
        const note = document.getElementById('scenario-note');

        const activeClass = 'py-2.5 px-2 rounded-xl border-2 border-[#0F433C] bg-[#0F433C] text-white text-xs font-black shadow-sm transition text-center flex flex-col items-center';
        const inactiveClass = 'py-2.5 px-2 rounded-xl border border-gray-200 bg-white text-gray-700 text-xs font-bold hover:bg-gray-50 transition text-center flex flex-col items-center';

        if (btnKon) btnKon.className = (type === 'konservatif') ? activeClass : inactiveClass;
        if (btnReal) btnReal.className = (type === 'realistis') ? activeClass : inactiveClass;
        if (btnOpt) btnOpt.className = (type === 'optimis') ? activeClass : inactiveClass;

        if (type === 'konservatif') {
            setPersenPreset(11);
            if (badge) {
                badge.innerText = 'Konservatif (Pasar Lesu)';
                badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-600 text-white';
            }
            if (note) note.innerText = 'Skenario Konservatif: Asumsi pertumbuhan omzet UMKM melambat 20-30%, dividen tetap terjaga pada batas aman minimum.';
        } else if (type === 'optimis') {
            setPersenPreset(20);
            if (badge) {
                badge.innerText = 'Optimis (Ekspansi Cepat)';
                badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-600 text-white';
            }
            if (note) note.innerText = 'Skenario Optimis: UMKM membuka cabang/menu baru dan membukukan lonjakan penjualan di atas rata-rata.';
        } else {
            setPersenPreset(15);
            if (badge) {
                badge.innerText = 'Realistis (Normal)';
                badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-black bg-[#0F433C] text-white';
            }
            if (note) note.innerText = 'Skenario Realistis: Performa penjualan mitra UMKM berjalan stabil sesuai proyeksi proposal rencana bisnis.';
        }
    }

    function onCalcChange() {
        const nominalInput = document.getElementById('input-range-nominal');
        const persenInput = document.getElementById('input-range-persen');
        const tenorInput = document.getElementById('input-range-tenor');

        if (!nominalInput || !persenInput || !tenorInput) return;

        const nominal = parseFloat(nominalInput.value) || 0;
        const persen = parseFloat(persenInput.value) || 0;
        const tenor = parseInt(tenorInput.value) || 12;

        const freqRadio = document.querySelector('input[name="freq"]:checked');
        const freqPerYear = freqRadio ? parseInt(freqRadio.value) : 12;

        // Update labels
        document.getElementById('label-nominal').innerText = 'Rp ' + Number(nominal).toLocaleString('id-ID');
        document.getElementById('label-persen').innerText = persen.toFixed(1) + '% per tahun';
        document.getElementById('label-tenor').innerText = tenor + ' Bulan (' + (tenor / 12).toFixed(1) + ' Tahun)';

        const smNominal = document.getElementById('sm-match-nominal-label');
        if (smNominal) smNominal.innerText = 'Rp ' + Number(nominal).toLocaleString('id-ID');

        // Total bagi hasil selama tenor: Nominal * (persen/100) * (tenor/12)
        const totalBagiHasil = nominal * (persen / 100) * (tenor / 12);
        const totalPengembalian = nominal + totalBagiHasil;

        // Dividen per periode
        const dividenPerTahun = nominal * (persen / 100);
        const dividenPerPeriode = dividenPerTahun / freqPerYear;

        // Payback period
        const paybackYears = persen > 0 ? (100 / persen).toFixed(1) : '∞';

        let freqText = 'Diterima setiap 1 bulan (Bulanan)';
        if (freqPerYear === 4) freqText = 'Diterima setiap 3 bulan (Triwulan)';
        if (freqPerYear === 2) freqText = 'Diterima setiap 6 bulan (Semesteran)';
        if (freqPerYear === 1) freqText = 'Diterima setiap 1 tahun (Tahunan)';

        document.getElementById('res-dividen-periode').innerText = 'Rp ' + Number(Math.round(dividenPerPeriode)).toLocaleString('id-ID');
        document.getElementById('res-periode-desc').innerText = freqText;
        document.getElementById('res-total-dividen').innerText = 'Rp ' + Number(Math.round(totalBagiHasil)).toLocaleString('id-ID');
        document.getElementById('res-total-pengembalian').innerText = 'Rp ' + Number(Math.round(totalPengembalian)).toLocaleString('id-ID');
        document.getElementById('res-payback').innerText = paybackYears + ' Tahun (jika murni dividen)';

        // Sinkronisasi ke Lembar Cetak Proyeksi (Print-Only Invoice Sheet)
        const printNominal = document.getElementById('print-calc-nominal');
        if (printNominal) printNominal.innerText = 'Rp ' + Number(nominal).toLocaleString('id-ID');

        const printRoi = document.getElementById('print-calc-roi');
        if (printRoi) printRoi.innerText = persen.toFixed(1) + '% per tahun';

        const printTenor = document.getElementById('print-calc-tenor');
        if (printTenor) printTenor.innerText = tenor + ' Bulan (' + (tenor / 12).toFixed(1) + ' Tahun)';

        const printFreq = document.getElementById('print-calc-freq');
        if (printFreq) printFreq.innerText = freqText;

        const scenBadge = document.getElementById('label-scenario-badge');
        const printScen = document.getElementById('print-calc-scenario');
        if (printScen && scenBadge) printScen.innerText = scenBadge.innerText.trim();

        const printDivPeriod = document.getElementById('print-calc-dividen-periode');
        if (printDivPeriod) printDivPeriod.innerText = 'Rp ' + Number(Math.round(dividenPerPeriode)).toLocaleString('id-ID');

        const printTotalDiv = document.getElementById('print-calc-total-dividen');
        if (printTotalDiv) printTotalDiv.innerText = 'Rp ' + Number(Math.round(totalBagiHasil)).toLocaleString('id-ID');

        const printTotalReturn = document.getElementById('print-calc-total-pengembalian');
        if (printTotalReturn) printTotalReturn.innerText = 'Rp ' + Number(Math.round(totalPengembalian)).toLocaleString('id-ID');

        const printPayback = document.getElementById('print-calc-payback');
        if (printPayback) printPayback.innerText = paybackYears + ' Tahun (jika murni dividen)';

        // Populate Cashflow Timeline Table (Layar & Cetak)
        const cfBody = document.getElementById('cashflow-tbody');
        const printCfBody = document.getElementById('print-cashflow-tbody');
        const cfBadge = document.getElementById('cf-tenor-badge');
        if (cfBody) {
            cfBody.innerHTML = '';
            if (printCfBody) printCfBody.innerHTML = '';
            const totalPeriods = Math.max(1, Math.round((tenor / 12) * freqPerYear));
            if (cfBadge) {
                cfBadge.innerText = totalPeriods + ' Periode (' + tenor + ' Bulan)';
            }
            
            const monthsPerPeriod = Math.max(1, Math.round(12 / freqPerYear));
            let runningTotal = 0;
            const singleDividen = totalBagiHasil / totalPeriods;

            for (let p = 1; p <= totalPeriods; p++) {
                const monthNum = p * monthsPerPeriod;
                const isFinal = (p === totalPeriods);
                const pokokReturned = isFinal ? nominal : 0;
                const totalCashIn = singleDividen + pokokReturned;
                runningTotal += totalCashIn;

                const tr = document.createElement('tr');
                tr.className = isFinal ? 'bg-emerald-50/70 font-bold border-t-2 border-emerald-300' : 'hover:bg-gray-50/70 transition';
                
                tr.innerHTML = `
                    <td class="py-2.5 px-3 flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full ${isFinal ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-700'} text-[10px] flex items-center justify-center font-bold">${p}</span>
                        <span>Bulan ke-${monthNum} ${isFinal ? '<span class="text-[10px] text-emerald-800 font-extrabold uppercase ml-1">(Jatuh Tempo)</span>' : ''}</span>
                    </td>
                    <td class="py-2.5 px-3 text-emerald-700 font-semibold">+Rp ${Number(Math.round(singleDividen)).toLocaleString('id-ID')}</td>
                    <td class="py-2.5 px-3 text-gray-700">${pokokReturned > 0 ? '<span class="text-teal-900 font-black">+Rp ' + Number(pokokReturned).toLocaleString('id-ID') + ' (Pelunasan Pokok)</span>' : '<span class="text-gray-300">-</span>'}</td>
                    <td class="py-2.5 px-3 font-black text-gray-900">Rp ${Number(Math.round(totalCashIn)).toLocaleString('id-ID')}</td>
                    <td class="py-2.5 px-3 font-black ${isFinal ? 'text-emerald-700 text-sm' : 'text-gray-600'}">Rp ${Number(Math.round(runningTotal)).toLocaleString('id-ID')}</td>
                `;
                cfBody.appendChild(tr);

                if (printCfBody) {
                    const printTr = document.createElement('tr');
                    printTr.className = isFinal ? 'font-bold bg-gray-50 border-t-2 border-gray-400' : 'border-b border-gray-200';
                    printTr.innerHTML = `
                        <td class="border border-gray-300 py-1.5 px-2.5 text-center text-gray-700 font-mono">${p}</td>
                        <td class="border border-gray-300 py-1.5 px-3 text-gray-900">Bulan ke-${monthNum} ${isFinal ? '<span class="text-[10px] uppercase font-bold text-gray-600">(Pelunasan)</span>' : ''}</td>
                        <td class="border border-gray-300 py-1.5 px-3 text-right font-mono text-gray-900">Rp ${Number(Math.round(singleDividen)).toLocaleString('id-ID')}</td>
                        <td class="border border-gray-300 py-1.5 px-3 text-right font-mono text-gray-700">${pokokReturned > 0 ? 'Rp ' + Number(pokokReturned).toLocaleString('id-ID') : '-'}</td>
                        <td class="border border-gray-300 py-1.5 px-3 text-right font-mono font-semibold text-gray-900">Rp ${Number(Math.round(totalCashIn)).toLocaleString('id-ID')}</td>
                        <td class="border border-gray-300 py-1.5 px-3 text-right font-mono font-bold text-gray-900">Rp ${Number(Math.round(runningTotal)).toLocaleString('id-ID')}</td>
                    `;
                    printCfBody.appendChild(printTr);
                }
            }
        }
    }

    function toggleCashflowSchedule() {
        const sec = document.getElementById('seksi-cashflow-table');
        const btnLabel = document.getElementById('btn-toggle-cashflow-label');
        if (!sec) return;
        if (sec.classList.contains('hidden')) {
            sec.classList.remove('hidden');
            if (btnLabel) btnLabel.innerHTML = 'Tutup Jadwal Arus Kas Dividen &uarr;';
            sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function openInvestModalWithCalc(idUmkm, namaUsaha, fallbackPersen) {
        const nominalInput = document.getElementById('input-range-nominal');
        const persenInput = document.getElementById('input-range-persen');
        const calcNominal = nominalInput ? parseFloat(nominalInput.value) : 5000000;
        const calcPersen = persenInput ? parseFloat(persenInput.value) : (fallbackPersen || 15);

        document.getElementById('invest-modal-nama-usaha').innerText = namaUsaha;
        document.getElementById('invest-modal-nominal').value = calcNominal;
        document.getElementById('invest-modal-persen').value = calcPersen;
        document.getElementById('form-invest-proposal').action = '/dashboard/investor/invest/' + idUmkm;
        document.getElementById('invest-modal').classList.remove('hidden');
    }

    function setNominalPreset(val) {
        const input = document.getElementById('input-range-nominal');
        if (input) {
            input.value = val;
            onCalcChange();
        }
    }
    function setPersenPreset(val) {
        const input = document.getElementById('input-range-persen');
        if (input) {
            input.value = val;
            onCalcChange();
        }
    }
    function setTenorPreset(val) {
        const input = document.getElementById('input-range-tenor');
        if (input) {
            input.value = val;
            onCalcChange();
        }
    }

    // Auto-calculate on tab load if calculator present
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('input-range-nominal')) {
            onCalcChange();
        }
    });

    window.addEventListener('beforeprint', function() {
        if (document.getElementById('input-range-nominal')) {
            onCalcChange();
        }
    });

    // Modal Lihat Klarifikasi Kendala Usaha UMKM
    function openLihatKlarifikasiModal(namaUsaha, periode, kategori, alasan, solusi, lampiranUrl, status, catatanAdmin) {
        document.getElementById('lihat-klr-umkm').innerText = namaUsaha;
        document.getElementById('lihat-klr-periode').innerText = periode;
        document.getElementById('lihat-klr-kategori').innerText = kategori;
        document.getElementById('lihat-klr-alasan').innerText = alasan;
        document.getElementById('lihat-klr-solusi').innerText = solusi;

        const lampiranContainer = document.getElementById('lihat-klr-lampiran-container');
        const lampiranLink = document.getElementById('lihat-klr-lampiran-link');
        if (lampiranUrl) {
            lampiranLink.href = lampiranUrl;
            lampiranContainer.classList.remove('hidden');
        } else {
            lampiranContainer.classList.add('hidden');
        }

        const statusBadge = document.getElementById('lihat-klr-status');
        const catatanAdminEl = document.getElementById('lihat-klr-catatan-admin');
        if (status === 'diverifikasi_admin') {
            statusBadge.className = 'px-2 py-0.5 rounded text-[10px] font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-300';
            statusBadge.innerText = 'Diverifikasi & Disetujui Admin';
        } else if (status === 'ditolak') {
            statusBadge.className = 'px-2 py-0.5 rounded text-[10px] font-black uppercase bg-rose-100 text-rose-800 border border-rose-300';
            statusBadge.innerText = 'Ditolak Tim Admin';
        } else {
            statusBadge.className = 'px-2 py-0.5 rounded text-[10px] font-black uppercase bg-amber-100 text-amber-800 border border-amber-300';
            statusBadge.innerText = 'Sedang Ditinjau Tim Compliance';
        }

        catatanAdminEl.innerText = catatanAdmin ? `Catatan Admin: "${catatanAdmin}"` : 'Menunggu tinjauan kepatuhan resmi dari administrator platform.';

        document.getElementById('modal-lihat-klarifikasi').classList.remove('hidden');
    }

    function closeLihatKlarifikasiModal() {
        document.getElementById('modal-lihat-klarifikasi').classList.add('hidden');
    }
</script>

<!-- MODAL LIHAT KLARIFIKASI KENDALA USAHA DARI UMKM -->
<div id="modal-lihat-klarifikasi" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-sky-100 text-sky-800 flex items-center justify-center text-lg font-black shrink-0">
                    ℹ️
                </div>
                <div>
                    <h3 class="text-lg font-black text-[#1A202C]">Laporan Kendala Usaha & Dividen</h3>
                    <p class="text-xs text-gray-500">Transparansi resmi dari pengelola mitra UMKM</p>
                </div>
            </div>
            <button type="button" onclick="closeLihatKlarifikasiModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center text-sm font-bold">✕</button>
        </div>

        <div class="space-y-4 text-xs">
            <!-- Header Ringkasan Usaha & Periode -->
            <div class="p-3.5 rounded-2xl bg-gray-50 border border-gray-200/80 flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-gray-400 uppercase font-bold block">Mitra UMKM:</span>
                    <strong id="lihat-klr-umkm" class="text-sm font-black text-gray-900">-</strong>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-gray-400 uppercase font-bold block">Periode Kewajiban:</span>
                    <strong id="lihat-klr-periode" class="text-xs font-bold text-gray-800">-</strong>
                </div>
            </div>

            <!-- Kategori Kendala -->
            <div>
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block mb-1">Faktor Utama Kendala:</span>
                <span id="lihat-klr-kategori" class="inline-block px-3 py-1 rounded-full text-xs font-black bg-purple-100 text-purple-900 border border-purple-200">
                    -
                </span>
            </div>

            <!-- Uraian Penjelasan -->
            <div>
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block mb-1">Penjelasan Kondisi Usaha:</span>
                <div id="lihat-klr-alasan" class="p-3.5 rounded-xl bg-gray-50 border border-gray-100 text-gray-700 leading-relaxed font-mono text-[11px]">
                    -
                </div>
            </div>

            <!-- Komitmen & Solusi Pemulihan -->
            <div>
                <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider block mb-1">Komitmen & Solusi Pemulihan Omzet:</span>
                <div id="lihat-klr-solusi" class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 leading-relaxed text-xs font-medium">
                    -
                </div>
            </div>

            <!-- Dokumen Lampiran -->
            <div id="lihat-klr-lampiran-container" class="hidden">
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block mb-1">Dokumen Lampiran Bukti:</span>
                <a id="lihat-klr-lampiran-link" href="#" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold border border-blue-200 transition">
                    <span>📎 Unduh / Lihat Dokumen Pendukung</span>
                    <span>↗</span>
                </a>
            </div>

            <!-- Status Tinjauan Admin Platform -->
            <div class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200 text-amber-900 text-[11px] space-y-1">
                <div class="flex items-center justify-between">
                    <span class="font-bold">Status Verifikasi Compliance Admin:</span>
                    <span id="lihat-klr-status" class="px-2 py-0.5 rounded text-[10px] font-black uppercase">-</span>
                </div>
                <p id="lihat-klr-catatan-admin" class="text-amber-800 italic pt-1"></p>
            </div>

            <div class="pt-2">
                <button type="button" onclick="closeLihatKlarifikasiModal()" class="w-full py-2.5 px-4 rounded-xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm">
                    Tutup Informasi
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
