<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: CommentItem.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Items;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\CommentInterface;
use xkamen06\pms\Model\UserInterface;

/**
 * Class CommentItem
 * @package xkamen06\pms\Model\Items
 */
class CommentItem implements CommentInterface
{
    /**
     * @var string Database table name
     */
    protected $table = 'comment';

    /**
     * @var int|null Id of this comment
     */
    protected $commentId;

    /**
     * @var string Content of comment
     */
    protected $content;

    /**
     * @var int|null Id of author of this comment
     */
    protected $userId;

    /**
     * @var int|null Id of article
     */
    protected $articleId;

    /**
     * @var int|null Id of task
     */
    protected $taskId;

    /**
     * @var string|null Created at
     */
    protected $createdAt;

    /**
     * @var string|null Updated at
     */
    protected $updatedAt;

    /**
     * @var UserInterface|null Owner of comment
     */
    protected $owner;

    /**
     * CommentItem constructor.
     *
     * @param null $row
     *
     * @throws NotFoundHttpException
     */
    public function __construct($row = null)
    {
        if (isset($row['commentid'])) {
            $this->commentId = $row['commentid'];
        }
        $this->content = $row['content'];
        if (isset($row['userid'])) {
            $this->userId = $row['userid'];
        }
        if (isset($row['articleid'])) {
            $this->articleId = $row['commentid'];
        }
        if (isset($row['taskid'])) {
            $this->taskId = $row['taskid'];
        }
        if (isset($row['created_at'])) {
            $this->createdAt = $row['created_at'];
        }
        if (isset($row['updated_at'])) {
            $this->updatedAt = $row['updated_at'];
        }

        if ($this->userId !== null) {
            $this->owner = userRepository()->getUserById($this->userId);
        }
    }

    /**
     * Gets comment id
     *
     * @return int|null
     */
    public function getCommentId() : ?int
    {
        return $this->commentId;
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
        return $this->userId;
    }

    /**
     * Gets article id
     *
     * @return int|null
     */
    public function getArticleId() : ?int
    {
        return $this->articleId;
    }

    /**
     * Gets task id
     *
     * @return int|null
     */
    public function getTaskId() : ?int
    {
        return $this->taskId;
    }

    /**
     * Gets created_at
     *
     * @return string|null
     */
    public function getCreatedAt() : ?string
    {
        return $this->createdAt;
    }

    /**
     * Gets updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt() : ?string
    {
        return $this->updatedAt;
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
        return $this->owner;
    }

    /**
     * Gets added at
     *
     * @return null|string
     */
    public function getAddedAt() : ?string
    {
        if ($this->createdAt) {
            $date =  substr($this->createdAt, 0, 10);
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);
            $time = substr($this->createdAt, 11, 5);
            return $day . '.' . $month . '.' . $year . ' ' . $time;
        }
        return null;
    }
}