<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyedia_ruko', function (Blueprint $table) {
            $table->id('id_penyedia');
            $table->string('nama_perusahaan', 150);
            $table->string('kontak', 20);
            $table->text('alamat');
            $table->timestamps();

            $table->index('nama_perusahaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyedia_ruko');
    }
};
