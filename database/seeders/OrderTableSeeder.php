<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('seeder.order_amount') < 10000) {
            \App\Models\Order::factory(config('seeder.order_amount'))->create();
        } else {
            for ($i = 0; $i < config('seeder.order_amount') / 10000; $i++) {
                \App\Models\Order::factory(10000)->create();
            }
        }

        if (config('seeder.order_amount') < 10000) {
            \App\Models\OrderDetail::factory(config('seeder.order_amount'))->create();
        } else {
            for ($i = 0; $i < config('seeder.order_amount') / 10000; $i++) {
                \App\Models\OrderDetail::factory(10000)->create();
            }
        }
    }
}
