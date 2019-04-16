<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: repositories.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

if (! function_exists('userRepository')) {
    function userRepository() : \xkamen06\pms\Model\UserRepositoryInterface
    {
        static $repo = null;
        if (null === $repo) {
            $repo = app(xkamen06\pms\Model\UserRepositoryInterface::class);
        }
        return $repo;
    }
}

if (! function_exists('teamRepository')) {
    function teamRepository() : \xkamen06\pms\Model\TeamRepositoryInterface
    {
        static $repo = null;
        if (null === $repo) {
            $repo = app(xkamen06\pms\Model\TeamRepositoryInterface::class);
        }
        return $repo;
    }
}

if (! function_exists('articleRepository')) {
    function articleRepository() : \xkamen06\pms\Model\ArticleRepositoryInterface
    {
        static $repo = null;
        if (null === $repo) {
            $repo = app(xkamen06\pms\Model\ArticleRepositoryInterface::class);
        }
        return $repo;
    }
}

if (! function_exists('commentRepository')) {
    function commentRepository() : \xkamen06\pms\Model\CommentRepositoryInterface
    {
        static $repo = null;
        if (null === $repo) {
            $repo = app(xkamen06\pms\Model\CommentRepositoryInterface::class);
        }
        return $repo;
    }
}

if (! function_exists('projectRepository')) {
    function projectRepository() : \xkamen06\pms\Model\ProjectRepositoryInterface
    {
        static $repo = null;
        if (null === $repo) {
            $repo = app(xkamen06\pms\Model\ProjectRepositoryInterface::class);
        }
        return $repo;
    }
}

if (! function_exists('taskRepository')) {
    function taskRepository() : \xkamen06\pms\Model\TaskRepositoryInterface
    {
        static $repo = null;
        if (null === $repo) {
            $repo = app(xkamen06\pms\Model\TaskRepositoryInterface::class);
        }
        return $repo;
    }
}

if (! function_exists('fileRepository')) {
    function fileRepository() : \xkamen06\pms\Model\FileRepositoryInterface
    {
        static $repo = null;
        if (null === $repo) {
            $repo = app(xkamen06\pms\Model\FileRepositoryInterface::class);
        }
        return $repo;
    }
}

if (! function_exists('driverRepository')) {
    function driverRepository() : \xkamen06\pms\Model\Driver\DriverRepositoryInterface
    {
        static $repo = null;
        if (null === $repo) {
            $repo = app(xkamen06\pms\Model\Driver\DriverRepositoryInterface::class);
        }
        return $repo;
    }
}