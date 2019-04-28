<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: UserTableSeeder.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

/**
 * Class UserTableSeeder
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        DB::table('users')->truncate();
        $faker = Factory::create();

        DB::table('users')->insert([
            'password' => bcrypt('secret'),
            'firstname' => 'admin',
            'surname' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        for ($i = 0; $i < 399; $i++) {
            $lastname = $faker->lastName;
            $firstname = $faker->firstName;
            $login = mb_strtolower($lastname . $firstname);
            DB::table('users')->insert([
                'password' => bcrypt('secret'),
                'firstname' => $firstname,
                'surname' => $lastname,
                'email' => $login . random_int(0, 99) . '@gmail.com',
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

    }
}
