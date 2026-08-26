<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $response = Http::get(
        'http://host.docker.internal:8000/api/posts'
    );

    $posts = $response->successful()
        ? $response->json('data', [])
        : [];

    return view('home', compact('posts'));
});

Route::get('/categories', function () {

    $response = Http::get(
        'http://host.docker.internal:8000/api/categories'
    );

    $categories = $response->successful()
        ? $response->json('data', [])
        : [];

    return view('categories', compact('categories'));
});

Route::get('/categories/{id}', function ($id) {

    $response = Http::get(
        'http://host.docker.internal:8000/api/categories/' . $id
    );

    abort_unless($response->successful(), 404);

    $category = $response->json('data');

    return view('category-detail', compact('category'));
});

Route::get('/posts/create', function () {
    return view('post-create');
});

Route::get('/posts/{id}', function ($id) {

    $response = Http::get(
        'http://host.docker.internal:8000/api/posts/' . $id
    );

    abort_unless($response->successful(), 404);

    $post = $response->json('data');

    $commentsResponse = Http::get(
        'http://host.docker.internal:8000/api/comments',
        [
            'post_id' => $id,
        ]
    );

    $comments = $commentsResponse->successful()
        ? $commentsResponse->json('data', [])
        : [];

    return view('post-detail', compact('post', 'comments'));
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});


