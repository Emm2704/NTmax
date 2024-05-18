<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// posts routes

Route::resource('posts', PostController::class)->parameters([
    'posts' => 'post',
]) ->middleware(['auth', 'verified']);

Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    //ver imagen
    Route::get('/posts/{id}/image', [PostController::class, 'showImage'])->name('posts.image.show');

    //mis posts

    Route::get('/mis-posts', [PostController::class, 'misPosts'])
    ->middleware(['auth', 'verified'])
    ->name('posts.mis-posts');

    Route::put('/mis-posts/{post}/inactivar', [PostController::class, 'inactivar'])->name('posts.inactivar');
    Route::put('/mis-posts/{post}/activar', [PostController::class, 'activar'])->name('posts.activar');

