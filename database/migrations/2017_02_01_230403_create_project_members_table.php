<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('project_member', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member')->unsigned();
            $table->foreign('member')->references('id')->on('users');
            $table->integer('project')->unsigned();
            $table->foreign('project')->references('id')->on('project');
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
        Schema::dropIfExists('project_member');
    }
}
