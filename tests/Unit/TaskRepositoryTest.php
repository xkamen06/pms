<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TaskRepositoryTest.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace PMS\Tests\Unit;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xkamen06\pms\Model\TaskRepositoryInterface;

/**
 * Class TaskRepositoryTest
 * @package PMS\Tests\Unit
 */
class TaskRepositoryTest extends BaseRepositoryTest
{
    /**
     * @var string
     */
    protected $table = 'task';

    /**
     * Returns if helper returns instance of repository
     *
     * @return bool
     */
    public function isRepositoryHelperInstanceOfRepository(): bool
    {
        return taskRepository() instanceof TaskRepositoryInterface;
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
    public function get_tasks_by_project_id_with_existing_id_should_return_nonempty_array()
    {
        $task = $this->getTestObject();
        $tasks = taskRepository()->getTasksByProjectId($task->projectid);
        $this->assertNotEmpty($tasks);
    }

    /** @test */
    public function get_tasks_by_project_id_without_existing_id_should_return_empty_array()
    {
        $tasks = taskRepository()->getTasksByProjectId(0);
        $this->assertEmpty($tasks);
    }

    /** @test */
    public function get_task_by_id_with_existing_id_should_return_object()
    {
        $taskId = $this->getTestObject()->taskid;
        $task = taskRepository()->getTaskById($taskId);
        $this->assertEquals($taskId, $task->getTaskId());
    }

    /** @test */
    public function get_task_by_id_without_existing_id_should_throw_exception()
    {
        $this->expectException(NotFoundHttpException::class);
        taskRepository()->getTaskById(0);
    }

    /** @test */
    public function update_task_by_id_should_update_task()
    {
        $value = 'aaa';
        $type = 'bug';
        $status = 'new';
        $taskId = $this->getTestObject()->taskid;
        taskRepository()->updateTaskById($taskId, [
            'name' => $value,
            'description' => $value,
            'type' => $type,
            'status' => $status
        ]);
        $task = DB::table($this->table)->where('taskid', $taskId)->first();
        $this->assertEquals($value, $task->name);
        $this->assertEquals($value, $task->description);
        $this->assertEquals($type, $task->type);
        $this->assertEquals($status, $task->status);
    }

    /** @test */
    public function delete_user_from_task_by_id_should_delete_user_from_task()
    {
        $taskId = $this->getTestObject()->taskid;
        $userIds = DB::table('user_task')->where('taskid', $taskId)->pluck('userid');
        $userId = DB::table('users')->whereNotIn('id', $userIds)->first()->id;
        DB::table('user_task')->insert([
            'user_taskid' => $userId . $taskId,
            'userid' => $userId,
            'taskid' => $taskId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        taskRepository()->deleteUserFromTaskById($userId, $taskId);
        $userTask = DB::table('user_task')->where('taskid', $taskId)
            ->where('userid', $userId)->first();
        $this->assertNull($userTask);
    }

    /** @test */
    public function change_task_status_should_change_task_status()
    {
        $task = $this->getTestObject();
        if ($task->status === 'done') {
            $status = 'new';
        } elseif ($task->status === 'new') {
            $status = 'in_progress';
        } else {
            $status = 'done';
        }
        taskRepository()->changeTaskStatus($task->taskid, $status);
        $task = DB::table($this->table)->where('taskid', $task->taskid)->first();
        $this->assertEquals($status, $task->status);
    }

    /** @test */
    public function delete_task_by_id_should_delete_task()
    {
        $taskId = $this->getTestObject()->taskid;
        taskRepository()->deleteTaskById($taskId);
        $task = DB::table($this->table)->where('taskid', $taskId)->first();
        $this->assertNull($task);
    }

    /** @test */
    public function delete_tasks_by_project_id_should_delete_tasks()
    {
        $task = $this->getTestObject();
        $taskid = $task->taskid;
        taskRepository()->deleteTasksByProjectId($task->projectid);
        $task = DB::table($this->table)->where('taskid', $taskid)->first();
        $this->assertNull($task);
    }
}
