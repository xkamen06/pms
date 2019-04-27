<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ArticleRepositoryInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Interface ArticleRepositoryInterface
 * @package xkamen06\pms\Model
 */
interface ArticleRepositoryInterface
{
    /**
     * Get few (number) articles by its id
     *
     * @param int $teamId
     *
     * @param int $number
     *
     * @return array
     */
    public function getFewArticlesByTeamId(int $teamId, int $number) : array;

    /**
     * Get all articles by team id
     *
     * @param int $teamId
     *
     * @return array
     */
    public function getAllArticlesByTeamId(int $teamId) : array;

    /**
     * Get article by its id
     *
     * @param int $articleId
     *
     * @return ArticleInterface
     *
     * @throws NotFoundHttpException
     */
    public function getArticleById(int $articleId) : ArticleInterface;

    /**
     * Delete article by articleId
     *
     * @param int $articleId
     *
     * @return void
     */
    public function deleteArticleById(int $articleId) : void;

    /**
     * Update article by articleId
     *
     * @param int $articleId
     *
     * @param array $params
     *
     * @param string|null $path
     *
     * @return void
     */
    public function updateArticle(int $articleId, array $params, ?string $path) : void;

    /**
     * Add article
     *
     * @param int $teamId
     *
     * @param array $params
     *
     * @param string $path
     *
     * @return void
     */
    public function addArticle(int $teamId, array $params, ?string $path) : void;
}