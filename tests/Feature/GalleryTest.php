<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_index_returns_successful_response(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_guest_cannot_post_upload(): void
    {
        Storage::fake('public');

        $this->post('/images/create', [
            'title' => 'A photo',
            'image' => UploadedFile::fake()->image('photo.jpg'),
        ])->assertRedirect(route('login'));

        $this->assertDatabaseCount('images', 0);
    }

    public function test_authenticated_user_can_upload_and_see_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('sunset.jpg');

        $this->actingAs($user)
            ->post('/images/create', [
                'title' => 'Sunset',
                'image' => $file,
            ])
            ->assertRedirect(route('gallery.index'));

        $image = Image::query()->first();

        $this->assertNotNull($image);
        $this->assertSame('Sunset', $image->title);
        $this->assertSame($user->id, $image->user_id);
        $this->assertStringStartsWith('gallery/', $image->path);
        Storage::disk('public')->assertExists($image->path);

        $this->get('/')->assertOk()->assertSee('Sunset');
        $this->get(route('images.show', $image))->assertOk()->assertSee('Sunset');
    }

    public function test_user_cannot_delete_another_users_image(): void
    {
        Storage::fake('public');

        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $image = Image::factory()->for($owner)->create([
            'path' => 'gallery/owned.jpg',
        ]);

        Storage::disk('public')->put($image->path, 'fake-bytes');

        $this->actingAs($intruder)
            ->delete(route('images.destroy', $image))
            ->assertForbidden();

        $this->assertDatabaseHas('images', ['id' => $image->id]);
        Storage::disk('public')->assertExists($image->path);
    }
}
