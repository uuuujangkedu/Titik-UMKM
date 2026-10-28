<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekomendasiRuko extends Model
{
    protected $table = 'rekomendasi_ruko';

    protected $primaryKey = 'id_rekomendasi';

    protected $fillable = [
        'id_pengguna',
        'nama_pengusul',
        'kontak_pengusul',
        'tipe_pengusul',
        'nama_ruko',
        'lokasi',
        'foto_ruko',
        'harga_sewa_per_bulan',
        'total_unit',
        'potensi_usaha',
        'kontak_pemilik',
        'siap_danai',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'harga_sewa_per_bulan' => 'decimal:2',
        'total_unit' => 'integer',
        'siap_danai' => 'boolean',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id');
    }

    /**
     * Label representasi pengusul (Investor, UMKM, atau Publik)
     */
    public function getLabelPengusulAttribute(): string
    {
        if ($this->tipe_pengusul === 'investor') {
            return 'Mitra Investor: ' . ($this->pengguna->name ?? $this->nama_pengusul ?? 'Investor');
        } elseif ($this->tipe_pengusul === 'umkm') {
            return 'Pelaku UMKM: ' . ($this->pengguna->name ?? $this->nama_pengusul ?? 'Mitra UMKM');
        } else {
            return 'Publik / Pemilik: ' . ($this->nama_pengusul ?? 'Warga / Agen Properti');
        }
    }
}
