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
 * Class CreateCommentTable
 */
class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->increments('commentid')->unsigned();
            $table->text('content');
            $table->integer('userid')->unsigned()->nullable();
            $table->integer('articleid')->unsigned()->nullable();
            $table->integer('taskid')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('userid')->references('id')->on('users');
            $table->foreign('articleid')->references('articleid')->on('article');
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
        Schema::dropIfExists('comment');
    }
}
