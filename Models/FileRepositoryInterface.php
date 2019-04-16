<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: FileRepositoryInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

/**
 * Interface FileRepositoryInterface
 * @package xkamen06\pms\Model
 */
interface FileRepositoryInterface
{
    /**
     * Store file to database
     *
     * @param $params
     *
     * @return void
     */
    public function storeFile(array $params) : void;

    /**
     * Get files by projectId
     *
     * @param int $projectId
     *
     * @return array
     */
    public function getFilesByProjectId(int $projectId) : array;

    /**
     * Get files by projectId
     *
     * @param int $taskId
     *
     * @return array
     */
    public function getFilesByTaskId(int $taskId) : array;

    /**
     * Get file by it's id
     *
     * @param int $fileId
     *
     * @return FileInterface
     */
    public function getFileById(int $fileId) : FileInterface;

    /**
     * Delete file by it's id
     *
     * @param $fileId
     *
     * @return void
     */
    public function deleteFileById(int $fileId) : void;

    /**
     * Move file to project
     *
     * @param int $fileId
     *
     * @param int $projectId
     */
    public function moveFileToProject(int $fileId, int $projectId) : void;

    /**
     * Copy file to project
     *
     * @param int $fileId
     *
     * @param int $projectId
     */
    public function copyFileToProject(int $fileId, int $projectId) : void;

    /**
     * Delete files by projectId
     *
     * @param int $projectId
     */
    public function deleteFilesByProjectId(int $projectId) : void;

    /**
     * Delete files by taskId
     *
     * @param int $taskId
     */
    public function deleteFilesByTaskId(int $taskId) : void;

    /**
     * Get task files count
     *
     * @return int
     */
    public function getTaskFilesCount() : int;

    /**
     * Get submit files count
     *
     * @return int
     */
    public function getSubmitFilesCount() : int;

    /**
     * Get submit files count by user id
     *
     * @param int $userId
     *
     * @return int
     */
    public function getSubmitFilesCountByUserId(int $userId) : int;

    /**
     * Get files count by user id
     *
     * @param int $userId
     *
     * @return int
     */
    public function getFilesCountByUserId(int $userId) : int;
}