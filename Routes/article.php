<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: article.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Support\Facades\Route;

Route::get('/articlesbyteam/{teamId}', 'ArticleController@showArticlesByTeamId')->name('articlesbyteam');
Route::get('/showarticle/{articleId}/{editCommentId?}', 'ArticleController@showArticleById')->name('articlebyid');
Route::get('/deletearticle/{articleId}', 'ArticleController@deleteArticleById')->name('deletearticle');
Route::get('/editarticle/{articleId}', 'ArticleController@showEditForm')->name('editarticle');
Route::post('/updatearticle/{articleId}', 'ArticleController@updateArticle')->name('updatearticle');
Route::get('/addarticleform/{teamId}', 'ArticleController@showAddForm')->name('addarticleform');
Route::post('/addarticle/{teamId}', 'ArticleController@addArticle')->name('addarticle');

