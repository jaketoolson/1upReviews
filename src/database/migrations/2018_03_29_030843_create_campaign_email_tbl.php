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
            $table->bigInteger('tenant_id')->unsigned();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('campaign_emails', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->bigInteger('tenant_id', false, true);
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('email_template_id')->unsigned();
            $table->bigInteger('sent_by')->unsigned();
            $table->string('recipient_email');
            $table->string('subject');
            $table->string('body_html');
            $table->string('body_text');
            $table->string('provider_message_id')->nullable()->default(null);
            $table->string('origin_message_id')->nullable()->default(null);
            $table->text('provider_response')->nullable()->default(null);
            $table->dateTime('delivered_at')->nullable()->default(null);
            $table->dateTime('bounced_at')->nullable()->default(null);
            $table->dateTime('opened_at')->nullable()->default(null);
            $table->dateTime('resent_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE campaign_emails AUTO_INCREMENT=1100000');
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
