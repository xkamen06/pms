<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: PMSAuthenticatesUsers.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Traits;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\View\View;

/**
 * Trait PMSAuthenticatesUsers
 * @package xkamen06\pms\Traits
 */
trait PMSAuthenticatesUsers
{
    use AuthenticatesUsers;

    /**
     * Show the application's login form.
     *
     * @return View
     */
    public function showLoginForm() : View
    {
        return view('pms::Auth.login');
    }
}