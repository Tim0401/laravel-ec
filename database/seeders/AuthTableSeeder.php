<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

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
        if (config('seeder.user_amount') < 1000) {
            \App\Models\User::factory(config('seeder.user_amount'))->create();
        } else {
            for ($i = 0; $i < config('seeder.user_amount') / 1000; $i++) {
                $users = \App\Models\User::factory(1000)->make();
                \App\Models\User::insert(array_map(function ($item) {
                    $item['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
                    $item['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
                    $item['email_verified_at'] = Carbon::now()->format('Y-m-d H:i:s');
                    $item['password'] = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password
                    unset($item['profile_photo_url']);
                    return $item;
                }, $users->toArray()));
            }
        }

        \App\Models\Seller::insert([
            'name' => 'テストCMS',
            'email' => config('seeder.sample_cms_email'),
            'password' => Hash::make('password'),
        ]);
        if (config('seeder.seller_amount') < 1000) {
            \App\Models\Seller::factory(config('seeder.seller_amount'))->create();
        } else {
            for ($i = 0; $i < config('seeder.seller_amount') / 1000; $i++) {
                $sellers = \App\Models\Seller::factory(1000)->make();
                \App\Models\Seller::insert(array_map(function ($item) {
                    $item['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
                    $item['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
                    $item['email_verified_at'] = Carbon::now()->format('Y-m-d H:i:s');
                    $item['password'] = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password
                    unset($item['profile_photo_url']);
                    return $item;
                }, $sellers->toArray()));
            }
        }
    }
}
