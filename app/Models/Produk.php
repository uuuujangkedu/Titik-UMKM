<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_umkm',
        'nama_produk',
        'harga',
        'stok',
        'status',
        'foto',
        'deskripsi',
        'terjual',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'terjual' => 'integer',
    ];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'id_umkm', 'id_umkm');
    }
}
