<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->text(200),
            'price' => $this->faker->numberBetween(1000, 100000),
            'stock' => $this->faker->numberBetween(1, 100),
            'image' => $this->faker->imageUrl(640, 480, 'products'),
            'category_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
