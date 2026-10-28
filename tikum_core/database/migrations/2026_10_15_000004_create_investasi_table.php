<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investasi', function (Blueprint $table) {
            $table->id('id_investasi');
            $table->foreignId('id_pengguna')
                ->constrained('users', 'id')
                ->onDelete('restrict');
            $table->unsignedBigInteger('id_umkm');
            $table->decimal('jumlah_modal', 15, 2);
            $table->decimal('persentase_bagi_hasil', 5, 2);
            $table->string('periode_pembagian', 20);
            $table->string('status', 20)->default('pending');
            $table->timestamp('tanggal_investasi')->useCurrent();
            $table->timestamps();

            $table->foreign('id_umkm')
                ->references('id_umkm')
                ->on('umkm')
                ->onDelete('restrict');

            $table->index('id_pengguna');
            $table->index('id_umkm');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investasi');
    }
};
