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
 * Class CreateTaskTable
 */
class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('task', function (Blueprint $table) {
            $table->increments('taskid')->unsigned();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['requirement', 'bug'])->default('requirement');
            $table->enum('status', ['new', 'in_progress', 'done'])->default('new');
            $table->integer('projectid')->unsigned();
            $table->integer('leaderid')->unsigned()->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('task');
    }
}
