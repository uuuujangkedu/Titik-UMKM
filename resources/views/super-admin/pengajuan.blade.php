@extends('layouts.super-admin')

@section('title', 'Persetujuan Proposal UMKM')

@section('content')
<div class="space-y-8">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">PENGAJUAN UMKM</h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                Persetujuan dan verifikasi proposal pendanaan & sewa ruko pelaku usaha.
            </p>
        </div>
        
        <!-- Search Bar -->
        <form action="{{ route('superadmin.pengajuan') }}" method="GET" class="flex items-center gap-2">
            <input type="hidden" name="status" value="{{ $statusFilter }}">
            <div class="relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari usaha / pemilik / WA..."
                       class="w-64 sm:w-80 px-4 py-2.5 rounded-2xl bg-white border border-[#E8E6DF] text-xs font-semibold placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0F433C]">
                <svg class="w-4 h-4 text-gray-400 absolute right-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <button type="submit" class="px-4 py-2.5 rounded-2xl bg-[#0F433C] hover:bg-[#19584F] text-white text-xs font-bold transition shadow-sm">
                Cari
            </button>
        </form>
    </div>

    <!-- TABS FILTER STATUS -->
    <div class="flex flex-wrap items-center gap-2 border-b border-gray-200 pb-3">
        <a href="{{ route('superadmin.pengajuan', ['status' => 'semua', 'q' => request('q')]) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-extrabold transition {{ $statusFilter === 'semua' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
            Semua ({{ $countSemua }})
        </a>
        <a href="{{ route('superadmin.pengajuan', ['status' => 'menunggu_verifikasi', 'q' => request('q')]) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-extrabold transition flex items-center gap-2 {{ $statusFilter === 'menunggu_verifikasi' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white border border-amber-200 text-amber-800 hover:bg-amber-50' }}">
            <span>⏳ Menunggu Verifikasi</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $statusFilter === 'menunggu_verifikasi' ? 'bg-amber-700 text-white' : 'bg-amber-100 text-amber-900' }}">{{ $countMenunggu }}</span>
        </a>
        <a href="{{ route('superadmin.pengajuan', ['status' => 'terverifikasi', 'q' => request('q')]) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-extrabold transition flex items-center gap-2 {{ $statusFilter === 'terverifikasi' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white border border-emerald-200 text-emerald-800 hover:bg-emerald-50' }}">
            <span>✓ Terverifikasi</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $statusFilter === 'terverifikasi' ? 'bg-emerald-800 text-white' : 'bg-emerald-100 text-emerald-900' }}">{{ $countTerverifikasi }}</span>
        </a>
        <a href="{{ route('superadmin.pengajuan', ['status' => 'ditolak', 'q' => request('q')]) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-extrabold transition flex items-center gap-2 {{ $statusFilter === 'ditolak' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white border border-rose-200 text-rose-800 hover:bg-rose-50' }}">
            <span>✕ Ditolak</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $statusFilter === 'ditolak' ? 'bg-rose-800 text-white' : 'bg-rose-100 text-rose-900' }}">{{ $countDitolak }}</span>
        </a>
        <a href="{{ route('superadmin.pengajuan', ['status' => 'draf', 'q' => request('q')]) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-extrabold transition flex items-center gap-2 {{ $statusFilter === 'draf' ? 'bg-gray-700 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            <span>📝 Draf Belum Lengkap</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $statusFilter === 'draf' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-800' }}">{{ $countDraf }}</span>
        </a>
    </div>

    <!-- LIST OF PROPOSALS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($pengajuanList as $umkm)
            <div class="bg-white rounded-3xl p-6 border border-[#E8E6DF] shadow-sm hover:shadow-md transition flex flex-col justify-between">
                
                <div>
                    <!-- Header Kartu: Status & ID -->
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <span class="text-[10px] font-mono font-bold text-gray-400">
                            #UMKM-{{ $umkm->id_umkm }}
                        </span>
                        <div>
                            @if($umkm->status_pengajuan === 'terverifikasi')
                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    ✓ Terverifikasi
                                </span>
                            @elseif($umkm->status_pengajuan === 'menunggu_verifikasi')
                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200 animate-pulse">
                                    ⏳ Menunggu Persetujuan
                                </span>
                            @elseif($umkm->status_pengajuan === 'ditolak')
                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
                                    ✕ Ditolak
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-gray-100 text-gray-700 border border-gray-200">
                                    Draf (Belum Dikirim)
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Profil Usaha -->
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-[#6B9E8A] text-white flex items-center justify-center shrink-0 font-black text-lg overflow-hidden shadow-sm">
                            @if(!empty($umkm->foto_produk))
                                <img src="{{ asset('storage/' . $umkm->foto_produk) }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($umkm->nama_usaha, 0, 2)) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-base font-black text-[#1A202C] leading-snug truncate">
                                {{ $umkm->nama_usaha }}
                            </h3>
                            <p class="text-xs font-semibold text-[#0F433C] mt-0.5">
                                {{ $umkm->jenis_usaha }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                Pemilik: <span class="font-bold text-gray-700">{{ $umkm->pemilik }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Detail Spesifikasi Proposal -->
                    <div class="bg-[#F9F8F3] p-4 rounded-2xl space-y-2 text-xs border border-[#E8E6DF] mb-5">
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Target Pendanaan:</span>
                            <span class="font-extrabold text-[#1A202C]">
                                {{ $umkm->target_pendanaan ? 'Rp ' . number_format($umkm->target_pendanaan, 0, ',', '.') : 'Belum ditentukan' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Bagi Hasil Ditawarkan:</span>
                            <span class="font-bold text-emerald-700">
                                {{ $umkm->persentase_bagi_hasil ? $umkm->persentase_bagi_hasil . '%' : '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Minat Ruko:</span>
                            <span class="font-semibold text-gray-800 truncate max-w-[150px]">
                                {{ $umkm->ruko->nama_ruko ?? 'Belum memilih' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">WhatsApp / Telp:</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->nomor_whatsapp) }}" target="_blank" class="font-bold text-teal-700 hover:underline">
                                {{ $umkm->nomor_whatsapp ?? '-' }}
                            </a>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Lokasi:</span>
                            <span class="font-medium text-gray-600 truncate max-w-[150px]">
                                {{ $umkm->provinsi_kota ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <!-- Dokumen Proposal File -->
                    @if(!empty($umkm->file_proposal))
                        <div class="mb-5">
                            <a href="{{ route('proposal.download', $umkm->id_umkm) }}" target="_blank" class="flex items-center gap-2 p-2.5 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-900 border border-teal-200 text-xs font-bold transition">
                                <svg class="w-4 h-4 text-teal-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="truncate">Unduh / Baca Berkas Proposal PDF</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- AKSI PERSETUJUAN / PENOLAKAN -->
                <div class="pt-4 border-t border-gray-100">
                    <div class="grid grid-cols-2 gap-2">
                        <!-- Tombol Setujui -->
                        <form id="form-approve-proposal-{{ $umkm->id_umkm }}" action="{{ route('superadmin.pengajuan.approve', $umkm->id_umkm) }}" method="POST">
                            @csrf
                            <button type="button"
                                    onclick="openAppConfirmModal({
                                        title: 'Setujui Proposal Usaha',
                                        message: 'Apakah Anda yakin ingin <strong>MENYETUJUI proposal usaha {{ addslashes($umkm->nama_usaha) }}</strong>? Usaha ini akan langsung terverifikasi dan tayang di katalog investasi untuk didanai.',
                                        badge: 'Usaha: {{ addslashes($umkm->nama_usaha) }} &bull; Target Rp {{ number_format($umkm->modal_dibutuhkan, 0, ',', '.') }}',
                                        confirmText: '✓ Ya, Setujui Proposal',
                                        confirmClass: 'bg-emerald-600 hover:bg-emerald-700 text-white',
                                        icon: 'check',
                                        form: document.getElementById('form-approve-proposal-{{ $umkm->id_umkm }}')
                                    })"
                                    class="w-full py-2.5 px-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold transition shadow-sm flex items-center justify-center gap-1.5 {{ $umkm->status_pengajuan === 'terverifikasi' ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $umkm->status_pengajuan === 'terverifikasi' ? 'disabled' : '' }}>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Setujui</span>
                            </button>
                        </form>

                        <!-- Tombol Tolak (Buka Dialog/Alasan) -->
                        <button type="button" onclick="openRejectModal('{{ $umkm->id_umkm }}', '{{ addslashes($umkm->nama_usaha) }}')"
                                class="w-full py-2.5 px-3 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-extrabold transition flex items-center justify-center gap-1.5 {{ $umkm->status_pengajuan === 'ditolak' ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $umkm->status_pengajuan === 'ditolak' ? 'disabled' : '' }}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>Tolak</span>
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-[#E8E6DF]">
                <div class="w-16 h-16 rounded-full bg-gray-100 text-gray-400 mx-auto flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Tidak ada pengajuan proposal ditemukan</h3>
                <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">
                    Tidak ada data dengan kriteria filter status atau kata kunci yang Anda masukkan.
                </p>
                <div class="mt-4">
                    <a href="{{ route('superadmin.pengajuan') }}" class="px-4 py-2 rounded-xl bg-[#0F433C] text-white text-xs font-bold hover:bg-[#19584F] transition">
                        Reset Filter
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="mt-8">
        {{ $pengajuanList->links() }}
    </div>

</div>

<!-- MODAL PENOLAKAN PROPOSAL -->
<div id="reject-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-gray-100 animate-scale-up">
        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 class="text-xl font-black text-[#1A202C]">Tolak Proposal Usaha</h3>
        <p class="text-xs text-gray-500 mt-1">
            Anda akan menolak pengajuan <span id="modal-usaha-name" class="font-bold text-gray-800"></span>. Berikan catatan atau alasan penolakan untuk pelaku usaha.
        </p>

        <form id="form-reject-pengajuan" method="POST" action="" class="mt-5 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Alasan Penolakan</label>
                <textarea name="alasan" rows="3" required placeholder="Contoh: Dokumen legalitas kurang lengkap, atau rincian pembagian hasil belum sesuai kriteria platform."
                          class="w-full p-3 rounded-2xl border border-[#E8E6DF] text-xs font-medium focus:outline-none focus:ring-2 focus:ring-rose-500"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <button type="button" onclick="closeRejectModal()" class="py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition shadow-sm">
                    Konfirmasi Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(id, namaUsaha) {
        document.getElementById('modal-usaha-name').innerText = namaUsaha;
        document.getElementById('form-reject-pengajuan').action = '/super-admin/pengajuan/' + id + '/reject';
        document.getElementById('reject-modal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('reject-modal').classList.add('hidden');
    }
</script>
@endsection
