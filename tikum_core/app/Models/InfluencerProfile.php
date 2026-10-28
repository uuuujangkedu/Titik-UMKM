<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InfluencerProfile extends Model
{
    use HasFactory;

    protected $table = 'influencer_profiles';

    protected $fillable = [
        'user_id',
        'nama_panggung',
        'kategori',
        'bio',
        'kota',
        'provinsi',
        'username_instagram',
        'username_tiktok',
        'username_youtube',
        'followers_count',
        'rate_story',
        'rate_reels_tiktok',
        'rate_visit_store',
        'sample_video_url_1',
        'sample_video_url_2',
        'status_verifikasi',
        'is_available',
        'total_selesai',
        'saldo',
        'bank_name',
        'nomor_rekening',
        'nama_rekening',
    ];

    protected $casts = [
        'rate_story' => 'float',
        'rate_reels_tiktok' => 'float',
        'rate_visit_store' => 'float',
        'saldo' => 'float',
        'is_available' => 'boolean',
        'followers_count' => 'integer',
        'total_selesai' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(InfluencerOrder::class, 'influencer_id');
    }

    public function getAverageRatingAttribute(): float
    {
        $avg = $this->orders()->whereNotNull('rating')->avg('rating');
        return $avg ? round((float) $avg, 1) : 5.0;
    }

    public function getTotalReviewsAttribute(): int
    {
        return $this->orders()->whereNotNull('rating')->count();
    }
}
