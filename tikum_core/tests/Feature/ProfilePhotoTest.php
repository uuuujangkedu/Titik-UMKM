<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfilePhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_profile_photo_via_web_form(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'umkm',
            'avatar_url' => null,
        ]);

        $file = UploadedFile::fake()->image('profile.jpg', 200, 200);

        $response = $this->actingAs($user)->post(route('profil.foto.update'), [
            'foto_profil' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertNotNull($user->avatar_url);
        Storage::disk('public')->assertExists($user->avatar_url);
        $this->assertStringContainsString('storage/avatars/', $user->avatar);
    }

    public function test_user_can_upload_profile_photo_via_ajax(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'investor',
            'avatar_url' => null,
        ]);

        $file = UploadedFile::fake()->image('investor.png', 300, 300);

        $response = $this->actingAs($user)->postJson(route('profil.foto.update'), [
            'foto_profil' => $file,
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui!',
        ]);

        $user->refresh();
        $this->assertNotNull($user->avatar_url);
        Storage::disk('public')->assertExists($user->avatar_url);
        $this->assertEquals($user->avatar, $response->json('avatar_url'));
    }

    public function test_user_cannot_upload_invalid_file_as_profile_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'investor',
            'avatar_url' => null,
        ]);

        $file = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');

        $response = $this->actingAs($user)->post(route('profil.foto.update'), [
            'foto_profil' => $file,
        ]);

        $response->assertSessionHasErrors('foto_profil');
        $this->assertNull($user->fresh()->avatar_url);
    }
}
