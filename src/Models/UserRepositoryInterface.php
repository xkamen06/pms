<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: UserRepositoryInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\Items\UserItem;

/**
 * Interface UserRepositoryInterface
 * @package xkamen06\pms\Model
 */
interface UserRepositoryInterface
{
    /**
     * Gets user by id
     *
     * @param int $userId
     *
     * @return UserInterface
     *
     * @throws NotFoundHttpException
     */
    public function getUserById(int $userId) : UserInterface;

    /**
     * Update user by id
     *
     * @param int $userId
     *
     * @param array $params
     *
     * @return string
     */
    public function updateUser(int $userId, array $params) : string;

    /**
     * Update user password by id
     *
     * @param int $userId
     *
     * @param array $params
     *
     * @return string
     */
    public function updatePassword(int $userId, array $params) : string;

    /**
     * Get all users paginator
     *
     * @param int $perPage
     *
     * @param int $page
     *
     * @return LengthAwarePaginator
     */
    public function getAllUsersPaginator(int $perPage, int $page) : LengthAwarePaginator;

    /**
     * Get users by team id
     *
     * @param int $teamId
     *
     * @return array
     */
    public function getUsersByTeamId(int $teamId) : array;

    /**
     * Delete user by id
     *
     * @param int $userId
     *
     * @return void
     */
    public function deleteUserById(int $userId) : void;

    /**
     * Get userIds by teamId (get members ids)
     *
     * @param int $teamId
     * @return Collection
     */
    public function getUserIdsByTeamId(int $teamId) : Collection;

    /**
     * Get users except ids
     *
     * @param Collection $exceptIds
     *
     * @return array
     */
    public function getUsersExceptIds(Collection $exceptIds) : array;

    /**
     * Get users by ids except ids
     *
     * @param Collection $exceptIds
     *
     * @param Collection $ids
     *
     * @return array
     */
    public function getUsersByIdsExceptIds(Collection $exceptIds, Collection $ids) : array;

    /**
     * Get users by team id
     *
     * @param int $projectId
     *
     * @return array
     */
    public function getUsersByProjectId(int $projectId) : array;

    /**
     * Get users by taskId (get members)
     *
     * @param int $taskId
     * @return array
     */
    public function getUsersByTaskId(int $taskId) : array;

    /**
     * Get userIds by taskId (get members ids)
     *
     * @param int $taskId
     * @return Collection
     */
    public function getUserIdsByTaskId(int $taskId) : Collection;

    /**
     * Get userIds by taskId (get members ids)
     *
     * @param int $projectId
     * @return Collection
     */
    public function getUserIdsByProjectId(int $projectId) : Collection;

    /**
     * Add user
     *
     * @param array $params
     * @return string
     */
    public function addUser(array $params) : string;

    /**
     * Returns if user by email exists
     *
     * @param string $email
     *
     * @return bool
     */
    public function existUserByEmail(string $email) : bool;
}