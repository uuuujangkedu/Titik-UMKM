<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teguran_dividen_log', function (Blueprint $table) {
            if (!Schema::hasColumn('teguran_dividen_log', 'status')) {
                $table->string('status', 30)->default('aktif')->after('pesan_teguran');
            }
            if (!Schema::hasColumn('teguran_dividen_log', 'catatan_penyelesaian')) {
                $table->text('catatan_penyelesaian')->nullable()->after('status');
            }
            if (!Schema::hasColumn('teguran_dividen_log', 'diselesaikan_pada')) {
                $table->timestamp('diselesaikan_pada')->nullable()->after('catatan_penyelesaian');
            }
            if (!Schema::hasColumn('teguran_dividen_log', 'diselesaikan_oleh')) {
                $table->unsignedBigInteger('diselesaikan_oleh')->nullable()->after('diselesaikan_pada');
            }
        });
    }

    public function down(): void
    {
        Schema::table('teguran_dividen_log', function (Blueprint $table) {
            $cols = ['status', 'catatan_penyelesaian', 'diselesaikan_pada', 'diselesaikan_oleh'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('teguran_dividen_log', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
