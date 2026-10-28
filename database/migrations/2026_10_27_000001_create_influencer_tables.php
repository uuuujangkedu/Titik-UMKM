<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('influencer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_panggung', 150);
            $table->string('kategori', 50)->default('Kuliner'); // Kuliner, Fashion, Kecantikan, Lifestyle, Teknologi, Jasa, UMKM & Bisnis
            $table->text('bio')->nullable();
            $table->string('kota', 100);
            $table->string('provinsi', 100)->nullable();
            $table->string('username_instagram', 100)->nullable();
            $table->string('username_tiktok', 100)->nullable();
            $table->string('username_youtube', 100)->nullable();
            $table->unsignedInteger('followers_count')->default(0);
            $table->decimal('rate_story', 15, 2)->default(50000);
            $table->decimal('rate_reels_tiktok', 15, 2)->default(150000);
            $table->decimal('rate_visit_store', 15, 2)->default(300000);
            $table->string('sample_video_url_1', 255)->nullable();
            $table->string('sample_video_url_2', 255)->nullable();
            $table->string('status_verifikasi', 30)->default('terverifikasi'); // terverifikasi, menunggu_verifikasi, ditolak
            $table->boolean('is_available')->default(true);
            $table->unsignedInteger('total_selesai')->default(0);
            $table->decimal('saldo', 15, 2)->default(0);
            $table->string('bank_name', 50)->nullable();
            $table->string('nomor_rekening', 50)->nullable();
            $table->string('nama_rekening', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('influencer_orders', function (Blueprint $table) {
            $table->id();
            $table->string('kode_order', 50)->unique();
            $table->foreignId('influencer_id')->constrained('influencer_profiles')->cascadeOnDelete();
            $table->unsignedBigInteger('umkm_id');
            $table->foreign('umkm_id')->references('id_umkm')->on('umkm')->cascadeOnDelete();
            $table->foreignId('investor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('pemesan_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('tipe_inisiatif', 40); // mandiri_umkm, sponsor_investor_langsung, pengajuan_sponsor_umkm
            $table->string('paket_konten', 50); // story, reels_tiktok, visit_store, paket_komplit
            $table->decimal('biaya', 15, 2)->default(0);
            $table->unsignedBigInteger('produk_id')->nullable();
            $table->foreign('produk_id')->references('id_produk')->on('produk')->nullOnDelete();
            $table->string('nama_campaign', 200);
            $table->text('catatan_brief');
            $table->date('target_selesai')->nullable();
            $table->string('status', 40)->default('menunggu_respon_influencer');
            $table->text('alasan_penolakan')->nullable();
            $table->string('link_bukti_konten', 255)->nullable();
            $table->string('screenshot_insight', 255)->nullable();
            $table->text('catatan_influencer')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->text('ulasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('influencer_orders');
        Schema::dropIfExists('influencer_profiles');
    }
};
