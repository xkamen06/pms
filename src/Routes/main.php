<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: main.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'xkamen06\pms\Controllers', 'middleware' => 'web'], function () {
    include __DIR__ . '/auth.php';
    Route::middleware(['auth'])->group(function() {
        include __DIR__ . '/user.php';
        include __DIR__ . '/dashboard.php';
        include __DIR__ . '/team.php';
        include __DIR__ . '/article.php';
        include __DIR__ . '/comment.php';
        include __DIR__ . '/project.php';
        include __DIR__ . '/task.php';
        include __DIR__ . '/driver.php';
        include __DIR__ . '/language.php';
        include __DIR__ . '/project.php';
        include __DIR__ . '/file.php';
    });
    Route::get('/', function () {
        if (auth()->user()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login');
        }
    });
});

