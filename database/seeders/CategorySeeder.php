<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name_ar' => 'ألعاب',
                'name_en' => 'Toys',
                'slug' => 'toys',
                'description_ar' => 'مجموعة متنوعة من الألعاب للأطفال',
                'description_en' => 'A variety of toys for children',
                'is_active' => true,
            ],
            [
                'name_ar' => 'ملابس',
                'name_en' => 'Clothing',
                'slug' => 'clothing',
                'description_ar' => 'ملابس أطفال عالية الجودة',
                'description_en' => 'High quality children clothing',
                'is_active' => true,
            ],
            [
                'name_ar' => 'أدوات طعام',
                'name_en' => 'Feeding',
                'slug' => 'feeding',
                'description_ar' => 'أدوات طعام وأطباق للأطفال',
                'description_en' => 'Feeding utensils and dishes for children',
                'is_active' => true,
            ],
            [
                'name_ar' => 'ألعاب تعليمية',
                'name_en' => 'Educational Toys',
                'slug' => 'educational-toys',
                'description_ar' => 'ألعاب تعليمية لتنمية مهارات الأطفال',
                'description_en' => 'Educational toys to develop children skills',
                'is_active' => true,
            ],
            [
                'name_ar' => 'مستلزمات الرضاعة',
                'name_en' => 'Baby Care',
                'slug' => 'baby-care',
                'description_ar' => 'مستلزمات العناية بالرضع',
                'description_en' => 'Baby care essentials',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
