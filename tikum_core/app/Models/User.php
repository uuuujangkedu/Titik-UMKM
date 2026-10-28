<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'provinsi',
        'kota',
        'provinsi_kota',
        'kecamatan',
        'kelurahan',
        'rt',
        'rw',
        'kategori_diminati',
        'password',
        'role',
        'email_verified_at',
        'phone_verified_at',
        'status',
        'avatar_url',
        'bank_name',
        'nomor_rekening',
        'nama_pemilik_rekening',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // ponytail: izinkan admin & super_admin. upgrade: tambah check permission spathie jika skala membesar.
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function thirdPartyAuthentications(): HasMany
    {
        return $this->hasMany(ThirdPartyAuthentication::class, 'user_id');
    }

    public function verificationCodes(): HasMany
    {
        return $this->hasMany(VerificationCode::class, 'user_id');
    }

    public function isEmailVerified(): bool
    {
        return ! is_null($this->email_verified_at);
    }

    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }

    public function getAvatarAttribute(): ?string
    {
        if (empty($this->avatar_url)) {
            return null;
        }

        $url = trim($this->avatar_url);

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, '//') || str_starts_with($url, 'data:image')) {
            return $url;
        }

        if (str_starts_with($url, 'storage/')) {
            return asset($url);
        }

        if (str_starts_with($url, 'images/') || str_starts_with($url, 'img/')) {
            return asset($url);
        }

        if (file_exists(public_path($url))) {
            return asset($url);
        }

        return asset('storage/'.ltrim($url, '/'));
    }

    public function umkm(): HasOne
    {
        return $this->hasOne(Umkm::class, 'user_id');
    }

    public function investasis(): HasMany
    {
        return $this->hasMany(Investasi::class, 'id_pengguna', 'id');
    }

    public function rekomendasiRukos(): HasMany
    {
        return $this->hasMany(RekomendasiRuko::class, 'id_pengguna', 'id');
    }

    public function sewaDisponsori(): HasMany
    {
        return $this->hasMany(TransaksiSewa::class, 'id_investor', 'id');
    }

    public function ulasanDiberikan(): HasMany
    {
        return $this->hasMany(UlasanUmkm::class, 'id_investor', 'id');
    }

    public function influencerProfile(): HasOne
    {
        return $this->hasOne(InfluencerProfile::class, 'user_id');
    }

    public function influencerOrdersAsInvestor(): HasMany
    {
        return $this->hasMany(InfluencerOrder::class, 'investor_id');
    }
}
