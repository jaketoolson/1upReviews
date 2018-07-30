<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTemplatesTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->binary('uuid');
            $table->bigInteger('organization_id', false, true);
            $table->string('name');
            $table->string('subject');
            $table->text('body_html');
            $table->text('body_text');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE email_templates AUTO_INCREMENT=1100000');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_templates');
    }
}
