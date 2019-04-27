<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ArticleItem.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Items;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\ArticleInterface;
use xkamen06\pms\Model\UserInterface;

/**
 * Class ArticleItem
 * @package xkamen06\pms\Model\Items
 */
class ArticleItem implements ArticleInterface
{
    /**
     * @var string Database table name
     */
    protected $table = 'article';

    /**
     * @var int|null Id of this article
     */
    protected $articleid;

    /**
     * @var string Title of this article
     */
    protected $title;

    /**
     * @var string|null Subtitle of this article
     */
    protected $subtitle;

    /**
     * @var string Type of this article
     */
    protected $type;

    /**
     * @var string Content of this article
     */
    protected $content;

    /**
     * @var string Path to image of thit article
     */
    protected $image;

    /**
     * @var int|null Id of user who added this article
     */
    protected $userid;

    /**
     * @var int Id of team which belong to this article
     */
    protected $teamid;

    /**
     * @var string|null Datetime when this article was created
     */
    protected $created_at;

    /**
     * @var string|null Datetime when this article was updated
     */
    protected $updated_at;

    /**
     * @var UserItem|null Owner of this article (who added it)
     */
    protected $owner;

    /**
     * ArticleItem constructor.
     *
     * @param null $row
     *
     * @throws NotFoundHttpException
     */
    public function __construct($row = null)
    {
        if (isset($row['articleid'])) {
            $this->articleid = $row['articleid'];
        }
        $this->title = $row['title'];
        $this->subtitle = $row['subtitle'];
        $this->type = $row['type'];
        $this->content = $row['content'];
        if (isset($row['image'])) {
            $this->image = $row['image'];
        }
        if (isset($row['userid'])) {
            $this->userid = $row['userid'];
        }
        $this->teamid = $row['teamid'];
        if (isset($row['created_at'])) {
            $this->created_at = $row['created_at'];
        }
        if (isset($row['updated_at'])) {
            $this->updated_at = $row['updated_at'];
        }
        if (isset($row['articleid'])) {
            $this->owner = userRepository()->getUserById($this->userid);
        }
    }

    /**
     * Saves item to the database
     */
    public function save() : int
    {
        $this->userid = auth()->user()->id;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
        $objectVars = get_object_vars($this);
        unset($objectVars['table'], $objectVars['articleid'], $objectVars['owner']);
        return DB::table($this->table)->insertGetId($objectVars);
    }

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
     * Gets image path
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
     * @return int
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
     * @return string
     */
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * Gets updated_at
     *
     * @return string
     */
    public function getUpdatedAt() : string
    {
        return $this->updated_at;
    }
    
    /**
     * Gets UserItem - owner of this article
     *
     * @return UserInterface|null
     */
    public function getOwner() : ?UserInterface
    {
        return $this->owner;
    }

    /**
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