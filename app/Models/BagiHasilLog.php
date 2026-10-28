<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BagiHasilLog extends Model
{
    protected $table = 'bagi_hasil_log';

    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_investasi',
        'tanggal_distribusi',
        'nominal_diterima',
        'bukti_transfer',
    ];

    protected $casts = [
        'nominal_diterima' => 'decimal:2',
        'tanggal_distribusi' => 'datetime',
    ];

    public function investasi(): BelongsTo
    {
        return $this->belongsTo(Investasi::class, 'id_investasi', 'id_investasi');
    }

    public function getBuktiTransferUrlAttribute(): ?string
    {
        if (empty($this->bukti_transfer)) {
            return null;
        }

        if (str_starts_with($this->bukti_transfer, 'http://') || str_starts_with($this->bukti_transfer, 'https://')) {
            return $this->bukti_transfer;
        }

        $cleanPath = ltrim($this->bukti_transfer, '/');
        if (str_starts_with($cleanPath, 'uploads/') || str_starts_with($cleanPath, 'images/')) {
            return asset($cleanPath);
        }

        if (str_starts_with($cleanPath, 'storage/')) {
            return asset($cleanPath);
        }

        if (file_exists(public_path($cleanPath))) {
            return asset($cleanPath);
        }

        return asset('storage/' . $cleanPath);
    }
}
