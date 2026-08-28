<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/categories/{slug}', [CategoryController::class, 'show']);

Route::get('/posts/create', [PostController::class, 'create']);

Route::get('/posts/{slug}', [PostController::class, 'show']);

Route::get('/login', [LoginController::class, 'show'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('/register', function () {
    return view('register');
});

Route::post('/posts', [PostController::class, 'store'])
    ->name('posts.store');

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::put('/dashboard/profile', [DashboardController::class, 'updateProfile'])
    ->name('dashboard.profile.update');

Route::get('/kullanim-kosullari', [ContractController::class, 'show'])
    ->name('contract.show');