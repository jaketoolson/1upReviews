<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFocusHistoryOrganizationPivotTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_social_focus_history', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('organization_id')->unsigned();
            $table->integer('social_focus_id')->unsigned();
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('social_focus_id')->references('id')->on('social_focus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('organization_social_focus_history');
    }
}
