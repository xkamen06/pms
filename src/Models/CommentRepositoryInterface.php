<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: CommentRepositoryInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Interface CommentRepositoryInterface
 * @package xkamen06\pms\Model
 */
interface CommentRepositoryInterface
{
    /**
     * Get comment by id
     *
     * @param int $commentId
     *
     * @return CommentInterface
     *
     * @throws NotFoundHttpException
     */
    public function getCommentById(int $commentId) : CommentInterface;

    /**
     * Get comments by article id
     *
     * @param int $articleId
     *
     * @return array
     */
    public function getCommentsByArticleId(int $articleId) : array;

    /**
     * Delete comments by articleId
     *
     * @param int $articleId
     *
     * @return void
     */
    public function deleteCommentsByArticleId(int $articleId) : void;

    /**
     * Add comment
     *
     * @param array $param
     *
     * @param array $params
     *
     * @return void
     */
    public function addComment(array $param, array $params) : void;

    /**
     * Delete comment
     *
     * @param int $commentId
     *
     * @return void
     */
    public function deleteComment(int $commentId) : void;

    /**
     * Update comment
     *
     * @param int $commentId
     *
     * @param array $params
     *
     * @return void
     */
    public function updateComment(int $commentId, array $params) : void;

    /**
     * Get comments by article id
     *
     * @param int $taskId
     *
     * @return array
     */
    public function getCommentsByTaskId(int $taskId) : array;

    /**
     * Delete comments by taskid
     *
     * @param int $taskId
     *
     * @return void
     */
    public function deleteCommentsByTaskId(int $taskId) : void;
}