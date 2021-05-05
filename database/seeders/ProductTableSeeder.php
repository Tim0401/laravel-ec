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

        \App\Models\Tag::factory(config('seeder.tag_amount'))->create();

        $tags = \App\Models\Tag::all();
        \App\Models\Product::factory(config('seeder.product_amount'))
            ->create()
            ->each(function ($product) use ($tags) {
                $product->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );
            });
    }
}
