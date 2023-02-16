<?php

namespace App\Providers;

use App\Services\GeometriService;
use App\Services\SawahService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class DependencyInjectionProvider extends ServiceProvider
{

    public array $singletons = [
        GeometriService::class,
        SawahService::class,
        UserService::class
    ];

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
        //
    }
}
