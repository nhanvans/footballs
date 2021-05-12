<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeFootballPitcheLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_football_pitche_langs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_football_pitche_id');
            $table->string('name');
            $table->string('lang');
            $table->timestamps();
//          foreign key
            $table->foreign('type_football_pitche_id')->references('id')->on('type_football_pitches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_football_pitche_langs');
    }
}
