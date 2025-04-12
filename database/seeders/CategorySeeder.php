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
        Category::query()->create([
            'name' => 'Ao phong/ Ao thun'
        ]);

        Category::query()->create([
            'name' => 'Ao polo'
        ]);

        Category::query()->create([
            'name' => 'Ao so mi'
        ]);

        Category::query()->create([
            'name' => 'Ao chong nang'
        ]);
    }
}
