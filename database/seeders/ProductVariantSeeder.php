<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing variants to avoid duplicates
        ProductVariant::truncate();

        $products = Product::all();
        $sizes = Size::where('is_active', true)->get();
        $colors = Color::where('is_active', true)->get();

        if ($products->isEmpty() || $sizes->isEmpty() || $colors->isEmpty()) {
            return;
        }

        // Base prices for different product types
        $basePrices = [
            'toys' => 34.99,
            'clothing' => 29.99,
            'feeding' => 24.99,
            'educational-toys' => 45.00,
            'baby-care' => 39.99,
        ];

        foreach ($products as $product) {
            $categorySlug = $product->category->slug ?? 'toys';
            $basePrice = $basePrices[$categorySlug] ?? 34.99;
            $skuPrefix = strtoupper(substr($product->slug ?? 'PROD', 0, 4)) . '-' . str_pad($product->id, 3, '0', STR_PAD_LEFT);

            // Create variants with different size and color combinations
            $sizeOptions = $sizes->take(3); // Use first 3 sizes
            $colorOptions = $colors->take(3); // Use first 3 colors

            $variantIndex = 1;

            foreach ($sizeOptions as $size) {
                foreach ($colorOptions as $color) {
                    // Price variation based on size
                    $sizeMultiplier = match ($size->slug) {
                        'small' => 0.9,
                        'medium' => 1.0,
                        'large' => 1.1,
                        'extra-large' => 1.2,
                        default => 1.0,
                    };

                    $price = round($basePrice * $sizeMultiplier, 2);
                    $stock = rand(10, 100);

                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size_id' => $size->id,
                        'color_id' => $color->id,
                        'sku' => $skuPrefix . '-' . strtoupper($size->slug ?? 'M') . '-' . strtoupper($color->slug ?? 'BLK') . '-' . str_pad($variantIndex, 3, '0', STR_PAD_LEFT),
                        'price' => $price,
                        'stock' => $stock,
                        'is_active' => true,
                    ]);

                    $variantIndex++;
                }
            }

            // Also create some variants with only size (no color)
            foreach ($sizeOptions->take(2) as $size) {
                $sizeMultiplier = match ($size->slug) {
                    'small' => 0.9,
                    'medium' => 1.0,
                    'large' => 1.1,
                    'extra-large' => 1.2,
                    default => 1.0,
                };

                $price = round($basePrice * $sizeMultiplier, 2);
                $stock = rand(10, 100);

                ProductVariant::create([
                    'product_id' => $product->id,
                    'size_id' => $size->id,
                    'color_id' => null,
                    'sku' => $skuPrefix . '-' . strtoupper($size->slug ?? 'M') . '-DEF-' . str_pad($variantIndex, 3, '0', STR_PAD_LEFT),
                    'price' => $price,
                    'stock' => $stock,
                    'is_active' => true,
                ]);

                $variantIndex++;
            }
        }
    }
}
