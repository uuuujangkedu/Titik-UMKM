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
        Schema::create('kontrak_investasi', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kontrak', 100)->unique();
            $table->unsignedBigInteger('id_investasi');
            $table->foreign('id_investasi')->references('id_investasi')->on('investasi')->cascadeOnDelete();
            $table->unsignedBigInteger('id_umkm');
            $table->foreign('id_umkm')->references('id_umkm')->on('umkm')->cascadeOnDelete();
            $table->foreignId('id_investor')->constrained('users')->cascadeOnDelete();
            $table->string('judul_kontrak', 255)->default('Perjanjian Kemitraan Modal & Bagi Hasil Sektor Riil');
            $table->string('skema_akad', 50)->default('Musyarakah (Bagi Hasil)');
            $table->decimal('nominal_modal', 15, 2);
            $table->decimal('persentase_bagi_hasil', 5, 2);
            $table->unsignedInteger('tenor_bulan')->default(12);
            $table->string('periode_dividen', 50)->default('Bulanan');
            $table->longText('signature_investor')->nullable();
            $table->longText('signature_umkm')->nullable();
            $table->timestamp('signed_at_investor')->nullable();
            $table->timestamp('signed_at_umkm')->nullable();
            $table->string('status', 40)->default('aktif_sah'); // draft, menunggu_tanda_tangan_umkm, aktif_sah, selesai
            $table->string('kode_keabsahan_qr', 64)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak_investasi');
    }
};
