<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ProjectItem.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Items;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\ProjectInterface;
use xkamen06\pms\Model\UserInterface;

/**
 * Class ProjectItem
 * @package xkamen06\pms\Model\Items
 */
class ProjectItem implements ProjectInterface
{
    /**
     * @var string Database table name
     */
    protected $table = 'team';

    /**
     * @var int|null Id of project
     */
    protected $projectId;

    /**
     * @var string Shortcut of project
     */
    protected $shortcut;

    /**
     * @var string Fullname of project
     */
    protected $fullname;

    /**
     * @var string|null Description of project
     */
    protected $description;

    /**
     * @var string Permissions to project
     */
    protected $permissions;

    /**
     * @var string Status of project
     */
    protected $status;

    /**
     * @var int|null Id of project leader
     */
    protected $leaderId;

    /**
     * @var string|null Created at
     */
    protected $createdAt;

    /**
     * @var string|null Updated at
     */
    protected $updatedAt;

    /**
     * @var UserInterface|null Leader of project
     */
    protected $leader;

    /**
     * TeamItem constructor.
     *
     * @param null $row
     */
    public function __construct($row = null)
    {
        if (isset($row['projectid'])) {
            $this->projectId = $row['projectid'];
        }
        $this->shortcut = $row['shortcut'];
        $this->fullname = $row['fullname'];
        $this->description = $row['description'];
        $this->permissions = $row['permissions'];
        $this->status = $row['status'];
        $this->leaderId = $row['leaderid'];
        if (isset($row['created_at'])) {
            $this->createdAt = $row['created_at'];
        }
        if (isset($row['updated_at'])) {
            $this->updatedAt = $row['updated_at'];
        }
    }

    /**
     * Gets project id
     *
     * @return int|null
     */
    public function getProjectId() : ?int
    {
        return $this->projectId;
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
        return $this->leaderId;
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
     * Gets leader
     *
     * @return UserInterface|null
     *
     * @throws NotFoundHttpException
     */
    public function getLeader() : ?UserInterface
    {
        if ($this->leaderId) {
            if ($this->leader === null) {
                $this->leader = userRepository()->getUserById($this->leaderId);
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
        return userRepository()->getUsersByProjectId($this->projectId);
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
     * Gets if user is member
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isMember(int $userId) : bool
    {
        return (DB::table('user_project')->where('projectid', '=', $this->projectId)->where('userid', '=', $userId)
                ->first() !== null);
    }
}