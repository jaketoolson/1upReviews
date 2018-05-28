<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'webhooks'], function(){

    Route::post('bounce', 'Api\Webhooks\Postmark\BounceWebhookController@store')
        ->name('api.webhook.postmarkapp.bounce.store');

    Route::post('delivery', 'Api\Webhooks\Postmark\DeliveredWebhookController@store')
        ->name('api.webhook.postmarkapp.delivery.store');

    Route::post('opens', 'Api\Webhooks\Postmark\OpenedWebhookController@store')
        ->name('api.webhook.postmarkapp.opens.store');
});

