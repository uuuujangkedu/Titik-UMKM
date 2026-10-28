@extends('layouts.super-admin')

@section('title', 'Monitoring Dividen & Kepatuhan UMKM')

@section('content')
<div class="space-y-8">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-[#0F433C] border border-emerald-200">
                    Sistem Kepatuhan & Audit
                </span>
                <span class="text-xs font-semibold text-gray-500">• Periode: {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">MONITORING DIVIDEN & KEPATUHAN</h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                Pengawasan penyetoran bagi hasil bulanan, mitigasi risiko wanprestasi, dan penerbitan Surat Peringatan (SP) resmi.
            </p>
        </div>
    </div>

    <!-- DIRECT WHATSAPP ACTION BANNER (IF SP JUST ISSUED) -->
    @if(session('wa_url'))
        <div class="bg-emerald-50 border-2 border-emerald-500 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 animate-bounce-once">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow">
                    <span class="text-2xl">💬</span>
                </div>
                <div>
                    <h4 class="font-extrabold text-emerald-950 text-base">Surat Peringatan Siap Dikirim ke WhatsApp!</h4>
                    <p class="text-xs text-emerald-800 mt-0.5">
                        Teguran resmi telah tersimpan di sistem. Kirimkan pesan resmi langsung ke nomor WhatsApp pemilik <strong>{{ session('wa_target') }}</strong>.
                    </p>
                </div>
            </div>
            <a href="{{ session('wa_url') }}" target="_blank" rel="noopener noreferrer" 
               class="px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black uppercase tracking-wider shadow-md hover:shadow-lg transition flex items-center gap-2 shrink-0">
                <span>Buka WhatsApp Sekarang</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    @endif

    <!-- STATS SUMMARY CARDS -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
        <!-- Total Kemitraan -->
        <div class="bg-white rounded-2xl p-4 border border-[#E8E6DF] shadow-sm">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Kemitraan Aktif</p>
            <p class="text-2xl font-black text-[#1A202C] mt-1">{{ $stats['total_kemitraan'] }}</p>
            <span class="text-[11px] text-gray-400 font-medium">Bagi hasil bulanan</span>
        </div>

        <!-- Lancar -->
        <div class="bg-white rounded-2xl p-4 border border-emerald-200 shadow-sm">
            <p class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Setoran Lancar</p>
            <p class="text-2xl font-black text-emerald-600 mt-1">{{ $stats['lancar'] }}</p>
            <span class="text-[11px] text-emerald-700 font-semibold">Tepat waktu</span>
        </div>

        <!-- Menjelang Jatuh Tempo -->
        <div class="bg-white rounded-2xl p-4 border border-blue-200 shadow-sm">
            <p class="text-[10px] font-bold text-blue-700 uppercase tracking-wider">Menjelang JT (Tgl 25)</p>
            <p class="text-2xl font-black text-blue-600 mt-1">{{ $stats['menjelang_jatuh_tempo'] }}</p>
            <span class="text-[11px] text-blue-700 font-medium">Waktu penyetoran</span>
        </div>

        <!-- Masa Tenggang -->
        <div class="bg-white rounded-2xl p-4 border border-amber-200 shadow-sm">
            <p class="text-[10px] font-bold text-amber-700 uppercase tracking-wider">Masa Tenggang</p>
            <p class="text-2xl font-black text-amber-600 mt-1">{{ $stats['masa_tenggang'] }}</p>
            <span class="text-[11px] text-amber-700 font-medium">Grace period 7 hari</span>
        </div>

        <!-- Menunggak / Terlambat -->
        <div class="bg-white rounded-2xl p-4 border border-rose-200 shadow-sm">
            <p class="text-[10px] font-bold text-rose-700 uppercase tracking-wider">Menunggak / Telat</p>
            <p class="text-2xl font-black text-rose-600 mt-1">{{ $stats['menunggak'] }}</p>
            <span class="text-[11px] text-rose-700 font-bold">Perlu tindakan SP</span>
        </div>

        <!-- Klarifikasi Masuk -->
        <div class="bg-white rounded-2xl p-4 border border-purple-200 shadow-sm">
            <p class="text-[10px] font-bold text-purple-700 uppercase tracking-wider">Klarifikasi Kendala</p>
            <p class="text-2xl font-black text-purple-600 mt-1">{{ $stats['klarifikasi'] }}</p>
            <span class="text-[11px] text-purple-700 font-medium">Ada laporan usaha</span>
        </div>
    </div>

    <!-- SEKSI 1: KLARIFIKASI KENDALA MENUNGGU VERIFIKASI (JIKA ADA) -->
    @if($klarifikasisPending->count() > 0)
        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border-2 border-purple-300 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center font-black">
                        ⚡
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#1A202C] text-lg">Laporan Klarifikasi Kendala Dividen ({{ $klarifikasisPending->count() }})</h3>
                        <p class="text-xs text-gray-600">UMKM menyampaikan alasan keterlambatan dan rencana pemulihan omzet. Periksa dan berikan verifikasi.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($klarifikasisPending as $klr)
                    <div class="bg-white rounded-2xl p-5 border border-purple-200 shadow-sm flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-purple-100 text-purple-800 border border-purple-200">
                                    {{ $klr->kategori_label }}
                                </span>
                                <span class="text-xs font-mono font-bold text-gray-500">
                                    Periode: {{ $klr->bulan_periode }}
                                </span>
                            </div>

                            <h4 class="font-black text-base text-[#1A202C]">{{ $klr->investasi->umkm->nama_usaha ?? 'UMKM' }}</h4>
                            <p class="text-xs text-gray-500 mb-3">
                                Investor: <strong>{{ $klr->investasi->pengguna->name ?? 'Investor' }}</strong> • 
                                Diajukan: {{ $klr->created_at->translatedFormat('d M Y, H:i') }}
                            </p>

                            <div class="bg-gray-50 rounded-xl p-3 text-xs text-gray-700 space-y-2 mb-3">
                                <div>
                                    <strong class="text-gray-900 block font-semibold mb-0.5">Penjelasan Kendala:</strong>
                                    <p class="leading-relaxed">{{ $klr->alasan }}</p>
                                </div>
                                <div>
                                    <strong class="text-emerald-900 block font-semibold mb-0.5">Komitmen & Solusi Pemulihan:</strong>
                                    <p class="leading-relaxed text-emerald-800">{{ $klr->komitmen_solusi }}</p>
                                </div>
                                @if($klr->lampiran_bukti)
                                    <div class="pt-1">
                                        <a href="{{ asset(ltrim($klr->lampiran_bukti, '/')) }}" target="_blank" 
                                           class="inline-flex items-center gap-1.5 text-[11px] font-bold text-purple-700 hover:text-purple-900 underline">
                                            📎 Lihat Dokumen Lampiran Bukti
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Tombol Verifikasi / Tolak -->
                        <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
                            <button type="button" onclick="openVerifikasiModal({{ $klr->id_klarifikasi }}, '{{ addslashes($klr->investasi->umkm->nama_usaha ?? 'UMKM') }}', '{{ $klr->bulan_periode }}', 'diverifikasi_admin')"
                                    class="flex-1 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition text-center shadow-sm">
                                ✓ Setujui & Beri Toleransi
                            </button>
                            <button type="button" onclick="openVerifikasiModal({{ $klr->id_klarifikasi }}, '{{ addslashes($klr->investasi->umkm->nama_usaha ?? 'UMKM') }}', '{{ $klr->bulan_periode }}', 'ditolak')"
                                    class="px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition border border-rose-200">
                                ✕ Tolak
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- SEKSI 2: DAFTAR KEMITRAAN & FILTER STATUS KEPATUHAN -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm space-y-6">
        
        <!-- Header & Filter Tabs -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-5">
            <div>
                <h3 class="text-xl font-extrabold text-[#1A202C]">Audit Kemitraan & Penyetoran Dividen</h3>
                <p class="text-xs text-gray-500 mt-0.5">Daftar semua kemitraan investasi aktif dan riwayat kepatuhan bulan berjalan.</p>
            </div>

            <!-- Tabs Filter -->
            <div class="flex flex-wrap items-center gap-1.5">
                <a href="{{ route('superadmin.dividen', ['status' => 'semua']) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $filter === 'semua' ? 'bg-[#0F433C] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Semua ({{ $stats['total_kemitraan'] }})
                </a>
                <a href="{{ route('superadmin.dividen', ['status' => 'lancar']) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $filter === 'lancar' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                    Lancar ({{ $stats['lancar'] }})
                </a>
                <a href="{{ route('superadmin.dividen', ['status' => 'menjelang_jatuh_tempo']) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $filter === 'menjelang_jatuh_tempo' ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-800 hover:bg-blue-100' }}">
                    Menjelang JT ({{ $stats['menjelang_jatuh_tempo'] }})
                </a>
                <a href="{{ route('superadmin.dividen', ['status' => 'masa_tenggang']) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $filter === 'masa_tenggang' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-800 hover:bg-amber-100' }}">
                    Masa Tenggang ({{ $stats['masa_tenggang'] }})
                </a>
                <a href="{{ route('superadmin.dividen', ['status' => 'menunggak']) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $filter === 'menunggak' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-800 hover:bg-rose-100' }}">
                    Menunggak ({{ $stats['menunggak'] }})
                </a>
                <a href="{{ route('superadmin.dividen', ['status' => 'klarifikasi']) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $filter === 'klarifikasi' ? 'bg-purple-600 text-white' : 'bg-purple-50 text-purple-800 hover:bg-purple-100' }}">
                    Klarifikasi ({{ $stats['klarifikasi'] }})
                </a>
            </div>
        </div>

        <!-- Tabel Kemitraan -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 text-[11px] font-extrabold uppercase tracking-wider text-gray-500 bg-gray-50/75">
                        <th class="py-3 px-4 rounded-l-xl">Mitra UMKM</th>
                        <th class="py-3 px-4">Investor</th>
                        <th class="py-3 px-4">Modal & Porsi</th>
                        <th class="py-3 px-4">Setoran Terakhir</th>
                        <th class="py-3 px-4">Status Dividen Bulan Ini</th>
                        <th class="py-3 px-4">Status SP / Hak</th>
                        <th class="py-3 px-4 text-center rounded-r-xl">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs">
                    @forelse($investasis as $inv)
                        @php
                            $status = $inv->status_dividen_bulan_ini;
                            $setoranTerakhir = $inv->bagiHasilLog->sortByDesc('created_at')->first();
                            $umkm = $inv->umkm;
                            $userUmkm = $umkm->user ?? null;
                            $phoneUmkm = $umkm->no_telepon ?? ($userUmkm->no_hp ?? '-');
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition">
                            <!-- UMKM -->
                            <td class="py-4 px-4 font-medium">
                                <div class="font-extrabold text-[#1A202C] text-sm">{{ $umkm->nama_usaha ?? 'UMKM' }}</div>
                                <div class="text-[11px] text-gray-500 flex items-center gap-1.5 mt-0.5">
                                    <span>👤 {{ $userUmkm->name ?? 'Pemilik' }}</span>
                                    <span>•</span>
                                    <span class="text-emerald-700 font-semibold">📞 {{ $phoneUmkm }}</span>
                                </div>
                            </td>

                            <!-- Investor -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-[#1A202C]">{{ $inv->pengguna->name ?? 'Investor' }}</div>
                                <div class="text-[11px] text-gray-400 truncate max-w-[140px]">{{ $inv->pengguna->email ?? '-' }}</div>
                            </td>

                            <!-- Modal & Porsi -->
                            <td class="py-4 px-4">
                                <div class="font-extrabold text-emerald-800">Rp {{ number_format($inv->jumlah_modal, 0, ',', '.') }}</div>
                                <div class="text-[11px] text-gray-500 font-semibold">{{ $inv->persentase_bagi_hasil ?? 0 }}% Dividen Netto</div>
                            </td>

                            <!-- Setoran Terakhir -->
                            <td class="py-4 px-4">
                                @if($setoranTerakhir)
                                    <div class="font-bold text-gray-800">Rp {{ number_format($setoranTerakhir->nominal_diterima, 0, ',', '.') }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono">{{ $setoranTerakhir->tanggal_distribusi ? $setoranTerakhir->tanggal_distribusi->translatedFormat('M Y') : '-' }}</div>
                                    @if(!empty($setoranTerakhir->bukti_transfer))
                                        <a href="{{ $setoranTerakhir->bukti_transfer_url }}" target="_blank" class="text-[10px] text-teal-700 hover:underline font-bold inline-flex items-center gap-0.5 mt-0.5">
                                            <span>Lihat Struk</span>
                                            <span class="text-[9px]">↗</span>
                                        </a>
                                    @endif
                                @else
                                    <span class="text-gray-400 italic text-[11px]">Belum ada setoran</span>
                                @endif
                            </td>

                            <!-- Status Dividen Bulan Ini -->
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold {{ $status['badge_class'] }}">
                                    <span>{{ $status['icon'] }}</span>
                                    <span>{{ $status['badge_label'] }}</span>
                                </span>
                                <div class="text-[10px] text-gray-400 mt-1">
                                    Jatuh tempo: {{ $status['due_date']->format('d M Y') }}
                                </div>
                            </td>

                            <!-- Status SP / Kepatuhan -->
                            <td class="py-4 px-4">
                                <div class="flex flex-col gap-1 items-start">
                                    @if(($umkm->jumlah_teguran_sp ?? 0) > 0)
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-rose-600 text-white">
                                            SP Terbit: {{ $umkm->jumlah_teguran_sp }}x
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-gray-100 text-gray-600">
                                            Bebas SP
                                        </span>
                                    @endif

                                    @if(($umkm->status_kepatuhan_dividen ?? 'lancar') === 'dibekukan')
                                        <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase bg-red-800 text-white animate-pulse">
                                            🚫 DIBEKUKAN
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Tindakan -->
                            <td class="py-4 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Terbitkan SP -->
                                    <button type="button" 
                                            onclick="openSpModal({{ $inv->id_investasi }}, '{{ addslashes($umkm->nama_usaha ?? 'UMKM') }}', '{{ $phoneUmkm }}', {{ $umkm->jumlah_teguran_sp ?? 0 }})"
                                            class="px-2.5 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-extrabold transition shadow-sm flex items-center gap-1"
                                            title="Terbitkan Surat Peringatan (SP-1, SP-2, SP-3)">
                                        <span>⚠️ SP</span>
                                    </button>

                                    <!-- Bekukan / Pulihkan Akun (Modal Kustom Modern) -->
                                    <form id="form-freeze-{{ $inv->id_investasi }}" action="{{ route('superadmin.dividen.umkm.toggle-freeze', $umkm->id_umkm ?? 0) }}" method="POST">
                                        @csrf
                                        @if(($umkm->status_kepatuhan_dividen ?? 'lancar') === 'dibekukan')
                                            <button type="button" 
                                                    onclick="openAppConfirmModal({
                                                        title: 'Pulihkan Hak Pendanaan UMKM',
                                                        message: 'Apakah Anda yakin ingin <strong>mencabut status pembekuan</strong> mitra <strong>{{ addslashes($umkm->nama_usaha ?? 'UMKM') }}</strong>? Mitra dapat kembali mengajukan permodalan dan terdaftar di platform secara normal.',
                                                        badge: 'Mitra: {{ addslashes($umkm->nama_usaha ?? 'UMKM') }} &bull; Pulihkan Hak',
                                                        confirmText: '✓ Ya, Pulihkan Akun',
                                                        confirmClass: 'bg-emerald-600 hover:bg-emerald-700 text-white',
                                                        icon: 'check',
                                                        form: document.getElementById('form-freeze-{{ $inv->id_investasi }}')
                                                    })"
                                                    class="px-2.5 py-1.5 rounded-xl bg-emerald-100 hover:bg-emerald-200 text-emerald-800 text-[11px] font-bold transition flex items-center gap-1" title="Pulihkan Hak Pendanaan">
                                                ✓ Pulihkan
                                            </button>
                                        @else
                                            <button type="button" 
                                                    onclick="openAppConfirmModal({
                                                        title: 'Bekukan Hak Pendanaan UMKM',
                                                        message: 'Apakah Anda yakin ingin <strong>membekukan sementara hak pendanaan</strong> mitra <strong>{{ addslashes($umkm->nama_usaha ?? 'UMKM') }}</strong>? Pengajuan modal baru dan promosi kemitraan akan dinonaktifkan sementara hingga kewajiban dividen diselesaikan.',
                                                        badge: 'Mitra: {{ addslashes($umkm->nama_usaha ?? 'UMKM') }} &bull; Sanksi Wanprestasi',
                                                        confirmText: '🚫 Ya, Bekukan Akun',
                                                        confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
                                                        icon: 'danger',
                                                        form: document.getElementById('form-freeze-{{ $inv->id_investasi }}')
                                                    })"
                                                    class="px-2.5 py-1.5 rounded-xl bg-gray-100 hover:bg-rose-100 text-gray-700 hover:text-rose-700 text-[11px] font-bold transition flex items-center gap-1" title="Bekukan Hak Pendanaan">
                                                🚫 Bekukan
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-400">
                                <p class="text-sm font-semibold">Tidak ada data kemitraan pada kategori ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- SEKSI 3: RIWAYAT AUDIT SURAT PERINGATAN (SP) -->
    @if($riwayatTeguran->count() > 0)
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm space-y-4">
            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                <h3 class="text-base font-extrabold text-[#1A202C]">Riwayat Penerbitan Surat Peringatan (Log Kepatuhan)</h3>
                <span class="text-xs text-gray-400">{{ $riwayatTeguran->count() }} Surat Tercatat</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-[10px] font-extrabold text-gray-500 uppercase tracking-wider border-b border-gray-100 pb-2">
                            <th class="py-2 px-3">Tanggal Terbit</th>
                            <th class="py-2 px-3">Tingkat SP</th>
                            <th class="py-2 px-3">Status</th>
                            <th class="py-2 px-3">Mitra UMKM</th>
                            <th class="py-2 px-3">Investor Terkait</th>
                            <th class="py-2 px-3">Tenggat Respons</th>
                            <th class="py-2 px-3">Admin Penerbit</th>
                            <th class="py-2 px-3">Isi Teguran</th>
                            <th class="py-2 px-3 text-right">Aksi Kelola</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($riwayatTeguran as $teguran)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-2.5 px-3 text-gray-500 font-mono whitespace-nowrap">{{ $teguran->created_at->translatedFormat('d M Y, H:i') }}</td>
                                <td class="py-2.5 px-3 whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded font-black text-[10px] 
                                        {{ $teguran->tingkat_sp === 'SP-3' ? 'bg-red-700 text-white' : ($teguran->tingkat_sp === 'SP-2' ? 'bg-orange-600 text-white' : 'bg-amber-500 text-white') }}">
                                        {{ $teguran->tingkat_sp }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 whitespace-nowrap">
                                    @if(($teguran->status ?? 'aktif') === 'selesai')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                            ✓ Lunas / Selesai
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-900 border border-amber-300 inline-flex items-center gap-1 animate-pulse">
                                            ● Menunggu Penyetoran
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-3 font-bold text-gray-900 whitespace-nowrap">{{ $teguran->umkm->nama_usaha ?? '-' }}</td>
                                <td class="py-2.5 px-3 text-gray-600 whitespace-nowrap">{{ $teguran->investasi->pengguna->name ?? '-' }}</td>
                                <td class="py-2.5 px-3 font-mono text-rose-700 font-semibold whitespace-nowrap">{{ $teguran->created_at->addDays(3)->translatedFormat('d M Y') }}</td>
                                <td class="py-2.5 px-3 text-gray-500 whitespace-nowrap">{{ $teguran->admin->name ?? 'Admin' }}</td>
                                <td class="py-2.5 px-3 text-gray-600 max-w-xs truncate" title="{{ $teguran->pesan_teguran }}">
                                    {{ $teguran->pesan_teguran }}
                                    @if(!empty($teguran->catatan_penyelesaian))
                                        <div class="text-[10px] text-emerald-700 font-semibold mt-0.5">
                                            Catatan: {{ $teguran->catatan_penyelesaian }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-2.5 px-3 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if(($teguran->status ?? 'aktif') !== 'selesai')
                                            <!-- Tombol Tandai Selesai / Cabut SP -->
                                            <form id="form-selesai-sp-{{ $teguran->id_teguran }}" action="{{ route('superadmin.dividen.sp.selesai', $teguran->id_teguran) }}" method="POST">
                                                @csrf
                                                <button type="button"
                                                        onclick="openAppConfirmModal({
                                                            title: 'Cabut / Selesaikan Surat Peringatan',
                                                            message: 'Konfirmasi bahwa kewajiban bagi hasil dividen oleh mitra <strong>{{ addslashes($teguran->umkm->nama_usaha ?? 'UMKM') }}</strong> telah disetorkan / dilunasi? Status Surat Peringatan (<strong>{{ $teguran->tingkat_sp }}</strong>) akan dicabut dan status kepatuhan UMKM dipulihkan.',
                                                            badge: 'Resolusi: {{ $teguran->tingkat_sp }} &bull; {{ addslashes($teguran->umkm->nama_usaha ?? 'UMKM') }}',
                                                            confirmText: '✓ Ya, Tandai Lunas & Cabut SP',
                                                            confirmClass: 'bg-emerald-600 hover:bg-emerald-700 text-white',
                                                            icon: 'check',
                                                            form: document.getElementById('form-selesai-sp-{{ $teguran->id_teguran }}')
                                                        })"
                                                        class="px-2.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-[11px] font-bold transition flex items-center gap-1 shadow-xs"
                                                        title="Tandai Selesai / Cabut SP karena sudah bayar">
                                                    <span>✓ Selesaikan (Lunas)</span>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Tombol Hapus SP -->
                                        <form id="form-delete-sp-{{ $teguran->id_teguran }}" action="{{ route('superadmin.dividen.sp.delete', $teguran->id_teguran) }}" method="POST">
                                            @csrf
                                            <button type="button"
                                                    onclick="openAppConfirmModal({
                                                        title: 'Hapus Surat Peringatan dari Log',
                                                        message: 'Apakah Anda yakin ingin <strong>menghapus catatan log {{ $teguran->tingkat_sp }}</strong> untuk mitra <strong>{{ addslashes($teguran->umkm->nama_usaha ?? 'UMKM') }}</strong>? Data akan dihapus dari riwayat log kepatuhan.',
                                                        badge: 'Hapus Log: {{ $teguran->tingkat_sp }} &bull; {{ addslashes($teguran->umkm->nama_usaha ?? 'UMKM') }}',
                                                        confirmText: '🗑 Hapus Log',
                                                        confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
                                                        icon: 'danger',
                                                        form: document.getElementById('form-delete-sp-{{ $teguran->id_teguran }}')
                                                    })"
                                                    class="px-2.5 py-1.5 rounded-xl bg-gray-50 hover:bg-rose-50 text-gray-500 hover:text-rose-600 border border-gray-200 hover:border-rose-200 text-[11px] font-bold transition flex items-center gap-1 shadow-xs"
                                                    title="Hapus record log ini">
                                                <span>🗑 Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

