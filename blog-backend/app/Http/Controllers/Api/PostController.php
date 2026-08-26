<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Carbon\Carbon;

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
            $date = $request->date;

            if ($date === 'today') {
                $posts->whereDate('published_at', Carbon::today());
            }

            if ($date === 'week') {
                $posts->whereBetween('published_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ]);
            }

            if ($date === 'month') {
                $posts->whereBetween('published_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                ]);
            }

            if ($date === 'year') {
                $posts->whereBetween('published_at', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            }
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

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $post = Post::create([
            'user_id' => $request->user()->id,
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => \Illuminate\Support\Str::slug($validated['title']) . '-' . uniqid(),
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'status' => 'pending',
            'approved_by' => null,
            'approved_at' => null,
            'published_at' => null,
        ]);

        return new PostResource(
            $post->load(['user', 'category'])
        );
    }

    public function mine(Request $request)
    {
        $posts = Post::with(['user', 'category'])
            ->where('user_id', $request->user()->id)
            ->latest('created_at')
            ->get();

        return PostResource::collection($posts);
    }
}