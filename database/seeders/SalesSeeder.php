<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get products and users
        $products = Product::all();
        $users = User::where('role', 'staff')->get();
        
        if ($products->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No products or staff users found. Please run ProductSeeder and StaffSeeder first.');
            return;
        }

        $this->command->info('Generating 2,000 sales records spanning 2 years...');
        
        // Define date range (2 years back from today)
        $startDate = Carbon::now()->subYears(2);
        $endDate = Carbon::now();
        
        // Create 2,000 sales records
        $totalSales = 2000;
        $createdSales = 0;
        
        // Progress tracking
        $progressBar = $this->command->getOutput()->createProgressBar($totalSales);
        $progressBar->start();
        
        for ($i = 0; $i < $totalSales; $i++) {
            // Generate random date within the 2-year span
            $randomDate = Carbon::createFromTimestamp(
                rand($startDate->timestamp, $endDate->timestamp)
            );
            
            // Get random product and user
            $product = $products->random();
            $user = $users->random();
            
            // Generate realistic quantity (1-10 items, with some bulk orders)
            $quantity = rand(1, 10);
            if (rand(1, 20) === 1) { // 5% chance for bulk order
                $quantity = rand(10, 50);
            }
            
            // Use product's current price as base, with some variation
            $basePrice = $product->price;
            $priceVariation = rand(90, 110) / 100; // ±10% price variation
            $unitPrice = round($basePrice * $priceVariation, 2);
            
            $totalAmount = round($quantity * $unitPrice, 2);
            
            // Create the sale
            Sale::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_amount' => $totalAmount,
                'sale_date' => $randomDate->format('Y-m-d'),
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
            
            $createdSales++;
            $progressBar->advance();
            
            // Update progress every 100 records
            if ($createdSales % 100 === 0) {
                $this->command->newLine();
                $this->command->info("Created {$createdSales} sales records...");
            }
        }
        
        $progressBar->finish();
        $this->command->newLine();
        
        // Update product stock quantities based on sales
        $this->command->info('Updating product stock quantities...');
        
        foreach ($products as $product) {
            // Calculate total sales for this product
            $totalSold = Sale::where('product_id', $product->id)->sum('quantity');
            
            // Set a realistic initial stock (total sold + some remaining stock)
            $remainingStock = rand(10, 100);
            $newStockQuantity = $totalSold + $remainingStock;
            
            // Update product stock
            $product->update(['stock_quantity' => $newStockQuantity]);
            
            // Update product status based on stock level
            if ($newStockQuantity <= 0) {
                $product->update(['status' => 'Out of Stock']);
            } elseif ($newStockQuantity <= 10) {
                $product->update(['status' => 'Low Stock']);
            } else {
                $product->update(['status' => 'In Stock']);
            }
        }
        
        $this->command->info("Sales data seeded successfully!");
        $this->command->info("Created {$createdSales} sales records spanning from {$startDate->format('Y-m-d')} to {$endDate->format('Y-m-d')}");
        $this->command->info("Updated stock quantities for {$products->count()} products");
    }
}