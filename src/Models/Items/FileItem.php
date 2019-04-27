<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: FileItem.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Items;

use xkamen06\pms\Model\FileInterface;

/**
 * Class FileItem
 * @package xkamen06\pms\Model\Items
 */
class FileItem implements FileInterface
{
    /**
     * @var string Database table name
     */
    protected $table = 'file';

    /**
     * @var int|null Id of file
     */
    protected $fileId;

    /**
     * @var string Name of file
     */
    protected $filename;

    /**
     * @var string Path to file
     */
    protected $path;

    /**
     * @var string Type of file
     */
    protected $type;

    /**
     * @var int|null Id of owner of file
     */
    protected $userId;

    /**
     * @var int|null Id of project
     */
    protected $projectId;

    /**
     * @var int|null Id of task
     */
    protected $taskId;

    /**
     * @var string|null Description of file
     */
    protected $description;

    /**
     * @var string|null Created at
     */
    protected $createdAt;

    /**
     * @var string|null Updated at
     */
    protected $updatedAt;

    /**
     * TeamItem constructor.
     *
     * @param null $row
     */
    public function __construct($row = null)
    {
        if (isset($row['fileid'])) {
            $this->fileId = $row['fileid'];
        }
        $this->filename = $row['filename'];
        $this->path = $row['path'];
        $this->type = $row['type'];
        $this->userId = $row['userid'];
        if (isset($row['projectid'])) {
            $this->projectId = $row['projectid'];
        }
        if (isset($row['taskid'])) {
            $this->taskId = $row['taskid'];
        }
        $this->description = $row['description'];
        if (isset($row['created_at'])) {
            $this->createdAt = $row['created_at'];
        }
        if (isset($row['updated_at'])) {
            $this->updatedAt = $row['updated_at'];
        }
    }

    /**
     * Gets file id
     *
     * @return int|null
     */
    public function getFileId() : ?int
    {
        return $this->fileId;
    }

    /**
     * Gets filename
     *
     * @return string
     */
    public function getFilename() : string
    {
        return $this->filename;
    }

    /**
     * Gets path
     *
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * Gets type
     *
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Gets user id
     *
     * @return int
     */
    public function getUserId() : ?int
    {
        return $this->userId;
    }

    /**
     * Gets project id
     *
     * @return int|null
     */
    public function getProjectId() : ?int
    {
        return $this->projectId;
    }

    /**
     * Gets task id
     *
     * @return int|null
     */
    public function getTaskId() : ?int
    {
        return $this->taskId;
    }

    /**
     * Gets description
     *
     * @return null|string
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }

    /**
     * Gets created_at
     *
     * @return null|string
     */
    public function getCreatedAt() : ?string
    {
        return $this->createdAt;
    }

    /**
     * Gets updated_at
     *
     * @return null|string
     */
    public function getUpdatedAt() : ?string
    {
        return $this->updatedAt;
    }

    /**
     * Gets added at
     *
     * @return null|string
     */
    public function getAddedAt() : ?string
    {
        if ($this->createdAt) {
            $date =  substr($this->createdAt, 0, 10);
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);
            $time = substr($this->createdAt, 11, 5);
            return $day . '.' . $month . '.' . $year . ' ' . $time;
        }
        return null;
    }
}