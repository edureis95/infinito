<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('project', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number')->unique();
            $table->string('name');
            $table->string('description');
            $table->string('picture')->default('');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->integer('client')->nullable()->unsigned();
            $table->foreign('client')->references('id')->on('client');
            $table->integer('responsible')->unsigned();
            $table->foreign('responsible')->references('id')->on('users');
            $table->integer('privacy')->default(0);
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
        Schema::dropIfExists('project');
    }
}
