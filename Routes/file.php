<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: file.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Support\Facades\Route;

Route::get('/showaddtoprojectfileform/{projectId}', 'FileController@showAddFileToProjectForm')->name('showaddtoprojectfileform');
Route::get('/showaddtotaskfileform/{taskId}', 'FileController@showAddFileToTaskForm')->name('showaddtotaskfileform');
Route::post('/addfiletoproject/{projectId}', 'FileController@addFileToProject')->name('addfiletoproject');
Route::post('/addfiletotask/{taskId}', 'FileController@addFileToTask')->name('addfiletotask');
Route::get('/downloadfile/{fileId}', 'FileController@downloadFile')->name('downloadfile');
Route::get('/deletefile/{fileId}', 'FileController@deleteFile')->name('deletefile');
Route::get('/movefiletoproject/{fileId}/{projectId}', 'FileController@moveFileToProject')->name('movefiletoproject');
Route::get('/copyfiletoproject/{fileId}/{projectId}', 'FileController@copyFileToProject')->name('copyfiletoproject');