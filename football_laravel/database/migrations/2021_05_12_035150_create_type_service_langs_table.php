<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeServiceLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_service_langs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_service_id');
            $table->string('name');
            $table->string('lang');
            $table->timestamps();
//          foreign key
            $table->foreign('type_service_id')->references('id')->on('type_services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_service_langs');
    }
}
