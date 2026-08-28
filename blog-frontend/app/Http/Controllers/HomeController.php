<?php

namespace App\Http\Controllers;

use App\Services\BackendApiService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        protected BackendApiService $api
    ) {
    }

    public function index(Request $request)
    {
        $params = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'in:today,week,month,year'],
            'author' => ['nullable', 'integer'],
        ]);

        $response = $this->api->getPosts($params);

        $posts = $response->successful()
            ? $response->json('data', [])
            : [];

        $categoriesResponse = $this->api->getCategories();

        $categories = $categoriesResponse->successful()
            ? $categoriesResponse->json('data', [])
            : [];

        return view('home', compact(
            'posts',
            'categories'
        ));
    }
}