<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web\Account\Organization;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use OneUpReviews\Http\Controllers\Controller;
use OneUpReviews\Http\Requests\OrganizationCardRequest;
use OneUpReviews\Http\Requests\OrganizationSettingsUpdateRequest;
use OneUpReviews\Models\CreditCardParams;
use OneUpReviews\Services\AccountService;
use OneUpReviews\Services\SocialFocusService;
use OneUpReviews\Services\SubscriptionService;

class CardController extends Controller
{
    /**
     * @var SubscriptionService
     */
    private $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index()
    {
        $organization = Auth::user()->organization;

        return $this->view('account.organization.card', compact('organization'));
    }

    public function store(OrganizationCardRequest $request)
    {
        $date = Carbon::create($request->get('expiration_year'), $request->get('expiration_month'), 1);

        $cardParams = new CreditCardParams(
            $request->get('number'),
            $date,
            $request->get('cvc')
        );

        $this->subscriptionService->addCard(
            Auth::user()->organization,
            $cardParams
        );

        return $this->redirect('/account/organization/card');
    }
}
