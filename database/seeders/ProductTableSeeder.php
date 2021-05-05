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

        \App\Models\Tag::factory(10)->create();

        $tags = \App\Models\Tag::all();
        \App\Models\Product::factory(100)
            ->create()
            ->each(function ($product) use ($tags) {
                $product->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );
            });
    }
}
