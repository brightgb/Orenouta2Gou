<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        /** 歌部門 **/
        $this->mapSongWebRoutes();
        $this->mapSongApiRoutes();

        /** 漫才部門 **/
        $this->mapManzaiWebRoutes();

        /** 管理画面 **/
        $this->mapAdminWebRoutes();
        $this->mapAdminApiRoutes();
    }

    // 歌部門
    protected function mapSongWebRoutes()
    {
        Route::prefix('song')
             ->middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/song/web.php'));
    }
    protected function mapSongApiRoutes()
    {
        Route::prefix('song')
             ->middleware('SongApi')
             ->namespace($this->namespace)
             ->group(base_path('routes/song/api.php'));
    }

    // 漫才部門
    protected function mapManzaiWebRoutes()
    {
        Route::prefix('manzai')
             ->middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/manzai/web.php'));
    }

    // 管理画面
    protected function mapAdminWebRoutes()
    {
        Route::prefix('admin')
             ->middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/admin_web.php'));
    }
    protected function mapAdminApiRoutes()
    {
        Route::prefix('admin')
             ->middleware('adminApi')
             ->namespace($this->namespace)
             ->group(base_path('routes/admin_api.php'));
    }


    /*
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    protected function mapAdminApiRoutes()
    {
        Route::prefix('admin/api')
             ->middleware('adminApi')
             ->namespace($this->namespace)
             ->group(base_path('routes/admin/api.php'));
    }
    */
}