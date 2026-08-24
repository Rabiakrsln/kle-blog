<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() 
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        $category->load([
            'posts' => function ($query) {
                $query->where('status', 'approved')
                    ->latest();
            }
        ]);
        
        abort_unless($category->is_active, 404);

        return new CategoryResource($category);
    }
}
