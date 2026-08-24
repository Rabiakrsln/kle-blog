<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request) 
    {
        $posts = Post::with(['user', 'category'])
            ->where('status', 'approved');

        if ($request->filled('search')) {
            $posts->where('title', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('category')) {
            $posts->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }

        if ($request->filled('date')) {
            $posts->whereDate('published_at', $request->date);
        }

        if ($request->filled('author')) {
            $posts->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->author . '%');
            });
        }

        $posts = $posts->latest('published_at')->get();

        return PostResource::collection($posts);    
    }

    public function show(Post $post) 
    {
        $post->load(['user', 'category']);

        abort_unless($post->status === 'approved', 404);

        return new PostResource($post);    
    }
}
