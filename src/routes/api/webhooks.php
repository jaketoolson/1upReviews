<?php

Route::group(['prefix' => 'webhooks'], function(){
    Route::post('postmark', 'Webhooks\PostmarkWebhookController@store')
        ->middleware('postmark')
        ->name('api.webhooks.postmark.store');
});

