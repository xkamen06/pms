<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TeamInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Interface TeamInterface
 * @package xkamen06\pms\Model
 */
interface TeamInterface
{
    /**
     * Gets team id
     *
     * @return int|null
     */
    public function getTeamId() : ?int;

    /**
     * Gets shortcut
     *
     * @return string
     */
    public function getShortcut() : string;

    /**
     * Gets fullname
     *
     * @return string
     */
    public function getFullname() : string;

    /**
     * Gets description
     *
     * @return string|null
     */
    public function getDescription() : ?string;

    /**
     * Gets permissions
     *
     * @return string
     */
    public function getPermissions() : string;

    /**
     * Gets leader id
     *
     * @return int|null
     */
    public function getLeaderId() : ?int;

    /**
     * Gets created_at
     *
     * @return string|null
     */
    public function getCreatedAt() : ?string;

    /**
     * Gets updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt() : ?string;

    /**
     * Gets leader
     *
     * @return UserInterface|null
     *
     * @throws NotFoundHttpException
     */
    public function getLeader() : ?UserInterface;

    /**
     * Gets members
     *
     * @return array
     */
    public function getMembers() : array;

    /**
     * Gets if user is member
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isMember(int $userId) : bool;

    /**
     * Gets added at
     *
     * @return null|string
     */
    public function getAddedAt() : ?string;
}