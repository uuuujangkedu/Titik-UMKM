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
            if (! Schema::hasColumn('users', 'rt')) {
                $table->string('rt', 10)->nullable()->after('kelurahan');
            }
            if (! Schema::hasColumn('users', 'rw')) {
                $table->string('rw', 10)->nullable()->after('rt');
            }
        });

        Schema::table('umkm', function (Blueprint $table) {
            if (! Schema::hasColumn('umkm', 'rt')) {
                $table->string('rt', 10)->nullable()->after('kelurahan');
            }
            if (! Schema::hasColumn('umkm', 'rw')) {
                $table->string('rw', 10)->nullable()->after('rt');
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
            if (Schema::hasColumn('users', 'rw')) {
                $cols[] = 'rw';
            }
            if (Schema::hasColumn('users', 'rt')) {
                $cols[] = 'rt';
            }
            if (! empty($cols)) {
                $table->dropColumn($cols);
            }
        });

        Schema::table('umkm', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('umkm', 'rw')) {
                $cols[] = 'rw';
            }
            if (Schema::hasColumn('umkm', 'rt')) {
                $cols[] = 'rt';
            }
            if (! empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
