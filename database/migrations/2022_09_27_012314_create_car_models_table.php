<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('automaker_id');
            $table->string('name', 30);
            $table->string('image', 150);
            $table->integer('number_ports');
            $table->integer('places');
            $table->boolean('air_bag');
            $table->boolean('abs');
            $table->timestamps();

            $table->foreign('automaker_id')->references('id')->on('automakers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_models');
    }
}
