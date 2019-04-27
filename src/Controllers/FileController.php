<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: FileController.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Cache;

/**
 * Class FileController
 * @package xkamen06\pms\Controllers
 */
class FileController
{
    /**
     * Authorize user to add file
     *
     * @param int $projectId
     *
     * @throws UnauthorizedException | NotFoundHttpException
     *
     * @return void
     */
    public function authorizeUserAdd(int $projectId) : void
    {
        $project = projectRepository()->getProjectById($projectId);
        if (auth()->user()->role !== 'admin' && !$project->isMember(auth()->user()->id)
            && $project->getLeaderId() !== auth()->user()->id) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Authorize user to delete file
     *
     * @param int $fileId
     *
     * @throws UnauthorizedException | NotFoundHttpException
     *
     * @return void
     */
    public function authorizeUserDelete(int $fileId) : void
    {
        $file = fileRepository()->getFileById($fileId);
        if ($projectId = $file->getProjectId()) {
            $project = projectRepository()->getProjectById($projectId);
        } else {
            $project = taskRepository()->getTaskById($file->getTaskId())->getProjectId();
        }
        if (auth()->user()->role !== 'admin' && $file->getUserId() !== auth()->user()->id
            && $project->getLeaderId() !== auth()->user()->id) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Modify filename
     *
     * @param string $originalName
     *
     * @param string $additionalString
     *
     * @return string
     */
    protected function modifyFilename(string $originalName, string $additionalString) : string
    {
        $extStart = strpos($originalName ,pathinfo($originalName, PATHINFO_EXTENSION)) - 1;
        return substr($originalName, 0, $extStart) . $additionalString . '.' .
            pathinfo($originalName, PATHINFO_EXTENSION);
    }

    /**
     * Show add file fomr
     *
     * @param int $projectId
     *
     * @return View
     */
    public function showAddFileToProjectForm(int $projectId) : View
    {
        return view('pms::File.create', ['projectId' => $projectId]);
    }

    /**
     * Show add file fomr
     *
     * @param int $taskId
     *
     * @return View
     */
    public function showAddFileToTaskForm(int $taskId) : View
    {
        return view('pms::File.create', ['taskId' => $taskId]);
    }

    /**
     * Add file to project
     *
     * @param int $projectId
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function addFileToProject(int $projectId, Request $request) : RedirectResponse
    {
        $this->authorizeUserAdd($projectId);
        $requestFilename =  $request->file('filename');
        if ($requestFilename === null) {
            throw new NotFoundHttpException();
        }
        $originalFilename = $requestFilename->getClientOriginalName() ;
        $originalFilename = $this->modifyFilename($originalFilename, '-project' . $projectId);
        $path = $requestFilename->storeAs('public', $originalFilename);
        $request['originalFilename'] = $originalFilename;
        $request['path'] = $path;
        $request['projectId'] = $projectId;
        fileRepository()->storeFile($request->all());
        Cache::flush();
        return redirect()->route('showproject', ['projectId' => $projectId]);
    }

    /**
     * Add file to task
     *
     * @param int $taskId
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function addFileToTask(int $taskId, Request $request) : RedirectResponse
    {
        $task = taskRepository()->getTaskById($taskId);
        $this->authorizeUserAdd($task->getProjectId());
        $requestFilename = $request->file('filename');
        if ($requestFilename === null) {
            throw new NotFoundHttpException();
        }
        $originalFilename = $requestFilename->getClientOriginalName();
        $originalFilename = $this->modifyFilename($originalFilename, '-task' . $taskId);
        $path = $requestFilename->storeAs('public', $originalFilename);
        $request['originalFilename'] = $originalFilename;
        $request['path'] = $path;
        $request['taskId'] = $taskId;
        fileRepository()->storeFile($request->all());
        Cache::flush();
        return redirect()->route('showtask', ['taskId' => $taskId]);
    }

    /**
     * Download file
     *
     * @param $fileId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function downloadFile(int $fileId) : RedirectResponse
    {
        $file = fileRepository()->getFileById($fileId);
        return response()->redirectTo(\Storage::url($file->getPath()));
    }

    /**
     * Delete file
     *
     * @param $fileId
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function deleteFile(int $fileId) : RedirectResponse
    {
        $this->authorizeUserDelete($fileId);
        fileRepository()->deleteFileById($fileId);
        Cache::flush();
        return redirect()->back();
    }

    /**
     * Move file to project
     *
     * @param int $fileId
     *
     * @param int $projectId
     *
     * @return RedirectResponse
     *
     * @throws NotFoundHttpException | UnauthorizedException
     */
    public function moveFileToProject(int $fileId, int $projectId) : RedirectResponse
    {
        $this->authorizeUserAdd($projectId);
        fileRepository()->moveFileToProject($fileId, $projectId);
        Cache::flush();
        return redirect()->back();
    }

    /**
     * Copy file to project
     *
     * @param int $fileId
     *
     * @param int $projectId
     *
     * @return RedirectResponse
     *
     * @throws NotFoundHttpException | UnauthorizedException
     */
    public function copyFileToProject(int $fileId, int $projectId) : RedirectResponse
    {
        $this->authorizeUserAdd($projectId);
        fileRepository()->copyFileToProject($fileId, $projectId);
        Cache::flush();
        return redirect()->back();
    }
}