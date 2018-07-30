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
        $emailTemplates = EmailTemplate::with('campaignEmails')->orderByDesc('created_at')->get();

        return $this->view('emails.templates.index', compact('emailTemplates'));
    }

    public function create()
    {
        return $this->view('emails.templates.create');
    }

    public function store(EmailTemplateCreationRequest $request)
    {
        EmailTemplate::create([
            'tenant_id' => auth()->user()->tenant_id,
            'name' => $request->get('name'),
            'subject' => $request->get('subject'),
            'body_html' => $request->get('body')
        ]);

        return $this->redirect('/emails/templates');
    }
}
