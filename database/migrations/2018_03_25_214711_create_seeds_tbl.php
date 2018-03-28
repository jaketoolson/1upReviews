<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeedsTbl extends Migration
{
    public function up()
    {
        Schema::create('seeds', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('seed_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seeds');
    }
}
