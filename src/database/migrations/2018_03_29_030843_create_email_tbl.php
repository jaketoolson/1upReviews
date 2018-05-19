<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('sent_by')->unsigned();
            $table->string('recipient_email');
            $table->string('subject');
            $table->string('body_html');
            $table->string('body_text');
            $table->string('provider_message_id');
            $table->string('origin_message_id');
            $table->text('provider_response');
            $table->boolean('is_delivered')->default(0);
            $table->boolean('is_bounced')->default(0);
            $table->boolean('is_opened')->default(0);
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
        Schema::dropIfExists('email');
    }
}
