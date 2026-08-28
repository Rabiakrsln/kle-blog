<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Contract;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);

        $admin = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        $admin->assignRole('admin');

        $users = User::factory(10)->create();

        foreach ($users as $user) {
            $user->assignRole('user');
        }

        $categories = Category::factory(5)->create();

        foreach ($categories->take(3) as $index => $category) {
            Post::create([
                'user_id' => $users->first()->id,
                'category_id' => $category->id,
                'title' => 'Örnek Blog Yazısı ' . ($index + 1),
                'slug' => 'ornek-blog-yazisi-' . ($index + 1),
                'excerpt' => 'KLE Blog için örnek blog yazısı.',
                'content' => 'Bu yazı proje kurulumu sonrasında ana sayfanın boş kalmaması için oluşturulmuştur.',
                'status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => now(),
                'published_at' => now(),
            ]);
        }

        Post::factory(17)->create();

        Comment::factory(50)->create();

        Contract::updateOrCreate(
            ['slug' => 'kullanim-kosullari'],
            [
                'title' => 'Kullanım Koşulları',
                'content' => 'KLE Blog kullanım koşulları.',
                'is_active' => true,
                'published_at' => now(),
            ]
        );
    }
}