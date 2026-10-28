<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_footer_legal_links_open_public_draft_pages(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('privacy'), false)
            ->assertSee(route('terms'), false);

        $this->get(route('privacy'))
            ->assertOk()
            ->assertSee('Kebijakan Privasi')
            ->assertSee('Status: draf. Kebijakan ini perlu ditinjau dan disahkan pemilik layanan sebelum diberlakukan.');

        $this->get(route('terms'))
            ->assertOk()
            ->assertSee('Syarat dan Ketentuan')
            ->assertSee('Status: draf. Syarat ini perlu ditinjau dan disahkan pemilik layanan sebelum diberlakukan.')
            ->assertSee('Pendanaan usaha memiliki risiko');
    }

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Masuk dengan Google');
        $response->assertSee('Masuk ke akun');
    }

    public function test_register_page_renders_successfully(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Daftar dengan Google');
        $response->assertSee('Investor');
        $response->assertSee('Pelaku UMKM');
    }

    public function test_user_can_register_and_receives_otp(): void
    {
        Mail::fake();

        $response = $this->post('/register', [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'nomor_telepon' => '081234567890',
            'role' => 'investor',
            'password' => 'Rahasia123!',
            'password_confirmation' => 'Rahasia123!',
        ]);

        $response->assertRedirect('/verify-otp');
        $this->assertDatabaseHas('users', [
            'email' => 'budi@example.com',
            'status' => 'menunggu_verifikasi',
        ]);

        $this->assertDatabaseHas('verification_codes', [
            'sent_to' => 'budi@example.com',
            'verification_type' => 'otp_email',
            'is_used' => false,
        ]);
    }

    public function test_registration_saves_umkm_role_selected_by_user(): void
    {
        Mail::fake();

        $this->post('/register', [
            'nama' => 'Sari Usaha',
            'email' => 'sari@example.com',
            'nomor_telepon' => '081234567890',
            'role' => 'umkm',
            'password' => 'Rahasia123!',
            'password_confirmation' => 'Rahasia123!',
        ])->assertRedirect('/verify-otp');

        $this->assertDatabaseHas('users', [
            'email' => 'sari@example.com',
            'role' => 'umkm',
        ]);

        $this->assertDatabaseHas('umkm', [
            'pemilik' => 'Sari Usaha',
        ]);
    }

    public function test_active_user_can_login_directly_without_otp(): void
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'Rahasia123!',
            'role' => 'investor',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => 'budi@example.com',
            'password' => 'Rahasia123!',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_unverified_user_login_triggers_otp(): void
    {
        Mail::fake();

        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'Rahasia123!',
            'role' => 'investor',
            'status' => 'menunggu_verifikasi',
        ]);

        $response = $this->post('/login', [
            'email' => 'budi@example.com',
            'password' => 'Rahasia123!',
        ]);

        $response->assertRedirect('/verify-otp');
        $this->assertEquals($user->id, session('otp_user_id'));
    }

    public function test_user_can_verify_otp_and_login(): void
    {
        Mail::fake();

        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'Rahasia123!',
            'role' => 'investor',
            'status' => 'menunggu_verifikasi',
        ]);

        $code = VerificationCode::create([
            'user_id' => $user->id,
            'verification_type' => 'otp_email',
            'secret_code' => '654321',
            'sent_to' => $user->email,
            'is_used' => false,
            'expires_at' => now()->addMinutes(5),
        ]);

        $response = $this->withSession([
            'otp_user_id' => $user->id,
            'otp_email' => $user->email,
            'otp_action' => 'daftar',
        ])->post('/verify-otp', [
            'otp' => '654321',
        ]);

        $response->assertRedirect('/formulir/investor');
        $this->assertAuthenticatedAs($user);

        $user->refresh();
        $this->assertEquals('aktif', $user->status);
        $this->assertNotNull($user->email_verified_at);

        $code->refresh();
        $this->assertTrue($code->is_used);
    }

    public function test_google_oauth_callback_creates_and_authenticates_user(): void
    {
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-unique-id-999');
        $abstractUser->shouldReceive('getName')->andReturn('Google User');
        $abstractUser->shouldReceive('getEmail')->andReturn('googleuser@gmail.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://lh3.googleusercontent.com/avatar.jpg');

        $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'googleuser@gmail.com',
            'status' => 'aktif',
        ]);
        $this->assertDatabaseHas('third_party_authentications', [
            'provider_name' => 'google',
            'provider_user_id' => 'google-unique-id-999',
        ]);
    }

    public function test_google_registration_saves_selected_role_before_redirect(): void
    {
        $this->get('/register?role=umkm')->assertSee('auth/google?role=umkm', false);
        $this->get('/register/investor')->assertSee('auth/google?role=investor', false);
        $this->get('/register/umkm')->assertSee('auth/google?role=umkm', false);
    }

    public function test_google_login_links_existing_manual_otp_account(): void
    {
        $manual = User::create([
            'name' => 'Nurul Manual',
            'email' => 'nurul@gmail.com',
            'password' => 'Rahasia123!',
            'role' => 'umkm',
            'status' => 'aktif',
            'phone_number' => '081200000000',
            'email_verified_at' => now(),
        ]);

        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-nurul-id');
        $abstractUser->shouldReceive('getName')->andReturn('NURUL DWI ALFIYANTI');
        $abstractUser->shouldReceive('getEmail')->andReturn('NURUL@Gmail.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://lh3.googleusercontent.com/nurul.jpg');

        $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $provider->shouldReceive('user')->andReturn($abstractUser);
        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $this->get('/auth/google/callback')->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($manual->fresh());
        $this->assertSame(1, User::where('email', 'nurul@gmail.com')->count());

        $fresh = $manual->fresh();
        $this->assertSame('umkm', $fresh->role);
        $this->assertSame('Nurul Manual', $fresh->name);
        $this->assertTrue(Hash::check('Rahasia123!', $fresh->password));

        $this->assertDatabaseHas('third_party_authentications', [
            'user_id' => $manual->id,
            'provider_name' => 'google',
            'provider_user_id' => 'google-nurul-id',
        ]);
    }

    public function test_google_registration_uses_selected_umkm_role(): void
    {
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-umkm-id');
        $abstractUser->shouldReceive('getName')->andReturn('UMKM User');
        $abstractUser->shouldReceive('getEmail')->andReturn('umkm-google@example.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn(null);

        $provider = Mockery::mock('Laravel\\Socialite\\Two\\GoogleProvider');
        $provider->shouldReceive('user')->andReturn($abstractUser);
        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $this->withSession(['google_registration_role' => 'umkm'])
            ->get('/auth/google/callback')
            ->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'umkm-google@example.com',
            'role' => 'umkm',
        ]);
    }

    public function test_forgot_password_sends_otp_and_resets_password(): void
    {
        Mail::fake();

        $user = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'password' => 'Lama123!@#',
            'role' => 'investor',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        // 1. Request forgot password
        $response = $this->post('/forgot-password', [
            'email' => 'siti@example.com',
        ]);
        $response->assertRedirect('/verify-otp');

        $this->assertDatabaseHas('verification_codes', [
            'user_id' => $user->id,
            'sent_to' => 'siti@example.com',
            'is_used' => false,
        ]);

        $code = VerificationCode::where('user_id', $user->id)->latest('id_verification')->first();

        // 2. Verifikasi OTP untuk reset
        $verifyResponse = $this->withSession([
            'otp_user_id' => $user->id,
            'otp_email' => $user->email,
            'otp_action' => 'reset_password',
        ])->post('/verify-otp', [
            'otp' => $code->secret_code,
        ]);

        $verifyResponse->assertRedirect('/reset-password');
        $this->assertTrue(session('can_reset_password'));

        // 3. Simpan sandi baru
        $updateResponse = $this->withSession([
            'can_reset_password' => true,
            'reset_user_id' => $user->id,
        ])->post('/reset-password', [
            'password' => 'Baru123!@#',
            'password_confirmation' => 'Baru123!@#',
        ]);

        $updateResponse->assertRedirect('/login');

        // 4. Verifikasi password baru bisa dipakai login
        $user->refresh();
        $this->assertTrue(Hash::check('Baru123!@#', $user->password));
    }

    public function test_gabung_investor_page_renders_successfully(): void
    {
        $response = $this->get('/gabung/investor');
        $response->assertStatus(200);
        $response->assertSee('Gabung Jadi Investor');
        $response->assertSee('Kemitraan permodalan bagi investor produktif');
    }

    public function test_gabung_umkm_page_renders_successfully(): void
    {
        $response = $this->get('/gabung/umkm');
        $response->assertStatus(200);
        $response->assertSee('Gabung Jadi Pelaku UMKM');
        $response->assertSee('Solusi modal dan sewa ruko bagi pelaku usaha');
    }

    public function test_register_investor_form_renders_successfully(): void
    {
        $response = $this->get('/register/investor');
        $response->assertStatus(200);
        $response->assertSee('Daftar sebagai mitra investor');
        $response->assertSee('Daftar dengan Google');
        $response->assertSee('Investor');
    }

    public function test_register_umkm_form_renders_successfully(): void
    {
        $response = $this->get('/register/umkm');
        $response->assertStatus(200);
        $response->assertSee('Daftar sebagai pelaku UMKM');
        $response->assertSee('Daftar dengan Google');
        $response->assertSee('Pelaku UMKM');
    }

    public function test_umkm_dashboard_renders_onboarding_form(): void
    {
        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/formulir/umkm');
        $response->assertStatus(200);
        $response->assertSee('Formulir pendaftaran pelaku UMKM');
        $response->assertSee('Identitas pengaju UMKM');
        $response->assertSee('Informasi usaha & produk', false);
        $response->assertSee('Lokasi ruko (pilihan minat sewa)');
        $response->assertSee('Simpan draf');
        $response->assertSee('Kirim pengajuan ke admin');
    }

    public function test_umkm_can_save_draft_and_submit_pengajuan(): void
    {
        $user = User::factory()->create([
            'role' => 'umkm',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        // Simpan draf
        $draftResponse = $this->actingAs($user)->post('/formulir/umkm', [
            'aksi' => 'simpan_draf',
            'nama_usaha' => 'Kopi Sejahtera',
            'jenis_usaha' => 'Makanan',
            'pemilik' => 'Budi Santoso',
            'nomor_whatsapp' => '081234567890',
        ]);

        $draftResponse->assertRedirect(route('dashboard', ['tab' => 'profil']));
        $this->assertDatabaseHas('umkm', [
            'user_id' => $user->id,
            'nama_usaha' => 'Kopi Sejahtera',
            'status_pengajuan' => 'draf',
        ]);

        // Kirim pengajuan
        $submitResponse = $this->actingAs($user)->post('/formulir/umkm', [
            'aksi' => 'kirim_pengajuan',
            'nama_usaha' => 'Kopi Sejahtera',
            'jenis_usaha' => 'Makanan',
            'pemilik' => 'Budi Santoso',
            'nomor_whatsapp' => '081234567890',
        ]);

        $submitResponse->assertRedirect(route('dashboard', ['tab' => 'profil']));
        $this->assertDatabaseHas('umkm', [
            'user_id' => $user->id,
            'nama_usaha' => 'Kopi Sejahtera',
            'status_pengajuan' => 'menunggu_verifikasi',
        ]);
    }

    public function test_investor_form_and_dashboard_renders(): void
    {
        $user = User::factory()->create([
            'role' => 'investor',
            'status' => 'aktif',
            'email_verified_at' => now(),
            'kategori_diminati' => null,
        ]);

        // Belum isi formulir -> diarahkan ke formulir investor
        $redirectResponse = $this->actingAs($user)->get('/dashboard');
        $redirectResponse->assertRedirect('/formulir/investor');

        // Buka formulir investor
        $formResponse = $this->actingAs($user)->get('/formulir/investor');
        $formResponse->assertStatus(200);
        $formResponse->assertSee('Formulir pendaftaran investor', false);
        $formResponse->assertSee('Identitas pendaftar investor', false);
        $formResponse->assertSee('Katalog minat pendanaan', false);

        // Kirim formulir investor
        $saveResponse = $this->actingAs($user)->post('/formulir/investor', [
            'nama' => $user->name,
            'nomor_telepon' => '081299887766',
            'kategori_diminati' => 'Makanan',
        ]);
        $saveResponse->assertRedirect('/dashboard');

        // Setelah diisi, status menjadi menunggu_verifikasi dan melihat layar tunggu persetujuan admin
        $user->refresh();
        $this->assertEquals('Makanan', $user->kategori_diminati);
        $this->assertEquals('menunggu_verifikasi', $user->status);

        $dashResponse = $this->actingAs($user)->get('/dashboard');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Mitra Investor');
        $dashResponse->assertSee('Akun Mitra Investor Anda Sedang Menunggu Verifikasi & Persetujuan (ACC) Admin', false);

        // Setelah disetujui (ACC) oleh Super Admin, dashboard investor terbuka penuh
        $user->update(['status' => 'aktif']);
        $approvedResponse = $this->actingAs($user->fresh())->get('/dashboard');
        $approvedResponse->assertStatus(200);
        $approvedResponse->assertSee('BERANDA');
        $approvedResponse->assertSee('Peluang Investasi Pilihan');
        $approvedResponse->assertSee('Ruko Strategis Siap Ditempati UMKM');
    }
}
