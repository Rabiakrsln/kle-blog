<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'in:today,week,month,year'],
            'author' => ['nullable', 'integer', 'exists:users,id'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $posts = Post::with(['user', 'category'])
            ->where('status', 'approved')
            ->whereNotNull('published_at');

        if (!empty($validated['search'])) {
            $posts->where(
                'title',
                'like',
                '%' . $validated['search'] . '%'
            );
        }

        if (!empty($validated['category'])) {
            $posts->whereHas('category', function ($query) use ($validated) {
                $query->where('slug', $validated['category'])
                    ->where('is_active', true);
            });
        }

        if (!empty($validated['date'])) {
            $date = $validated['date'];

            if ($date === 'today') {
                $posts->whereDate(
                    'published_at',
                    Carbon::today()
                );
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

        if (!empty($validated['author'])) {
            $posts->where('user_id', $validated['author']);
        }

        $perPage = $validated['per_page'] ?? 10;

        $posts = $posts
            ->latest('published_at')
            ->paginate($perPage);

        return PostResource::collection($posts);
    }

    public function show(Post $post)
    {
        abort_unless(
            $post->status === 'approved' &&
            $post->published_at !== null,
            404
        );

        $post->load(['user', 'category']);

        return new PostResource($post);
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $post = Post::create([
            'user_id' => $request->user()->id,
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . uniqid(),
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
        $validated = $request->validate([
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $perPage = $validated['per_page'] ?? 10;

        $posts = Post::with(['user', 'category'])
            ->where('user_id', $request->user()->id)
            ->latest('created_at')
            ->paginate($perPage);

        return PostResource::collection($posts);
    }
}