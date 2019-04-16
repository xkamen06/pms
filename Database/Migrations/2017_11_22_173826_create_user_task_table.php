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
 * Class CreateUserTaskTable
 */
class CreateUserTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('user_task', function (Blueprint $table) {
            $table->integer('user_taskid')->unsigned()->primary();
            $table->integer('userid')->unsigned();
            $table->integer('taskid')->unsigned();
            $table->timestamps();

            $table->foreign('userid')->references('id')->on('users');
            $table->foreign('taskid')->references('taskid')->on('task');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('user_task');
    }
}
