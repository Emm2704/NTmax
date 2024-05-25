<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SavedPostController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RoleController;

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

    // user Routes

    Route::resource('usuarios', UserController::class)->middleware(['auth', 'verified']);
    
    Route::put('/usuarios{usuario}', [UserController::class, 'inactivar']) -> name('usuarios.inactivar');
    Route::put('/usuarios/{usuario}/activar', [UserController::class, 'activar'])->name('usuarios.activar');
    
    
    //Menu routes
    Route::get('menu', [MenuController::class, 'index'])->name('menu.index');

    //role route


    // acciones post routes


    Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('posts.like');
    Route::delete('/posts/{post}/unlike', [LikeController::class, 'unlike'])->name('posts.unlike');
    Route::post('/posts/{post}/save', [SavedPostController::class, 'save'])->name('posts.save');

    Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('posts.comment');

    Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('posts.like');
    Route::delete('/posts/{post}/unlike', [LikeController::class, 'unlike'])->name('posts.unlike');

    Route::get('/saved-posts', [SavedPostController::class, 'index'])->name('saved-posts.index');

    //Un solo post
    Route::get('/dashboard/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts/{post}/comment', [PostController::class, 'addComment'])->name('posts.addComment');
    Route::get('/posts/{post}/comments', [PostController::class, 'comments'])->name('posts.comments');


    // routes cursos
    Route::resource('courses', CourseController::class);
    Route::post('courses/{course}/toggle-status', [CourseController::class, 'toggleStatus'])->name('courses.toggle-status');

    //roles routes
    Route::resource('roles', RoleController::class);