<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TaskTableSeeder.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Database\Seeder;
use Faker\Factory;

/**
 * Class TaskTableSeeder
 */
class TaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        DB::table('task')->truncate();
        $faker = Factory::create();

        $projects = DB::table('project')->get();
        $projectsCount = count($projects);

        $users = DB::table('users')->get();
        $usersCount = count($users);

        for ($i = 0; $i < 800; $i++) {
            DB::table('task')->insert([
                'name' => $faker->word,
                'description' => $faker->text(),
                'type' => array_random(['requirement', 'bug']),
                'status' => array_random(['new', 'in_progress', 'done']),
                'projectid' => $projects[random_int(0, $projectsCount - 1)]->projectid,
                'leaderid' => $users[random_int(0, $usersCount - 1)]->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
