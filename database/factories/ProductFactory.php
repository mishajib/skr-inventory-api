<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name'        => fake()->word,
            'code'        => fake()->unique()->randomNumber(8),
            'cost'        => fake()->randomFloat(2, 1, 1000),
            'price'       => fake()->randomFloat(2, 1, 1000),
            'note'        => fake()->text,
            'brand_id'    => fake()->randomElement(Brand::all()->pluck('id')->toArray()),
            'category_id' => fake()->randomElement(Category::all()->pluck('id')->toArray()),
            'unit_id'     => fake()->randomElement(Unit::all()->pluck('id')->toArray()),
        ];
    }
}
