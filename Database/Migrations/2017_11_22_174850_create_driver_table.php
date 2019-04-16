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
 * Class CreateDriverTable
 */
class CreateDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('driver', function (Blueprint $table) {
            $table->increments('driverid')->unsigned();
            $table->enum('type', ['item', 'eloquent'])->default('item');
            $table->timestamps();
        });

        DB::table('driver')->insert([
            'type' => 'item',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('driver');
    }
}
