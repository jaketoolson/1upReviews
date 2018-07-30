<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

Route::group(['prefix' => 'account', 'middleware', 'api'], function(){
    Route::post('login', 'Account\LoginController@login')->name('api.account.login');
    Route::post('logout', 'Account\LoginController@logout')->name('api.account.logout');
    Route::post('refresh', 'Account\LoginController@refresh')->name('api.account.refresh');
    Route::post('me', 'Account\LoginController@me')->name('api.account.me');
});

