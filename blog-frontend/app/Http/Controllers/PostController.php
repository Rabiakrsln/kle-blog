<?php

namespace App\Http\Controllers;

use App\Services\BackendApiService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        protected BackendApiService $api
    ) {
    }

    public function show(string $slug)
    {
        $response = $this->api->getPost($slug);

        abort_unless($response->successful(), 404);

        $post = $response->json('data');

        $commentsResponse = $this->api->getComments($post['id']);

        $comments = $commentsResponse->successful()
            ? $commentsResponse->json('data', [])
            : [];

        return view('post-detail', compact('post', 'comments'));
    }

    public function create()
    {
        $response = $this->api->getCategories();

        $categories = $response->successful()
            ? $response->json('data', [])
            : [];

        return view('post-create', compact('categories'));
    }

    public function store(Request $request)
    {
        $token = $request->session()->get('api_token');

        if (!$token) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'category_id' => ['required', 'integer'],
            'title' => ['required', 'string'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
        ]);

        $response = $this->api->createPost($token, $validated);

        if (!$response->successful()) {
            return back()
                ->withErrors([
                    'post' => $response->json(
                        'message',
                        'Yazı oluşturulamadı.'
                    ),
                ])
                ->withInput();
        }

        return redirect('/dashboard')
            ->with('success', 'Yazın başarıyla gönderildi. Yönetici onayından sonra yayınlanacaktır.');
    }
}