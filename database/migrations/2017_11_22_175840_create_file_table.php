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
 * Class CreateFileTable
 */
class CreateFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('file', function (Blueprint $table) {
            $table->increments('fileid')->unsigned();
            $table->string('filename');
            $table->string('path');
            $table->enum('type', ['task', 'submit'])->default('task');
            $table->integer('userid')->unsigned()->nullable();
            $table->integer('projectid')->unsigned()->nullable();
            $table->integer('taskid')->unsigned()->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('userid')->references('id')->on('users');
            $table->foreign('projectid')->references('projectid')->on('project');
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
        Schema::dropIfExists('file');
    }
}
