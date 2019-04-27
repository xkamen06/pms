<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: UserProjectTableSeeder.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Database\Seeder;

/**
 * Class UserProjectTableSeeder
 */
class UserProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        DB::table('user_project')->truncate();

        $projects = DB::table('project')->get();

        foreach ($projects as $project) {
            $users = DB::table('users')->where('id', '!=', $project->leaderid)->get();
            $usersCount = count($users);
            $numberOfMembers = array_random([ 1, 3, 4, 5, 6, 7, 8, 9, 10]);
            for ($i = 0; $i < $numberOfMembers; $i++) {
                $userId = $users[random_int(0, $usersCount - 1)]->id;
                while (DB::table('user_project')->where('user_projectid', '=', $userId . $project->projectid)->first()) {
                    $userId = $users[random_int(0, $usersCount - 1)]->id;
                }
                DB::table('user_project')->insert([
                    'user_projectid' => (int)($userId . $project->projectid),
                    'userid' => $userId,
                    'projectid' => $project->projectid,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
