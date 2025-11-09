<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $toysCategory = Category::where('slug', 'toys')->first();
        $clothingCategory = Category::where('slug', 'clothing')->first();
        $feedingCategory = Category::where('slug', 'feeding')->first();
        $educationalToysCategory = Category::where('slug', 'educational-toys')->first();
        $babyCareCategory = Category::where('slug', 'baby-care')->first();

        $products = [
            // Toys Category
            [
                'name_ar' => 'جيري الزرافة اللطيفة',
                'name_en' => 'Gerry the Gentle Giraffe',
                'slug' => 'gerry-the-gentle-giraffe',
                'description_ar' => 'تعرف على جيري، ألطف زرافة في السافانا! مصنوع من القطن العضوي الفائق النعومة المعتمد من GOTS، تم تصميم جيري للعناق اللانهائي والمغامرات الخيالية. ابتسامته اللطيفة ورقبته الطويلة القابلة للعناق تجعله الرفيق المثالي لطفلك الصغير، من وقت القيلولة إلى وقت اللعب.',
                'description_en' => 'Meet Gerry, the friendliest giraffe in the savanna! Made from ultra-soft, GOTS-certified organic cotton, Gerry is designed for endless cuddles and imaginative adventures. His gentle smile and long, huggable neck make him the perfect companion for your little one, from naptime to playtime.',
                'image' => null,
                'category_id' => $toysCategory->id,
                'is_active' => true,
            ],
            [
                'name_ar' => 'إلارا الفيل',
                'name_en' => 'Elara the Elephant',
                'slug' => 'elara-the-elephant',
                'description_ar' => 'إلارا الفيل اللطيف، مصنوع من القطن العضوي الناعم. رفيق مثالي للأطفال.',
                'description_en' => 'Elara the gentle elephant, made from soft organic cotton. Perfect companion for children.',
                'image' => null,
                'category_id' => $toysCategory->id,
                'is_active' => true,
            ],
            [
                'name_ar' => 'ليو الأسد الشجاع',
                'name_en' => 'Leo the Brave Lion',
                'slug' => 'leo-the-brave-lion',
                'description_ar' => 'ليو الأسد الشجاع، مصنوع من مواد آمنة وناعمة للأطفال.',
                'description_en' => 'Leo the brave lion, made from safe and soft materials for children.',
                'image' => null,
                'category_id' => $toysCategory->id,
                'is_active' => true,
            ],

            // Clothing Category
            [
                'name_ar' => 'قميص قطني عضوي',
                'name_en' => 'Organic Cotton T-Shirt',
                'slug' => 'organic-cotton-t-shirt',
                'description_ar' => 'قميص قطني عضوي ناعم ومريح للأطفال. مصنوع من مواد آمنة.',
                'description_en' => 'Soft and comfortable organic cotton t-shirt for children. Made from safe materials.',
                'image' => null,
                'category_id' => $clothingCategory->id,
                'is_active' => true,
            ],
            [
                'name_ar' => 'بنطلون رياضي',
                'name_en' => 'Sporty Pants',
                'slug' => 'sporty-pants',
                'description_ar' => 'بنطلون رياضي مريح ومناسب للعب والحركة.',
                'description_en' => 'Comfortable sporty pants perfect for play and movement.',
                'image' => null,
                'category_id' => $clothingCategory->id,
                'is_active' => true,
            ],

            // Feeding Category
            [
                'name_ar' => 'طبق طعام سيليكون',
                'name_en' => 'Silicone Feeding Bowl',
                'slug' => 'silicone-feeding-bowl',
                'description_ar' => 'طبق طعام من السيليكون الآمن للأطفال. سهل التنظيف ومقاوم للحرارة.',
                'description_en' => 'Safe silicone feeding bowl for children. Easy to clean and heat resistant.',
                'image' => null,
                'category_id' => $feedingCategory->id,
                'is_active' => true,
            ],
            [
                'name_ar' => 'ملعقة طعام ناعمة',
                'name_en' => 'Soft Feeding Spoon',
                'slug' => 'soft-feeding-spoon',
                'description_ar' => 'ملعقة طعام ناعمة مصممة خصيصاً للأطفال الرضع.',
                'description_en' => 'Soft feeding spoon specially designed for infants.',
                'image' => null,
                'category_id' => $feedingCategory->id,
                'is_active' => true,
            ],

            // Educational Toys Category
            [
                'name_ar' => 'مكعبات بناء ملونة',
                'name_en' => 'Rainbow Building Blocks',
                'slug' => 'rainbow-building-blocks',
                'description_ar' => 'مجموعة مكعبات بناء ملونة تساعد الأطفال على تطوير مهاراتهم الإبداعية والحركية.',
                'description_en' => 'Colorful building blocks set that helps children develop their creative and motor skills.',
                'image' => null,
                'category_id' => $educationalToysCategory->id,
                'is_active' => true,
            ],
            [
                'name_ar' => 'أحجية الألوان',
                'name_en' => 'Color Puzzle',
                'slug' => 'color-puzzle',
                'description_ar' => 'أحجية تعليمية تساعد الأطفال على تعلم الألوان والأشكال.',
                'description_en' => 'Educational puzzle that helps children learn colors and shapes.',
                'image' => null,
                'category_id' => $educationalToysCategory->id,
                'is_active' => true,
            ],

            // Baby Care Category
            [
                'name_ar' => 'بطانية سحابة دافئة',
                'name_en' => 'Cozy Cloud Blanket',
                'slug' => 'cozy-cloud-blanket',
                'description_ar' => 'بطانية ناعمة ودافئة مصنوعة من القطن العضوي. مثالية للرضع.',
                'description_en' => 'Soft and warm blanket made from organic cotton. Perfect for infants.',
                'image' => null,
                'category_id' => $babyCareCategory->id,
                'is_active' => true,
            ],
            [
                'name_ar' => 'مناديل مبللة عضوية',
                'name_en' => 'Organic Baby Wipes',
                'slug' => 'organic-baby-wipes',
                'description_ar' => 'مناديل مبللة عضوية آمنة ولطيفة على بشرة الأطفال الحساسة.',
                'description_en' => 'Organic baby wipes that are safe and gentle on sensitive baby skin.',
                'image' => null,
                'category_id' => $babyCareCategory->id,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
