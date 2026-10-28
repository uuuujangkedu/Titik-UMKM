<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkm', function (Blueprint $table) {
            if (! Schema::hasColumn('umkm', 'status_pengajuan')) {
                $table->string('status_pengajuan', 30)->default('draf')->after('id_ruko_diminati');
            }
            if (! Schema::hasColumn('umkm', 'modal_dibutuhkan')) {
                $table->decimal('modal_dibutuhkan', 15, 2)->nullable()->after('status_pengajuan');
            }
            if (! Schema::hasColumn('umkm', 'estimasi_bagi_hasil')) {
                $table->string('estimasi_bagi_hasil', 50)->nullable()->after('modal_dibutuhkan');
            }
            if (! Schema::hasColumn('umkm', 'nik_penanggung_jawab')) {
                $table->string('nik_penanggung_jawab', 30)->nullable()->after('pemilik');
            }
        });
    }

    public function down(): void
    {
        Schema::table('umkm', function (Blueprint $table) {
            $table->dropColumn(array_filter([
                Schema::hasColumn('umkm', 'status_pengajuan') ? 'status_pengajuan' : null,
                Schema::hasColumn('umkm', 'modal_dibutuhkan') ? 'modal_dibutuhkan' : null,
                Schema::hasColumn('umkm', 'estimasi_bagi_hasil') ? 'estimasi_bagi_hasil' : null,
                Schema::hasColumn('umkm', 'nik_penanggung_jawab') ? 'nik_penanggung_jawab' : null,
            ]));
        });
    }
};
