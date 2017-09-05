<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number')->unique();
            $table->string('name');
            $table->string('description');
            $table->integer('responsible')->unsigned();
            $table->foreign('responsible')->references('id')->on('users');
            $table->integer('activity_task_id')->references('id')->on('gantt_tasks');
            $table->integer('task_counter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity');
    }
}
