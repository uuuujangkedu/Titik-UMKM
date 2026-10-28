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
        if (! Schema::hasTable('produk')) {
            Schema::create('produk', function (Blueprint $table) {
                $table->id('id_produk');
                $table->unsignedBigInteger('id_umkm');
                $table->string('nama_produk', 150);
                $table->decimal('harga', 15, 2)->default(0);
                $table->integer('stok')->default(10);
                $table->string('status', 20)->default('tersedia');
                $table->string('foto')->nullable();
                $table->text('deskripsi')->nullable();
                $table->integer('terjual')->default(0);
                $table->timestamps();

                $table->foreign('id_umkm')->references('id_umkm')->on('umkm')->onDelete('cascade');
                $table->index('id_umkm');
            });
        }

        if (Schema::hasTable('investasi')) {
            Schema::table('investasi', function (Blueprint $table) {
                if (! Schema::hasColumn('investasi', 'catatan')) {
                    $table->text('catatan')->nullable()->after('status');
                }
                if (! Schema::hasColumn('investasi', 'dibaca')) {
                    $table->boolean('dibaca')->default(false)->after('catatan');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');

        if (Schema::hasTable('investasi')) {
            Schema::table('investasi', function (Blueprint $table) {
                if (Schema::hasColumn('investasi', 'catatan')) {
                    $table->dropColumn('catatan');
                }
                if (Schema::hasColumn('investasi', 'dibaca')) {
                    $table->dropColumn('dibaca');
                }
            });
        }
    }
};
