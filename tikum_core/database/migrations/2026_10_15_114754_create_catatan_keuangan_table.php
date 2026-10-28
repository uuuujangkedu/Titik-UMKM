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
        Schema::create('catatan_keuangan', function (Blueprint $table) {
            $table->id('id_keuangan');
            $table->unsignedBigInteger('id_umkm');
            $table->string('bulan_tahun', 50);
            $table->decimal('pendapatan', 15, 2)->default(0);
            $table->decimal('hpp', 15, 2)->default(0);
            $table->decimal('beban_operasional', 15, 2)->default(0);
            $table->decimal('beban_lain', 15, 2)->default(0);
            $table->decimal('laba_bersih', 15, 2)->default(0);
            $table->decimal('margin_laba', 6, 2)->default(0);
            $table->string('status_laba', 20)->default('untung');
            $table->string('foto_bukti')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_umkm')->references('id_umkm')->on('umkm')->onDelete('cascade');
            $table->index('id_umkm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_keuangan');
    }
};
