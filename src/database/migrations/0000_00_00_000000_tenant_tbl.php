<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->binary('uuid');
            $table->string('name');
            $table->bigInteger('social_focus_id', false, true)->nullable()->default(null);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE organizations AUTO_INCREMENT=1100000');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
