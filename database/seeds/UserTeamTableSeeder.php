<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: UserTeamTableSeeder.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Database\Seeder;

/**
 * Class UserTeamTableSeeder
 */
class UserTeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        DB::table('user_team')->truncate();

        $teams = DB::table('team')->get();
        foreach ($teams as $team) {
            $numberOfMembers = array_random([ 3, 4, 5, 6, 7, 8, 9]);
            $disabledIds[] = $team->leaderid;
            for ($i = 0; $i < $numberOfMembers; $i++) {
                $users = DB::table('users')->whereNotIn('id', $disabledIds)->get();
                $usersCount = count($users);
                if ($usersCount === 0) {
                    break;
                }
                $user = $users[random_int(0, $usersCount - 1)];
                $disabledIds[] = $user->id;
                DB::table('user_team')->insert([
                    'user_teamid' => (int)(0 . $user->id . $team->teamid),
                    'userid' => $user->id,
                    'teamid' => $team->teamid,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
