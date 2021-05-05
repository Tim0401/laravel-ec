<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('seeder.tag_amount') < 10000) {
            \App\Models\Tag::factory(config('seeder.tag_amount'))->create();
        } else {
            for ($i = 0; $i < config('seeder.tag_amount') / 10000; $i++) {
                \App\Models\Tag::factory(10000)->create();
            }
        }

        $tags = \App\Models\Tag::all();

        if (config('seeder.order_amount') < 10000) {
            \App\Models\Product::factory(config('seeder.product_amount'))
                ->create()
                ->each(function ($product) use ($tags) {
                    $product->tags()->attach(
                        $tags->random(rand(1, 3))->pluck('id')->toArray()
                    );
                });
        } else {
            for ($i = 0; $i < config('seeder.order_amount') / 10000; $i++) {
                \App\Models\Product::factory(10000)
                    ->create()
                    ->each(function ($product) use ($tags) {
                        $product->tags()->attach(
                            $tags->random(rand(1, 3))->pluck('id')->toArray()
                        );
                    });
            }
        }
    }
}
