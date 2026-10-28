<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_sewa', function (Blueprint $table) {
            $table->id('id_sewa');
            $table->unsignedBigInteger('id_umkm');
            $table->unsignedBigInteger('id_ruko');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->decimal('total_harga', 12, 2);
            $table->string('status_pembayaran', 20)->default('pending');
            $table->timestamps();

            $table->foreign('id_umkm')
                ->references('id_umkm')
                ->on('umkm')
                ->onDelete('restrict');

            $table->foreign('id_ruko')
                ->references('id_ruko')
                ->on('ruko')
                ->onDelete('restrict');

            $table->index('id_umkm');
            $table->index('id_ruko');
            $table->index('status_pembayaran');
            $table->index(['id_ruko', 'tanggal_mulai', 'tanggal_selesai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_sewa');
    }
};
