<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Investasi extends Model
{
    protected $table = 'investasi';

    protected $primaryKey = 'id_investasi';

    protected $fillable = [
        'id_pengguna',
        'id_umkm',
        'jumlah_modal',
        'persentase_bagi_hasil',
        'periode_pembagian',
        'status',
        'catatan',
        'dibaca',
        'tanggal_investasi',
    ];

    protected $casts = [
        'jumlah_modal' => 'decimal:2',
        'persentase_bagi_hasil' => 'decimal:2',
        'tanggal_investasi' => 'datetime',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id');
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'id_umkm', 'id_umkm');
    }

    public function bagiHasilLog(): HasMany
    {
        return $this->hasMany(BagiHasilLog::class, 'id_investasi', 'id_investasi');
    }

    public function pesanInvestasi(): HasMany
    {
        return $this->hasMany(PesanInvestasi::class, 'id_investasi', 'id_investasi')->oldest();
    }

    public function ulasan()
    {
        return $this->hasOne(UlasanUmkm::class, 'id_investasi', 'id_investasi');
    }

    public function klarifikasiDividen(): HasMany
    {
        return $this->hasMany(KlarifikasiDividen::class, 'id_investasi', 'id_investasi')->latest();
    }

    public function teguranDividen(): HasMany
    {
        return $this->hasMany(TeguranDividenLog::class, 'id_investasi', 'id_investasi')->latest();
    }

    public function kontrak(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(KontrakInvestasi::class, 'id_investasi', 'id_investasi');
    }

    /**
     * Hitung Status Kepatuhan & Jatuh Tempo Dividen Bulan Berjalan
     */
    public function getStatusDividenBulanIniAttribute(): array
    {
        $now = now();
        $bulanSekarang = $now->translatedFormat('F Y');
        
        // 1. Cek riwayat setoran di bulan berjalan
        $setoranBulanIni = $this->bagiHasilLog
            ->filter(function ($log) use ($now) {
                return $log->tanggal_distribusi 
                    && $log->tanggal_distribusi->month === $now->month 
                    && $log->tanggal_distribusi->year === $now->year;
            })->first();

        $terakhirSetor = $this->bagiHasilLog->sortByDesc('tanggal_distribusi')->first();

        $dueDate = \Carbon\Carbon::create($now->year, $now->month, 25);

        if ($setoranBulanIni) {
            return [
                'code' => 'lancar',
                'badge_label' => 'Bulan Ini Sudah Disetor',
                'badge_class' => 'bg-emerald-100 text-emerald-800 border border-emerald-300',
                'icon' => '✓',
                'bulan_periode' => $bulanSekarang,
                'jatuh_tempo_hari' => 25,
                'due_date' => $dueDate,
                'terakhir_setor' => $setoranBulanIni->tanggal_distribusi,
                'nominal_disetor' => (float) $setoranBulanIni->nominal_diterima,
                'klarifikasi' => null,
            ];
        }

        // 2. Cek apakah ada klarifikasi penundaan di bulan berjalan
        $klarifikasi = $this->klarifikasiDividen
            ->filter(function ($k) use ($bulanSekarang) {
                return $k->bulan_periode === $bulanSekarang && $k->status !== 'ditolak';
            })->first();

        if ($klarifikasi) {
            $isApproved = $klarifikasi->status === 'diverifikasi_admin';
            return [
                'code' => $isApproved ? 'klarifikasi_disetujui' : 'klarifikasi',
                'badge_label' => $isApproved ? 'Dispensasi Disetujui (Setor Bulan Depan)' : 'Klarifikasi Diajukan (Menunggu ACC)',
                'badge_class' => $isApproved ? 'bg-emerald-100 text-emerald-900 border border-emerald-300' : 'bg-sky-100 text-sky-900 border border-sky-300',
                'icon' => $isApproved ? '✓' : 'ℹ',
                'bulan_periode' => $bulanSekarang,
                'jatuh_tempo_hari' => 25,
                'due_date' => $dueDate,
                'terakhir_setor' => $terakhirSetor ? $terakhirSetor->tanggal_distribusi : null,
                'nominal_disetor' => 0,
                'klarifikasi' => $klarifikasi,
                'disetujui_bulan_depan' => $isApproved,
            ];
        }

        // 3. Status Berdasarkan Tanggal Jatuh Tempo (Tgl 25) & Toleransi Grace Period
        $dayNow = $now->day;
        if ($dayNow < 25) {
            return [
                'code' => 'menjelang_jatuh_tempo',
                'badge_label' => 'Jatuh Tempo 25 ' . $now->translatedFormat('M'),
                'badge_class' => 'bg-teal-50 text-teal-800 border border-teal-300',
                'icon' => '📅',
                'bulan_periode' => $bulanSekarang,
                'jatuh_tempo_hari' => 25,
                'due_date' => $dueDate,
                'terakhir_setor' => $terakhirSetor ? $terakhirSetor->tanggal_distribusi : null,
                'nominal_disetor' => 0,
                'klarifikasi' => null,
            ];
        } elseif ($dayNow <= 30) {
            // Tanggal 25-30: Masa Tenggang (Grace Period)
            return [
                'code' => 'masa_tenggang',
                'badge_label' => 'Masa Tenggang (Grace Period)',
                'badge_class' => 'bg-amber-100 text-amber-900 border border-amber-300',
                'icon' => '⏳',
                'bulan_periode' => $bulanSekarang,
                'jatuh_tempo_hari' => 25,
                'due_date' => $dueDate,
                'terakhir_setor' => $terakhirSetor ? $terakhirSetor->tanggal_distribusi : null,
                'nominal_disetor' => 0,
                'klarifikasi' => null,
            ];
        } else {
            // Lewat masa tenggang tanpa setor & tanpa klarifikasi
            return [
                'code' => 'menunggak',
                'badge_label' => 'Terlambat / Menunggak',
                'badge_class' => 'bg-rose-100 text-rose-800 border border-rose-300',
                'icon' => '⚠️',
                'bulan_periode' => $bulanSekarang,
                'jatuh_tempo_hari' => 25,
                'due_date' => $dueDate,
                'terakhir_setor' => $terakhirSetor ? $terakhirSetor->tanggal_distribusi : null,
                'nominal_disetor' => 0,
                'klarifikasi' => null,
            ];
        }
    }
}
