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
 * Class CreateTeamTable
 */
class CreateTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('team', function (Blueprint $table) {
            $table->increments('teamid')->unsigned();
            $table->string('shortcut')->unique();
            $table->string('fullname');
            $table->text('description')->nullable();
            $table->enum('permissions', ['members', 'all'])->default('members');
            $table->integer('leaderid')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('leaderid')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('team');
    }
}
