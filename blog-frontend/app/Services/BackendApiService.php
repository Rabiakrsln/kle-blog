<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BackendApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.backend.url'), '/');
    }

    public function getPosts(array $params = [])
    {
        return Http::get($this->baseUrl . '/api/posts', $params);
    }

    public function getCategories()
    {
        return Http::get($this->baseUrl . '/api/categories');
    }

    public function getPost(string $slug)
    {
        return Http::get($this->baseUrl . '/api/posts/' . $slug);
    }

    public function getCategory(string $slug)
    {
        return Http::get($this->baseUrl . '/api/categories/' . $slug);
    }

    public function getContract(string $slug)
    {
        return Http::get($this->baseUrl . '/api/contracts/' . $slug);
    }

    public function getComments(int $postId)
    {
        return Http::get($this->baseUrl . '/api/comments', [
            'post_id' => $postId,
        ]);
    }

    public function login(string $email, string $password)
    {
        return Http::post($this->baseUrl . '/api/login', [
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function logout(string $token)
    {
        return Http::withToken($token)
            ->post($this->baseUrl . '/api/logout');
    }

    public function getUser(string $token)
    {
        return Http::withToken($token)
            ->get($this->baseUrl . '/api/user');
    }

    public function updateProfile(string $token, array $data)
    {
        return Http::withToken($token)
            ->put($this->baseUrl . '/api/user', $data);
    }

    public function getUserPosts(string $token)
    {
        return Http::withToken($token)
            ->get($this->baseUrl . '/api/user/posts');
    }

    public function getUserComments(string $token)
    {
        return Http::withToken($token)
            ->get($this->baseUrl . '/api/user/comments');
    }

    public function createPost(string $token, array $data)
    {
        return Http::withToken($token)
            ->post($this->baseUrl . '/api/posts', $data);
    }

}