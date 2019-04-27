<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: FileEloquent.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Eloquents;

use Illuminate\Database\Eloquent\Model;
use xkamen06\pms\Model\FileInterface;

/**
 * Class FileEloquent
 * @package xkamen06\pms\Model\Eloquents
 */
class FileEloquent extends Model implements FileInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'fileid',
        'filename',
        'path',
        'type',
        'userid',
        'projectid',
        'taskid',
        'description',
        'created_at',
        'updated_at'
    ];

    /**
     * Gets file id
     *
     * @return int|null
     */
    public function getFileId() : ?int
    {
        return $this->fileid;
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
     * @return int|null
     */
    public function getUserId() : ?int
    {
        return $this->userid;
    }

    /**
     * Gets project id
     *
     * @return int|null
     */
    public function getProjectId() : ?int
    {
        return $this->projectid;
    }

    /**
     * Gets task id
     *
     * @return int|null
     */
    public function getTaskId() : ?int
    {
        return $this->taskid;
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
        return $this->created_at;
    }

    /**
     * Gets updated_at
     *
     * @return null|string
     */
    public function getUpdatedAt() : ?string
    {
        return $this->updated_at;
    }

    /**
     * Gets added at
     *
     * @return null|string
     */
    public function getAddedAt() : ?string
    {
        if ($this->created_at) {
            $date =  substr($this->created_at, 0, 10);
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);
            $time = substr($this->created_at, 11, 5);
            return $day . '.' . $month . '.' . $year . ' ' . $time;
        }
        return null;
    }
}