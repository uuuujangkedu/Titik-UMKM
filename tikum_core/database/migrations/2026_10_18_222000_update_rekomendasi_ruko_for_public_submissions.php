<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Modifikasi tabel rekomendasi_ruko
        if (Schema::hasTable('rekomendasi_ruko')) {
            // Ubah id_pengguna agar nullable (untuk pengusul publik yang tidak login)
            try {
                DB::statement("ALTER TABLE rekomendasi_ruko MODIFY id_pengguna BIGINT UNSIGNED NULL");
            } catch (\Throwable $e) {
                // Abaikan jika sudah nullable
            }

            Schema::table('rekomendasi_ruko', function (Blueprint $table) {
                if (!Schema::hasColumn('rekomendasi_ruko', 'nama_pengusul')) {
                    $table->string('nama_pengusul', 100)->nullable()->after('id_pengguna');
                }
                if (!Schema::hasColumn('rekomendasi_ruko', 'kontak_pengusul')) {
                    $table->string('kontak_pengusul', 50)->nullable()->after('nama_pengusul');
                }
                if (!Schema::hasColumn('rekomendasi_ruko', 'tipe_pengusul')) {
                    $table->string('tipe_pengusul', 20)->default('investor')->after('kontak_pengusul');
                }
                if (!Schema::hasColumn('rekomendasi_ruko', 'foto_ruko')) {
                    $table->string('foto_ruko', 255)->nullable()->after('lokasi');
                }
            });
        }

        // 2. Tambahkan kolom foto & potensi pada tabel ruko utama
        if (Schema::hasTable('ruko')) {
            Schema::table('ruko', function (Blueprint $table) {
                if (!Schema::hasColumn('ruko', 'foto_ruko')) {
                    $table->string('foto_ruko', 255)->nullable()->after('lokasi');
                }
                if (!Schema::hasColumn('ruko', 'deskripsi_potensi')) {
                    $table->text('deskripsi_potensi')->nullable()->after('foto_ruko');
                }
                if (!Schema::hasColumn('ruko', 'kontak_pemilik')) {
                    $table->string('kontak_pemilik', 50)->nullable()->after('deskripsi_potensi');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('rekomendasi_ruko')) {
            Schema::table('rekomendasi_ruko', function (Blueprint $table) {
                $columns = ['nama_pengusul', 'kontak_pengusul', 'tipe_pengusul', 'foto_ruko'];
                foreach ($columns as $col) {
                    if (Schema::hasColumn('rekomendasi_ruko', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('ruko')) {
            Schema::table('ruko', function (Blueprint $table) {
                $columns = ['foto_ruko', 'deskripsi_potensi', 'kontak_pemilik'];
                foreach ($columns as $col) {
                    if (Schema::hasColumn('ruko', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
