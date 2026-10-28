<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Umkm extends Model
{
    protected $table = 'umkm';

    protected $primaryKey = 'id_umkm';

    protected $fillable = [
        'user_id',
        'nama_usaha',
        'jenis_usaha',
        'pemilik',
        'nik_penanggung_jawab',
        'nomor_whatsapp',
        'provinsi',
        'kota',
        'provinsi_kota',
        'kecamatan',
        'kelurahan',
        'rt',
        'rw',
        'deskripsi',
        'foto_produk',
        'file_proposal',
        'id_ruko_diminati',
        'status_pengajuan',
        'modal_dibutuhkan',
        'estimasi_bagi_hasil',
        'status_kepatuhan_dividen',
        'jumlah_teguran_sp',
        'teguran_sp_terakhir',
        'catatan_pembekuan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ruko()
    {
        return $this->belongsTo(Ruko::class, 'id_ruko_diminati', 'id_ruko');
    }

    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class, 'id_umkm', 'id_umkm');
    }

    public function investasi(): HasMany
    {
        return $this->hasMany(Investasi::class, 'id_umkm', 'id_umkm');
    }

    public function transaksiSewa(): HasMany
    {
        return $this->hasMany(TransaksiSewa::class, 'id_umkm', 'id_umkm');
    }

    public function catatanKeuangan(): HasMany
    {
        return $this->hasMany(CatatanKeuangan::class, 'id_umkm', 'id_umkm');
    }

    public function ulasanUmkm(): HasMany
    {
        return $this->hasMany(UlasanUmkm::class, 'id_umkm', 'id_umkm')->where('status', 'tayang');
    }

    /**
     * Rating rata-rata dari seluruh investor terverifikasi (skala 1-5)
     */
    public function getRatingRataRataAttribute(): float
    {
        $avg = $this->ulasanUmkm()->avg('rating');

        return $avg ? round((float) $avg, 1) : 0.0;
    }

    /**
     * Total ulasan terverifikasi yang diterima
     */
    public function getTotalUlasanAttribute(): int
    {
        return $this->ulasanUmkm()->count();
    }

    public function klarifikasiDividen(): HasMany
    {
        return $this->hasMany(KlarifikasiDividen::class, 'id_umkm', 'id_umkm')->latest();
    }

    public function teguranDividen(): HasMany
    {
        return $this->hasMany(TeguranDividenLog::class, 'id_umkm', 'id_umkm')->latest();
    }

    /**
     * URL Foto produk atau profil usaha UMKM
     */
    public function getFotoUrlAttribute(): string
    {
        if (! empty($this->foto_produk)) {
            if (str_starts_with($this->foto_produk, 'http://') || str_starts_with($this->foto_produk, 'https://')) {
                return $this->foto_produk;
            }
            if (file_exists(public_path(ltrim($this->foto_produk, '/\\')))) {
                return asset(ltrim($this->foto_produk, '/\\'));
            }
            if (file_exists(storage_path('app/public/'.ltrim($this->foto_produk, '/\\')))) {
                return asset('storage/'.ltrim($this->foto_produk, '/\\'));
            }
        }

        $nameLower = mb_strtolower($this->nama_usaha ?? '', 'UTF-8');
        if (str_contains($nameLower, 'kopi')) {
            return 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=600&q=80';
        }
        if (str_contains($nameLower, 'sepatu') || str_contains($nameLower, 'laundry')) {
            return 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=600&q=80';
        }
        if (str_contains($nameLower, 'batik') || str_contains($nameLower, 'tenun')) {
            return 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=600&q=80';
        }
        if (str_contains($nameLower, 'sayur') || str_contains($nameLower, 'hidroponik')) {
            return 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=600&q=80';
        }

        $categoryDefaults = [
            'Makanan' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80',
            'Minuman' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=600&q=80',
            'Jasa' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=600&q=80',
            'Fashion' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=600&q=80',
            'Agribisnis' => 'https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?auto=format&fit=crop&w=600&q=80',
        ];

        return $categoryDefaults[$this->jenis_usaha] ?? 'https://images.unsplash.com/photo-1472851294608-062f824d29cc?auto=format&fit=crop&w=600&q=80';
    }

    public function influencerOrders(): HasMany
    {
        return $this->hasMany(InfluencerOrder::class, 'umkm_id', 'id_umkm');
    }

    public function getTotalModalTerkumpulAttribute(): float
    {
        return (float) $this->investasi()->whereIn('status', ['aktif', 'pending'])->sum('jumlah_modal');
    }

    public function getJumlahInvestorSindikasiAttribute(): int
    {
        return $this->investasi()->whereIn('status', ['aktif', 'pending'])->distinct('id_pengguna')->count('id_pengguna');
    }

    public function getTargetPendanaanFinalAttribute(): float
    {
        return (float) ($this->modal_dibutuhkan ?: ($this->target_pendanaan ?? 25000000));
    }

    public function getPersentaseSindikasiAttribute(): float
    {
        $target = $this->target_pendanaan_final;
        if ($target <= 0) return 0.0;
        $pct = ($this->total_modal_terkumpul / $target) * 100;
        return round(min(100, $pct), 1);
    }

    public function getSisaKebutuhanModalAttribute(): float
    {
        return max(0, $this->target_pendanaan_final - $this->total_modal_terkumpul);
    }
}
