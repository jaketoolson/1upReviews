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
use OneUpReviews\Models\User;
use OneUpReviews\Services\CampaignEmailService;

class EmailController extends Controller
{
    /**
     * @var CampaignEmailService
     */
    private $campaignEmailService;

    public function __construct(CampaignEmailService $campaignEmailService)
    {
        $this->campaignEmailService = $campaignEmailService;
    }

    public function index()
    {
        $campaignEmails = CampaignEmail::with(['client', 'emailTemplate', 'tenant'])->get()->sortByDesc('created_at');

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
        $user = User::first();
        $tenant = $user->tenant;
        $client = Client::find($request->get('client_id'));
        $emailTemplate = EmailTemplate::find($request->get('email_template_id'));

        $this->campaignEmailService->create(
            $tenant,
            $client,
            $user,
            $emailTemplate
        );

        $this->redirect('/emails/campaigns');
    }
}
