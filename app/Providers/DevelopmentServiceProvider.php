<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider as BarryvdhIdeHelperServiceProvider;
use Barryvdh\Debugbar\ServiceProvider as BarryvdhDebugbarServiceProvider;

class DevelopmentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // .envにてAPP_DEBUGがtrueなら開発用パッケージを読込
		if (env('APP_DEBUG', false)) {
			$this->app->register(BarryvdhIdeHelperServiceProvider::class);
			$this->app->register(BarryvdhDebugbarServiceProvider::class);
		}
    }
}
