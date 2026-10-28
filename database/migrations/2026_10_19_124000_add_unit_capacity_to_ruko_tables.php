<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kapasitas unit pada tabel ruko
        if (Schema::hasTable('ruko')) {
            Schema::table('ruko', function (Blueprint $table) {
                if (!Schema::hasColumn('ruko', 'total_unit')) {
                    $table->unsignedInteger('total_unit')->default(1)->after('harga_sewa_per_bulan');
                }
                if (!Schema::hasColumn('ruko', 'unit_terisi')) {
                    $table->unsignedInteger('unit_terisi')->default(0)->after('total_unit');
                }
            });
        }

        // 2. Tambah kapasitas unit pada tabel rekomendasi_ruko
        if (Schema::hasTable('rekomendasi_ruko')) {
            Schema::table('rekomendasi_ruko', function (Blueprint $table) {
                if (!Schema::hasColumn('rekomendasi_ruko', 'total_unit')) {
                    $table->unsignedInteger('total_unit')->default(1)->after('harga_sewa_per_bulan');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('ruko')) {
            Schema::table('ruko', function (Blueprint $table) {
                if (Schema::hasColumn('ruko', 'unit_terisi')) {
                    $table->dropColumn('unit_terisi');
                }
                if (Schema::hasColumn('ruko', 'total_unit')) {
                    $table->dropColumn('total_unit');
                }
            });
        }

        if (Schema::hasTable('rekomendasi_ruko')) {
            Schema::table('rekomendasi_ruko', function (Blueprint $table) {
                if (Schema::hasColumn('rekomendasi_ruko', 'total_unit')) {
                    $table->dropColumn('total_unit');
                }
            });
        }
    }
};
