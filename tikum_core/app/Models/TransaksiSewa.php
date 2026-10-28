<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiSewa extends Model
{
    protected $table = 'transaksi_sewa';

    protected $primaryKey = 'id_sewa';

    protected $fillable = [
        'id_umkm',
        'id_investor',
        'id_ruko',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status_pembayaran',
        'catatan_sponsor',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'total_harga' => 'decimal:2',
    ];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'id_umkm', 'id_umkm');
    }

    public function ruko(): BelongsTo
    {
        return $this->belongsTo(Ruko::class, 'id_ruko', 'id_ruko');
    }

    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_investor', 'id');
    }
}
