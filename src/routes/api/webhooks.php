<?php

Route::group(['prefix' => 'webhooks'], function(){

    Route::post('bounce', 'Webhooks\Postmark\BounceWebhookController@store')
        ->name('api.webhook.postmarkapp.bounce.store');

    Route::post('delivery', 'Webhooks\Postmark\DeliveredWebhookController@store')
        ->name('api.webhook.postmarkapp.delivery.store');

    Route::post('opens', 'Webhooks\Postmark\OpenedWebhookController@store')
        ->name('api.webhook.postmarkapp.opens.store');
});

