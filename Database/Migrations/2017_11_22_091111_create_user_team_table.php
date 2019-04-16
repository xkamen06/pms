<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * Author: Zdenek Kamensky
 * Date: 2018
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserTeamTable
 */
class CreateUserTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('user_team', function (Blueprint $table) {
            $table->integer('user_teamid')->unsigned()->primary();
            $table->integer('userid')->unsigned();
            $table->integer('teamid')->unsigned();
            $table->timestamps();

            $table->foreign('userid')->references('id')->on('users');
            $table->foreign('teamid')->references('teamid')->on('team');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('user_team');
    }
}
