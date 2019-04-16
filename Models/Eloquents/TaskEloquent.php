<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TaskEloquent.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Eloquents;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\TaskInterface;
use DB;
use xkamen06\pms\Model\UserInterface;

/**
 * Class TaskEloquent
 * @package xkamen06\pms\Model\Eloquents
 */
class TaskEloquent extends Model implements TaskInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'taskid',
        'name',
        'description',
        'type',
        'status',
        'projectid',
        'leaderid',
        'created_at',
        'updated_at'
    ];

    /**
     * Leader of task
     *
     * @var UserInterface|null
     */
    protected $leader;

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
     * Gets name
     *
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
    public function getStatus() : ?string
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
        return $this->projectid;
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
            return $day . '.' . $month . '.' . $year;
        }
        return null;
    }

    /**
     * Gets members
     *
     * @return array
     */
    public function getMembers() : array
    {
        return userRepository()->getUsersByTaskId($this->taskid);
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
     * Gets if user is member of task
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isMember(int $userId) : bool
    {
        return (DB::table('user_task')->where('taskid', '=', $this->taskid)->where('userid', '=', $userId)
                ->first() !== null);
    }
}