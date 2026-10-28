<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UlasanUmkm extends Model
{
    protected $table = 'ulasan_umkm';

    protected $primaryKey = 'id_ulasan';

    protected $fillable = [
        'id_umkm',
        'id_investor',
        'id_investasi',
        'rating',
        'rating_transparansi',
        'rating_dividen',
        'ulasan',
        'balasan_umkm',
        'tanggal_balasan',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
        'rating_transparansi' => 'integer',
        'rating_dividen' => 'integer',
        'tanggal_balasan' => 'datetime',
    ];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'id_umkm', 'id_umkm');
    }

    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_investor', 'id');
    }

    public function investasi(): BelongsTo
    {
        return $this->belongsTo(Investasi::class, 'id_investasi', 'id_investasi');
    }

    /**
     * Nama investor yang disamarkan sebagian untuk privasi finansial
     * Contoh: Budi Santoso -> Budi S***, Zidan -> Zi***
     */
    public function getNamaInvestorTersensorAttribute(): string
    {
        $fullName = trim($this->investor->name ?? 'Mitra Investor');
        $parts = preg_split('/\s+/', $fullName);
        if (count($parts) > 1) {
            $firstName = $parts[0];
            $initial = strtoupper(substr($parts[1], 0, 1));
            return "{$firstName} {$initial}***";
        }

        $len = strlen($fullName);
        if ($len > 3) {
            return substr($fullName, 0, 2) . '***';
        } elseif ($len > 1) {
            return substr($fullName, 0, 1) . '***';
        }

        return $fullName;
    }
}
