<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: DashboardController.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Controllers;

use Illuminate\View\View;

/**
 * Class DashboardController
 * @package xkamen06\pms\Controllers
 */
class DashboardController
{
    /**
     * Show dashboard
     *
     * @return View
     */
    public function showDashboard() : View
    {
        if (auth()->user()->role === 'admin') {
            $usersCount = userRepository()->getCount();
            $projectsCount = projectRepository()->getCount();
            $teamsCount = teamRepository()->getCount();
            $articlesCount = articleRepository()->getCount();
            $tasksCount = taskRepository()->getCount();
            $closedProjectsCount = projectRepository()->getClosedProjectsCount();
            $activeProjectsCount = projectRepository()->getActiveProjectsCount();
            $requirementTasksCount = taskRepository()->getRequirementTasksCount();
            $bugTasksCount = taskRepository()->getBugTasksCount();
            $newTasksCount = taskRepository()->getNewTasksCount();
            $inProgressTasksCount = taskRepository()->getInProgressTasksCount();
            $doneTasksCount = taskRepository()->getDoneTasksCount();
            $filesCount = fileRepository()->getCount();
            $taskFilesCount = fileRepository()->getTaskFilesCount();
            $submitFilesCount = fileRepository()->getSubmitFilesCount();
            return view('pms::dashboard', compact(
                    'usersCount',
                    'projectsCount',
                    'teamsCount',
                    'articlesCount',
                    'tasksCount',
                    'closedProjectsCount',
                    'activeProjectsCount',
                    'requirementTasksCount',
                    'bugTasksCount',
                    'newTasksCount',
                    'inProgressTasksCount',
                    'doneTasksCount',
                    'filesCount',
                    'taskFilesCount',
                    'submitFilesCount'
                )
            );
        }
        $myProjectsCount = projectRepository()->getProjectsByUserIdCount(auth()->user()->id);
        $myActiveProjectsCount = projectRepository()->getActiveProjectsByUserIdCount(auth()->user()->id);
        $tasks = taskRepository()->getTasksByUserId(auth()->user()->id);
        $filesCount = fileRepository()->getFilesCountByUserId(auth()->user()->id);
        $filesSubmitCount = fileRepository()->getSubmitFilesCountByUserId(auth()->user()->id);
        $teamsCount = teamRepository()->getTeamsCountByUserId(auth()->user()->id);
        return view('pms::dashboard', compact(
            'myProjectsCount',
            'myActiveProjectsCount',
            'tasks',
            'filesCount',
            'filesSubmitCount',
            'teamsCount'
        ));
    }
}