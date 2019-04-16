<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: ArticleTableSeeder.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Database\Seeder;
use Faker\Factory;

/**
 * Class ArticleTableSeeder
 */
class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        DB::table('article')->truncate();
        $faker = Factory::create();
        $teams = DB::table('team')->get();
        $teamsCount = count($teams);

        for ($i = 0; $i < 500; $i++) {
            $teamId = $teams[random_int(0, $teamsCount - 1)]->teamid;
            $usersTeam = DB::table('user_team')->where('teamid', '=', $teamId)->get();
            $usersTeamCount = count($usersTeam);
            if ($usersTeamCount === 0) {
                continue;
            }
            $userId = $usersTeam[random_int(0, $usersTeamCount - 1)]->userid;
            DB::table('article')->insert([
                'title' => $faker->sentence,
                'subtitle' => array_random([null ,$faker->sentence]),
                'type' => array_random(['info', 'requirement', 'attention']),
                'content' => $faker->text(),
                'image' => null,
                'userid' => $userId,
                'teamid' => $teamId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
