<?php

namespace App\Http\Controllers;

use App\Services\BackendApiService;

class CategoryController extends Controller
{
    public function __construct(
        protected BackendApiService $api
    ) {
    }

    public function index()
    {
        $response = $this->api->getCategories();

        $categories = $response->successful()
            ? $response->json('data', [])
            : [];

        return view('categories', compact('categories'));
    }

    public function show(string $slug)
    {
        $response = $this->api->getCategory($slug);

        abort_unless($response->successful(), 404);

        $category = $response->json('data');

        return view('category-detail', compact('category'));
    }
}