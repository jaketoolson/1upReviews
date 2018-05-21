<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('company_user', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('company_user');
    }
}
