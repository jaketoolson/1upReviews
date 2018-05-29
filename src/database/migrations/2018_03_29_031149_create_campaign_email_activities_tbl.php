<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use OneUpReviews\Models\EmailActivityInterface;

class CreateCampaignEmailActivitiesTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_email_activities', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->bigInteger('campaign_email_id')->unsigned();
            $table->text('raw_json');
            $table->enum('type', [EmailActivityInterface::TYPES])->default(null)->nullable();
            $table->dateTime('resent_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE campaign_email_activities AUTO_INCREMENT=1100000');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_email_activities');
    }
}
