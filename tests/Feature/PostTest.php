<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('shows explore page', function () {
    $this->get('/explore')->assertOk();
});

it('redirects guests who try to create a post', function () {
    $this->post('/post', [
        'title' => 'Ginger',
        'image' => 'posts/gingerdeluna.png',
        'content' => 'No content.',
    ])->assertRedirect('/signin');
});

it('stores a post for an authenticated user', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/post', [
            'title' => 'pls work',
            'image' => UploadedFile::fake()->image('posts/i-am-groot.jpg'),
            'content' => 'I am Groot.',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('posts', [
        'title' => 'pls work',
        'user_id' => $user->id,
    ]);
});

it('rejects invalid input', function () {
    $this->actingAs(User::factory()->create())
        ->post('/post', ['title' => ''])
        ->assertSessionHasErrors('title');
});

/* it("forbids editing another user's post", function () {
    $post = Post::factory()->create();
    $other = User::factory()->create();

    $this->actingAs($other)
        ->put("/post/{$post->uuid}", ['title' => 'Hacked'])
        ->assertForbidden();

    expect($post->fresh()->title)->not->toBe('Hacked');
}); */
