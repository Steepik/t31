<?php

namespace App\Providers;

use App\GlobalNotify;
use App\NotifyUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        Schema::defaultStringLength(191);

        Blade::if('admin', function() {
            return Auth::user()->is_admin;
        });

        Blade::if('wholesaler', function() {
            if (Auth::check() && Auth::user()->is_admin)
                return true;

            if (Auth::check())
                return Auth::user()->is_wholesaler || User::isAvailableToShowOptPriceForRoz();

            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
