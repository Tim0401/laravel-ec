<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->realText(rand(10, 20)),
            'description' => $this->faker->realText,
            'price' => $this->faker->numberBetween(0, 100),
            'stock' => $this->faker->numberBetween(0, 100),
            'image_path' => '/storage/noimage.png'
        ];
    }
}
