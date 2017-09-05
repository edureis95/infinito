<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GanttTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('gantt_tasks', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('text');
            $table->datetime('start_date');
            $table->integer('duration');
            $table->float('progress');
            $table->double('sortorder')->default(0);
            $table->integer('parent');
            $table->datetime('deadline')->default(null);
            $table->datetime('planned_start')->default(null);
            $table->datetime('planned_end')->default(null);
            $table->datetime('end_date');
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
        //
    }
}
