<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Database\Factories\ProductFactory;
use Database\Factories\ProductVariantFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call([
        //     CategorySeeder::class,
        //     SizeSeeder::class,
        //     ColorSeeder::class,
        // ]);

        // Product::factory(100)->create();

        ProductVariant::factory(250)->create();
    }
}
