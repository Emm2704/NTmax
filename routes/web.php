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
use App\Http\Controllers\BookController;

use App\Http\Controllers\SavedBookController;
use App\Http\Controllers\SavedAudioController;

use App\Http\Controllers\AudioController;

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

    //routes books
    Route::resource('books', BookController::class);
    Route::get('books/download/{book}', [BookController::class, 'download'])->name('books.download');

    //saved books routes
    

    Route::get('/saved-books', [SavedBookController::class, 'index'])->name('saved-books.index');
    Route::post('/books/{book}/save', [SavedBookController::class, 'save'])->name('books.save');
    Route::delete('/books/{book}/unsave', [SavedBookController::class, 'destroy'])->name('books.unsave');

    //audios routes

    Route::resource('audios', AudioController::class);  
    Route::post('/audios/{audio}/like', [AudioController::class, 'toggleLike'])->name('audios.like');
    Route::get('/saved-audios', [SavedAudioController::class, 'index'])->name('saved-audios.index');
    Route::post('/audios/{audio}/save', [SavedAudioController::class, 'save'])->name('audios.save');
    Route::delete('/audios/{audio}/unsave', [SavedAudioController::class, 'unsave'])->name('audios.unsave');
    Route::put('/audios/{audio}/inactivar', [AudioController::class, 'inactivar'])->name('audios.inactivar');
    Route::put('/audios/{audio}/activar', [AudioController::class, 'activar'])->name('audios.activar');

    // guardados
    Route::get('/saved', function () {
        return view('saved-menu');
    })->name('saved.menu');
    Route::get('/posts/mis-posts', [PostController::class, 'misPosts'])->name('posts.mis-posts');
    Route::get('/audios/mis-audios', [AudioController::class, 'misAudios'])->name('saved-audios.index');

    