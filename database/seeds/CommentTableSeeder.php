<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: CommentTableSeeder.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Database\Seeder;
use Faker\Factory;

/**
 * Class CommentTableSeeder
 */
class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        DB::table('comment')->truncate();
        $faker = Factory::create();

        $articles = DB::table('article')->get();
        $tasks = DB::table('task')->get();
        $articlesCount = count($articles);
        $tasksCount = count($tasks);

        for ($i = 0; $i < 1000; $i++) {
            $article = $articles[random_int(0, $articlesCount - 1)];
            $users = DB::table('user_team')->where('teamid', '=', $article->teamid)->get();
            $userCount = count($users);
            DB::table('comment')->insert([
                'content' => $faker->text(),
                'userid' => $users[random_int(0, $userCount - 1)]->userid,
                'articleid' => $article->articleid,
                'taskid' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for ($i = 0; $i < 300; $i++) {
            $task = $tasks[random_int(0, $tasksCount - 1)];
            $users = DB::table('user_task')->where('taskid', '=', $task->taskid)->get();
            $userCount = count($users);
            if ($userCount === 0) { continue; }
            DB::table('comment')->insert([
                'content' => $faker->text(),
                'userid' => $users[random_int(0, $userCount - 1)]->userid,
                'articleid' => null,
                'taskid' => $task->taskid,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
