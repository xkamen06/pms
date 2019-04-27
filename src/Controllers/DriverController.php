<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: DriverController.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Controllers;

use Illuminate\Http\RedirectResponse;
use Cache;

/**
 * Class DriverController
 * @package xkamen06\pms\Controllers
 */
class DriverController
{
    /**
     * Change driver
     *
     * @param string $driver
     *
     * @return RedirectResponse
     */
    public function changeDriver(string $driver) : RedirectResponse
    {
        driverRepository()->changeDriver($driver);
        Cache::flush();
        return redirect()->back();
    }
}