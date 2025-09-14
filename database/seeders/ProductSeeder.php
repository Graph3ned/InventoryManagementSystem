<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vegetables = Category::where('name', 'Vegetables')->first();
        $fruits = Category::where('name', 'Fruits')->first();
        $dairy = Category::where('name', 'Dairy')->first();
        $meat = Category::where('name', 'Meat')->first();
        $grains = Category::where('name', 'Grains')->first();

        $products = [
            // Vegetables
            [
                'name' => 'Fresh Tomatoes',
                'category_id' => $vegetables->id,
                'price' => 25.99,
                'stock_quantity' => 50,
                'status' => 'In Stock',
                'description' => 'Fresh red tomatoes',
            ],
            [
                'name' => 'Organic Carrots',
                'category_id' => $vegetables->id,
                'price' => 19.50,
                'stock_quantity' => 30,
                'status' => 'In Stock',
                'description' => 'Organic fresh carrots',
            ],
            [
                'name' => 'Green Lettuce',
                'category_id' => $vegetables->id,
                'price' => 15.00,
                'stock_quantity' => 5,
                'status' => 'Low Stock',
                'description' => 'Fresh green lettuce',
            ],
            [
                'name' => 'Red Onions',
                'category_id' => $vegetables->id,
                'price' => 18.75,
                'stock_quantity' => 2,
                'status' => 'Low Stock',
                'description' => 'Fresh red onions',
            ],

            // Fruits
            [
                'name' => 'Bananas',
                'category_id' => $fruits->id,
                'price' => 12.50,
                'stock_quantity' => 40,
                'status' => 'In Stock',
                'description' => 'Fresh yellow bananas',
            ],
            [
                'name' => 'Apples',
                'category_id' => $fruits->id,
                'price' => 35.00,
                'stock_quantity' => 25,
                'status' => 'In Stock',
                'description' => 'Fresh red apples',
            ],

            // Dairy
            [
                'name' => 'Fresh Milk',
                'category_id' => $dairy->id,
                'price' => 45.00,
                'stock_quantity' => 20,
                'status' => 'In Stock',
                'description' => 'Fresh cow milk',
            ],
            [
                'name' => 'Cheddar Cheese',
                'category_id' => $dairy->id,
                'price' => 120.00,
                'stock_quantity' => 0,
                'status' => 'Out of Stock',
                'description' => 'Aged cheddar cheese',
            ],

            // Meat
            [
                'name' => 'Chicken Breast',
                'category_id' => $meat->id,
                'price' => 180.00,
                'stock_quantity' => 15,
                'status' => 'In Stock',
                'description' => 'Fresh chicken breast',
            ],

            // Grains
            [
                'name' => 'Jasmine Rice',
                'category_id' => $grains->id,
                'price' => 55.00,
                'stock_quantity' => 100,
                'status' => 'In Stock',
                'description' => 'Premium jasmine rice',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
