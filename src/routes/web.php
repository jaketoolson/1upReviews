<?php

Route::get('/', function () {
    return view('layouts.main');
});

Route::get('{any}', function () {
    return view('layouts.main');
})->where('any', '.*');