<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contract;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // $adminRole = Role::firstOrCreate([
        //     'name' => 'admin',
        //     'guard_name' => 'web',
        // ]);



        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);
        User::factory(10)->create();
        Category::factory(5)->create();
        Post::factory(20)->create();
        Comment::factory(50)->create();
        Contract::factory(3)->create();

        $admin = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
            ]
        );

        $admin->assignRole('admin');
    }
}
