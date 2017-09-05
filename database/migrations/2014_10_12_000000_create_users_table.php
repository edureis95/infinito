<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('avatar')->default('default.jpg');
            $table->string('password');
            $table->string('cell_phone')->default('');
            $table->string('desk_phone')->default('');
            $table->string('skype')->default('');
            $table->integer('company')->unsigned()->default(1);
            $table->integer('function')->unsigned()->default(1);
            $table->foreign('company')->references('id')->on('company');
            $table->foreign('function')->references('id')->on('function');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
