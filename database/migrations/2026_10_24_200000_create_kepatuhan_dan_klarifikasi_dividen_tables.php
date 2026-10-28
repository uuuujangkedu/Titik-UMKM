<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom kepatuhan dividen pada tabel umkm
        Schema::table('umkm', function (Blueprint $table) {
            if (!Schema::hasColumn('umkm', 'status_kepatuhan_dividen')) {
                $table->string('status_kepatuhan_dividen', 30)->default('lancar')->after('status_pengajuan');
            }
            if (!Schema::hasColumn('umkm', 'jumlah_teguran_sp')) {
                $table->unsignedInteger('jumlah_teguran_sp')->default(0)->after('status_kepatuhan_dividen');
            }
            if (!Schema::hasColumn('umkm', 'teguran_sp_terakhir')) {
                $table->timestamp('teguran_sp_terakhir')->nullable()->after('jumlah_teguran_sp');
            }
            if (!Schema::hasColumn('umkm', 'catatan_pembekuan')) {
                $table->text('catatan_pembekuan')->nullable()->after('teguran_sp_terakhir');
            }
        });

        // 2. Tabel Klarifikasi Dividen (Saat UMKM mengalami kendala arus kas / omzet turun)
        Schema::create('klarifikasi_dividen', function (Blueprint $table) {
            $table->id('id_klarifikasi');
            $table->unsignedBigInteger('id_investasi');
            $table->unsignedBigInteger('id_umkm');
            $table->string('bulan_periode', 50); // Contoh: "Oktober 2026"
            $table->string('kategori_kendala', 50); // omzet_menurun, beban_operasional, piutang_tertunda, force_majeure, lainnya
            $table->text('alasan');
            $table->string('lampiran_bukti', 255)->nullable();
            $table->text('komitmen_solusi')->nullable();
            $table->string('status', 30)->default('menunggu_tinjauan'); // menunggu_tinjauan, disetujui_investor, diverifikasi_admin, ditolak
            $table->text('catatan_admin')->nullable();
            $table->text('catatan_investor')->nullable();
            $table->timestamps();

            $table->foreign('id_investasi')
                ->references('id_investasi')
                ->on('investasi')
                ->onDelete('cascade');

            $table->foreign('id_umkm')
                ->references('id_umkm')
                ->on('umkm')
                ->onDelete('cascade');

            $table->index(['id_investasi', 'bulan_periode']);
        });

        // 3. Tabel Log Surat Peringatan (Teguran SP Dividen dari Admin)
        Schema::create('teguran_dividen_log', function (Blueprint $table) {
            $table->id('id_teguran');
            $table->unsignedBigInteger('id_investasi');
            $table->unsignedBigInteger('id_umkm');
            $table->string('tingkat_sp', 20); // SP-1, SP-2, SP-3
            $table->text('pesan_teguran');
            $table->unsignedBigInteger('dikirim_oleh')->nullable();
            $table->timestamps();

            $table->foreign('id_investasi')
                ->references('id_investasi')
                ->on('investasi')
                ->onDelete('cascade');

            $table->foreign('id_umkm')
                ->references('id_umkm')
                ->on('umkm')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teguran_dividen_log');
        Schema::dropIfExists('klarifikasi_dividen');

        Schema::table('umkm', function (Blueprint $table) {
            $columns = ['status_kepatuhan_dividen', 'jumlah_teguran_sp', 'teguran_sp_terakhir', 'catatan_pembekuan'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('umkm', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
