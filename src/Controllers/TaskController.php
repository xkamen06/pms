<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TaskController.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Controllers;

use Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\TaskInterface;

/**
 * Class TaskController
 * @package xkamen06\pms\Controllers
 */
class TaskController
{
    /**
     * Authorize user, if user is able to do the action
     *
     * @param int $projectId
     *
     * @return void
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function authorizeUserCreate(int $projectId) : void
    {
        $project = projectRepository()->getProjectById($projectId);
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $project->getLeaderId()
            && !$project->isMember(auth()->user()->id)) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Authorize user, if user is able to do the action
     *
     * @param int $projectId
     *
     * @return void
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function authorizeUserShowAndMembers(int $projectId) : void
    {
        $project = projectRepository()->getProjectById($projectId);
        if ($project->getPermissions() !== 'all' && auth()->user()->role !== 'admin'
            && auth()->user()->id !== $project->getLeaderId() && !$project->isMember(auth()->user()->id)) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Authorize user, if user can edit or delete task
     *
     * @param TaskInterface $task
     *
     * @return void
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function authorizeUserEditDelete(TaskInterface $task) : void
    {
        $project = projectRepository()->getProjectById($task->getProjectId());
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $project->getLeaderId()
            && $task->getLeaderId() !== auth()->user()->id) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Authorize user to assign task to me
     *
     * @param int $taskId
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function authorizeUserAssignTaskToMe(int $taskId) : void
    {
        $task = taskRepository()->getTaskById($taskId);
        $project = projectRepository()->getProjectById($task->getProjectId());
        if ($task->isMember(auth()->user()->id) || (auth()->user()->role !== 'admin' &&
                auth()->user()->id !== $project->getLeaderId() && !$project->isMember(auth()->user()->id))) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Create task
     *
     * @param int $projectId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showCreateTaskForm(int $projectId) : View
    {
        $this->authorizeUserCreate($projectId);
        return view('pms::Task.create', compact('projectId'));
    }

    /**
     * Create new task
     *
     * @param int $projectId
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function createTask(int $projectId, Request $request) : RedirectResponse
    {
        $this->authorizeUserCreate($projectId);
        $taskId = taskRepository()->createTask($projectId, $request->all());
        Cache::flush();
        return redirect()->route('showtask', compact('taskId'));
    }

    /**
     * Show task by it's id
     *
     * @param int $taskId
     *
     * @param int|null $editCommentId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showTask(int $taskId, ?int $editCommentId = null) : View
    {
        $task = taskRepository()->getTaskById($taskId);
        $this->authorizeUserShowAndMembers($task->getProjectId());
        $project = projectRepository()->getProjectById($task->getProjectId());
        $members = $task->getMembers();
        $comments = commentRepository()->getCommentsByTaskId($taskId);

        $submitFiles = fileRepository()->getFilesByTaskId($taskId);
        $taskFiles = [];
        foreach ($submitFiles as $i => $file) {
            if ($file->getType() === 'task') {
                $taskFiles[] = $file;
                unset($submitFiles[$i]);
            }
        }
        return view('pms::Task.show', compact('task', 'members',
            'comments', 'editCommentId', 'project', 'submitFiles', 'taskFiles'));
    }

    /**
     * Show edit task form
     *
     * @param int $taskId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showEditTaskForm(int $taskId) : View
    {
        $task = taskRepository()->getTaskById($taskId);
        $this->authorizeUserEditDelete($task);
        return view('pms::Task.edit', compact('task'));
    }

    /**
     * Update task
     *
     * @param int $taskId
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function updateTask(int $taskId, Request $request) : RedirectResponse
    {
        $task = taskRepository()->getTaskById($taskId);
        $this->authorizeUserEditDelete($task);
        taskRepository()->updateTaskById($taskId, $request->all());
        Cache::flush();
        return redirect()->route('showtask', compact('taskId'));
    }

    /**
     * Show add member to task form
     *
     * @param int $taskId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showAddMemberForm(int $taskId) : View
    {
        $task = taskRepository()->getTaskById($taskId);
        $this->authorizeUserShowAndMembers($task->getProjectId());
        $exceptIds = userRepository()->getUserIdsByTaskId($taskId);
        if ($task->getLeaderId()) {
            $exceptIds->push($task->getLeaderId());
        }
        $ids = userRepository()->getUserIdsByProjectId($task->getProjectId());
        $users = userRepository()->getUsersByIdsExceptIds($exceptIds, $ids);

        return view('pms::Task.addmembers', compact('users', 'taskId'));
    }

    /**
     * Add members to task
     *
     * @param int $taskId
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function addMembers(int $taskId, Request $request) : RedirectResponse
    {
        $task = taskRepository()->getTaskById($taskId);
        $this->authorizeUserShowAndMembers($task->getProjectId());
        taskRepository()->addMembers($taskId ,$request->all());
        Cache::flush();
        return redirect()->route('showtask', compact('taskId'));
    }

    /**
     * Delete user (identified by userId) from task (identified by taskId)
     *
     * @param int $taskId
     *
     * @param int $userId
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function deleteTaskMember(int $taskId, int $userId) : RedirectResponse
    {
        $task = taskRepository()->getTaskById($taskId);
        $this->authorizeUserShowAndMembers($task->getProjectId());
        taskRepository()->deleteUserFromTaskById($userId, $taskId);
        Cache::flush();
        return redirect()->back();
    }

    /**
     * Change task status
     *
     * @param int $taskId
     *
     * @param string $status
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function changeTaskStatus(int $taskId, string $status) : RedirectResponse
    {
        $task = taskRepository()->getTaskById($taskId);
        $this->authorizeUserEditDelete($task);
        taskRepository()->changeTaskStatus($taskId, $status);
        Cache::flush();
        return redirect()->back();
    }

    /**
     * Delete task by id
     *
     * @param int $taskId
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function deleteTaskById(int $taskId) : RedirectResponse
    {
        $task = taskRepository()->getTaskById($taskId);
        $this->authorizeUserEditDelete($task);
        $projectId = taskRepository()->deleteTaskById($taskId);
        Cache::flush();
        return redirect()->route('showproject', compact('projectId'));
    }

    /**
     * Assign task to me
     *
     * @param int $taskId
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function assignTaskToMe(int $taskId) : RedirectResponse
    {
        $this->authorizeUserAssignTaskToMe($taskId);
        taskRepository()->addMembers($taskId ,[auth()->user()->id => '']);
        Cache::flush();
        return redirect()->back();
    }
}