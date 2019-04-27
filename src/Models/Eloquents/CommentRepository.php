<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: CommentRepository.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Eloquents;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\CommentInterface;
use xkamen06\pms\Model\CommentRepositoryInterface;
use xkamen06\pms\Notifications\NewArticleCommentNotification;
use xkamen06\pms\Notifications\NewTeamArticleNotification;

/**
 * Class CommentRepository
 * @package xkamen06\pms\Model\Eloquents
 */
class CommentRepository extends Repository implements CommentRepositoryInterface
{
    /**
     * @var string Database table name
     */
    protected $table = 'comment';

    /**
     * How long are data stored in cache
     * @var int
     */
    protected $cacheInterval = 1;

    /**
     * Cached tags
     * @var array
     */
    protected $cacheTags = ['CommentRepository', 'comment'];


    /**
     * Get comment by id
     *
     * @param int $commentId
     *
     * @return CommentInterface
     *
     * @throws NotFoundHttpException
     */
    public function getCommentById(int $commentId) : CommentInterface
    {
        $cacheKey = 'CommentRepository.getCommentById' . $commentId;

        $comment = $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($commentId) {
           return CommentEloquent::where('commentid', '=', $commentId)->first(); 
        });
        if ($comment) {
            return $comment;
        }
        throw new NotFoundHttpException();
    }

    /**
     * Get comments by article id
     *
     * @param int $articleId
     *
     * @return array
     */
    public function getCommentsByArticleId(int $articleId) : array
    {
        $cacheKey = 'CommentRepository.getCommentsByArticleId' . $articleId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($articleId) {
            return $this->toArray(CommentEloquent::where('articleid', '=', $articleId)->get());
        });
    }

    /**
     * Delete comments by articleId
     *
     * @param int $articleId
     *
     * @return void
     */
    public function deleteCommentsByArticleId(int $articleId) : void
    {
        CommentEloquent::where('articleid', '=', $articleId)->delete();
    }

    /**
     * Add comment
     *
     * @param array $param
     *
     * @param array $params
     *
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function addComment(array $param, array $params) : void
    {
        if (isset($param['articleid'])) {
            CommentEloquent::insertGetId([
                'content' => $params['content'],
                'articleid' => $param['articleid'],
                'userid' => auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $article = articleRepository()->getArticleById($param['articleid']);
            $owner = $article->getOwner();
            if ($owner->getUserId() !== auth()->user()->id) {
                $owner->notify(new NewArticleCommentNotification(auth()->user()->id, $article));
            }
        } else {
            CommentEloquent::insert([
                'content' => $params['content'],
                'taskid' => $param['taskid'],
                'userid' => auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Delete comment
     *
     * @param int $commentId
     *
     * @return void
     */
    public function deleteComment(int $commentId) : void
    {
        CommentEloquent::where('commentid', '=', $commentId)->delete();
    }

    /**
     * Update comment
     *
     * @param int $commentId
     *
     * @param array $params
     *
     * @return void
     */
    public function updateComment(int $commentId, array $params) : void
    {
        CommentEloquent::where('commentid', '=', $commentId)->update([
            'content' => $params['content'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get comments by article id
     *
     * @param int $taskId
     *
     * @return array
     */
    public function getCommentsByTaskId(int $taskId) : array
    {
        $cacheKey = 'CommentRepository.getCommentsByTaskId' . $taskId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($taskId) {
            return $this->toArray(CommentEloquent::where('taskid', '=', $taskId)->get());
        });
    }

    /**
     * Delete comments by taskid
     *
     * @param int $taskId
     *
     * @return void
     */
    public function deleteCommentsByTaskId(int $taskId) : void
    {
        CommentEloquent::where('taskid', '=', $taskId)->delete();
    }
}