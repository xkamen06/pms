<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TaskItem.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Items;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\TaskInterface;
use DB;
use xkamen06\pms\Model\UserInterface;

/**
 * Class TaskItem
 * @package xkamen06\pms\Model\Items
 */
class TaskItem implements TaskInterface
{
    /**
     * @var string Database table name
     */
    protected $table = 'task';

    /**
     * @var int|null Id of task
     */
    protected $taskId;

    /**
     * @var string Name of task
     */
    protected $name;

    /**
     * @var string|null Task description
     */
    protected $description;

    /**
     * @var string Type of task
     */
    protected $type;

    /**
     * @var string Task status
     */
    protected $status;

    /**
     * @var int Id of project
     */
    protected $projectId;

    /**
     * @var int|null Id of task leader
     */
    protected $leaderid;

    /**
     * @var string|null Created at
     */
    protected $createdAt;

    /**
     * @var string|null Updated at
     */
    protected $updatedAt;

    /**
     * @var UserInterface|null Leader of task
     */
    protected $leader;

    /**
     * TeamItem constructor.
     * @param null $row
     */
    public function __construct($row = null)
    {
        if (isset($row['taskid'])) {
            $this->taskId = $row['taskid'];
        }
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->type = $row['type'];
        $this->status = $row['status'];
        $this->projectId = $row['projectid'];
        if (isset($row['leaderid'])) {
            $this->leaderid = $row['leaderid'];
        }
        if (isset($row['created_at'])) {
            $this->createdAt = $row['created_at'];
        }
        if (isset($row['updated_at'])) {
            $this->updatedAt = $row['updated_at'];
        }
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
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Gets description
     *
     * @return string|null
     */
    public function getDescription() : ?string
    {
        return $this->description;
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
     * Gets status
     *
     * @return string
     */
    public function getStatus() : string
    {
        return $this->status;
    }

    /**
     * Gets project id
     *
     * @return int
     */
    public function getProjectId() : int
    {
        return $this->projectId;
    }

    /**
     * Gets leader id
     *
     * @return int|null
     */
    public function getLeaderId() : ?int
    {
        return $this->leaderid;
    }

    /**
     * Gets leader
     *
     * @return null|UserInterface
     *
     * @throws NotFoundHttpException
     */
    public function getLeader() : ?UserInterface
    {
        if ($this->leaderid) {
            if ($this->leader === null) {
                $this->leader = userRepository()->getUserById($this->leaderid);
            }
            return $this->leader;
        }
        return null;
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
            return $day . '.' . $month . '.' . $year;
        }
        return null;
    }

    /**
     * Gets members of task
     *
     * @return array
     */
    public function getMembers() : array
    {
        return userRepository()->getUsersByTaskId($this->taskId);
    }

    /**
     * Get if user is member of task
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isMember(int $userId) : bool
    {
        return (DB::table('user_task')->where('taskid', '=', $this->taskId)->where('userid', '=', $userId)
                ->first() !== null);
    }
}