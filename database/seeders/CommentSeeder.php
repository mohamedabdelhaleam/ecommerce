<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $users = User::all();

        if ($products->isEmpty()) {
            return;
        }

        $comments = [
            [
                'product_id' => $products->first()->id,
                'user_id' => $users->first()->id ?? null,
                'name' => $users->first()->name ?? 'Sarah K.',
                'email' => $users->first()->email ?? 'sarah@example.com',
                'comment' => 'So incredibly soft! My daughter absolutely loves her new giraffe. It\'s the perfect size for her to carry everywhere. Wonderful quality.',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'product_id' => $products->first()->id,
                'user_id' => null,
                'name' => 'Mark T.',
                'email' => 'mark@example.com',
                'comment' => 'Great toy, very well-made. Feels durable and safe. A little pricier than others, but you can feel the quality difference. Would recommend.',
                'rating' => 4,
                'is_approved' => true,
            ],
            [
                'product_id' => $products->first()->id,
                'user_id' => null,
                'name' => 'Emma L.',
                'email' => 'emma@example.com',
                'comment' => 'Perfect gift for my niece! She loves it and it\'s so soft. The quality is excellent.',
                'rating' => 5,
                'is_approved' => true,
            ],
        ];

        // Add more comments for other products
        foreach ($products->skip(1)->take(3) as $product) {
            $comments[] = [
                'product_id' => $product->id,
                'user_id' => null,
                'name' => 'John D.',
                'email' => 'john@example.com',
                'comment' => 'Really happy with this purchase. Great quality and my child loves it!',
                'rating' => 5,
                'is_approved' => true,
            ];

            $comments[] = [
                'product_id' => $product->id,
                'user_id' => null,
                'name' => 'Lisa M.',
                'email' => 'lisa@example.com',
                'comment' => 'Good product, but could be better. Still satisfied with the purchase.',
                'rating' => 4,
                'is_approved' => true,
            ];
        }

        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}