<!-- MODAL TERBITKAN SURAT PERINGATAN (SP) -->
<div id="modal-sp" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative border border-gray-100 animate-in fade-in duration-200">
        
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
            <div>
                <h3 class="text-xl font-black text-[#1A202C]">Penerbitan Surat Peringatan (SP)</h3>
                <p id="sp-umkm-subtitle" class="text-xs text-gray-500 mt-0.5">Teguran resmi atas keterlambatan setoran dividen.</p>
            </div>
            <button type="button" onclick="closeSpModal()" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:text-gray-800 flex items-center justify-center text-sm font-bold">
                ✕
            </button>
        </div>

        <form id="form-sp" action="" method="POST" class="space-y-4">
            @csrf
            
            <!-- Tingkat SP Selector -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tingkat Surat Peringatan</label>
                <div class="grid grid-cols-3 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="tingkat_sp" value="SP-1" class="peer sr-only" checked onchange="updateSpTemplate('SP-1')">
                        <div class="p-3 text-center rounded-xl border border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-900 transition">
                            <span class="block text-xs font-black">SP-1</span>
                            <span class="text-[10px] text-gray-500">Peringatan Awal</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="tingkat_sp" value="SP-2" class="peer sr-only" onchange="updateSpTemplate('SP-2')">
                        <div class="p-3 text-center rounded-xl border border-gray-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-900 transition">
                            <span class="block text-xs font-black">SP-2</span>
                            <span class="text-[10px] text-gray-500">Teguran Lanjutan</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="tingkat_sp" value="SP-3" class="peer sr-only" onchange="updateSpTemplate('SP-3')">
                        <div class="p-3 text-center rounded-xl border border-gray-200 peer-checked:border-rose-600 peer-checked:bg-rose-50 peer-checked:text-rose-900 transition">
                            <span class="block text-xs font-black">SP-3</span>
                            <span class="text-[10px] text-gray-500">Peringatan Final</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Tenggat Waktu Penyelesaian -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tenggat Waktu Respons / Penyetoran</label>
                <input type="date" name="tenggat_penyelesaian" id="sp-tenggat" 
                       value="{{ \Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                <p class="text-[10px] text-gray-400 mt-1">Default 3 hari kalender sejak penerbitan teguran.</p>
            </div>

            <!-- Pesan Teguran -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Isi Pesan Surat Peringatan</label>
                <textarea name="pesan_teguran" id="sp-pesan" rows="5" required
                          class="w-full p-3 rounded-xl border border-gray-200 text-xs leading-relaxed font-mono focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
            </div>

            <div class="bg-amber-50 rounded-xl p-3 border border-amber-200 text-[11px] text-amber-900 space-y-1">
                <p class="font-bold">Ketentuan Tindakan:</p>
                <p>Surat ini otomatis tercatat di histori chat kemitraan dan audit log Super Admin. Anda juga akan diarahkan langsung ke tautan WhatsApp pemilik usaha.</p>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeSpModal()" class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-black uppercase tracking-wider shadow-md hover:shadow-lg transition">
                    Terbitkan SP Resmi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL VERIFIKASI KLARIFIKASI KENDALA -->
