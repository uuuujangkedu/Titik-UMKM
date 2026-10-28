@extends('layouts.super-admin')

@section('title', 'Log Aktivitas & Monitoring Online')

@section('content')
<div class="space-y-8">

    <!-- PAGE HEADER -->
    <div>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[#1A202C]">LOG AKTIVITAS & SESI ONLINE</h1>
        <p class="text-sm sm:text-base text-gray-500 mt-1 font-medium">
            Monitoring pengguna yang sedang login di platform serta audit trail tindakan sistem secara realtime.
        </p>
    </div>

    <!-- SEKSI 1: USER YANG SEDANG LOGIN (REALTIME ONLINE) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-[#E0F7F6] text-[#00A389] flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-black text-[#1A202C]">Pengguna Sedang Login (Online Saat Ini)</h2>
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">
                        Menampilkan sesi pengguna aktif dengan interaksi dalam kurun waktu 15 menit terakhir.
                    </p>
                </div>
            </div>

            <div class="px-4 py-2 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-black flex items-center gap-2 self-start sm:self-auto">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span>{{ $onlineUsers->count() }} Pengguna Terhubung</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F9F8F3] border-b border-[#E8E6DF] text-[11px] font-black uppercase tracking-wider text-gray-500">
                        <th class="py-3.5 px-5">Pengguna</th>
                        <th class="py-3.5 px-5">Peran (Role)</th>
                        <th class="py-3.5 px-5">IP Address</th>
                        <th class="py-3.5 px-5">Browser / Perangkat</th>
                        <th class="py-3.5 px-5">Aktivitas Terakhir</th>
                        <th class="py-3.5 px-5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs font-medium">
                    @forelse($onlineUsers as $sess)
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="py-3.5 px-5">
                                <div class="font-black text-[#1A202C]">{{ $sess['name'] }}</div>
                                <div class="text-[11px] text-gray-400">{{ $sess['email'] }}</div>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $sess['role'] === 'super_admin' ? 'bg-purple-100 text-purple-800' : ($sess['role'] === 'investor' ? 'bg-blue-100 text-blue-800' : 'bg-teal-100 text-teal-800') }}">
                                    {{ $sess['role'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 font-mono text-gray-600">
                                {{ $sess['ip_address'] }}
                            </td>
                            <td class="py-3.5 px-5 text-gray-500 max-w-[240px] truncate" title="{{ $sess['user_agent'] }}">
                                {{ $sess['user_agent'] }}
                            </td>
                            <td class="py-3.5 px-5 text-gray-700 font-semibold">
                                {{ $sess['last_activity']->diffForHumans() }}
                            </td>
                            <td class="py-3.5 px-5 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Online
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400 text-xs">
                                Tidak ada sesi pengguna lain yang aktif saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- SEKSI 2: AUDIT TRAIL LOG AKTIVITAS ADMIN -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8E6DF] shadow-sm">
        <div class="mb-6">
            <h2 class="text-lg font-black text-[#1A202C]">Audit Trail Riwayat Aktivitas & Perubahan</h2>
            <p class="text-xs text-gray-400 font-medium mt-0.5">
                Rekaman semua aksi penting super admin: persetujuan proposal UMKM, penolakan, dan perubahan status pengguna.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F9F8F3] border-b border-[#E8E6DF] text-[11px] font-black uppercase tracking-wider text-gray-500">
                        <th class="py-3.5 px-5">Waktu</th>
                        <th class="py-3.5 px-5">Administrator</th>
                        <th class="py-3.5 px-5">Tindakan / Aksi</th>
                        <th class="py-3.5 px-5">Rincian Perubahan</th>
                        <th class="py-3.5 px-5">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs font-medium">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="py-3.5 px-5 text-gray-500 whitespace-nowrap">
                                {{ $log->waktu ? $log->waktu->format('d M Y, H:i:s') : '-' }}
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="font-extrabold text-[#1A202C]">{{ $log->pengguna->name ?? 'Sistem' }}</div>
                                <div class="text-[10px] text-gray-400">{{ $log->pengguna->email ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-extrabold {{ str_contains(strtolower($log->aksi), 'persetujuan') ? 'bg-emerald-100 text-emerald-800' : (str_contains(strtolower($log->aksi), 'tolak') ? 'bg-rose-100 text-rose-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-gray-600">
                                @if(is_array($log->detail_perubahan))
                                    <div class="space-y-0.5 text-[11px]">
                                        @foreach($log->detail_perubahan as $k => $v)
                                            <div>
                                                <span class="font-bold text-gray-700 capitalize">{{ str_replace('_', ' ', $k) }}:</span>
                                                <span class="text-gray-900">{{ is_array($v) ? json_encode($v) : $v }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500 font-mono text-[11px]">{{ $log->detail_perubahan ?? '-' }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5 font-mono text-gray-500">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400">
                                Belum ada riwayat aktivitas yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    </div>

</div>
@endsection
