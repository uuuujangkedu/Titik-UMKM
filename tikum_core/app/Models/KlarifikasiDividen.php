<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KlarifikasiDividen extends Model
{
    protected $table = 'klarifikasi_dividen';

    protected $primaryKey = 'id_klarifikasi';

    protected $fillable = [
        'id_investasi',
        'id_umkm',
        'bulan_periode',
        'kategori_kendala',
        'alasan',
        'lampiran_bukti',
        'komitmen_solusi',
        'status',
        'catatan_admin',
        'catatan_investor',
    ];

    public function investasi(): BelongsTo
    {
        return $this->belongsTo(Investasi::class, 'id_investasi', 'id_investasi');
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'id_umkm', 'id_umkm');
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori_kendala) {
            'omzet_menurun' => 'Penjualan / Omzet Menurun',
            'beban_operasional' => 'Lonjakan Beban Operasional',
            'piutang_tertunda' => 'Piutang Pelanggan Tertunda',
            'force_majeure' => 'Kendala Tak Terduga (Force Majeure)',
            default => 'Kendala Operasional Lainnya',
        };
    }
}
