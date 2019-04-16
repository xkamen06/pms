<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: singletons.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

/**
 * Configuration file to register singletons in PMSServiceProvider
 */
return [
    'items' => [
        'xkamen06\pms\Model\UserRepositoryInterface' => 'xkamen06\pms\Model\Items\UserRepository',
        'xkamen06\pms\Model\UserInterface' => 'xkamen06\pms\Model\Items\UserItem',

        'xkamen06\pms\Model\TeamRepositoryInterface' => 'xkamen06\pms\Model\Items\TeamRepository',
        'xkamen06\pms\Model\TeamInterface' => 'xkamen06\pms\Model\Items\TeamItem',

        'xkamen06\pms\Model\ProjectRepositoryInterface' => 'xkamen06\pms\Model\Items\ProjectRepository',
        'xkamen06\pms\Model\ProjectInterface' => 'xkamen06\pms\Model\Items\ProjectItem',

        'xkamen06\pms\Model\TaskRepositoryInterface' => 'xkamen06\pms\Model\Items\TaskRepository',
        'xkamen06\pms\Model\TaskInterface' => 'xkamen06\pms\Model\Items\TaskItem',

        'xkamen06\pms\Model\CommentRepositoryInterface' => 'xkamen06\pms\Model\Items\CommentRepository',
        'xkamen06\pms\Model\CommentInterface' => 'xkamen06\pms\Model\Items\CommentItem',

        'xkamen06\pms\Model\ArticleRepositoryInterface' => 'xkamen06\pms\Model\Items\ArticleRepository',
        'xkamen06\pms\Model\ArticleInterface' => 'xkamen06\pms\Model\Items\ArticleItem',

        'xkamen06\pms\Model\FileRepositoryInterface' => 'xkamen06\pms\Model\Items\FileRepository',
        'xkamen06\pms\Model\FileInterface' => 'xkamen06\pms\Model\Items\FileItem',
    ],

    'eloquents' => [
        'xkamen06\pms\Model\UserRepositoryInterface' => 'xkamen06\pms\Model\Eloquents\UserRepository',
        'xkamen06\pms\Model\UserInterface' => 'xkamen06\pms\Model\Eloquents\UserEloquent',

        'xkamen06\pms\Model\TeamRepositoryInterface' => 'xkamen06\pms\Model\Eloquents\TeamRepository',
        'xkamen06\pms\Model\TeamInterface' => 'xkamen06\pms\Model\Eloquents\TeamEloquent',

        'xkamen06\pms\Model\ProjectRepositoryInterface' => 'xkamen06\pms\Model\Eloquents\ProjectRepository',
        'xkamen06\pms\Model\ProjectInterface' => 'xkamen06\pms\Model\Eloquents\ProjectEloquent',

        'xkamen06\pms\Model\TaskRepositoryInterface' => 'xkamen06\pms\Model\Eloquents\TaskRepository',
        'xkamen06\pms\Model\TaskInterface' => 'xkamen06\pms\Model\Eloquents\TaskEloquent',

        'xkamen06\pms\Model\CommentRepositoryInterface' => 'xkamen06\pms\Model\Eloquents\CommentRepository',
        'xkamen06\pms\Model\CommentInterface' => 'xkamen06\pms\Model\Eloquents\CommentEloquent',

        'xkamen06\pms\Model\ArticleRepositoryInterface' => 'xkamen06\pms\Model\Eloquents\ArticleRepository',
        'xkamen06\pms\Model\ArticleInterface' => 'xkamen06\pms\Model\Eloquents\ArticleEloquent',

        'xkamen06\pms\Model\FileRepositoryInterface' => 'xkamen06\pms\Model\Eloquents\FileRepository',
        'xkamen06\pms\Model\FileInterface' => 'xkamen06\pms\Model\Eloquents\FileEloquent',
    ]
];