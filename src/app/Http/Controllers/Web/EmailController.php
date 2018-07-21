<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web;

use Illuminate\Http\Request;
use OneUpReviews\Http\Controllers\Controller;
use OneUpReviews\Models\CampaignEmail;
use OneUpReviews\Models\Client;
use OneUpReviews\Models\EmailTemplate;

class EmailController extends Controller
{
    public function index()
    {
        $campaignEmails = CampaignEmail::all()->sortByDesc('created_at');

        return $this->view('emails.campaigns.index', compact('campaignEmails'));
    }

    public function create()
    {
        $clients = Client::all();
        $emailTemplates = EmailTemplate::all();

        return $this->view('emails.campaigns.create', compact('clients', 'emailTemplates'));
    }

    public function store(Request $request)
    {
        $emailTemplate = EmailTemplate::find($request->get('email_template_id'));

        CampaignEmail::create([
           'tenant_id' => '',
           'client_id' => $request->get('client_id'),
           'email_template_id' => $request->get('email_template_id'),
        ]);
    }
}
