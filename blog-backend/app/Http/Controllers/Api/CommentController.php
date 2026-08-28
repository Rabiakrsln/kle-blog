<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'post_id' => ['nullable', 'integer', 'exists:posts,id'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $perPage = $validated['per_page'] ?? 10;

        $query = Comment::with('user')
            ->where('status', 'approved');

        if (!empty($validated['post_id'])) {
            $query->where('post_id', $validated['post_id']);
        }

        $comments = $query
            ->latest()
            ->paginate($perPage);

        return CommentResource::collection($comments);
    }

    public function store(StoreCommentRequest $request)
    {
        $validated = $request->validated();

        $comment = Comment::create([
            'post_id' => $validated['post_id'],
            'user_id' => $request->user()->id,
            'content' => $validated['content'],
            'status' => 'pending',
        ]);

        return new CommentResource(
            $comment->load('user')
        );
    }

    public function mine(Request $request)
    {
        $validated = $request->validate([
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $perPage = $validated['per_page'] ?? 10;

        $comments = Comment::with(['user', 'post'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate($perPage);

        return CommentResource::collection($comments);
    }
}