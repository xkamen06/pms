<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: project.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Support\Facades\Route;

Route::get('/allprojects', 'ProjectController@showAllProjects')->name('allprojects');
Route::get('/showproject/{teamId}', 'ProjectController@showProject')->name('showproject');
Route::get('/deleteprojectmember/{projectId}/{userId}', 'ProjectController@deleteUserFromProject')->name('deleteprojectmember');
Route::get('/changeprojectstatus/{projectId}/{change}', 'ProjectController@changeProjectStatus')->name('changeprojectstatus');
Route::get('/editproject/{projectId}', 'ProjectController@showEditForm')->name('editproject');
Route::post('/updateproject/{projectId}', 'ProjectController@updateProject')->name('updateproject');
Route::get('/addmembertoprojectform/{teamId}', 'ProjectController@showAddMemberForm')->name('addmembertoprojectform');
Route::post('/addmemberstoproject/{teamId}', 'ProjectController@addMembers')->name('addmemberstoproject');
Route::get('/createprojectform', 'ProjectController@showCreateForm')->name('createprojectform');
Route::post('/createproject', 'ProjectController@createProject')->name('createproject');
Route::get('/deleteproject/{projectId}', 'ProjectController@deleteProject')->name('deleteproject');
