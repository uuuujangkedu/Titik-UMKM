<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bank_name', 50)->nullable()->after('kategori_diminati');
            $table->string('nomor_rekening', 50)->nullable()->after('bank_name');
            $table->string('nama_pemilik_rekening', 100)->nullable()->after('nomor_rekening');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'nomor_rekening', 'nama_pemilik_rekening']);
        });
    }
};
