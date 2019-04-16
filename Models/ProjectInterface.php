<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ProjectInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Interface ProjectInterface
 * @package xkamen06\pms\Model
 */
interface ProjectInterface
{
    /**
     * Gets project id
     *
     * @return int|null
     */
    public function getProjectId() : ?int;

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
     * Gets status
     *
     * @return string
     */
    public function getStatus() : string;

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
     * Gets added at
     *
     * @return null|string
     */
    public function getAddedAt() : ?string;

    /**
     * Gets if user is member
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isMember(int $userId) : bool;
}