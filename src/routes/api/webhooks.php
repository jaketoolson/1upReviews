<?php

Route::group(['prefix' => 'webhooks'], function(){
    Route::post('postmark', 'Webhooks\Postmark\WebhookController@store')
        ->middleware('postmark')
        ->name('api.webhooks.postmark.store');
});

