<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: driver.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Support\Facades\Route;

Route::get('/changedriver/{driver}', 'DriverController@changeDriver')->name('changedriver');