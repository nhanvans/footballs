<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('football_place_id');
            $table->string('types')->nullable();
            $table->string('operation_times')->nullable();
            $table->string('prices')->nullable();
            $table->string('amenities')->nullable();
            $table->string('capacity')->nullable();
            $table->string('last_admission_time')->nullable();
            $table->string('preparation_time')->nullable();
            $table->string('holiday')->nullable();
            $table->timestamps();
//          foreign key
            $table->foreign('football_place_id')->references('id')->on('football_places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details');
    }
}
