<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TaskInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */


namespace xkamen06\pms\Model;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Interface TaskInterface
 * @package xkamen06\pms\Model
 */
interface TaskInterface
{
    /**
     * Gets task id
     *
     * @return int|null
     */
    public function getTaskId() : ?int;

    /**
     * Gets name
     *
     * @return string
     */
    public function getName() : string;

    /**
     * Gets description
     *
     * @return string|null
     */
    public function getDescription() : ?string;

    /**
     * Gets type
     *
     * @return string
     */
    public function getType() : string;

    /**
     * Gets status
     *
     * @return string
     */
    public function getStatus() : ?string;

    /**
     * Gets project id
     *
     * @return int
     */
    public function getProjectId() : int;

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
     * Gets added at
     *
     * @return null|string
     */
    public function getAddedAt() : ?string;

    /**
     * Gets members
     *
     * @return array
     */
    public function getMembers() : array;

    /**
     * Gets leader
     *
     * @return null|UserInterface
     *
     * @throws NotFoundHttpException
     */
    public function getLeader() : ?UserInterface;

    /**
     * Gets if user is member of task
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isMember(int $userId) : bool;
}