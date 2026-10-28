<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_sewa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_investor')->nullable()->after('id_umkm');
            $table->text('catatan_sponsor')->nullable()->after('status_pembayaran');

            $table->foreign('id_investor')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->index('id_investor');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_sewa', function (Blueprint $table) {
            $table->dropForeign(['id_investor']);
            $table->dropIndex(['id_investor']);
            $table->dropColumn(['id_investor', 'catatan_sponsor']);
        });
    }
};
