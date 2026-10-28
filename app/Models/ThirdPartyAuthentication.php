<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThirdPartyAuthentication extends Model
{
    protected $table = 'third_party_authentications';

    protected $primaryKey = 'id_oauth';

    protected $fillable = [
        'user_id',
        'provider_name',
        'provider_user_id',
        'avatar_url',
        'connected_at',
    ];

    protected function casts(): array
    {
        return [
            'connected_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
