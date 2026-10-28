<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogAktivitasAdmin extends Model
{
    protected $table = 'log_aktivitas_admin';

    protected $primaryKey = 'id_log_admin';

    protected $fillable = [
        'id_pengguna',
        'aksi',
        'detail_perubahan',
        'ip_address',
    ];

    protected $casts = [
        'detail_perubahan' => 'array',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id');
    }
}
