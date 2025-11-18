<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BulkProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all categories
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('No categories found. Please run CategorySeeder first.');
            return;
        }

        $this->command->info('Starting to seed 5000 products...');
        $bar = $this->command->getOutput()->createProgressBar(5000);
        $bar->start();

        // Product name templates for variety
        $productTypes = [
            'toy' => ['Toy', 'Game', 'Puzzle', 'Doll', 'Car', 'Ball', 'Block', 'Animal'],
            'clothing' => ['Shirt', 'Pants', 'Dress', 'Jacket', 'Hat', 'Socks', 'Shoes', 'Sweater'],
            'feeding' => ['Bowl', 'Spoon', 'Fork', 'Plate', 'Cup', 'Bottle', 'Bib', 'Mat'],
            'educational' => ['Book', 'Puzzle', 'Block', 'Card', 'Board', 'Tool', 'Kit', 'Set'],
            'care' => ['Blanket', 'Wipe', 'Lotion', 'Powder', 'Oil', 'Cream', 'Soap', 'Shampoo'],
        ];

        // Generate 5000 products
        for ($i = 1; $i <= 5000; $i++) {
            $category = $categories->random();
            $categorySlug = $category->slug;

            // Determine product type based on category
            $type = 'toy'; // default
            if (str_contains($categorySlug, 'clothing')) {
                $type = 'clothing';
            } elseif (str_contains($categorySlug, 'feeding')) {
                $type = 'feeding';
            } elseif (str_contains($categorySlug, 'educational')) {
                $type = 'educational';
            } elseif (str_contains($categorySlug, 'baby-care')) {
                $type = 'care';
            }

            // Generate product name
            $productType = $faker->randomElement($productTypes[$type] ?? $productTypes['toy']);
            $adjective = $faker->randomElement(['Premium', 'Deluxe', 'Classic', 'Modern', 'Eco-Friendly', 'Organic', 'Soft', 'Colorful', 'Fun', 'Safe']);

            $nameEn = $adjective . ' ' . $productType . ' ' . $i;
            $nameAr = 'منتج ' . $productType . ' ' . $i;

            // Generate slug
            $slug = Str::slug($nameEn);

            // Ensure unique slug
            $baseSlug = $slug;
            $counter = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            // Generate descriptions
            $descriptionEn = $faker->paragraph(3);
            $descriptionAr = 'وصف المنتج باللغة العربية. ' . $faker->paragraph(2);

            // Create product with placeholder image
            // Storing null will use the Product model's getImageAttribute accessor
            // which returns 'https://placehold.co/400' when image is null
            Product::create([
                'name_ar' => $nameAr,
                'name_en' => $nameEn,
                'slug' => $slug,
                'description_ar' => $descriptionAr,
                'description_en' => $descriptionEn,
                'image' => null, // Placeholder image will be served via Product model accessor
                'category_id' => $category->id,
                'is_active' => $faker->boolean(90), // 90% active
            ]);

            $bar->advance();

            // Show progress every 500 products
            if ($i % 500 == 0) {
                $this->command->newLine();
                $this->command->info("Created {$i} products so far...");
            }
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('Successfully created 5000 products with placeholder images!');
    }
}
