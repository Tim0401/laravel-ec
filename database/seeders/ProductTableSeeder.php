<?php

namespace Database\Seeders;

use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        // Tag
        if (config('seeder.tag_amount') < 1000) {
            \App\Models\Tag::factory(config('seeder.tag_amount'))->create();
        } else {
            for ($i = 0; $i < config('seeder.tag_amount') / 1000; $i++) {
                \App\Models\Tag::factory(1000)->create();
            }
        }

        // Product
        $tags = \App\Models\Tag::all();
        $sellers = Seller::pluck('id')->toArray();
        for ($i = 0; $i < config('seeder.product_amount') / 1000; $i++) {
            $products = \App\Models\Product::factory(1000)->make();
            \App\Models\Product::insert(array_map(function ($item) use ($sellers, $now) {
                $item['created_at'] = $now;
                $item['updated_at'] = $now;
                $item['seller_id'] = $sellers[array_rand($sellers)];
                return $item;
            }, $products->toArray()));
        }

        $products = \App\Models\Product::get();
        $products->each(function ($product) use ($tags) {
            $product->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
