<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ProjectRepository.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Items;

use xkamen06\pms\Notifications\AddUserToNotification;
use xkamen06\pms\Notifications\DeleteProjectTeamTaskNotification;
use xkamen06\pms\Notifications\DeleteUserFromNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\ProjectInterface;
use xkamen06\pms\Model\ProjectRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class ProjectRepository
 * @package xkamen06\pms\Model\Items
 */
class ProjectRepository extends Repository implements ProjectRepositoryInterface
{
    /**
     * @var string Database table name
     */
    protected $table = 'project';

    /**
     * How long are data stored in cache
     * @var int
     */
    protected $cacheInterval = 1;

    /**
     * Cached tags
     * @var array
     */
    protected $cacheTags = ['ProjectRepository', 'project'];


    /**
     * Fetched row from database to UserItem
     *
     * @param $fetchedRow
     *
     * @return ProjectInterface
     *
     * @throws NotFoundHttpException
     */
    protected function toItem($fetchedRow) : ProjectInterface
    {
        if($fetchedRow === null) {
            throw new NotFoundHttpException();
        }
        return new ProjectItem((array)$fetchedRow);
    }

    /**
     * Get projects by user id
     *
     * @param int $userId
     *
     * @return array
     */
    public function getProjectsByUserId(int $userId) : array
    {
        $cacheKey = 'ProjectRepository.getProjectsByUserId' . $userId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($userId) {
            $projectIds = DB::table('user_project')->where('userid', '=', $userId)->pluck('projectid');
            return $this->toItems($this->getQuery()->whereIn('projectid', $projectIds)
                ->orWhere('leaderid', $userId)->get());
        });
    }

    /**
     * Get projects count by user id
     *
     * @param int $userId
     *
     * @return int
     */
    public function getProjectsByUserIdCount(int $userId) : int
    {
        $cacheKey = 'ProjectRepository.getProjectsByUserIdCount' . $userId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($userId) {
            $projectIds = DB::table('user_project')->where('userid', '=', $userId)->pluck('projectid');
            return $this->getQuery()->whereIn('projectid', $projectIds)
                ->orWhere('leaderid', $userId)->count();
        });
    }

    /**
     * Get active projects count by user id
     *
     * @param int $userId
     *
     * @return int
     */
    public function getActiveProjectsByUserIdCount(int $userId) : int
    {
        $cacheKey = 'ProjectRepository.getActiveProjectsByUserIdCount' . $userId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($userId) {
            $projectIds = DB::table('user_project')->where('userid', '=', $userId)->pluck('projectid');
            return $this->getQuery()->whereIn('projectid', $projectIds)
                ->orWhere('leaderid', $userId)->where('status', 'active')->count();
        });
    }

    /**
     * Get all projects paginator
     *
     * @param int $perPage
     *
     * @param int $page
     *
     * @param array $skipedProjectIds
     *
     * @return LengthAwarePaginator
     */
    public function getAllProjectsPaginator(array $skipedProjectIds, int $perPage, int $page) : LengthAwarePaginator
    {
        return new LengthAwarePaginator($this->getItemsPerPage($skipedProjectIds, $perPage, $page),
            $this->getCount(), $perPage, $page);
    }

    /**
     * Get project by its id
     *
     * @param int $projectId
     *
     * @return ProjectInterface
     *
     * @throws NotFoundHttpException
     */
    public function getProjectById(int $projectId) : ProjectInterface
    {
        $cacheKey = 'ProjectRepository.getProjectById' . $projectId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($projectId) {
            return $this->toItem($this->getQuery()->where('projectid', '=', $projectId)->first());
        });
    }

    /**
     * Delete user from project by id
     *
     * @param int $userId
     *
     * @param int $projectId
     *
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function deleteUserFromProjectById(int $userId, int $projectId) : void
    {
        $user = userRepository()->getUserById($userId);
        $user->notify(new DeleteUserFromNotification('project', $projectId));
        DB::table('user_project')->where('userid', '=', $userId)->where('projectid', '=', $projectId)->delete();
    }

    /**
     * Change project's status
     *
     * @param int $projectId
     *
     * @param string $status
     */
    public function changeProjectStatus(int $projectId, string $status) : void
    {
        $this->getQuery()->where('projectid', '=', $projectId)->update([
            'status' => $status
        ]);
    }

    /**
     * Update project by id
     *
     * @param int $projectId
     *
     * @param array $params
     *
     * @return string
     */
    public function updateProject(int $projectId, array $params) : string
    {
        $project = $this->getQuery()->where('shortcut', $params['shortcut'])->first();
        if ($project && $project->projectid !== $projectId) {
            return 'shortcut_exist';
        }
        $this->getQuery()->where('projectid', '=', $projectId)->update([
            'shortcut' => $params['shortcut'],
            'fullname' => $params['fullname'],
            'description' => $params['description'],
            'permissions' => $params['permissions'],
        ]);
        return '';
    }

    /**
     * Add members to project
     *
     * @param int $projectId
     *
     * @param array $params
     *
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function addMembers(int $projectId, array $params) : void
    {
        unset($params['_token']);
        foreach ($params as $param => $p) {
            DB::table('user_project')->insert([
                'user_projectid' => (int)($param . $projectId),
                'userid' => $param,
                'projectid' => $projectId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $user = userRepository()->getUserById($param);
            $user->notify(new AddUserToNotification('project', $projectId));
        }
    }

    /**
     * Create project
     *
     * @param array $params
     *
     * @return int
     */
    public function createProject(array $params) : int
    {
        if ($this->getQuery()->where('shortcut', $params['shortcut'])->first()) {
            return -1;
        }
        return $this->getQuery()->insertGetId([
            'shortcut' => $params['shortcut'],
            'fullname' => $params['fullname'],
            'description' => $params['description'],
            'permissions' => $params['permissions'],
            'leaderid' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Delete project by id
     *
     * @param int $projectId
     *
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function deleteProjectById(int $projectId) : void
    {
        fileRepository()->deleteFilesByProjectId($projectId);
        taskRepository()->deleteTasksByProjectId($projectId);
        $projectName = $this->getProjectById($projectId)->getShortcut();
        $users = userRepository()->getUsersByProjectId($projectId);
        foreach ($users as $user) {
            $user->notify(new DeleteProjectTeamTaskNotification('project', $projectName));
        }
        DB::table('user_project')->where('projectid', '=', $projectId)->delete();
        $this->getQuery()->where('projectid', '=', $projectId)->delete();
    }

    /**
     * Gets active projects count
     *
     * @return int
     */
    public function getActiveProjectsCount() : int
    {
        $cacheKey = 'ProjectRepository.getActiveProjectsCount';

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () {
            return $this->getQuery()->where('status', 'active')->count();
        });
    }

    /**
     * Gets active projects count
     *
     * @return int
     */
    public function getClosedProjectsCount() : int
    {
        $cacheKey = 'ProjectRepository.getClosedProjectsCount';

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () {
            return $this->getQuery()->where('status', 'closed')->count();
        });
    }
}