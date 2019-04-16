<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ArticleRepository.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Eloquents;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\ArticleInterface;
use xkamen06\pms\Model\ArticleRepositoryInterface;
use xkamen06\pms\Notifications\NewTeamArticleNotification;

/**
 * Class ArticleRepository
 * @package xkamen06\pms\Model\Eloquents
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
            return $this->toArray(ArticleEloquent::where('teamid', '=', $teamId)
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
            return $this->toArray(ArticleEloquent::where('teamid', '=', $teamId)
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
        $article = $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($articleId) {
            return ArticleEloquent::where('articleid' , '=', $articleId)->first();
        });
        if ($article)
        {
            return $article;
        }
        throw new NotFoundHttpException();
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
        ArticleEloquent::where('articleid', '=', $articleId)->delete();
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
    public function updateArticle(int $articleId, array $params, ?string $path) : void
    {
        if ($path) {
            ArticleEloquent::where('articleid', '=', $articleId)->update([
                'title' => $params['title'],
                'subtitle' => $params['subtitle'],
                'type' => $params['type'],
                'content' => $params['content'],
                'image' => $path
            ]);
        } else {
            ArticleEloquent::where('articleid', '=', $articleId)->update([
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
        $articleId = ArticleEloquent::insertGetId([
           'title' => $params['title'],
           'subtitle' => $params['subtitle'],
           'type' => $params['type'],
           'content' => $params['content'],
           'image' => $path,
           'userid' => auth()->user()->id,
           'teamid' => $teamId,
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $team = teamRepository()->getTeamById($teamId);
        $users = userRepository()->getUsersByTeamId($teamId);
        $users[] = userRepository()->getUserById($team->getLeaderId());
        foreach ($users as $user) {
            $user->notify(new NewTeamArticleNotification(auth()->user()->id, $teamId, $articleId));
        }
    }

}