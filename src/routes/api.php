<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

Route::group(['prefix' => 'api'], function() {
    require 'api/webhooks.php';
    require 'api/auth.php';
});
