<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ProjectRepositoryInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\Items\ProjectItem;

/**
 * Interface ProjectRepositoryInterface
 * @package xkamen06\pms\Model
 */
interface ProjectRepositoryInterface
{
    /**
     * Get projects by user id
     *
     * @param int $userId
     *
     * @return array
     */
    public function getProjectsByUserId(int $userId) : array;

    /**
     * Get projects count by user id
     *
     * @param int $userId
     *
     * @return int
     */
    public function getProjectsByUserIdCount(int $userId) : int;

    /**
     * Get active projects count by user id
     *
     * @param int $userId
     *
     * @return int
     */
    public function getActiveProjectsByUserIdCount(int $userId) : int;

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
    public function getAllProjectsPaginator(array $skipedProjectIds, int $perPage, int $page) : LengthAwarePaginator;

    /**
     * Get project by its id
     *
     * @param int $projectId
     *
     * @return ProjectInterface
     *
     * @throws NotFoundHttpException
     */
    public function getProjectById(int $projectId) : ProjectInterface;

    /**
     * Delete user from project by id
     *
     * @param int $userId
     *
     * @param int $projectId
     *
     * @return void
     */
    public function deleteUserFromProjectById(int $userId, int $projectId) : void;

    /**
     * Change project's status
     *
     * @param int $projectId
     *
     * @param string $status
     */
    public function changeProjectStatus(int $projectId, string $status) : void;

    /**
     * Update project by id
     *
     * @param int $projectId
     *
     * @param array $params
     *
     * @return string
     */
    public function updateProject(int $projectId, array $params) : string;

    /**
     * Add members to project
     *
     * @param int $projectId
     *
     * @param array $params
     *
     * @return void
     */
    public function addMembers(int $projectId, array $params) : void;

    /**
     * Create project
     *
     * @param array $params
     *
     * @return int
     */
    public function createProject(array $params) : int;

    /**
     * Delete project by id
     *
     * @param int $projectId
     *
     * @return void
     */
    public function deleteProjectById(int $projectId) : void;

    /**
     * Gets active projects
     *
     * @return int
     */
    public function getActiveProjectsCount() : int;

    /**
     * Gets active projects
     *
     * @return int
     */
    public function getClosedProjectsCount() : int;
}