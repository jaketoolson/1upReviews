<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailInteractionTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_interaction', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->bigInteger('organization_id')->unsigned();
            $table->bigInteger('email_id')->unsigned();
            $table->bigInteger('social_focus_id')->unsigned();
            $table->text('focus_logged')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organization_id')
                ->references('id')
                ->on('organizations')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_interaction');
    }
}
