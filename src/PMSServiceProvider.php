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
use xkamen06\pms\Middlewares\Language;

include __DIR__ . '/../helper/repositories.php';

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
        // Load migrations from given folder
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // Load routes from given folder
        $this->loadRoutesFrom(__DIR__ . '/../routes/main.php');
        // Load views from given folder with 'pms' namespace
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'pms');
        // Load translations from given folder with 'pms' namespace
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'pms');
        // Push middleware to web middleware group
        app('router')->pushMiddlewareToGroup('web', Language::class);
        // Publish
        $this->publish();
        // Register singletons
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
        $this->publishes([__DIR__ . '/../publisher/resources/sass/' => base_path('resources/sass/')]);
        $this->publishes([__DIR__ . '/../publisher/public/' => base_path('public/')]);
        $this->publishes([__DIR__ . '/../publisher/config/singletons.php' => config_path('pms/singletons.php')]);
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
                $items = config('pms.singletons.items');
            } else {
                $items = config('pms.singletons.eloquents');
            }
            foreach ($items as $interface => $class) {
                $this->app->singleton($interface, $class);
            }
        } catch (\Exception $e) {}
    }
}