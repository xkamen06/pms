<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TaskRepositoryInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\Items\TaskItem;

/**
 * Interface TaskRepositoryInterface
 * @package xkamen06\pms\Model
 */
interface TaskRepositoryInterface
{
    /**
     * Gets tasks by projectId
     *
     * @param int $projectId
     *
     * @return array
     */
    public function getTasksByProjectId(int $projectId) : array;

    /**
     * Create task
     *
     * @param int $projectId
     *
     * @param array $params
     *
     * @return int
     */
    public function createTask(int $projectId, array $params) : int;

    /**
     * Get task by it's id
     *
     * @param int $taskId
     *
     * @return TaskInterface
     *
     * @throws NotFoundHttpException
     */
    public function getTaskById(int $taskId) : TaskInterface;

    /**
     * Update task by id
     *
     * @param int $taskId
     *
     * @param array $params
     *
     * @return void
     */
    public function updateTaskById(int $taskId, array $params) : void;

    /**
     * Add members to project
     *
     * @param int $taskId
     *
     * @param array $params
     *
     * @return void
     */
    public function addMembers(int $taskId, array $params) : void;

    /**
     * CHange task status
     *
     * @param int $taskId
     *
     * @param string $status
     */
    public function changeTaskStatus(int $taskId, string $status) : void;

    /**
     * Delete task by id
     *
     * @param int $taskId
     *
     * @return int
     */
    public function deleteTaskById(int $taskId) : int;

    /**
     * Delete tasks by project id
     *
     * @param int $projectId
     */
    public function deleteTasksByProjectId(int $projectId) : void;

    /**
     * Delete user from task by id
     *
     * @param int $userId
     *
     * @param int $taskId
     *
     * @return void
     */
    public function deleteUserFromTaskById(int $userId, int $taskId) : void;

    /**
     * Get requirement tasks count
     *
     * @return int
     */
    public function getRequirementTasksCount() : int;

    /**
     * Get bug tasks count
     *
     * @return int
     */
    public function getBugTasksCount() : int;

    /**
     * Get new tasks count
     *
     * @return int
     */
    public function getNewTasksCount() : int;

    /**
     * Get in progress tasks count
     *
     * @return int
     */
    public function getInProgressTasksCount() : int;

    /**
     * Get done tasks count
     *
     * @return int
     */
    public function getDoneTasksCount() : int;

    /**
     * Get tasks by user id
     *
     * @param int $userId
     *
     * @return array
     */
    public function getTasksByUserId(int $userId) : array;
}