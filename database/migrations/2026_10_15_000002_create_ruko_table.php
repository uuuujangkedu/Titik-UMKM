<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ruko', function (Blueprint $table) {
            $table->id('id_ruko');
            $table->unsignedBigInteger('id_penyedia');
            $table->string('nama_ruko', 100);
            $table->text('lokasi');
            $table->decimal('harga_sewa_per_bulan', 12, 2);
            $table->string('status_ketersediaan', 20)->default('tersedia');
            $table->timestamps();

            $table->foreign('id_penyedia')
                ->references('id_penyedia')
                ->on('penyedia_ruko')
                ->onDelete('restrict');

            $table->index('status_ketersediaan');
            $table->index('id_penyedia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ruko');
    }
};
