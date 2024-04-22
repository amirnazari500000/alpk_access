<?php

namespace Amir\Access\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class AccessProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__.'/../../vue/resources/js' => resource_path('js'),
        ], 'js');

//        Artisan::call('db:seed', ['--class' => 'Amir\Access\database\seeders\DatabaseSeeder']);


    }


}
