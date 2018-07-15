<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web;

use OneUpReviews\Http\Controllers\Controller;
use OneUpReviews\Http\Requests\EmailTemplateCreationRequest;
use OneUpReviews\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $emailTemplates = EmailTemplate::all();

        return $this->view('emails.templates.index', compact('emailTemplates'));
    }

    public function create()
    {
        return $this->view('emails.templates.create');
    }

    public function store(EmailTemplateCreationRequest $request)
    {
        $emailTemplate = EmailTemplate::create([
            'tenant_id' => 1100000,
            'name' => $request->get('name'),
            'subject' => $request->get('subject'),
            'body_html' => $request->get('body')
        ]);
    }
}
