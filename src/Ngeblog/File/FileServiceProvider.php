<?php

namespace Ngeblog\File;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::group([
                'prefix' => 'api',
                'middleware' => ['api']
            ], function () {
                $this->loadRoutesFrom(__DIR__.'/routes/api.php');
            });

        Route::group(['middleware' => ['web']], function () {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        });

        $this->loadViewsFrom(__DIR__.'/resources/views', 'file');
    }
}
