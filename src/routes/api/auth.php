<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

Route::group(['prefix' => 'auth', 'middleware', 'api'], function(){
    Route::post('login', 'Auth\LoginController@login')->name('api.auth.login');
    Route::post('logout', 'Auth\LoginController@logout')->name('api.auth.logout');
    Route::post('refresh', 'Auth\LoginController@refresh')->name('api.auth.refresh');
    Route::post('me', 'Auth\LoginController@me')->name('api.auth.me');
});

