<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ProjectRepositoryTest.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace PMS\Tests\Unit;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\ProjectRepositoryInterface;

/**
 * Class ProjectRepositoryTest
 * @package PMS\Tests\Unit
 */
class ProjectRepositoryTest extends BaseRepositoryTest
{
    /**
     * @var string
     */
    protected $table = 'project';

    /**
     * Returns if helper returns instance of repository
     *
     * @return bool
     */
    public function isRepositoryHelperInstanceOfRepository(): bool
    {
        return projectRepository() instanceof ProjectRepositoryInterface;
    }

    /**
     * Get test object
     * 
     * @return mixed
     */
    public function getTestObject()
    {
        return DB::table($this->table)->first();
    }

    /** @test */
    public function get_projects_by_userid_with_existing_userid_should_return_nonempty_array()
    {
        $projects = projectRepository()->getProjectsByUserId(DB::table('user_project')->first()->userid);
        $this->assertNotEmpty($projects);
    }

    /** @test */
    public function get_projects_by_userid_without_existing_userid_should_return_empty_array()
    {
        $projects = projectRepository()->getProjectsByUserId(1000);
        $this->assertEmpty($projects);
    }

    /** @test */
    public function get_all_projects_paginator_should_return_paginator_with_nonempty_array()
    {
        $perPage = 10;
        $page = 1;
        $skippedIds = [];
        $allProjectsPaginator = projectRepository()->getAllProjectsPaginator($skippedIds, $perPage, $page);
        $this->assertNotEmpty($allProjectsPaginator);
    }

    /** @test */
    public function get_all_projects_paginator_with_all_skiped_ids_should_return_paginator_with_empty_array()
    {
        $perPage = 10;
        $page = 1;
        $skippedIds = DB::table($this->table)->pluck('projectid');
        $allProjectsPaginator = projectRepository()->getAllProjectsPaginator($skippedIds->toArray(), $perPage, $page);
        $this->assertEmpty($allProjectsPaginator);
    }

    /** @test */
    public function get_project_by_id_with_existing_id_should_return_object()
    {
        $projectId = $this->getTestObject()->projectid;
        $project = projectRepository()->getProjectById($projectId);
        $this->assertEquals($projectId, $project->getProjectId());
    }

    /** @test */
    public function get_project_by_id_without_existing_id_should_throw_exception()
    {
        $this->expectException(NotFoundHttpException::class);
        projectRepository()->getProjectById(0);
    }

    /** @test */
    public function delete_user_from_project_by_id_should_delete_user_from_project()
    {
        $projectId = $this->getTestObject()->projectid;
        $userIds = DB::table('user_project')->where('projectid', $projectId)->pluck('userid');
        $userId = DB::table('users')->whereNotIn('id', $userIds)->first()->id;
        DB::table('user_project')->insert([
            'user_projectid' => $userId . $projectId,
            'userid' => $userId,
            'projectid' => $projectId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        projectRepository()->deleteUserFromProjectById($userId, $projectId);
        $userProject = DB::table('user_project')->where('projectid', $projectId)
            ->where('userid', $userId)->first();
        $this->assertNull($userProject);
    }

    /** @test */
    public function change_project_status_should_change_project_status()
    {
        $project = $this->getTestObject();
        if ($project->status === 'active') {
            $status = 'closed';
            projectRepository()->changeProjectStatus($project->projectid, $status);
        } else {
            $status = 'active';
            projectRepository()->changeProjectStatus($project->projectid, $status);
        }
        $project = DB::table($this->table)->where('projectid', $project->projectid)->first();
        $this->assertEquals($status, $project->status);
    }

    /** @test */
    public function update_project_should_update_project()
    {
        $projectId = $this->getTestObject()->projectid;
        $value = 'abc';
        $permissions = 'all';
        projectRepository()->updateProject($projectId, [
            'shortcut' => $value,
            'fullname' => $value,
            'description' => $value,
            'permissions' => $permissions
        ]);
        $project = DB::table($this->table)->where('projectid', $projectId)->first();
        $this->assertEquals($value, $project->shortcut);
        $this->assertEquals($value, $project->fullname);
        $this->assertEquals($value, $project->description);
        $this->assertEquals($permissions, $project->permissions);
    }

    /** @test */
    public function delete_project_by_id_should_delete_project()
    {
        $projectId = $this->getTestObject()->projectid;
        projectRepository()->deleteProjectById($projectId);
        $project = DB::table($this->table)->where('projectid', $projectId)->first();
        $this->assertNull($project);
    }
}
