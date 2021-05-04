<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewSeller;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        $this->multiLoginCustomize();
    }

    /**
     * マルチログインのカスタマイズ用メソッド
     * @return void
     */
    private function multiLoginCustomize()
    {
        // urlからユーザーを取得
        $user = \Str::of(\Request::path())->before('/');
        if (in_array($user, ['cms'])) {
            Fortify::createUsersUsing(CreateNewSeller::class);
            // FortifyのviewPrefixを書き換え（各ユーザー用viewを使用）
            Fortify::viewPrefix('cms.auth.');
            // 権限ページに合わせたguardの切り替え
            \Config::set('fortify.guard', 'cms');
            // ダッシュボードの切り替え
            \Config::set('fortify.home', '/cms' . RouteServiceProvider::HOME);
        } else {
            Fortify::createUsersUsing(CreateNewUser::class);
        }
    }
}
