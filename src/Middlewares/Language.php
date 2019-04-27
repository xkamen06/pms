<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: Language.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

/**
 * Class Language
 * @package xkamen06\pms\Middlewares
 */
class Language {

    /**
     * Language constructor.
     * @param Application $app
     * @param Request $request
     */
    public function __construct(Application $app, Request $request) {
        $this->app = $app;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->app->setLocale(session('my_locale', config('app.locale')));

        return $next($request);
    }
}
