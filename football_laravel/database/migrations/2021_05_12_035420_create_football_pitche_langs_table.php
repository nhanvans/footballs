<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFootballPitcheLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('football_pitche_langs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('football_pitche_id');
            $table->string('name');
            $table->string('size');
            $table->string('lang');
            $table->timestamps();
//          foreign key
            $table->foreign('football_pitche_id')->references('id')->on('football_pitches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('football_pitche_langs');
    }
}
