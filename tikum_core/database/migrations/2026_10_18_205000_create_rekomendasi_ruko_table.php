<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekomendasi_ruko', function (Blueprint $table) {
            $table->id('id_rekomendasi');
            $table->unsignedBigInteger('id_pengguna');
            $table->string('nama_ruko', 100);
            $table->text('lokasi');
            $table->decimal('harga_sewa_per_bulan', 12, 2);
            $table->text('potensi_usaha')->nullable();
            $table->string('kontak_pemilik', 50)->nullable();
            $table->boolean('siap_danai')->default(true);
            $table->string('status', 30)->default('menunggu_verifikasi');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->foreign('id_pengguna')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->index('id_pengguna');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_ruko');
    }
};
