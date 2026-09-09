<?php

use Illuminate\Support\Facades\Route;

Route::get('/welcome', fn () => view('welcome'));

Route::redirect('/', '/explore');
Route::get('/explore', fn () => view('explore'))->name('explore');
