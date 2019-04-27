<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: PMSServiceProvider.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms;

use Illuminate\Support\ServiceProvider;

include __DIR__ . '/Helpers/repositories.php';

/**
 * Class PMSServiceProvider
 *
 * @package xkamen06\pms
 */
class PMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/Routes/main.php');
        $this->loadViewsFrom(__DIR__ . '/Views', 'pms');
        $this->publish();
        $this->registerSingletons();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Publish all resources
     */
    public function publish(): void
    {
        $this->publishes([__DIR__ . '/Publisher/resources/assets/sass/' => base_path('resources/assets/sass/')]);
        $this->publishes([__DIR__ . '/Publisher/public/' => base_path('public/')]);
        $this->publishes([__DIR__ . '/Views/Auth/' => base_path('resources/views/auth/')]);
        $this->publishes([__DIR__ . '/Configs/' => base_path('config/')]);
        $this->publishes([__DIR__ . '/Lang' => base_path('resources/lang/')]);
    }

    /**
     * Register singletons
     */
    public function registerSingletons(): void
    {
        $this->app->singleton( 'xkamen06\pms\Model\Driver\DriverRepositoryInterface',
            'xkamen06\pms\Model\Driver\DriverRepository');

        try {
            if (driverRepository()->getDriver() === 'item') {
                $items = config('singletons.items');
            } else {
                $items = config('singletons.eloquents');
            }
            foreach ($items as $interface => $class) {
                $this->app->singleton($interface, $class);
            }
        } catch (\Exception $e) {}
    }
}