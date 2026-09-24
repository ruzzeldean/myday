<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', fn () => view('welcome'));
Route::redirect('/', '/explore');

Route::get('/explore', fn () => view('explore'))->name('explore');
Route::get('/signin', fn () => view('auth.signin'))->name('signin')->middleware('guest');
Route::get('/signup', fn () => view('auth.signup'))->name('signup')->middleware('guest');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');

Route::post('/post', [PostController::class, 'store'])->name('post.create')->middleware('auth');
