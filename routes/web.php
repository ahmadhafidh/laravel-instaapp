<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/', [PostController::class, 'listPosts'])->name('home');

    Route::prefix('posts')->name('posts.')->controller(PostController::class)->group(function () {
        Route::get('', 'listPosts')->name('list');
        Route::get('create', 'createForm')->name('create');
        Route::post('create', 'storePost')->name('store');

        Route::get('search', 'searchForm')->name('search.form');
        Route::get('search/results', 'searchPosts')->name('search.results');

        Route::get('{post}/edit', 'editForm')->name('edit.form');
        Route::post('{post}', 'updatePost')->name('update');

        Route::get('{post}', 'viewPost')->name('detail');
        Route::post('{post}/comments', 'storeComment')->name('comment');
        Route::post('{post}/like', 'toggleLike')->name('like');
        Route::delete('{post}', 'deletePost')->name('delete');
    });

    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'viewProfile')->name('view');
        Route::get('/edit', 'editForm')->name('edit');
        Route::patch('/update', 'updateProfile')->name('update');
    });
});


require __DIR__.'/auth.php';
