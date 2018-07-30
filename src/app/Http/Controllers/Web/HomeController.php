<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web;

use OneUpReviews\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('layouts.main');
    }
}
