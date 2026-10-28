<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesanInvestasi extends Model
{
    protected $table = 'pesan_investasi';

    protected $primaryKey = 'id_pesan';

    protected $fillable = [
        'id_investasi',
        'id_pengirim',
        'pesan',
        'lampiran',
        'dibaca',
    ];

    protected $casts = [
        'dibaca' => 'boolean',
    ];

    public function investasi(): BelongsTo
    {
        return $this->belongsTo(Investasi::class, 'id_investasi', 'id_investasi');
    }

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pengirim', 'id');
    }
}
