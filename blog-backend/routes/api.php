<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');

Route::get('/posts/{post:slug}', [PostController::class, 'show'])
    ->name('posts.show');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])
    ->name('categories.show');

Route::get('/contracts/{slug}', [ContractController::class, 'show'])
    ->name('contracts.show');

Route::get('/comments', [CommentController::class, 'index'])
    ->name('comments.index');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('auth.logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('auth.user');

    Route::put('/user', [AuthController::class, 'updateProfile'])
        ->name('auth.user.update');

    Route::get('/user/posts', [PostController::class, 'mine'])
        ->name('user.posts');

    Route::get('/user/comments', [CommentController::class, 'mine'])
        ->name('user.comments');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');
});

Route::middleware('guest')->group(function () {

    Route::post('/register', [AuthController::class, 'register'])
        ->name('auth.register');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('auth.login');
});