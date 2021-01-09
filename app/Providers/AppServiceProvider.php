<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //自定义验证规则
        Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            $reg = '/^1[3-9]\d{9}$/';
            return preg_match($reg,$value);
        });

        }
}
