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
        Schema::create('pesan_investasi', function (Blueprint $table) {
            $table->id('id_pesan');
            $table->unsignedBigInteger('id_investasi');
            $table->unsignedBigInteger('id_pengirim');
            $table->text('pesan');
            $table->string('lampiran', 255)->nullable();
            $table->boolean('dibaca')->default(false);
            $table->timestamps();

            $table->foreign('id_investasi')
                ->references('id_investasi')
                ->on('investasi')
                ->onDelete('cascade');

            $table->foreign('id_pengirim')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->index('id_investasi');
            $table->index('id_pengirim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan_investasi');
    }
};
