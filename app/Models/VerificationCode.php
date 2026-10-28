<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationCode extends Model
{
    protected $table = 'verification_codes';

    protected $primaryKey = 'id_verification';

    protected $fillable = [
        'user_id',
        'verification_type',
        'secret_code',
        'sent_to',
        'is_used',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'is_used' => 'boolean',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isValid(): bool
    {
        return ! $this->is_used && $this->expires_at->isFuture();
    }
}
