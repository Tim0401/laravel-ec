<?php

namespace App\Http\Middleware;

use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            $uri = $request->path();
            Debugbar::info($uri);

            // URIが以下から始まる場合
            if (Str::startsWith($uri, ['cms/'])) {
                return route('cms.login');
            }
            return route('login');
        }
    }
}
