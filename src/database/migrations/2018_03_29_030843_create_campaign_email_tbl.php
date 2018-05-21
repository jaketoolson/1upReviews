<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignEmailTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->bigInteger('company_id')->unsigned();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('campaign_emails', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->bigInteger('company_id')->unsigned();
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
        Schema::dropIfExists('campaign_emails');
        Schema::dropIfExists('campaigns');
    }
}
