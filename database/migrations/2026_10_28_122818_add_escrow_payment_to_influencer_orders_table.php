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
        Schema::table('influencer_orders', function (Blueprint $table) {
            $table->string('status_pembayaran', 30)->default('belum_bayar')->after('status');
            $table->string('bukti_transfer_pemesan', 255)->nullable()->after('status_pembayaran');
            $table->string('bank_pengirim', 50)->nullable()->after('bukti_transfer_pemesan');
            $table->string('nama_pengirim', 100)->nullable()->after('bank_pengirim');
            $table->string('nomor_rekening_pengirim', 50)->nullable()->after('nama_pengirim');
            $table->timestamp('waktu_transfer')->nullable()->after('nomor_rekening_pengirim');
            $table->text('catatan_pembayaran')->nullable()->after('waktu_transfer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('influencer_orders', function (Blueprint $table) {
            $table->dropColumn([
                'status_pembayaran',
                'bukti_transfer_pemesan',
                'bank_pengirim',
                'nama_pengirim',
                'nomor_rekening_pengirim',
                'waktu_transfer',
                'catatan_pembayaran',
            ]);
        });
    }
};
