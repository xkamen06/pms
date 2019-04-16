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
 * Class CreateArticleTable
 */
class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('articleid')->unsigned();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->enum('type', ['info', 'requirement', 'attention'])->default('info');
            $table->text('content');
            $table->string('image')->nullable();
            $table->integer('userid')->unsigned()->nullable();
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
        Schema::dropIfExists('article');
    }
}
