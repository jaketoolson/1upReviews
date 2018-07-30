<?php

Route::get('/account/login', 'Account\LoginController@index');
Route::post('/account/login', 'Account\LoginController@login');

Route::get('/account/register', 'Account\RegisterController@index');
Route::post('/account/register', 'Account\RegisterController@store');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', 'HomeController@index');
    Route::get('/account/dashboard', 'Account\DashboardController@index');
    Route::get('/account/profile', 'Account\ProfileController@index');
    Route::post('/account/logout', 'Account\LoginController@logout');

    Route::get('/emails/templates', 'EmailTemplateController@index');
    Route::get('/emails/templates/create', 'EmailTemplateController@create');
    Route::post('/emails/templates', 'EmailTemplateController@store');
    Route::patch('/emails/templates/{id}', 'EmailTemplateController@update');
    Route::delete('/emails/templates', 'EmailTemplateController@destroy');

    Route::get('/emails/campaigns', 'EmailController@index');
    Route::get('/emails/campaigns/create', 'EmailController@create');
    Route::post('/emails/campaigns', 'EmailController@store');

    Route::get('/clients', 'ClientController@index');
    Route::get('/clients/create', 'ClientController@create');
    Route::post('/clients', 'ClientController@store');
});


// TODO: Uncomment when front-end is serving pages.
//Route::get('{any}', function () {
//    return view('layouts.main');
//})->where('any', '.*');