<?php

namespace Ngeblog\Install;

use Illuminate\Support\ServiceProvider;
use Ngeblog\Install\Console\Commands\NgeblogInstallCommand;

class InstallServiceProvider extends ServiceProvider
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
        if ($this->app->runningInConsole()) {
            $this->commands([
                NgeblogInstallCommand::class
            ]);
        }

        $this->loadMigrationsFrom(__DIR__ . '\..\..\..\database\migrations');
    }
}
