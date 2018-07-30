<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantMetaTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_meta', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->binary('uuid');
            $table->bigInteger('organization_id', false, true);
            $table->text('social_order_default')->nullable()->default(null);
            $table->string('website_url')->nullable()->default(null);
            $table->string('facebook_url')->nullable()->default(null);
            $table->string('twitter_url')->nullable()->default(null);
            $table->string('google_url')->nullable()->default(null);
            $table->string('linkedin_url')->nullable()->default(null);
            $table->string('instagram_url')->nullable()->default(null);
            $table->string('youtube_url')->nullable()->default(null);
            $table->string('yelp_url')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });
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
