<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeguranDividenLog extends Model
{
    protected $table = 'teguran_dividen_log';

    protected $primaryKey = 'id_teguran';

    protected $fillable = [
        'id_investasi',
        'id_umkm',
        'tingkat_sp',
        'pesan_teguran',
        'dikirim_oleh',
        'status',
        'catatan_penyelesaian',
        'diselesaikan_pada',
        'diselesaikan_oleh',
    ];

    protected $casts = [
        'diselesaikan_pada' => 'datetime',
    ];

    public function investasi(): BelongsTo
    {
        return $this->belongsTo(Investasi::class, 'id_investasi', 'id_investasi');
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'id_umkm', 'id_umkm');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dikirim_oleh', 'id');
    }

    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diselesaikan_oleh', 'id');
    }
}
