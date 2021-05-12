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
            $table->string('types');
            $table->string('operation_times');
            $table->string('prices');
            $table->string('amenities');
            $table->string('capacity');
            $table->string('last_admission_time');
            $table->string('preparation_time');
            $table->string('holiday');
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
