<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatatanKeuangan extends Model
{
    protected $table = 'catatan_keuangan';

    protected $primaryKey = 'id_keuangan';

    protected $fillable = [
        'id_umkm',
        'bulan_tahun',
        'pendapatan',
        'hpp',
        'beban_operasional',
        'beban_lain',
        'laba_bersih',
        'margin_laba',
        'status_laba',
        'foto_bukti',
        'catatan',
    ];

    protected $casts = [
        'pendapatan' => 'decimal:2',
        'hpp' => 'decimal:2',
        'beban_operasional' => 'decimal:2',
        'beban_lain' => 'decimal:2',
        'laba_bersih' => 'decimal:2',
        'margin_laba' => 'decimal:2',
    ];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'id_umkm', 'id_umkm');
    }
}
