<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan_umkm', function (Blueprint $table) {
            $table->id('id_ulasan');
            $table->unsignedBigInteger('id_umkm');
            $table->unsignedBigInteger('id_investor');
            $table->unsignedBigInteger('id_investasi');
            $table->unsignedTinyInteger('rating')->default(5); // 1-5 Bintang
            $table->unsignedTinyInteger('rating_transparansi')->default(5); // 1-5 Bintang
            $table->unsignedTinyInteger('rating_dividen')->default(5); // 1-5 Bintang
            $table->text('ulasan');
            $table->text('balasan_umkm')->nullable();
            $table->timestamp('tanggal_balasan')->nullable();
            $table->string('status', 20)->default('tayang');
            $table->timestamps();

            $table->foreign('id_umkm')->references('id_umkm')->on('umkm')->onDelete('cascade');
            $table->foreign('id_investor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_investasi')->references('id_investasi')->on('investasi')->onDelete('cascade');

            $table->unique('id_investasi');
            $table->index(['id_umkm', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan_umkm');
    }
};
