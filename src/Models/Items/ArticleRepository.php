<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ArticleRepository.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Items;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\ArticleInterface;
use xkamen06\pms\Model\ArticleRepositoryInterface;
use xkamen06\pms\Notifications\NewTeamArticleNotification;

/**
 * Class ArticleRepository
 * @package xkamen06\pms\Model\Items
 */
class ArticleRepository extends Repository implements ArticleRepositoryInterface
{
    /**
     * @var string Database table name
     */
    protected $table = 'article';

    /**
     * How long are data stored in cache
     * @var int
     */
    protected $cacheInterval = 1;

    /**
     * Cached tags
     * @var array
     */
    protected $cacheTags = ['ArticleRepository', 'article'];


    /**
     * Fetched row from database to ArticleItem
     *
     * @param $fetchedRow
     *
     * @return ArticleItem
     *
     * @throws NotFoundHttpException
     */
    protected function toItem($fetchedRow) : ArticleItem
    {
        if($fetchedRow === null) {
            throw new NotFoundHttpException();
        }
        return new ArticleItem((array)$fetchedRow);
    }

    /**
     * Get few (specified by variable $number) team's articles by team id
     *
     * @param int $teamId
     *
     * @param int $number
     *
     * @return array
     */
    public function getFewArticlesByTeamId(int $teamId, int $number) : array
    {
        $cacheKey = 'ArticleRepository.getFewArticlesByTeamId' . $teamId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($teamId, $number) {
            return $this->toItems($this->getQuery()->where('teamid', '=', $teamId)
                ->orderBy('created_at', 'desc')->take($number)->get());
        });
    }

    /**
     * Get all articles by team id
     *
     * @param int $teamId
     *
     * @return array
     */
    public function getAllArticlesByTeamId(int $teamId) : array
    {
        $cacheKey = 'ArticleRepository.getAllArticlesByTeamId' . $teamId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($teamId) {
            return $this->toItems($this->getQuery()->where('teamid', '=', $teamId)
                ->orderBy('created_at', 'desc')->get());
        });
    }

    /**
     * Get article by its id
     *
     * @param int $articleId
     *
     * @return ArticleInterface
     *
     * @throws NotFoundHttpException
     */
    public function getArticleById(int $articleId) : ArticleInterface
    {
        $cacheKey = 'ArticleRepository.getArticleById' . $articleId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($articleId) {
            return $this->toItem($this->getQuery()->where('articleid', '=', $articleId)->first());
        });
    }

    /**
     * Delete article by articleId
     *
     * @param int $articleId
     *
     * @return void
     */
    public function deleteArticleById(int $articleId) : void
    {
        commentRepository()->deleteCommentsByArticleId($articleId);
        $this->getQuery()->where('articleid', '=', $articleId)->delete();
    }

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
    public function updateArticle(int $articleId, array $params, ?string  $path) : void
    {
        if ($path) {
            $this->getQuery()->where('articleid', '=', $articleId)->update([
                'title' => $params['title'],
                'subtitle' => $params['subtitle'],
                'type' => $params['type'],
                'content' => $params['content'],
                'image' => $path
            ]);
        } else {
            $this->getQuery()->where('articleid', '=', $articleId)->update([
                'title' => $params['title'],
                'subtitle' => $params['subtitle'],
                'type' => $params['type'],
                'content' => $params['content'],
            ]);
        }

    }

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
     *
     * @throws NotFoundHttpException
     */
    public function addArticle(int $teamId, array $params, ?string $path) : void
    {
        $params['teamid'] = $teamId;
        $params['image'] = $path;
        $article = new ArticleItem($params);
        $articleId = $article->save();

        $team = teamRepository()->getTeamById($teamId);
        $users = userRepository()->getUsersByTeamId($teamId);
        $users[] = userRepository()->getUserById($team->getLeaderId());
        foreach ($users as $user) {
            $user->notify(new NewTeamArticleNotification(auth()->user()->id, $teamId, $articleId));
        }
    }
}