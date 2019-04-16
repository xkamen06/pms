<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: language.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Support\Facades\Route;

Route::get('/language/{locale}', function ($locale) {
    session(['my_locale' => $locale]);
    return redirect()->back();
})->name('language');