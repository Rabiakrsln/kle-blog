<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with(['user', 'category'])
            ->where('status', 'approved')
            ->latest()
            ->get();

        return response()->json($posts);
    }

    public function show(string $slug) {
        $post = Post::with(['user', 'category'])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        return response()->json($post);
    }
}
