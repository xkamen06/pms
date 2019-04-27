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
 * Class CreateProjectTable
 */
class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('project', function (Blueprint $table) {
            $table->increments('projectid')->unsigned();
            $table->string('shortcut')->unique();
            $table->string('fullname');
            $table->text('description')->nullable();
            $table->enum('permissions', ['members', 'all'])->default('members');
            $table->enum('status', ['active', 'closed'])->default('active');
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
        Schema::dropIfExists('project');
    }
}
