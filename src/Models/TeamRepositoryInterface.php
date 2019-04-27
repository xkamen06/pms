<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TeamRepositoryInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\Items\TeamItem;

/**
 * Interface TeamRepositoryInterface
 * @package xkamen06\pms\Model
 */
interface TeamRepositoryInterface
{
    /**
     * Get all teams paginator
     *
     * @param int $perPage
     *
     * @param int $page
     *
     * @param array $skipedTeamsIds
     *
     * @return LengthAwarePaginator
     */
    public function getAllTeamsPaginator(array $skipedTeamsIds, int $perPage, int $page) : LengthAwarePaginator;

    /**
     * Get team by its id
     *
     * @param int $teamId
     *
     * @return TeamInterface
     *
     * @throws NotFoundHttpException
     */
    public function getTeamById(int $teamId) : TeamInterface;

    /**
     * Delete user from team by id
     *
     * @param int $userId
     *
     * @param int $teamId
     *
     * @return void
     */
    public function deleteUserFromTeamById(int $userId, int $teamId) : void;

    /**
     * Get teams by user id
     *
     * @param int $userId
     *
     * @return array
     */
    public function getTeamsByUserId(int $userId) : array;

    /**
     * Get teams count by user id
     *
     * @param int $userId
     *
     * @return int
     */
    public function getTeamsCountByUserId(int $userId) : int;

    /**
     * Delete team and its items by id
     *
     * @param int $teamId
     */
    public function deleteTeamById(int $teamId) : void;

    /**
     * Update team by id
     *
     * @param int $teamId
     *
     * @param array $params
     *
     * @return string
     */
    public function updateTeam(int $teamId, array $params) : string;

    /**
     * Create team
     *
     * @param array $params
     *
     * @return int
     */
    public function createTeam(array $params) : int;

    /**
     * Add members to team
     *
     * @param int $teamId
     *
     * @param array $params
     *
     * @return void
     */
    public function addMembers(int $teamId, array $params) : void;
}