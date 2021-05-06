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
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $users = User::pluck('id')->toArray();
        for ($i = 0; $i < config('seeder.order_amount') / 1000; $i++) {
            $orders = \App\Models\Order::factory(1000)->make();
            \App\Models\Order::insert(array_map(function ($item) use ($users, $now) {
                $item['created_at'] = $now;
                $item['updated_at'] = $now;
                $item['user_id'] = $users[array_rand($users)];
                return $item;
            }, $orders->toArray()));
        }

        // $orders = Order::limit()->pluck('id')->toArray();
        $products = Product::pluck('id')->toArray();
        // for ($i = 0; $i < config('seeder.order_amount') / 1000; $i++) {
        //     $orderDetails = \App\Models\OrderDetail::factory(1000)->make();
        //     \App\Models\OrderDetail::insert(array_map(function ($item) use ($orders, $products, $now) {
        //         $item['created_at'] = $now;
        //         $item['updated_at'] = $now;
        //         $item['order_id'] = $orders[array_rand($orders)];
        //         $item['product_id'] = $products[array_rand($products)];
        //         return $item;
        //     }, $orderDetails->toArray()));
        // }

        Order::orderBy('id')->chunk(1000, function ($orders) use ($products, $now) {
            $orderDetails = \App\Models\OrderDetail::factory(1000)->make();
            $orderIds = $orders->pluck('id')->toArray();
            \App\Models\OrderDetail::insert(array_map(function ($item) use ($orderIds, $products, $now) {
                $item['created_at'] = $now;
                $item['updated_at'] = $now;
                $item['order_id'] = $orderIds[array_rand($orderIds)];
                $item['product_id'] = $products[array_rand($products)];
                return $item;
            }, $orderDetails->toArray()));
        });
    }
}
