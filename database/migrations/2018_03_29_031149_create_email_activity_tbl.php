<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use OneUpReviews\Models\EmailActivity;

class CreateEmailActivityTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_activity', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->bigInteger('email_id')->unsigned();
            $table->text('raw_json');
            $table->enum('type', [EmailActivity::TYPES])->default(null)->nullable();
            $table->dateTime('resent_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_activity');
    }
}
