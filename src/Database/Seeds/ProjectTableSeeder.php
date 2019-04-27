<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ProjectTableSeeder.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Database\Seeder;
use Faker\Factory;

/**
 * Class ProjectTableSeeder
 */
class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        DB::table('project')->truncate();
        $faker = Factory::create();

        $users = DB::table('users')->get();
        $usersCount = count($users);

        for ($i = 0; $i < 100; $i++) {
            DB::table('project')->insert([
                'shortcut' => $faker->unique()->word,
                'fullname' => $faker->word,
                'description' => $faker->text(),
                'permissions' => array_random(['members', 'all']),
                'status' => array_random(['active', 'closed']),
                'leaderid' => $users[random_int(0, $usersCount - 1)]->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
