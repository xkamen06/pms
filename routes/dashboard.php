<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: dashboard.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', 'DashboardController@showDashboard')->name('dashboard');