<div id="modal-verifikasi" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl relative border border-gray-100">
        
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
            <h3 class="text-lg font-black text-[#1A202C]">Verifikasi Laporan Kendala</h3>
            <button type="button" onclick="closeVerifikasiModal()" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:text-gray-800 flex items-center justify-center text-sm font-bold">
                ✕
            </button>
        </div>

        <form id="form-verifikasi" action="" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="status" id="verifikasi-status" value="diverifikasi_admin">

            <div>
                <p class="text-xs text-gray-600 mb-2">
                    UMKM: <strong id="verifikasi-umkm" class="text-gray-900">-</strong> • Periode: <strong id="verifikasi-periode" class="text-gray-900">-</strong>
                </p>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Catatan & Ketetapan Tim Admin</label>
                <textarea name="catatan_admin" id="verifikasi-catatan" rows="4" required
                          placeholder="Tuliskan catatan hasil verifikasi, batas toleransi waktu baru, atau alasan penolakan..."
                          class="w-full p-3 rounded-xl border border-gray-200 text-xs leading-relaxed focus:outline-none focus:ring-2 focus:ring-[#0F433C]"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeVerifikasiModal()" class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition">
                    Batal
                </button>
                <button type="submit" id="btn-submit-verifikasi" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black uppercase tracking-wider shadow-md transition">
                    Simpan Ketetapan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const currentUmkmName = '';

    function openSpModal(investasiId, umkmName, phone, currentSpCount) {
        const modal = document.getElementById('modal-sp');
        const form = document.getElementById('form-sp');
        const subtitle = document.getElementById('sp-umkm-subtitle');
        
        form.action = `/super-admin/dividen/${investasiId}/teguran`;
        subtitle.innerHTML = `Mitra: <strong>${umkmName}</strong> (Telah menerima ${currentSpCount}x SP sebelumnya)`;
        
        // Auto select recommended SP level
        let nextSp = 'SP-1';
        if (currentSpCount === 1) nextSp = 'SP-2';
        else if (currentSpCount >= 2) nextSp = 'SP-3';
        
        const radio = form.querySelector(`input[name="tingkat_sp"][value="${nextSp}"]`);
        if (radio) {
            radio.checked = true;
        }
        
        updateSpTemplate(nextSp, umkmName);
        modal.classList.remove('hidden');
    }

    function closeSpModal() {
        document.getElementById('modal-sp').classList.add('hidden');
    }

    function updateSpTemplate(level, umkmName = 'Mitra UMKM') {
        const pesanField = document.getElementById('sp-pesan');
        if (level === 'SP-1') {
            pesanField.value = `Berdasarkan rekapitulasi data sistem, bagi hasil dividen kemitraan periode berjalan belum tercatat disetorkan dan telah melewati masa tenggang. Mohon segera melakukan penyetoran dividen atau menyampaikan klarifikasi kendala usaha secara resmi melalui dashboard Anda selambat-lambatnya sebelum tenggat waktu yang ditentukan.`;
        } else if (level === 'SP-2') {
            pesanField.value = `Ini merupakan Peringatan Lanjutan (SP-2) terkait kewajiban bagi hasil kemitraan yang belum dipenuhi. Keterlambatan tanpa laporan klarifikasi yang sah dapat berdampak pada peninjauan status kepatuhan dan reputasi mitra usaha Anda di platform DAYA UMKM. Harap segera diselesaikan.`;
        } else if (level === 'SP-3') {
            pesanField.value = `PERINGATAN FINAL (SP-3): Usaha Anda tercatat menunggak dividen bagi hasil dan telah mengabaikan peringatan sebelumnya. Jika dalam tenggat waktu berikut tidak ada penyetoran atau kesepakatan resolusi, sistem akan membekukan fasilitas pendanaan dan memfasilitasi mediasi wanprestasi dengan investor.`;
        }
    }

    function openVerifikasiModal(klarifikasiId, umkmName, periode, status) {
        const modal = document.getElementById('modal-verifikasi');
        const form = document.getElementById('form-verifikasi');
        const statusField = document.getElementById('verifikasi-status');
        const catatanField = document.getElementById('verifikasi-catatan');
        const submitBtn = document.getElementById('btn-submit-verifikasi');

        form.action = `/super-admin/dividen/klarifikasi/${klarifikasiId}/verifikasi`;
        document.getElementById('verifikasi-umkm').textContent = umkmName;
        document.getElementById('verifikasi-periode').textContent = periode;
        statusField.value = status;

        if (status === 'diverifikasi_admin') {
            catatanField.value = 'Laporan kendala telah diverifikasi dan disetujui. Diberikan toleransi penyesuaian jadwal dividen hingga akhir bulan berikutnya dengan komitmen pemulihan omzet.';
            submitBtn.textContent = 'Setujui & Verifikasi';
            submitBtn.className = 'px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black uppercase tracking-wider shadow-md transition';
        } else {
            catatanField.value = 'Laporan kendala ditolak karena dokumen pendukung tidak memadai atau alasan tidak sesuai dengan ketentuan SOP kemitraan. Mohon segera lakukan penyetoran kewajiban.';
            submitBtn.textContent = 'Tolak Klarifikasi';
            submitBtn.className = 'px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-black uppercase tracking-wider shadow-md transition';
        }

        modal.classList.remove('hidden');
    }

    function closeVerifikasiModal() {
        document.getElementById('modal-verifikasi').classList.add('hidden');
    }
</script>
@endsection
