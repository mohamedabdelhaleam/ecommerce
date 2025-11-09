<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            [
                'name_ar' => 'أحمر',
                'name_en' => 'Red',
                'slug' => 'red',
                'hex_code' => '#FF0000',
                'is_active' => true,
            ],
            [
                'name_ar' => 'أزرق',
                'name_en' => 'Blue',
                'slug' => 'blue',
                'hex_code' => '#0000FF',
                'is_active' => true,
            ],
            [
                'name_ar' => 'أخضر',
                'name_en' => 'Green',
                'slug' => 'green',
                'hex_code' => '#00FF00',
                'is_active' => true,
            ],
            [
                'name_ar' => 'أصفر',
                'name_en' => 'Yellow',
                'slug' => 'yellow',
                'hex_code' => '#FFFF00',
                'is_active' => true,
            ],
            [
                'name_ar' => 'وردي',
                'name_en' => 'Pink',
                'slug' => 'pink',
                'hex_code' => '#FFC0CB',
                'is_active' => true,
            ],
            [
                'name_ar' => 'بنفسجي',
                'name_en' => 'Purple',
                'slug' => 'purple',
                'hex_code' => '#800080',
                'is_active' => true,
            ],
            [
                'name_ar' => 'برتقالي',
                'name_en' => 'Orange',
                'slug' => 'orange',
                'hex_code' => '#FFA500',
                'is_active' => true,
            ],
            [
                'name_ar' => 'أسود',
                'name_en' => 'Black',
                'slug' => 'black',
                'hex_code' => '#000000',
                'is_active' => true,
            ],
            [
                'name_ar' => 'أبيض',
                'name_en' => 'White',
                'slug' => 'white',
                'hex_code' => '#FFFFFF',
                'is_active' => true,
            ],
            [
                'name_ar' => 'بني',
                'name_en' => 'Brown',
                'slug' => 'brown',
                'hex_code' => '#A52A2A',
                'is_active' => true,
            ],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
