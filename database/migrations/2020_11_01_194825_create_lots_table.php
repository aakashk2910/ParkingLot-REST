<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('status')->nullable();
            $table->string('category');
            });

        DB::table('lots')->truncate();

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'car']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'car']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'car']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'car']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'car']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'bus']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'bus']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'bus']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'bus']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'bus']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'motorbike']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'motorbike']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'motorbike']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'motorbike']
        );

        DB::table('lots')->insert(
            ['status' => 0, 'category' => 'motorbike']
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lots');
    }
}
