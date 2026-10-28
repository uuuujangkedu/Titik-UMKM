<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'provinsi_kota')) {
                $table->string('provinsi_kota', 100)->nullable()->after('phone_number');
            }
            if (! Schema::hasColumn('users', 'kecamatan')) {
                $table->string('kecamatan', 100)->nullable()->after('provinsi_kota');
            }
            if (! Schema::hasColumn('users', 'kelurahan')) {
                $table->string('kelurahan', 100)->nullable()->after('kecamatan');
            }
            if (! Schema::hasColumn('users', 'kategori_diminati')) {
                $table->string('kategori_diminati', 100)->nullable()->after('role');
            }
        });

        Schema::table('umkm', function (Blueprint $table) {
            if (! Schema::hasColumn('umkm', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id_umkm')->constrained('users')->cascadeOnDelete();
            }
            if (! Schema::hasColumn('umkm', 'nomor_whatsapp')) {
                $table->string('nomor_whatsapp', 25)->nullable()->after('pemilik');
            }
            if (! Schema::hasColumn('umkm', 'provinsi_kota')) {
                $table->string('provinsi_kota', 100)->nullable()->after('nomor_whatsapp');
            }
            if (! Schema::hasColumn('umkm', 'kecamatan')) {
                $table->string('kecamatan', 100)->nullable()->after('provinsi_kota');
            }
            if (! Schema::hasColumn('umkm', 'kelurahan')) {
                $table->string('kelurahan', 100)->nullable()->after('kecamatan');
            }
            if (! Schema::hasColumn('umkm', 'foto_produk')) {
                $table->string('foto_produk', 255)->nullable()->after('deskripsi');
            }
            if (! Schema::hasColumn('umkm', 'file_proposal')) {
                $table->string('file_proposal', 255)->nullable()->after('foto_produk');
            }
            if (! Schema::hasColumn('umkm', 'id_ruko_diminati')) {
                $table->unsignedBigInteger('id_ruko_diminati')->nullable()->after('file_proposal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_filter([
                Schema::hasColumn('users', 'provinsi_kota') ? 'provinsi_kota' : null,
                Schema::hasColumn('users', 'kecamatan') ? 'kecamatan' : null,
                Schema::hasColumn('users', 'kelurahan') ? 'kelurahan' : null,
                Schema::hasColumn('users', 'kategori_diminati') ? 'kategori_diminati' : null,
            ]));
        });

        Schema::table('umkm', function (Blueprint $table) {
            if (Schema::hasColumn('umkm', 'user_id')) {
                $table->dropForeign(['user_id']);
            }
            $table->dropColumn(array_filter([
                Schema::hasColumn('umkm', 'user_id') ? 'user_id' : null,
                Schema::hasColumn('umkm', 'nomor_whatsapp') ? 'nomor_whatsapp' : null,
                Schema::hasColumn('umkm', 'provinsi_kota') ? 'provinsi_kota' : null,
                Schema::hasColumn('umkm', 'kecamatan') ? 'kecamatan' : null,
                Schema::hasColumn('umkm', 'kelurahan') ? 'kelurahan' : null,
                Schema::hasColumn('umkm', 'foto_produk') ? 'foto_produk' : null,
                Schema::hasColumn('umkm', 'file_proposal') ? 'file_proposal' : null,
                Schema::hasColumn('umkm', 'id_ruko_diminati') ? 'id_ruko_diminati' : null,
            ]));
        });
    }
};
