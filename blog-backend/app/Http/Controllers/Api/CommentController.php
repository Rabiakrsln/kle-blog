<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with('user')
            ->where('status', 'approved');

        if ($request->filled('post_id')) {
            $query->where('post_id', $request->post_id);
        }

        $comments = $query
            ->latest()
            ->get();

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
        $comments = Comment::with(['user', 'post'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return CommentResource::collection($comments);
    }
}