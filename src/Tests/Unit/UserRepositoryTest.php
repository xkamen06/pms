<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: UserRepositoryTest.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace PMS\Tests\Unit;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\UserRepositoryInterface;

/**
 * Class UserRepositoryTest
 * @package PMS\Tests\Unit
 */
class UserRepositoryTest extends BaseRepositoryTest
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * Returns if helper returns instance of repository
     *
     * @return bool
     */
    public function isRepositoryHelperInstanceOfRepository(): bool
    {
        return userRepository() instanceof UserRepositoryInterface;
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
    public function get_user_by_id_with_existing_id_should_return_object()
    {
        $userId = $this->getTestObject()->id;
        $user = userRepository()->getUserById($userId);
        $this->assertEquals($userId, $user->getUserId());
    }

    /** @test */
    public function get_user_by_id_without_existing_id_should_throw_exception()
    {
        $this->expectException(NotFoundHttpException::class);
        userRepository()->getUserById(0);
    }

    /** @test */
    public function update_user_should_update_project()
    {
        $userId = $this->getTestObject()->id;
        $value = 'abc';
        $email = 'all@all.cz';
        userRepository()->updateUser($userId, [
            'firstname' => $value,
            'surname' => $value,
            'email' => $email
        ]);
        $user = DB::table($this->table)->where('id', $userId)->first();
        $this->assertEquals($value, $user->firstname);
        $this->assertEquals($value, $user->surname);
        $this->assertEquals($email, $user->email);
    }

    /** @test */
    public function get_users_by_team_id_with_existing_id_should_return_nonempty_array()
    {
        $teamId = DB::table('user_team')->first()->teamid;
        $users = userRepository()->getUsersByTeamId($teamId);
        $this->assertNotEmpty($users);
    }

    /** @test */
    public function get_users_by_team_id_without_existing_id_should_return_empty_array()
    {
        $users = userRepository()->getUsersByTeamId(0);
        $this->assertEmpty($users);
    }

    /** @test */
    public function get_user_ids_by_team_id_with_existing_id_should_return_nonempty_array()
    {
        $teamId = DB::table('user_team')->first()->teamid;
        $users = userRepository()->getUserIdsByTeamId($teamId);
        $this->assertNotEmpty($users);
    }

    /** @test */
    public function get_user_ids_by_team_id_without_existing_id_should_return_empty_array()
    {
        $users = userRepository()->getUserIdsByTeamId(0);
        $this->assertEmpty($users);
    }

    /** @test */
    public function get_users_except_ids_with_no_except_ids_should_return_nonempty_array()
    {
        $users = userRepository()->getUsersExceptIds(collect());
        $this->assertNotEmpty($users);
    }

    /** @test */
    public function get_users_except_ids_with_all_except_ids_should_return_nonempty_array()
    {
        $usersCollection = DB::table($this->table)->pluck('id');
        $users = userRepository()->getUsersExceptIds($usersCollection);
        $this->assertEmpty($users);
    }

    /** @test */
    public function get_users_by_ids_except_ids_with_no_except_ids_should_return_nonempty_array()
    {
        $usersCollection = DB::table($this->table)->pluck('id');
        $users = userRepository()->getUsersByIdsExceptIds(collect(), $usersCollection);
        $this->assertNotEmpty($users);
    }

    /** @test */
    public function get_users_by_ids_except_ids_with_all_except_ids_should_return_empty_array()
    {
        $usersCollection = DB::table($this->table)->pluck('id');
        $users = userRepository()->getUsersByIdsExceptIds($usersCollection, $usersCollection);
        $this->assertEmpty($users);
    }

    /** @test */
    public function get_users_by_project_id_with_existing_id_should_return_nonempty_array()
    {
        $projectId = DB::table('user_project')->first()->projectid;
        $users = userRepository()->getUsersByProjectId($projectId);
        $this->assertNotEmpty($users);
    }

    /** @test */
    public function get_users_by_project_id_without_existing_id_should_return_empty_array()
    {
        $users = userRepository()->getUsersByProjectId(0);
        $this->assertEmpty($users);
    }

    /** @test */
    public function get_user_ids_by_project_id_with_existing_id_should_return_nonempty_array()
    {
        $projectId = DB::table('user_project')->first()->projectid;
        $users = userRepository()->getUserIdsByProjectId($projectId);
        $this->assertNotEmpty($users);
    }

    /** @test */
    public function get_user_ids_by_project_id_without_existing_id_should_return_empty_array()
    {
        $users = userRepository()->getUserIdsByProjectId(0);
        $this->assertEmpty($users);
    }

    /** @test */
    public function get_users_by_task_id_with_existing_id_should_return_nonempty_array()
    {
        $taskId = DB::table('user_task')->first()->taskid;
        $users = userRepository()->getUsersByTaskId($taskId);
        $this->assertNotEmpty($users);
    }

    /** @test */
    public function get_users_by_task_id_without_existing_id_should_return_empty_array()
    {
        $users = userRepository()->getUsersByTaskId(0);
        $this->assertEmpty($users);
    }

    /** @test */
    public function get_user_ids_by_task_id_with_existing_id_should_return_nonempty_array()
    {
        $taskId = DB::table('user_task')->first()->taskid;
        $users = userRepository()->getUserIdsByTaskId($taskId);
        $this->assertNotEmpty($users);
    }

    /** @test */
    public function get_user_ids_by_task_id_without_existing_id_should_return_empty_array()
    {
        $users = userRepository()->getUserIdsByTaskId(0);
        $this->assertEmpty($users);
    }

    /** @test */
    public function add_user_should_add_user()
    {
        $value = 'aaa';
        $email = 'aaa@aaa.cz';
        userRepository()->addUser([
            'firstname' => $value,
            'surname' => $value,
            'email' => $email,
            'password' => '1234567890',
            'password_again' => '1234567890'
        ]);
        $user = DB::table($this->table)->where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertEquals($value, $user->firstname);
        $this->assertEquals($value, $user->surname);
        $this->assertEquals($email, $user->email);
        DB::table($this->table)->where('id', $user->id)->delete();
    }

    /** @test */
    public function delete_user_by_id_should_delete_user()
    {
        $userId = $this->getTestObject()->id;
        userRepository()->deleteUserById($userId);
        $user = DB::table($this->table)->where('id', $userId)->first();
        $this->assertNull($user);
    }
}
