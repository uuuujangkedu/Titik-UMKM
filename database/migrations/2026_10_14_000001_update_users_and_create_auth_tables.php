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
        Schema::dropIfExists('third_party_authentications');
        Schema::dropIfExists('verification_codes');

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number', 25)->nullable()->after('email');
            }
            $table->string('password')->nullable()->change();
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role', 30)->default('investor')->after('password');
            }
            if (! Schema::hasColumn('users', 'phone_verified_at')) {
                $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            }
            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status', 30)->default('menunggu_verifikasi')->after('phone_verified_at');
            }
            if (! Schema::hasColumn('users', 'avatar_url')) {
                $table->text('avatar_url')->nullable()->after('status');
            }
        });

        // Tabel autentikasi_pihak_ketiga (Google OAuth)
        Schema::create('third_party_authentications', function (Blueprint $table) {
            $table->id('id_oauth');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('provider_name', 50)->default('google');
            $table->string('provider_user_id', 255);
            $table->text('avatar_url')->nullable();
            $table->timestamp('connected_at')->useCurrent();
            $table->timestamps();

            $table->unique(['provider_name', 'provider_user_id'], 'oauth_provider_uid_unique');
        });

        // Tabel kode_verifikasi (OTP Email / SMS)
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id('id_verification');
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('verification_type', 30)->default('otp_email');
            $table->string('secret_code', 10);
            $table->string('sent_to', 150);
            $table->boolean('is_used')->default(false);
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->index(['sent_to', 'verification_type'], 'verif_sent_type_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_codes');
        Schema::dropIfExists('third_party_authentications');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_filter([
                Schema::hasColumn('users', 'phone_number') ? 'phone_number' : null,
                Schema::hasColumn('users', 'role') ? 'role' : null,
                Schema::hasColumn('users', 'phone_verified_at') ? 'phone_verified_at' : null,
                Schema::hasColumn('users', 'status') ? 'status' : null,
                Schema::hasColumn('users', 'avatar_url') ? 'avatar_url' : null,
            ]));
        });
    }
};
