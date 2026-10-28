<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_aktivitas_admin', function (Blueprint $table) {
            $table->id('id_log_admin');
            $table->foreignId('id_pengguna')
                ->constrained('users', 'id')
                ->onDelete('restrict');
            $table->string('aksi', 100);
            $table->text('detail_perubahan')->nullable();
            $table->string('ip_address', 45);
            $table->timestamps();

            $table->index('id_pengguna');
            $table->index('aksi');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas_admin');
    }
};
