<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web\Account;

use OneUpReviews\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        return $this->view('account.profile');
    }
}
