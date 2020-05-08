<?php

namespace Fmujie\TulingApi;

use Illuminate\Support\ServiceProvider;

class TulingApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
     public function boot()
    {
        // 发布配置文件
        $this->publishes([
            __DIR__.'/config/laravel-tuling-apikey.php' => config_path('laravel-tuling-apikey.php'), // 发布配置文件到 laravel 的config 下
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function register()
    {
         //
    }
}
