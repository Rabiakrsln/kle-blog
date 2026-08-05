<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() 
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }

    public function show(string $slug)
    {
        $category = Category::with([
            'posts' => function ($query) {
                $query->where('status', 'approved')
                    ->latest();
            }
        ])
        ->where('slug', $slug)
        ->where('is_active', true)
        ->firstOrFail();

        return response()->json($category);
    }
}
