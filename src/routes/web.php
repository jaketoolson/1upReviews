<?php

Route::get('/', function () {
    return view('layouts.main');
});

Route::get('/auth/login', 'Auth\LoginController@index');
Route::post('/auth/login', 'Auth\LoginController@login');
Route::post('/auth/logout', 'Auth\LoginController@logout');

Route::get('/emails/templates', 'EmailTemplateController@index');
Route::get('/emails/templates/create', 'EmailTemplateController@create');
Route::post('/emails/templates', 'EmailTemplateController@store');
Route::patch('/emails/templates/{id}', 'EmailTemplateController@update');
Route::delete('/emails/templates', 'EmailTemplateController@destroy');

Route::get('/emails/campaigns', 'EmailController@index');
Route::get('/emails/campaigns/create', 'EmailController@create');

Route::get('/clients', 'ClientController@index');
Route::get('/clients/create', 'ClientController@create');
Route::post('/clients', 'ClientController@store');


// TODO: Uncomment when front-end is serving pages.
//Route::get('{any}', function () {
//    return view('layouts.main');
//})->where('any', '.*');