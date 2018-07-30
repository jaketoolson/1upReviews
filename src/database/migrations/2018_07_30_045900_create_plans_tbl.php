<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function(Blueprint $table){
           $table->increments('id');
           $table->string('stripe_plan_id');
           $table->string('stripe_product_id');
           $table->string('name');
           $table->string('product_name');
           $table->decimal('amount', 10, 2);
           $table->string('interval');
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_plans');
    }
}
