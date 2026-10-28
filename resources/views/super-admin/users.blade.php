@extends('layouts.super-admin')

@section('title', 'Manajemen Akun Pengguna')

@section('content')
<div class="space-y-8">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">MANAJEMEN AKUN</h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
                Daftar lengkap pengguna yang mendaftar di platform DAYA UMKM.
            </p>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('superadmin.users') }}" method="GET" class="flex items-center gap-2">
            <input type="hidden" name="role" value="{{ $roleFilter }}">
            <div class="relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / email / no telp..."
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

    <!-- 4 KARTU RINGKASAN PENGGUNA -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white p-5 rounded-3xl border border-[#E8E6DF] shadow-sm">
            <p class="text-xs font-bold text-gray-500">Semua Pengguna</p>
            <h3 class="text-2xl sm:text-3xl font-black text-[#1A202C] mt-1">{{ $totalAll }}</h3>
            <span class="text-[11px] text-gray-400">Total Akun Terdaftar</span>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-[#E8E6DF] shadow-sm">
            <p class="text-xs font-bold text-blue-600">Investor Terdaftar</p>
            <h3 class="text-2xl sm:text-3xl font-black text-blue-900 mt-1">{{ $totalInvestors }}</h3>
            <span class="text-[11px] text-gray-400">Pemberi Modal</span>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-[#E8E6DF] shadow-sm">
            <p class="text-xs font-bold text-teal-600">Pelaku UMKM</p>
            <h3 class="text-2xl sm:text-3xl font-black text-teal-900 mt-1">{{ $totalUmkm }}</h3>
            <span class="text-[11px] text-gray-400">Pengusaha Terdaftar</span>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-[#E8E6DF] shadow-sm">
            <p class="text-xs font-bold text-purple-600">Super Admin / Staf</p>
            <h3 class="text-2xl sm:text-3xl font-black text-purple-900 mt-1">{{ $totalAdmin }}</h3>
            <span class="text-[11px] text-gray-400">Akses Pengelola</span>
        </div>
    </div>

    <!-- INFO HAK AKSES BANNER -->
    @if(auth()->user()->role === 'admin')
        <div class="p-4 rounded-2xl bg-sky-50 border border-sky-200 text-sky-900 text-xs flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="w-6 h-6 rounded-full bg-sky-500 text-white flex items-center justify-center font-bold text-xs shrink-0">ℹ</span>
                <span>Mode <strong>Admin Operasional</strong>: Anda berwenang meninjau dan menyetujui (ACC) akun mitra investor & pengajuan UMKM. Fitur penangguhan dan ganti role dikunci untuk Super Administrator.</span>
            </div>
        </div>
    @else
        <div class="p-4 rounded-2xl bg-purple-50 border border-purple-200 text-purple-900 text-xs flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="w-6 h-6 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-xs shrink-0">★</span>
                <span>Mode <strong>Super Administrator</strong>: Anda memiliki kendali penuh atas sistem, termasuk hak istimewa <strong>Mengganti Role Pengguna</strong>, <strong>Menangguhkan Akun</strong>, dan <strong>Verifikasi (ACC)</strong>.</span>
            </div>
        </div>
    @endif

    <!-- TABS FILTER PERAN -->
    <div class="flex flex-wrap items-center gap-2 border-b border-gray-200 pb-3">
        <a href="{{ route('superadmin.users', ['role' => 'semua', 'q' => request('q')]) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-extrabold transition {{ $roleFilter === 'semua' ? 'bg-[#0F433C] text-white shadow-sm' : 'bg-white border border-[#E8E6DF] text-gray-600 hover:bg-gray-50' }}">
            Semua Peran ({{ $totalAll }})
        </a>
        <a href="{{ route('superadmin.users', ['role' => 'investor', 'q' => request('q')]) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-extrabold transition {{ $roleFilter === 'investor' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white border border-blue-200 text-blue-800 hover:bg-blue-50' }}">
            Investor ({{ $totalInvestors }})
        </a>
        <a href="{{ route('superadmin.users', ['role' => 'umkm', 'q' => request('q')]) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-extrabold transition {{ $roleFilter === 'umkm' ? 'bg-teal-600 text-white shadow-sm' : 'bg-white border border-teal-200 text-teal-800 hover:bg-teal-50' }}">
            Pelaku UMKM ({{ $totalUmkm }})
        </a>
        <a href="{{ route('superadmin.users', ['role' => 'admin', 'q' => request('q')]) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-extrabold transition {{ $roleFilter === 'admin' ? 'bg-sky-600 text-white shadow-sm' : 'bg-white border border-sky-200 text-sky-800 hover:bg-sky-50' }}">
            Admin Staf ({{ $totalStaffAdmin }})
        </a>
        <a href="{{ route('superadmin.users', ['role' => 'super_admin', 'q' => request('q')]) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-extrabold transition {{ $roleFilter === 'super_admin' ? 'bg-purple-600 text-white shadow-sm' : 'bg-white border border-purple-200 text-purple-800 hover:bg-purple-50' }}">
            Super Admin ({{ $totalSuperAdmin }})
        </a>
    </div>

    <!-- TABEL MANAJEMEN AKUN -->
    <div class="bg-white rounded-3xl border border-[#E8E6DF] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F9F8F3] border-b border-[#E8E6DF] text-[11px] font-black uppercase tracking-wider text-gray-500">
                        <th class="py-4 px-6">Pengguna</th>
                        <th class="py-4 px-6">Kontak & Lokasi</th>
                        <th class="py-4 px-6">Peran (Role)</th>
                        <th class="py-4 px-6">Status Akun</th>
                        <th class="py-4 px-6">Tgl Mendaftar</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs font-medium">
                    @forelse($users as $u)
                        <tr class="hover:bg-gray-50/80 transition">
                            <!-- Info Pengguna -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#6B9E8A] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-sm overflow-hidden">
                                        @if(!empty($u->avatar))
                                            <img src="{{ $u->avatar }}" alt="{{ $u->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($u->name, 0, 2)) }}
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-extrabold text-[#1A202C] truncate">
                                            {{ $u->name }}
                                        </div>
                                        <div class="text-[11px] text-gray-400 truncate">
                                            {{ $u->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Kontak & Lokasi -->
                            <td class="py-4 px-6">
                                <div class="text-gray-800 font-semibold">{{ $u->phone_number ?? '-' }}</div>
                                <div class="text-[11px] text-gray-400">{{ $u->provinsi_kota ?? 'Lokasi belum diisi' }}</div>
                            </td>

                            <!-- Role -->
                            <td class="py-4 px-6">
                                @if($u->role === 'super_admin')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-purple-100 text-purple-800 border border-purple-200">
                                        Super Admin
                                    </span>
                                @elseif($u->role === 'admin')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-sky-100 text-sky-800 border border-sky-200">
                                        Admin (Staf)
                                    </span>
                                @elseif($u->role === 'investor')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-blue-100 text-blue-800 border border-blue-200">
                                        Investor
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-teal-100 text-teal-800 border border-teal-200">
                                        Pelaku UMKM
                                    </span>
                                @endif
                            </td>

                            <!-- Status Akun -->
                            <td class="py-4 px-6">
                                @if($u->status === 'aktif')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @elseif($u->status === 'ditangguhkan')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Ditangguhkan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        {{ ucfirst($u->status ?? 'menunggu') }}
                                    </span>
                                @endif
                            </td>

                            <!-- Tgl Daftar -->
                            <td class="py-4 px-6 text-gray-500 font-medium">
                                {{ $u->created_at ? $u->created_at->format('d M Y, H:i') : '-' }}
                            </td>

                            <!-- Aksi Toggle / ACC Status / Ganti Role -->
                            <td class="py-4 px-6 text-right">
                                @if($u->id !== auth()->id())
                                    <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                        <!-- 1. Tombol ACC Akun (Bisa dilakukan Super Admin & Admin Biasa) -->
                                        @if($u->status === 'menunggu_verifikasi')
                                            <form id="form-approve-user-{{ $u->id }}" action="{{ route('superadmin.users.approve', $u->id) }}" method="POST">
                                                @csrf
                                                <button type="button"
                                                        onclick="openAppConfirmModal({
                                                            title: 'Setujui (ACC) Pendaftaran Akun',
                                                            message: 'Apakah Anda yakin ingin <strong>MENYETUJUI (ACC)</strong> akun <strong>{{ addslashes($u->name) }}</strong> sebagai <strong>{{ strtoupper($u->role) }}</strong>?',
                                                            badge: 'Role: {{ strtoupper($u->role) }} &bull; {{ $u->email }}',
                                                            confirmText: '✓ Ya, Setujui Akun',
                                                            confirmClass: 'bg-emerald-600 hover:bg-emerald-700 text-white',
                                                            icon: 'check',
                                                            form: document.getElementById('form-approve-user-{{ $u->id }}')
                                                        })"
                                                        class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black transition shadow-sm flex items-center gap-1">
                                                    ✓ ACC Akun
                                                </button>
                                            </form>
                                        @endif

                                        <!-- 2. Aksi Khusus Super Admin: Ganti Role & Tangguhkan Akun -->
                                        @if(auth()->user()->role === 'super_admin')
                                            <!-- Tombol Ganti Role -->
                                            <button type="button" 
                                                    onclick="openRoleModal('{{ $u->id }}', '{{ addslashes($u->name) }}', '{{ $u->role }}')" 
                                                    class="px-2.5 py-1.5 rounded-xl bg-purple-50 hover:bg-purple-100 border border-purple-200 text-purple-700 text-xs font-bold transition flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                                </svg>
                                                <span>Ganti Role</span>
                                            </button>

                                            <!-- Tombol Suspend / Aktifkan -->
                                            <form id="form-toggle-user-{{ $u->id }}" action="{{ route('superadmin.users.toggle', $u->id) }}" method="POST">
                                                @csrf
                                                @if($u->status === 'aktif')
                                                    <button type="button"
                                                            onclick="openAppConfirmModal({
                                                                title: 'Tangguhkan Akun Pengguna',
                                                                message: 'Apakah Anda yakin ingin <strong>menangguhkan akun {{ addslashes($u->name) }}</strong>? Pengguna tidak akan dapat masuk ke sistem sampai akun diaktifkan kembali.',
                                                                badge: 'Status: Ditangguhkan &bull; {{ $u->email }}',
                                                                confirmText: 'Tangguhkan Akun',
                                                                confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
                                                                icon: 'danger',
                                                                form: document.getElementById('form-toggle-user-{{ $u->id }}')
                                                            })"
                                                            class="px-2.5 py-1.5 rounded-xl border border-rose-200 hover:bg-rose-50 text-rose-600 text-xs font-bold transition">
                                                        Tangguhkan
                                                    </button>
                                                @elseif($u->status !== 'menunggu_verifikasi')
                                                    <button type="button"
                                                            onclick="openAppConfirmModal({
                                                                title: 'Aktifkan Kembali Akun',
                                                                message: 'Apakah Anda yakin ingin <strong>mengaktifkan kembali akun {{ addslashes($u->name) }}</strong>?',
                                                                badge: 'Status: Aktif &bull; {{ $u->email }}',
                                                                confirmText: '✓ Ya, Aktifkan Akun',
                                                                confirmClass: 'bg-emerald-600 hover:bg-emerald-700 text-white',
                                                                icon: 'check',
                                                                form: document.getElementById('form-toggle-user-{{ $u->id }}')
                                                            })"
                                                            class="px-2.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm">
                                                        Aktifkan
                                                    </button>
                                                @endif
                                            </form>
                                        @else
                                            @if($u->status !== 'menunggu_verifikasi')
                                                <span class="text-[11px] text-gray-400 font-medium">Hanya Lihat</span>
                                            @endif
                                        @endif
                                    </div>
                                @else
                                    <span class="text-[11px] font-bold text-gray-400 italic">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400">
                                Tidak ada data pengguna yang sesuai pencarian atau filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINATION -->
    <div class="mt-8">
        {{ $users->links() }}
    </div>

    <!-- MODAL GANTI ROLE (Khusus Super Admin) -->
    <div id="role-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full border border-gray-200 shadow-2xl relative">
            <button type="button" onclick="closeRoleModal()" class="absolute top-5 right-5 text-gray-400 hover:text-gray-700 text-xl font-bold">
                &times;
            </button>

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center font-black text-lg">
                    ⚙
                </div>
                <div>
                    <h3 class="text-lg font-black text-gray-900">Ubah Role Pengguna</h3>
                    <p class="text-xs text-gray-500" id="modal-user-name">Pengguna</p>
                </div>
            </div>

            <form id="form-change-role" method="POST" action="">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Pilih Role Baru:</label>
                        <select name="role" id="modal-role-select" class="w-full px-4 py-3 rounded-2xl bg-[#F9F8F3] border border-[#E8E6DF] text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-600">
                            <option value="investor">Mitra Investor</option>
                            <option value="umkm">Pelaku UMKM</option>
                            <option value="admin">Admin Biasa (Operasional & Verifikator)</option>
                            <option value="super_admin">Super Administrator</option>
                        </select>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-[11px] leading-relaxed">
                        <strong>Perhatian:</strong> Perubahan role akan langsung mengubah hak akses pengguna pada saat login berikutnya (termasuk menu dashboard yang dapat mereka akses).
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" onclick="closeRoleModal()" class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-black transition shadow-md">
                            Simpan Perubahan Role
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRoleModal(userId, userName, currentRole) {
            const modal = document.getElementById('role-modal');
            const nameEl = document.getElementById('modal-user-name');
            const selectEl = document.getElementById('modal-role-select');
            const form = document.getElementById('form-change-role');

            nameEl.textContent = userName;
            selectEl.value = currentRole;
            form.action = `/super-admin/users/${userId}/change-role`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeRoleModal() {
            const modal = document.getElementById('role-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</div>
@endsection
