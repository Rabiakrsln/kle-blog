<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 9999),
            'content' => fake()->paragraphs(10, true),
            'is_active' => true,
            'published_at' => now(),
        ];
    }
}
