<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenyediaRuko extends Model
{
    protected $table = 'penyedia_ruko';

    protected $primaryKey = 'id_penyedia';

    protected $fillable = [
        'nama_perusahaan',
        'kontak',
        'alamat',
    ];

    public function ruko(): HasMany
    {
        return $this->hasMany(Ruko::class, 'id_penyedia', 'id_penyedia');
    }
}
