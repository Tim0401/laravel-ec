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
        \App\Models\Order::factory(config('seeder.order_amount'))->create();
        \App\Models\OrderDetail::factory(config('seeder.order_amount'))->create();
    }
}
