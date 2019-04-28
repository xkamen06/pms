<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TaskRepository.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Eloquents;

use xkamen06\pms\Notifications\AddUserToNotification;
use xkamen06\pms\Notifications\DeleteProjectTeamTaskNotification;
use xkamen06\pms\Notifications\DeleteUserFromNotification;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\TaskInterface;
use xkamen06\pms\Model\TaskRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class TaskRepository
 * @package xkamen06\pms\Model\Eloquents
 */
class TaskRepository extends Repository implements TaskRepositoryInterface
{
    /**
     * @var string Database table name
     */
    protected $table = 'task';

    /**
     * How long are data stored in cache
     * @var int
     */
    protected $cacheInterval = 1;

    /**
     * Cached tags
     * @var array
     */
    protected $cacheTags = ['TaskRepository', 'task'];


    /**
     * Gets tasks by projectId
     *
     * @param int $projectId
     *
     * @return array
     */
    public function getTasksByProjectId(int $projectId) : array
    {
        $cacheKey = 'TaskRepository.getTasksByProjectId' . $projectId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($projectId) {
            return $this->toArray(TaskEloquent::where('projectid', '=', $projectId)->get());
        });
    }

    /**
     * Create task
     *
     * @param int $projectId
     *
     * @param array $params
     *
     * @return int
     */
    public function createTask(int $projectId, array $params) : int
    {
        return TaskEloquent::insertGetId([
            'name' => $params['name'],
            'description' => $params['description'],
            'type' => $params['type'],
            'status' => 'new',
            'projectid' => $projectId,
            'leaderid' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get task by it's id
     *
     * @param int $taskId
     *
     * @return TaskInterface
     *
     * @throws NotFoundHttpException
     */
    public function getTaskById(int $taskId) : TaskInterface
    {
        $cacheKey = 'TaskRepository.getTaskById' . $taskId;

        $task = $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($taskId) {
            return TaskEloquent::where('taskid', '=', $taskId)->first();
        });
        if ($task) {
            return $task;
        }
        throw new NotFoundHttpException();
    }

    /**
     * Update task by id
     *
     * @param int $taskId
     *
     * @param array $params
     *
     * @return void
     */
    public function updateTaskById(int $taskId, array $params) : void
    {
        TaskEloquent::where('taskid', '=', $taskId)->update([
            'name' => $params['name'],
            'description' => $params['description'],
            'type' => $params['type'],
            'status' => $params['status'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Add members to project
     *
     * @param int $taskId
     *
     * @param array $params
     *
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function addMembers(int $taskId, array $params) : void
    {
        if (isset($params['_token'])) {
            unset($params['_token']);
        }
        foreach ($params as $param => $p) {
            DB::table('user_task')->insert([
                'user_taskid' => (int)($param . $taskId),
                'userid' => $param,
                'taskid' => $taskId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $user = userRepository()->getUserById($param);
            $user->notify(new AddUserToNotification('task', $taskId));
        }
    }

    /**
     * Delete user from task by id
     *
     * @param int $userId
     *
     * @param int $taskId
     *
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function deleteUserFromTaskById(int $userId, int $taskId) : void
    {
        $user = userRepository()->getUserById($userId);
        $user->notify(new DeleteUserFromNotification('task', $taskId));
        DB::table('user_task')->where('userid', '=', $userId)->where('taskid', '=', $taskId)->delete();
    }

    /**
     * CHange task status
     *
     * @param int $taskId
     *
     * @param string $status
     */
    public function changeTaskStatus(int $taskId, string $status) : void
    {
        TaskEloquent::where('taskid', '=', $taskId)->update([
            'status' => $status
        ]);
    }

    /**
     * Delete task by id
     *
     * @param int $taskId
     *
     * @return int
     */
    public function deleteTaskById(int $taskId) : int
    {
        fileRepository()->deleteFilesByTaskId($taskId);
        $projectId = TaskEloquent::where('taskid', '=', $taskId)->select('projectid')->first();
        commentRepository()->deleteCommentsByTaskId($taskId);
        $taskName = $this->getTaskById($taskId)->getName();
        $users = userRepository()->getUsersByTaskId($taskId);
        foreach ($users as $user) {
            $user->notify(new DeleteProjectTeamTaskNotification('task', $taskName));
        }
        DB::table('user_task')->where('taskid', '=', $taskId)->delete();
        TaskEloquent::where('taskid', '=', $taskId)->delete();
        return $projectId->projectid;
    }

    /**
     * Delete tasks by project id
     *
     * @param int $projectId
     */
    public function deleteTasksByProjectId(int $projectId) : void
    {
        $taskIds = $this->toArray(TaskEloquent::where('projectid', '=', $projectId)->select('taskid')->get());
        foreach ($taskIds as $taskId) {
            $this->deleteTaskById($taskId->taskid);
        }
    }

    /**
     * Get requirement tasks count
     *
     * @return int
     */
    public function getRequirementTasksCount() : int
    {
        $cacheKey = 'TaskRepository.getRequirementTasksCount';

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () {
            return TaskEloquent::where('type', 'requirement')->count();
        });
    }

    /**
     * Get bug tasks count
     *
     * @return int
     */
    public function getBugTasksCount() : int
    {
        $cacheKey = 'TaskRepository.getBugTasksCount';

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () {
            return TaskEloquent::where('type', 'bug')->count();
        });
    }

    /**
     * Get new tasks count
     *
     * @return int
     */
    public function getNewTasksCount() : int
    {
        $cacheKey = 'TaskRepository.getNewTasksCount';

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () {
            return TaskEloquent::where('status', 'new')->count();
        });
    }

    /**
     * Get in progress tasks count
     *
     * @return int
     */
    public function getInProgressTasksCount() : int
    {
        $cacheKey = 'TaskRepository.getInProgressTasksCount';

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () {
            return TaskEloquent::where('status', 'in_progress')->count();
        });
    }

    /**
     * Get done tasks count
     *
     * @return int
     */
    public function getDoneTasksCount() : int
    {
        $cacheKey = 'TaskRepository.getDoneTasksCount';

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () {
            return TaskEloquent::where('status', 'done')->count();
        });
    }

    /**
     * Get tasks by user id
     *
     * @param $userId
     *
     * @return array
     */
    public function getTasksByUserId(int $userId) : array
    {
        $cacheKey = 'TaskRepository.getTasksByUserId' . $userId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($userId) {
            $taskIds = DB::table('user_task')->where('userid', $userId)->pluck('taskid');
            return $this->toArray(TaskEloquent::whereIn('taskid', $taskIds)->get());
        });
    }
}