<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $orders = Order::pluck('id')->toArray();
        $products = Product::pluck('id')->toArray();
        return [
            'order_id' => $this->faker->randomElement($orders),
            'product_id' => $this->faker->randomElement($products),
            'price' => $this->faker->numberBetween(0, 100),
            'amount' => $this->faker->numberBetween(0, 100),
        ];
    }
}
