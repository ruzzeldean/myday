<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', fn () => view('welcome'));
Route::redirect('/', '/explore');

Route::get('/signin', fn () => view('auth.signin'))->name('signin')->middleware('guest');
Route::get('/signup', fn () => view('auth.signup'))->name('signup')->middleware('guest');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::get('/u/{user:username}', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/explore', [PostController::class, 'index'])->name('explore');
Route::post('/post', [PostController::class, 'store'])->name('post.create')->middleware('auth');
Route::get('/post/{post:uuid}', [PostController::class, 'show'])->whereUuid('post')->name('post.show');
Route::put('/post/{post:uuid}', [PostController::class, 'update'])->whereUuid('post')->name('post.update')->middleware('auth');
Route::patch('/post/{post:uuid}', [PostController::class, 'destroy'])->name('post.destroy')->middleware('auth');

Route::get('/post/trashed', [PostController::class, 'trashed'])->name('post.trashed')->middleware('auth');
Route::get('/post/trashed/{post:uuid}', [PostController::class, 'showTrashed'])
    ->withTrashed()->whereUuid('post')
    ->name('post.showTrashed')->middleware('auth');
Route::patch('/post/trashed/{post:uuid}', [PostController::class, 'restore'])
    ->whereUuid('post')
    ->name('post.restore')
    ->middleware('auth');
Route::delete('/post/trashed/{post:uuid}', [PostController::class, 'forceDestroy'])
    ->whereUuid('post')
    ->name('post.forceDestroy')
    ->middleware('auth');
