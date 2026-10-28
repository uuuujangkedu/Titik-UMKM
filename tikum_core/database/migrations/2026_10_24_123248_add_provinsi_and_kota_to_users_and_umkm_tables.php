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
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'provinsi')) {
                $table->string('provinsi', 100)->nullable()->after('phone_number');
            }
            if (! Schema::hasColumn('users', 'kota')) {
                $table->string('kota', 100)->nullable()->after('provinsi');
            }
        });

        Schema::table('umkm', function (Blueprint $table) {
            if (! Schema::hasColumn('umkm', 'provinsi')) {
                $table->string('provinsi', 100)->nullable()->after('nomor_whatsapp');
            }
            if (! Schema::hasColumn('umkm', 'kota')) {
                $table->string('kota', 100)->nullable()->after('provinsi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('users', 'kota')) {
                $cols[] = 'kota';
            }
            if (Schema::hasColumn('users', 'provinsi')) {
                $cols[] = 'provinsi';
            }
            if (! empty($cols)) {
                $table->dropColumn($cols);
            }
        });

        Schema::table('umkm', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('umkm', 'kota')) {
                $cols[] = 'kota';
            }
            if (Schema::hasColumn('umkm', 'provinsi')) {
                $cols[] = 'provinsi';
            }
            if (! empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
