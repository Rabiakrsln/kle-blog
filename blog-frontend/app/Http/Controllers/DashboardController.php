<?php

namespace App\Http\Controllers;

use App\Services\BackendApiService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected BackendApiService $api
    ) {
    }

    public function index(Request $request)
    {
        $token = $request->session()->get('api_token');

        if (!$token) {
            return redirect('/login');
        }

        $userResponse = $this->api->getUser($token);

        if (!$userResponse->successful()) {
            $request->session()->forget('api_token');

            return redirect('/login');
        }

        $user = $userResponse->json();

        $postsResponse = $this->api->getUserPosts($token);
        $commentsResponse = $this->api->getUserComments($token);

        $posts = $postsResponse->successful()
            ? $postsResponse->json('data', [])
            : [];

        $comments = $commentsResponse->successful()
            ? $commentsResponse->json('data', [])
            : [];

        return view('dashboard', compact(
            'user',
            'posts',
            'comments'
        ));
    }

    public function updateProfile(Request $request)
    {
        $token = $request->session()->get('api_token');

        if (!$token) {
            return redirect('/login');
        }

        $response = $this->api->updateProfile(
            $token,
            $request->only(['name', 'email'])
        );

        if ($response->successful()) {
            return redirect('/dashboard')
                ->with('success', 'Profil bilgilerin başarıyla güncellendi.');
        }

        return redirect('/dashboard')
            ->withErrors([
                'profile' => $response->json('message', 'Profil güncellenirken bir hata oluştu.')
            ])
            ->withInput();
    }
}