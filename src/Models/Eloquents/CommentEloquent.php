<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: CommentEloquent.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Eloquents;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\CommentInterface;
use xkamen06\pms\Model\UserInterface;

/**
 * Class CommentEloquent
 * @package xkamen06\pms\Model\Eloquents
 */
class CommentEloquent extends Model implements CommentInterface
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'comment';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'commentid',
        'content',
        'userid',
        'articleid',
        'taskid',
        'created_at',
        'updated_at'
    ];

    /**
     * Comment owner
     *
     * @var UserInterface|null
     */
    protected $owner;

    /**
     * Gets comment id
     *
     * @return int|null
     */
    public function getCommentId() : ?int
    {
        return $this->commentid;
    }

    /**
     * Gets content
     *
     * @return string
     */
    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * Gets user id
     *
     * @return int|null
     */
    public function getUserId() : ?int
    {
        return $this->userid;
    }

    /**
     * Gets article id
     *
     * @return int|null
     */
    public function getArticleId() : ?int
    {
        return $this->articleid;
    }

    /**
     * Gets task id
     *
     * @return int|null
     */
    public function getTaskId() : ?int
    {
        return $this->taskid;
    }

    /**
     * Gets created_at
     *
     * @return string|null
     */
    public function getCreatedAt() : ?string
    {
        return $this->created_at;
    }

    /**
     * Gets updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt() : ?string
    {
        return $this->updated_at;
    }

    /**
     * Gets UserItem - owner of this article
     *
     * @return UserInterface|null
     *
     * @throws NotFoundHttpException
     */
    public function getOwner() : ?UserInterface
    {
        if ($this->userid) {
            if ($this->owner === null) {
                $this->owner = userRepository()->getUserById($this->userid);
            }
            return $this->owner;
        }
        return null;
    }

    /**
     * Gets added at
     *
     * @return null|string
     */
    public function getAddedAt() : ?string
    {
        if ($this->created_at) {
            $date =  substr($this->created_at, 0, 10);
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);
            $time = substr($this->created_at, 11, 5);
            return $day . '.' . $month . '.' . $year . ' ' . $time;
        }
        return null;
    }
}