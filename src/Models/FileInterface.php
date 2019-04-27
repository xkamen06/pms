<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: FileInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

/**
 * Interface FileInterface
 * @package xkamen06\pms\Model
 */
interface FileInterface
{
    /**
     * Gets file id
     *
     * @return int|null
     */
    public function getFileId() : ?int;

    /**
     * Gets filename
     *
     * @return string
     */
    public function getFilename() : string;

    /**
     * Gets path
     *
     * @return string
     */
    public function getPath() : string;

    /**
     * Gets type
     *
     * @return string
     */
    public function getType() : string;

    /**
     * Gets user id
     *
     * @return int|null
     */
    public function getUserId() : ?int;

    /**
     * Gets project id
     *
     * @return int|null
     */
    public function getProjectId() : ?int;

    /**
     * Gets task id
     *
     * @return int|null
     */
    public function getTaskId() : ?int;

    /**
     * Gets description
     *
     * @return null|string
     */
    public function getDescription() : ?string;

    /**
     * Gets created_at
     *
     * @return null|string
     */
    public function getCreatedAt() : ?string;

    /**
     * Gets updated_at
     *
     * @return null|string
     */
    public function getUpdatedAt() : ?string;

    /**
     * Gets added at
     *
     * @return null|string
     */
    public function getAddedAt() : ?string;
}