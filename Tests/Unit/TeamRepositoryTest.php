<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TeamRepositoryTest.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace PMS\Tests\Unit;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\TeamRepositoryInterface;

/**
 * Class TeamRepositoryTest
 * @package PMS\Tests\Unit
 */
class TeamRepositoryTest extends BaseRepositoryTest
{
    /**
     * @var string
     */
    protected $table = 'team';

    /**
     * Returns if helper returns instance of repository
     *
     * @return bool
     */
    public function isRepositoryHelperInstanceOfRepository(): bool
    {
        return teamRepository() instanceof TeamRepositoryInterface;
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
    public function get_all_teams_paginator_should_return_paginator_with_nonempty_array()
    {
        $perPage = 10;
        $page = 1;
        $skippedIds = [];
        $allTeamsPaginator = teamRepository()->getAllTeamsPaginator($skippedIds, $perPage, $page);
        $this->assertNotEmpty($allTeamsPaginator);
    }

    /** @test */
    public function get_all_teams_paginator_with_all_skiped_ids_should_return_paginator_with_empty_array()
    {
        $perPage = 10;
        $page = 1;
        $skippedIds = DB::table($this->table)->pluck('teamid');
        $allTeamsPaginator = teamRepository()->getAllTeamsPaginator($skippedIds->toArray(), $perPage, $page);
        $this->assertEmpty($allTeamsPaginator);
    }

    /** @test */
    public function get_team_by_id_with_existing_id_should_return_object()
    {
        $teamId = $this->getTestObject()->teamid;
        $team = teamRepository()->getTeamById($teamId);
        $this->assertEquals($teamId, $team->getTeamId());
    }

    /** @test */
    public function get_team_by_id_without_existing_id_should_throw_exception()
    {
        $this->expectException(NotFoundHttpException::class);
        teamRepository()->getTeamById(0);
    }

    /** @test */
    public function delete_user_from_team_by_id_should_delete_user_from_team()
    {
        $teamId = $this->getTestObject()->teamid;
        $userIds = DB::table('user_team')->where('teamid', $teamId)->pluck('userid');
        $userId = DB::table('users')->whereNotIn('id', $userIds)->first()->id;
        DB::table('user_team')->insert([
            'user_teamid' => $userId . $teamId,
            'userid' => $userId,
            'teamid' => $teamId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        teamRepository()->deleteUserFromTeamById($userId, $teamId);
        $userTeam = DB::table('user_team')->where('teamid', $teamId)
            ->where('userid', $userId)->first();
        $this->assertNull($userTeam);
    }

    /** @test */
    public function get_teams_by_user_id_with_existing_id_should_return_nonempty_array()
    {
        $userId = DB::table('user_team')->first()->userid;
        $teams = teamRepository()->getTeamsByUserId($userId);
        $this->assertNotEmpty($teams);
    }

    /** @test */
    public function get_teams_by_user_id_without_existing_id_should_return_empty_array()
    {
        $teams = teamRepository()->getTeamsByUserId(0);
        $this->assertEmpty($teams);
    }

    /** @test */
    public function delete_team_by_id_should_delete_team()
    {
        $teamId = $this->getTestObject()->teamid;
        teamRepository()->deleteTeamById($teamId);
        $team = DB::table($this->table)->where('teamid', $teamId)->first();
        $this->assertNull($team);
    }

    /** @test */
    public function update_team_should_update_team()
    {
        $teamId = $this->getTestObject()->teamid;
        $value = 'abc';
        $permissions = 'all';
        teamRepository()->updateTeam($teamId, [
            'shortcut' => $value,
            'fullname' => $value,
            'description' => $value,
            'permissions' => $permissions
        ]);
        $team = DB::table($this->table)->where('teamid', $teamId)->first();
        $this->assertEquals($value, $team->shortcut);
        $this->assertEquals($value, $team->fullname);
        $this->assertEquals($value, $team->description);
        $this->assertEquals($permissions, $team->permissions);
    }
}
