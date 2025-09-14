<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Vegetables',
                'description' => 'Fresh vegetables and greens',
            ],
            [
                'name' => 'Fruits',
                'description' => 'Fresh fruits and berries',
            ],
            [
                'name' => 'Dairy',
                'description' => 'Milk, cheese, and dairy products',
            ],
            [
                'name' => 'Meat',
                'description' => 'Fresh meat and poultry',
            ],
            [
                'name' => 'Grains',
                'description' => 'Rice, wheat, and other grains',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
