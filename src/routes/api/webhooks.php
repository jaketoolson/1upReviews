<?php

Route::group(['prefix' => 'webhooks'], function(){
    Route::post('postmark', 'Webhooks\PostmarkWebhookController@handleWebhook')
        ->middleware('postmark')
        ->name('api.webhooks.postmark.store');

    Route::post('stripe', 'Webhooks\StripeWebhookController@handleWebhook')
        ->name('api.webhooks.stripe.store');
});

