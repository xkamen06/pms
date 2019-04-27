<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: CommentRepository.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Interface CommentInterface
 * @package xkamen06\pms\Model
 */
interface CommentInterface
{
    /**
     * Gets comment id
     *
     * @return int|null
     */
    public function getCommentId() : ?int;

    /**
     * Gets content
     *
     * @return string
     */
    public function getContent() : string;

    /**
     * Gets user id
     *
     * @return int|null
     */
    public function getUserId() : ?int;

    /**
     * Gets article id
     *
     * @return int|null
     */
    public function getArticleId() : ?int;

    /**
     * Gets task id
     *
     * @return int|null
     */
    public function getTaskId() : ?int;

    /**
     * Gets created_at
     *
     * @return string|null
     */
    public function getCreatedAt() : ?string;

    /**
     * Gets updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt() : ?string;

    /**
     * Gets UserItem - owner of this article
     *
     * @return UserInterface|null
     *
     * @throws NotFoundHttpException
     */
    public function getOwner() : ?UserInterface;

    /**
     * Gets added at
     *
     * @return null|string
     */
    public function getAddedAt() : ?string;
}