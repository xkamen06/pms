<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: FileRepository.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Eloquents;

use Cache;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\FileInterface;
use xkamen06\pms\Model\FileRepositoryInterface;

/**
 * Class FileRepository
 * @package xkamen06\pms\Model\Eloquents
 */
class FileRepository extends Repository implements FileRepositoryInterface
{
    /**
     * @var string Database table name
     */
    protected $table = 'file';

    /**
     * How long are data stored in cache
     * @var int
     */
    protected $cacheInterval = 1;

    /**
     * Cached tags
     * @var array
     */
    protected $cacheTags = ['FileRepository', 'file'];

    /**
     * Store file to database
     *
     * @param $params
     *
     * @return void
     */
    public function storeFile(array $params) : void
    {
        if (isset($params['taskId'])) {
            FileEloquent::insert([
                'filename' => $params['originalFilename'],
                'path' => $params['path'],
                'taskid' => $params['taskId'],
                'type' => $params['type'],
                'description' => $params['description'],
                'userid' => auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            FileEloquent::insert([
                'filename' => $params['originalFilename'],
                'path' => $params['path'],
                'projectid' => $params['projectId'],
                'type' => $params['type'],
                'description' => $params['description'],
                'userid' => auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Get files by projectId
     *
     * @param int $projectId
     *
     * @return array
     */
    public function getFilesByProjectId(int $projectId) : array
    {
        $cacheKey = 'FileRepository.getFilesByProjectId' . $projectId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($projectId) {
            return $this->toArray(FileEloquent::where('projectid', '=', $projectId)->get());
        });
    }

    /**
     * Get files by projectId
     *
     * @param int $taskId
     *
     * @return array
     */
    public function getFilesByTaskId(int $taskId) : array
    {
        $cacheKey = 'FileRepository.getFilesByTaskId' . $taskId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($taskId) {
            return $this->toArray(FileEloquent::where('taskid', '=', $taskId)->get());
        });
    }

    /**
     * Get file by it's id
     *
     * @param int $fileId
     *
     * @return FileInterface
     *
     * @throws NotFoundHttpException
     */
    public function getFileById(int $fileId) : FileInterface
    {
        $file = FileEloquent::where('fileid', '=', $fileId)->first();
        if ($file) {
            return $file;
        }
        throw new NotFoundHttpException();
    }

    /**
     * Delete file by it's id
     *
     * @param $fileId
     *
     * @return void
     */
    public function deleteFileById(int $fileId) : void
    {
        $file = $this->getFileById($fileId);
        \Storage::delete($file->getPath());
        FileEloquent::where('fileid', '=',$fileId)->delete();
    }

    /**
     * Move file to project
     *
     * @param int $fileId
     *
     * @param int $projectId
     */
    public function moveFileToProject(int $fileId, int $projectId) : void
    {
        $file = FileEloquent::where('fileid', '=', $fileId)->first();
        $extStart = strpos($file->getFilename() ,pathinfo($file->getFilename(), PATHINFO_EXTENSION)) - 1;
        $posId = '-task' . $file->getTaskId();
        $posIdStart = strpos($file->getFilename(), $posId);
        $newFilename = substr(substr($file->getFilename(), 0, $extStart), 0, $posIdStart)
            . '-project' . $projectId . '.' . pathinfo($file->getFilename(), PATHINFO_EXTENSION);
        FileEloquent::where('fileid', '=', $fileId)->update([
            'filename' => $newFilename,
            'path' => '/public' . $newFilename,
            'taskid' => null,
            'projectid' => $projectId
        ]);
    }

    /**
     * Copy file to project
     *
     * @param int $fileId
     *
     * @param int $projectId
     */
    public function copyFileToProject(int $fileId, int $projectId) : void
    {
        $file = FileEloquent::where('fileid', '=', $fileId)->first();
        $extStart = strpos($file->getFilename() ,pathinfo($file->getFilename(), PATHINFO_EXTENSION)) - 1;
        $posId = '-task' . $file->getTaskId();
        $posIdStart = strpos($file->getFilename(), $posId);
        $newFilename = substr(substr($file->getFilename(), 0, $extStart), 0, $posIdStart)
            . '-project' . $projectId . '.' . pathinfo($file->getFilename(), PATHINFO_EXTENSION);
        Storage::copy($file->getPath(), 'public/' . $newFilename);
        FileEloquent::insert([
            'filename' => $newFilename,
            'path' => 'public/' . $newFilename,
            'projectid' => $projectId,
            'type' => $file->getType(),
            'description' => $file->getDescription(),
            'userid' => $file->getUserId(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Delete files by projectId
     *
     * @param int $projectId
     */
    public function deleteFilesByProjectId(int $projectId) : void
    {
        $files = FileEloquent::where('projectid', '=', $projectId)->get();
        foreach ($files as $file) {
            $this->deleteFileById($file->getFileId());
        }
    }

    /**
     * Delete files by taskId
     *
     * @param int $taskId
     */
    public function deleteFilesByTaskId(int $taskId) : void
    {
        $files = FileEloquent::where('taskid', '=', $taskId)->get();
        foreach ($files as $file) {
            $this->deleteFileById($file->getFileId());
        }
    }

    /**
     * Get task files count
     *
     * @return int
     */
    public function getTaskFilesCount() : int
    {
        $cacheKey = 'FileRepository.getTaskFilesCount';

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () {
            return FileEloquent::where('type', 'task')->count();
        });
    }

    /**
     * Get submit files count
     *
     * @return int
     */
    public function getSubmitFilesCount() : int
    {
        $cacheKey = 'FileRepository.getSubmitFilesCount';

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () {
            return FileEloquent::where('type', 'submit')->count();
        });
    }

    /**
     * Get submit files count by user id
     *
     * @param int $userId
     *
     * @return int
     */
    public function getSubmitFilesCountByUserId(int $userId) : int
    {
        $cacheKey = 'FileRepository.getSubmitFilesCountByUserId' . $userId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($userId) {
            return FileEloquent::where('type', 'submit')->where('userid', $userId)->count();
        });
    }

    /**
     * Get files count by user id
     *
     * @param int $userId
     *
     * @return int
     */
    public function getFilesCountByUserId(int $userId) : int
    {
        $cacheKey = 'FileRepository.getFilesCountByUserId' . $userId;

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($userId) {
            return FileEloquent::where('userid', $userId)->count();
        });
    }
}