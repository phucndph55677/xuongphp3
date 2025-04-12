<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code'=> Str::upper(fake()->bothify('??###?')),
            'name' => fake()->text(25),
            'image' => fake()->imageUrl(),
            'description' => fake()->paragraph(),
            'metarial' => fake()->text(30),
            'instruct' => fake()->text(99),
            'onpage' => rand(0, 1),
            'category_id' => rand(1, 4),
        ];
    }
}
