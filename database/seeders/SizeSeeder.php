<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            [
                'name_ar' => 'صغير',
                'name_en' => 'Small',
                'slug' => 'small',
                'value' => '12',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name_ar' => 'متوسط',
                'name_en' => 'Medium',
                'slug' => 'medium',
                'value' => '18',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name_ar' => 'كبير',
                'name_en' => 'Large',
                'slug' => 'large',
                'value' => '24',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name_ar' => 'كبير جداً',
                'name_en' => 'Extra Large',
                'slug' => 'extra-large',
                'value' => '30',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name_ar' => 'واحد',
                'name_en' => 'One Size',
                'slug' => 'one-size',
                'value' => null,
                'order' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($sizes as $size) {
            Size::create($size);
        }
    }
}
