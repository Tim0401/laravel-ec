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
        \App\Models\User::factory(config('seeder.user_amount'))->create();

        \App\Models\Seller::insert([
            'name' => 'テストCMS',
            'email' => config('seeder.sample_cms_email'),
            'password' => Hash::make('password'),
        ]);
        \App\Models\Seller::factory(config('seeder.seller_amount'))->create();
    }
}
