<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('client', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('contact');
            $table->string('representant_name');
            $table->string('representant_contact');
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
