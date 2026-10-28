<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfluencerOrder extends Model
{
    use HasFactory;

    protected $table = 'influencer_orders';

    protected $fillable = [
        'kode_order',
        'influencer_id',
        'umkm_id',
        'investor_id',
        'pemesan_user_id',
        'tipe_inisiatif',
        'paket_konten',
        'biaya',
        'produk_id',
        'nama_campaign',
        'catatan_brief',
        'target_selesai',
        'status',
        'status_pembayaran',
        'bukti_transfer_pemesan',
        'bank_pengirim',
        'nama_pengirim',
        'nomor_rekening_pengirim',
        'waktu_transfer',
        'catatan_pembayaran',
        'alasan_penolakan',
        'link_bukti_konten',
        'screenshot_insight',
        'catatan_influencer',
        'rating',
        'ulasan',
    ];

    protected $casts = [
        'biaya' => 'float',
        'target_selesai' => 'date',
        'waktu_transfer' => 'datetime',
        'rating' => 'integer',
    ];

    public function getBuktiTransferPemesanUrlAttribute(): ?string
    {
        if (empty($this->bukti_transfer_pemesan)) {
            return null;
        }

        if (str_starts_with($this->bukti_transfer_pemesan, 'http://') || str_starts_with($this->bukti_transfer_pemesan, 'https://')) {
            return $this->bukti_transfer_pemesan;
        }

        $cleanPath = ltrim($this->bukti_transfer_pemesan, '/');

        return asset($cleanPath);
    }

    public function influencer(): BelongsTo
    {
        return $this->belongsTo(InfluencerProfile::class, 'influencer_id');
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'id_umkm');
    }

    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'investor_id');
    }

    public function pemesan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pemesan_user_id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id_produk');
    }

    public function getPaketLabelAttribute(): string
    {
        return match ($this->paket_konten) {
            'story' => 'Instagram Story Promo',
            'reels_tiktok' => 'Video TikTok / Reels Review',
            'visit_store' => 'Visit Toko / Ruko & Review Lengkap',
            'paket_komplit' => 'Paket Komplit (Visit + Video + Story)',
            default => ucfirst(str_replace('_', ' ', $this->paket_konten)),
        };
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'menunggu_persetujuan_investor' => ['label' => 'Menunggu Persetujuan Investor', 'color' => 'amber'],
            'menunggu_respon_influencer' => ['label' => 'Menunggu Respon Influencer', 'color' => 'blue'],
            'menunggu_pembayaran_escrow' => ['label' => 'Menunggu Pembayaran Escrow', 'color' => 'amber'],
            'sedang_dikerjakan' => ['label' => 'Sedang Diproduksi / Dikerjakan', 'color' => 'purple'],
            'menunggu_verifikasi' => ['label' => 'Konten Siap Verifikasi', 'color' => 'orange'],
            'selesai' => ['label' => 'Selesai & Tayang', 'color' => 'emerald'],
            'ditolak_investor' => ['label' => 'Ditolak Investor', 'color' => 'rose'],
            'ditolak_influencer' => ['label' => 'Ditolak Influencer', 'color' => 'rose'],
            'dibatalkan' => ['label' => 'Dibatalkan', 'color' => 'gray'],
            default => ['label' => ucfirst($this->status), 'color' => 'gray'],
        };
    }
}
