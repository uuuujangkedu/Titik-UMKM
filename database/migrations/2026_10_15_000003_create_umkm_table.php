<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkm', function (Blueprint $table) {
            $table->id('id_umkm');
            $table->string('nama_usaha', 150);
            $table->string('jenis_usaha', 100);
            $table->string('pemilik', 100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->index('jenis_usaha');
            $table->index('nama_usaha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};
