<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: PMSDataSeeder.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Database\Seeder;

/**
 * Class PMSDataSeeder
 */
class PMSDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        //enable to truncate tables where are foregin keys
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(UserTableSeeder::class);
        $this->call(TeamTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
        $this->call(UserTeamTableSeeder::class);
        $this->call(UserProjectTableSeeder::class);
        $this->call(TaskTableSeeder::class);
        $this->call(UserTaskTableSeeder::class);
        $this->call(ArticleTableSeeder::class);
        $this->call(CommentTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
