<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ArticleEloquent.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Eloquents;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\ArticleInterface;
use xkamen06\pms\Model\UserInterface;

/**
 * Class ArticleEloquent
 * @package xkamen06\pms\Model\Eloquents
 */
class ArticleEloquent extends Model implements ArticleInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'articleid',
        'title',
        'subtitle',
        'type',
        'content',
        'image',
        'userid',
        'teamid',
        'created_at',
        'updated_at'
    ];

    /**
     * Article owner
     *
     * @var UserInterface|null
     */
    protected $owner;

    /**
     * Gets articleId
     *
     * @return int|null
     */
    public function getArticleId() : ?int
    {
        return $this->articleid;
    }

    /**
     * Gets title
     *
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * Gets subtitle
     *
     * @return string|null
     */
    public function getSubtitle() : ?string
    {
        return $this->subtitle;
    }

    /**
     * Gets type
     *
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
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
     * Gets path to image
     *
     * @return null|string
     */
    public function getImage() : ?string
    {
        return $this->image;
    }

    /**
     * Gets userId
     *
     * @return int|null
     */
    public function getUserId() : ?int
    {
        return $this->userid;
    }

    /**
     * Gets teamId
     *
     * @return int
     */
    public function getTeamId() : int
    {
        return $this->teamid;
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