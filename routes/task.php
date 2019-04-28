<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: task.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Support\Facades\Route;

Route::get('/showcreatetaskform/{projectId}', 'TaskController@showCreateTaskForm')->name('showcreatetaskform');
Route::post('/createtask/{projectId}', 'TaskController@createTask')->name('createtask');
Route::get('/showtask/{taskId}/{editCommentId?}', 'TaskController@showTask')->name('showtask');
Route::get('/showedittaskform/{taskId}', 'TaskController@showEditTaskFOrm')->name('showedittaskform');
Route::post('/updatetask/{taskId}', 'TaskController@updateTask')->name('updatetask');
Route::get('/addmembertotaskform/{taskId}', 'TaskController@showAddMemberForm')->name('addmembertotaskform');
Route::post('/addmemberstotask/{taskId}', 'TaskController@addMembers')->name('addmemberstotask');
Route::get('/deletetaskmember/{taskId}/{userId}', 'TaskController@deleteTaskMember')->name('deletetaskmember');
Route::get('/changetaskstatus/{taskId}/{status}', 'TaskController@changeTaskStatus')->name('changetaskstatus');
Route::get('/deletetaskbyid/{taskId}', 'TaskController@deleteTaskById')->name('deletetaskbyid');
Route::get('/assigntasktome/{taskId}', 'TaskController@assignTaskToMe')->name('assigntasktome');