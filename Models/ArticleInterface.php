<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ArticleInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Interface ArticleInterface
 * @package xkamen06\pms\Model
 */
interface ArticleInterface
{
    /**
     * Gets articleId
     *
     * @return int|null
     */
    public function getArticleId() : ?int;

    /**
     * Gets title
     *
     * @return string
     */
    public function getTitle() : string;

    /**
     * Gets subtitle
     *
     * @return string|null
     */
    public function getSubtitle() : ?string;

    /**
     * Gets type
     *
     * @return string
     */
    public function getType() : string;

    /**
     * Gets content
     *
     * @return string
     */
    public function getContent() : string;

    /**
     * Gets path to image
     *
     * @return null|string
     */
    public function getImage() : ?string;

    /**
     * Gets userId
     *
     * @return int|null
     */
    public function getUserId() : ?int;

    /**
     * Gets teamId
     *
     * @return int
     */
    public function getTeamId() : int;

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