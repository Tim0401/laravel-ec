<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::pluck('id')->toArray();
        for ($i = 0; $i < config('seeder.order_amount') / 1000; $i++) {
            $orders = \App\Models\Order::factory(1000)->make();
            \App\Models\Order::insert(array_map(function ($item) use (&$users) {
                $item['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
                $item['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
                $item['user_id'] = $users[array_rand($users)];
                return $item;
            }, $orders->toArray()));
        }

        $orders = Order::pluck('id')->toArray();
        $products = Product::pluck('id')->toArray();
        for ($i = 0; $i < config('seeder.order_amount') / 1000; $i++) {
            $orderDetails = \App\Models\OrderDetail::factory(1000)->make();
            \App\Models\OrderDetail::insert(array_map(function ($item) use (&$orders, &$products) {
                $item['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
                $item['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
                $item['order_id'] = $orders[array_rand($orders)];
                $item['product_id'] = $products[array_rand($products)];
                return $item;
            }, $orderDetails->toArray()));
        }
    }
}
