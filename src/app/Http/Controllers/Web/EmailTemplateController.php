<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web;

use OneUpReviews\Http\Controllers\Controller;
use OneUpReviews\Http\Requests\EmailTemplateCreationRequest;

class EmailTemplateController extends Controller
{
    public function index()
    {
        return $this->view('emails.templates.index');
    }

    public function create()
    {
        return $this->view('emails.templates.create');
    }

    public function store(EmailTemplateCreationRequest $request)
    {
        dd($request);
    }
}
