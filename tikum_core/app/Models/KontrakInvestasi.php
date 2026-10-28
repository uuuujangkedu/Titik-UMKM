<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KontrakInvestasi extends Model
{
    use HasFactory;

    protected $table = 'kontrak_investasi';

    protected $fillable = [
        'nomor_kontrak',
        'id_investasi',
        'id_umkm',
        'id_investor',
        'judul_kontrak',
        'skema_akad',
        'nominal_modal',
        'persentase_bagi_hasil',
        'tenor_bulan',
        'periode_dividen',
        'signature_investor',
        'signature_umkm',
        'signed_at_investor',
        'signed_at_umkm',
        'status',
        'kode_keabsahan_qr',
    ];

    protected $casts = [
        'nominal_modal' => 'float',
        'persentase_bagi_hasil' => 'float',
        'tenor_bulan' => 'integer',
        'signed_at_investor' => 'datetime',
        'signed_at_umkm' => 'datetime',
    ];

    public function investasi(): BelongsTo
    {
        return $this->belongsTo(Investasi::class, 'id_investasi', 'id_investasi');
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'id_umkm', 'id_umkm');
    }

    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_investor', 'id');
    }

    public function getIsFullySignedAttribute(): bool
    {
        return !empty($this->signature_investor) && !empty($this->signature_umkm);
    }
}
