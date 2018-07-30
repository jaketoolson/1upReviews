<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web\Account;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;
use OneUpReviews\Http\Controllers\Controller;
use OneUpReviews\Http\Requests\OrganizationSettingsUpdateRequest;
use OneUpReviews\Services\AccountService;
use OneUpReviews\Services\SocialFocusService;

class OrganizationSettingsController extends Controller
{
    /**
     * @var AccountService
     */
    private $accountService;

    /**
     * @var SocialFocusService
     */
    private $socialFocusService;

    public function __construct(
        ResponseFactory $responseFactory,
        AccountService $accountService,
        SocialFocusService $socialFocusService
    ) {
        parent::__construct($responseFactory);

        $this->accountService = $accountService;
        $this->socialFocusService = $socialFocusService;
    }

    public function index()
    {
        $organization = Auth::user()->organization;
        $socialFocii = $this->socialFocusService->getAll();

        return $this->view('account.organization.settings', compact('organization', 'socialFocii'));
    }

    public function update(OrganizationSettingsUpdateRequest $request)
    {
        $this->accountService->updateOrganization(
            Auth::user()->getOrganizationId(),
            $request->get('name'),
            $request->get('social_focus_id')
        );

        return $this->redirect('/account/organization/settings');
    }
}
