<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bagi_hasil_log', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_investasi');
            $table->timestamp('tanggal_distribusi');
            $table->decimal('nominal_diterima', 15, 2);
            $table->string('bukti_transfer', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_investasi')
                ->references('id_investasi')
                ->on('investasi')
                ->onDelete('cascade');

            $table->index('id_investasi');
            $table->index('tanggal_distribusi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bagi_hasil_log');
    }
};
