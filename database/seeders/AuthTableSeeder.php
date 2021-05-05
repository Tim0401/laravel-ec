<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::insert([
            'name' => 'テストユーザー',
            'email' => config('seeder.sample_user_email'),
            'password' => Hash::make('password'),
        ]);
        if (config('seeder.user_amount') < 10000) {
            \App\Models\User::factory(config('seeder.user_amount'))->create();
        } else {
            for ($i = 0; $i < config('seeder.user_amount') / 10000; $i++) {
                \App\Models\User::factory(10000)->create();
            }
        }

        \App\Models\Seller::insert([
            'name' => 'テストCMS',
            'email' => config('seeder.sample_cms_email'),
            'password' => Hash::make('password'),
        ]);
        if (config('seeder.seller_amount') < 10000) {
            \App\Models\Seller::factory(config('seeder.seller_amount'))->create();
        } else {
            for ($i = 0; $i < config('seeder.seller_amount') / 10000; $i++) {
                \App\Models\Seller::factory(10000)->create();
            }
        }
    }
}
