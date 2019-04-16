<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: user.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Support\Facades\Route;

Route::get('/allusers', 'UserController@showAllUsers')->name('allusers');
Route::get('/userprofile/{userId}', 'UserController@showUserProfile')->name('userprofile');
Route::get('/edituser/{userId}', 'UserController@showEditForm')->name('edituser');
Route::post('/updateuser/{userId}', 'UserController@updateUser')->name('updateuser');
Route::get('/changepassword/{userId}', 'UserController@showChangePasswordForm')->name('changepassword');
Route::post('/updatepassword/{userId}', 'UserController@updatePassword')->name('updatepassword');
Route::get('/adduserform', 'UserController@showAddUserForm')->name('adduserform');
Route::post('/adduser', 'UserController@addUser')->name('adduser');
Route::get('/deleteuser/{userId}', 'UserController@deleteUser')->name('deleteuser');
