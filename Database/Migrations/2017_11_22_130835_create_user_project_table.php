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
 * Class CreateUserProjectTable
 */
class CreateUserProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('user_project', function (Blueprint $table) {
            $table->integer('user_projectid')->unsigned()->primary();
            $table->integer('userid')->unsigned();
            $table->integer('projectid')->unsigned();
            $table->timestamps();

            $table->foreign('userid')->references('id')->on('users');
            $table->foreign('projectid')->references('projectid')->on('project');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('user_project');
    }
}
