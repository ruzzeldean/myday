<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = Post::latest()->paginate(10);

        return view('posts.explore', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $request->user()->posts()->create($validated);

        return response()->json(['message' => 'Post successfully created.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        // eager load user
        $post->load('user');

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $oldImage = $post->image;

            $validated['image'] = $request->file('image')->store('posts', 'public');

            $post->update($validated);

            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        } else {
            unset($validated['image']);

            $post->update($validated);
        }

        return response()->json(['message' => 'Post successfully updated.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('profile.index')->with('success', 'Post successfully deleted.');
    }

    public function trashed(): View
    {
        $posts = Post::onlyTrashed()->where('user_id', auth()->id())->latest('deleted_at')->get();

        return view('posts.trashed', compact('posts'));
    }

    public function showTrashed(Post $post): View
    {
        abort_unless($post->user_id === auth()->id(), 404);

        return view('posts.show', compact('post'));
    }

    public function restore(string $uuid): RedirectResponse
    {
        $post = Post::onlyTrashed()->where('uuid', $uuid)->firstOrFail();

        $post->restore();

        return redirect()->route('post.trashed')->with('success', 'Post successfully restored.');
    }

    public function forceDestroy(string $uuid): RedirectResponse
    {
        $post = Post::onlyTrashed()->where('uuid', $uuid)->firstOrFail();

        $post->forceDelete();

        return redirect()->route('post.trashed')->with('success', 'Post permanently deleted.');
    }
}
