<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parkings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('vehicleId')->unsigned();
            $table->foreign('vehicleId')->references('id')->on('vehicles')->onDelete('cascade');;
            $table->integer('lotId')->unsigned();
            $table->foreign('lotId')->references('id')->on('lots')->onDelete('cascade');;
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('parkings');
    }
}
