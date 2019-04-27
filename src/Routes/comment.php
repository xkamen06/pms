<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: comment.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Support\Facades\Route;

Route::post('/addarticlecomment/{articleId}', 'CommentController@addArticleComment')->name('addarticlecomment');
Route::post('/addtaskcomment/{taskId}', 'CommentController@addTaskComment')->name('addtaskcomment');
Route::get('/deletecomment/{commentId}', 'CommentController@deleteComment')->name('deletecomment');
Route::get('/updatearticlecomment/{commentId}/{articleId}', 'CommentController@updatearticleComment')->name('updatearticlecomment');
Route::get('/updatetaskcomment/{commentId}/{taskId}', 'CommentController@updatetaskComment')->name('updatetaskcomment');
