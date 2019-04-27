<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ProjectEloquent.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Eloquents;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\ProjectInterface;
use Illuminate\Support\Facades\DB;
use xkamen06\pms\Model\UserInterface;

/**
 * Class ProjectEloquent
 * @package xkamen06\pms\Model\Eloquents
 */
class ProjectEloquent extends Model implements ProjectInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'projectid',
        'shortcut',
        'fullname',
        'description',
        'permissions',
        'status',
        'leaderid',
        'created_at',
        'updated_at'
    ];

    /**
     * Project leader
     *
     * @var UserInterface|Null
     */
    protected $leader;

    /**
     * Gets project id
     *
     * @return int|null
     */
    public function getProjectId() : ?int
    {
        return $this->projectid;
    }

    /**
     * Gets shortcut
     *
     * @return string
     */
    public function getShortcut() : string
    {
        return $this->shortcut;
    }

    /**
     * Gets fullname
     *
     * @return string
     */
    public function getFullname() : string
    {
        return $this->fullname;
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
     * Gets permissions
     *
     * @return string
     */
    public function getPermissions() : string
    {
        return $this->permissions;
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
     * Gets leader
     *
     * @return UserInterface|null
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
     * Gets members
     *
     * @return array
     */
    public function getMembers() : array
    {
        return userRepository()->getUsersByProjectId($this->projectid);
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
     * Gets if user is member
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isMember(int $userId) : bool
    {
        return (DB::table('user_project')->where('projectid', '=', $this->projectid)->where('userid', '=', $userId)
                ->first() !== null);
    }
}