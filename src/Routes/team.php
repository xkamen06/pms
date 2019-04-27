<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: team.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Support\Facades\Route;

Route::get('/allteams', 'TeamController@showAllTeams')->name('allteams');
Route::get('/showteam/{teamId}', 'TeamController@showTeam')->name('showteam');
Route::get('/deleteteammember/{teamId}/{userId}', 'TeamController@deleteUserFromTeam')->name('deleteteammember');
Route::get('/deleteteam/{teamId}', 'TeamController@deleteTeam')->name('deleteteam');
Route::get('/editteam/{teamId}', 'TeamController@showEditForm')->name('editteam');
Route::post('/updateteam/{teamId}', 'TeamController@updateTeam')->name('updateteam');
Route::get('/createteamform', 'TeamController@showCreateForm')->name('createteamform');
Route::post('/createteam', 'TeamController@createTeam')->name('createteam');
Route::get('/addmembertoteamform/{teamId}', 'TeamController@showAddMemberForm')->name('addmembertoteamform');
Route::post('/addmemberstoteam/{teamId}', 'TeamController@addMembers')->name('addmemberstoteam');

