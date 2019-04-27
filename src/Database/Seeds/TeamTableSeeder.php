<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: TeamTableSeeder.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Database\Seeder;
use Faker\Factory;

/**
 * Class TeamTableSeeder
 */
class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        DB::table('team')->truncate();
        $faker = Factory::create();

        $users = DB::table('users')->get();
        $usersCount = count($users);

        for ($i = 0; $i < 80; $i++) {
            DB::table('team')->insert([
                'shortcut' => $faker->unique()->word,
                'fullname' => $faker->word,
                'description' => $faker->text(),
                'permissions' => array_random(['members', 'all']),
                'leaderid' => $users[random_int(0, $usersCount - 1)]->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
