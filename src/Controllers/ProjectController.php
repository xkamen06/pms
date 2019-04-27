<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ProjectController.php
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

/**
 * Class ProjectController
 * @package xkamen06\pms\Controllers
 */
class ProjectController
{
    /**
     * Number of items per page
     *
     * @var int
     */
    private $perPage = 20;

    /**
     * Authorize user, if user is able to do the action
     *
     * @param int $projectId
     *
     * @return void
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    private function authorizeUser(int $projectId) : void
    {
        $leaderId = projectRepository()->getProjectById($projectId)->getLeaderId();
        if ((auth()->user()->role !== 'admin') && (auth()->user()->id !== $leaderId)) {
            throw new UnauthorizedException('Permission denied.');
        }
    }

    /**
     * Show all projects
     *
     * @return View
     */
    public function showAllProjects() : View
    {
        $myprojects = projectRepository()->getProjectsByUserId(auth()->user()->id);
        $myprojectLeader = [];
        $myprojectsIds = [];
        foreach ($myprojects as $i => $myproject) {
            $myprojectsIds[] = $myproject->getProjectId();
        }
        $projectsPaginator = projectRepository()->getAllProjectsPaginator($myprojectsIds, $this->perPage,
            request('page', 1));
        $projectsPaginator->setPath('/allprojects');
        foreach ($myprojects as $i => $project) {
            if ($project->getLeaderId() === auth()->user()->id) {
                $myprojectLeader[] = $project;
                unset($myprojects[$i]);
            }
        }
        return view('pms::Project.index', compact('projectsPaginator', 'myprojects', 'myprojectLeader'));
    }

    /**
     * Show project by projectId
     *
     * @param int $projectId
     *
     * @return View
     *
     * @throws  NotFoundHttpException
     */
    public function showProject(int $projectId) : View
    {
        $project = projectRepository()->getProjectById($projectId);
        $leader = $project->getLeader();
        $members = $project->getMembers();
        $tasks = taskRepository()->getTasksByProjectId($projectId);
        $submitFiles = fileRepository()->getFilesByProjectId($projectId);
        $taskFiles = [];
        foreach ($submitFiles as $i => $file) {
            if ($file->getType() === 'task') {
                $taskFiles[] = $file;
                unset($submitFiles[$i]);
            }
        }
        return view('pms::Project.show', compact('project', 'leader',
            'members', 'tasks', 'submitFiles', 'taskFiles'));
    }

    /**
     * Delete user (identified by userId) from project (identified by projectId)
     *
     * @param int $projectId
     *
     * @param int $userId
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function deleteUserFromProject(int $projectId, int $userId) : RedirectResponse
    {
        $this->authorizeUser($projectId);
        projectRepository()->deleteUserFromProjectById($userId, $projectId);
        Cache::flush();
        return redirect()->back();
    }

    /**
     * Change project's status
     *
     * @param int $projectId
     *
     * @param string $status
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function changeProjectStatus(int $projectId, string $status) : RedirectResponse
    {
        $this->authorizeUser($projectId);
        projectRepository()->changeProjectStatus($projectId, $status);
        Cache::flush();
        return redirect()->back();
    }

    /**
     * Show edit form to edit project
     *
     * @param int $projectId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showEditForm(int $projectId) : View
    {
        $this->authorizeUser($projectId);
        $project = projectRepository()->getProjectById($projectId);
        return view('pms::Project.edit', compact('project'));
    }

    /**
     * Update project
     *
     * @param int $projectId
     *
     * @param Request $request
     *
     * @return RedirectResponse|View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function updateProject(int $projectId, Request $request)
    {
        $this->authorizeUser($projectId);
        $status = projectRepository()->updateProject($projectId, $request->all());
        if ($status === 'shortcut_exist') {
            $project = projectRepository()->getProjectById($projectId);
            return view('pms::Project.edit', [
                'project' => $project,
                'error' => trans('Project.edit.error_shortcut_exist')
            ]);
        }
        Cache::flush();
        return redirect()->route('showproject', compact('projectId'));
    }

    /**
     * Show add member to project form
     *
     * @param int $projectId
     *
     * @return View
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function showAddMemberForm(int $projectId) : View
    {
        $this->authorizeUser($projectId);
        $project = projectRepository()->getProjectById($projectId);
        $exceptIds = userRepository()->getUserIdsByProjectId($projectId);
        if ($project->getLeaderId()) {
            $exceptIds->push($project->getLeaderId());
        }
        $users = userRepository()->getUsersExceptIds($exceptIds);

        return view('pms::Project.addmembers', compact('users', 'projectId'));
    }

    /**
     * Add members to project
     *
     * @param int $projectId
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function addMembers(int $projectId, Request $request) : RedirectResponse
    {
        $this->authorizeUser($projectId);
        projectRepository()->addMembers($projectId ,$request->all());
        Cache::flush();
        return redirect()->route('showproject', compact('projectId'));
    }

    /**
     * Show create project form
     *
     * @return View
     */
    public function showCreateForm() : View
    {
        return view('pms::Project.create');
    }

    /**
     * Create new project
     *
     * @param Request $request
     *
     * @return RedirectResponse|View
     */
    public function createProject(Request $request)
    {
        $projectId = projectRepository()->createProject($request->all());
        if ($projectId === -1) {
            return view('pms::Project.create', [
                'error' => trans('Project.create.error_shortcut_exist')
            ]);
        }
        Cache::flush();
        return redirect()->route('showproject', compact('projectId'));
    }

    /**
     * Delete project
     *
     * @param int $projectId
     *
     * @return RedirectResponse
     *
     * @throws UnauthorizedException | NotFoundHttpException
     */
    public function deleteProject(int $projectId) : RedirectResponse
    {
        $this->authorizeUser($projectId);
        projectRepository()->deleteProjectById($projectId);
        Cache::flush();
        return redirect()->route('allprojects');
    }
}