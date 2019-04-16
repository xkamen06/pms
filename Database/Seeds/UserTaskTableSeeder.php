<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: UserTaskTableSeeder.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Database\Seeder;

/**
 * Class UserTaskTableSeeder
 */
class UserTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        DB::table('user_task')->truncate();

        $users = DB::table('users')->get();
        $tasks = DB::table('task')->get();
        $usersCount = count($users);
        $tasksCount = count($tasks);

        for ($i = 0; $i < 350; $i++) {
            $userId = $users[random_int(0, $usersCount - 1)]->id;
            $taskId = $tasks[random_int(0, $tasksCount - 1)]->taskid;
            while (DB::table('user_task')->where('user_taskid', '=', $userId . $taskId)->first()) {
                $userId = $users[random_int(0, $usersCount - 1)]->id;
                $taskId = $tasks[random_int(0, $tasksCount - 1)]->taskid;
            }

            DB::table('user_task')->insert([
                'user_taskid' => $userId . $taskId,
                'userid' => $userId,
                'taskid' => $taskId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
