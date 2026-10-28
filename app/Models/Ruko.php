<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruko extends Model
{
    protected $table = 'ruko';

    protected $primaryKey = 'id_ruko';

    protected $fillable = [
        'id_penyedia',
        'nama_ruko',
        'lokasi',
        'foto_ruko',
        'deskripsi_potensi',
        'kontak_pemilik',
        'harga_sewa_per_bulan',
        'total_unit',
        'unit_terisi',
        'status_ketersediaan',
    ];

    protected $casts = [
        'harga_sewa_per_bulan' => 'decimal:2',
        'total_unit' => 'integer',
        'unit_terisi' => 'integer',
    ];

    /**
     * Hitung sisa unit yang masih kosong / belum diisi
     */
    public function getSisaUnitAttribute(): int
    {
        $total = max(1, (int) ($this->total_unit ?? 1));
        $terisi = max(0, (int) ($this->unit_terisi ?? 0));

        return max(0, $total - $terisi);
    }

    /**
     * Cek apakah ruko sudah penuh terisi
     */
    public function getIsPenuhAttribute(): bool
    {
        return $this->sisa_unit <= 0 || $this->status_ketersediaan === 'tersewa';
    }

    /**
     * Status deskriptif: Kosong, Terisi Sebagian, atau Sudah Diisi
     */
    public function getStatusDisplayAttribute(): string
    {
        if ($this->is_penuh) {
            return 'Sudah Diisi (Penuh)';
        } elseif (($this->unit_terisi ?? 0) > 0) {
            return 'Terisi Sebagian';
        }

        return 'Kosong (Siap Huni)';
    }

    /**
     * Class CSS badge warna berdasarkan status ketersediaan
     */
    public function getStatusBadgeClassAttribute(): string
    {
        if ($this->is_penuh) {
            return 'bg-rose-50 text-rose-700 border-rose-200';
        } elseif (($this->unit_terisi ?? 0) > 0) {
            return 'bg-amber-50 text-amber-800 border-amber-200';
        }

        return 'bg-emerald-50 text-emerald-800 border-emerald-200';
    }

    /**
     * Skor Rating Kelayakan Lokasi & Potensi Komersial (skala 1 - 5)
     */
    public function getRatingLokasiAttribute(): float
    {
        $ratings = [
            1 => 4.9,
            2 => 4.8,
            3 => 4.9,
            4 => 4.7,
            5 => 4.6,
            6 => 4.8,
            7 => 4.7,
            8 => 4.8,
            9 => 4.7,
        ];

        return $ratings[$this->id_ruko] ?? 4.8;
    }

    public function penyedia(): BelongsTo
    {
        return $this->belongsTo(PenyediaRuko::class, 'id_penyedia', 'id_penyedia');
    }

    public function transaksiSewa(): HasMany
    {
        return $this->hasMany(TransaksiSewa::class, 'id_ruko', 'id_ruko');
    }

    /**
     * URL Foto fisik ruko komersial
     */
    public function getFotoUrlAttribute(): string
    {
        if (! empty($this->foto_ruko)) {
            if (str_starts_with($this->foto_ruko, 'http://') || str_starts_with($this->foto_ruko, 'https://')) {
                return $this->foto_ruko;
            }
            $clean = ltrim($this->foto_ruko, '/\\');
            if (file_exists(public_path($clean))) {
                return asset($clean);
            }
            if (file_exists(storage_path('app/public/'.$clean))) {
                return asset('storage/'.$clean);
            }

            return asset($clean);
        }

        // Foto ruko komersial modern berkualitas tinggi untuk tiap ruko
        $defaults = [
            1 => 'https://images.unsplash.com/photo-1541123437800-1bb1317badc2?auto=format&fit=crop&w=600&q=80',
            2 => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=600&q=80',
            3 => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=600&q=80',
            4 => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=600&q=80',
            5 => 'https://images.unsplash.com/photo-1582037928769-181f2644ecb7?auto=format&fit=crop&w=600&q=80',
            6 => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=600&q=80',
        ];

        return $defaults[$this->id_ruko] ?? 'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=600&q=80';
    }
}
