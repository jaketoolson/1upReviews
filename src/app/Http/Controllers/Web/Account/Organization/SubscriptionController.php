<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Web\Account\Organization;

use Exception;
use Illuminate\Support\Facades\Auth;
use OneUpReviews\Exceptions\CardNotOnFileException;
use OneUpReviews\Http\Controllers\Controller;
use OneUpReviews\Services\SubscriptionService;

class SubscriptionController extends Controller
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

        return $this->view('account.organization.subscription', compact('organization'));
    }

    public function store()
    {
        $organization = Auth::user()->organization;

        try {
            $this->subscriptionService->addSubscription($organization);
        } catch (CardNotOnFileException $e) {
            return $this->redirect('/account/organization/card');
        } catch (Exception $e) {
            return $e;
        }

        return $this->redirect('/account/organization/subscription');
    }

    public function destroy()
    {
        $organization = Auth::user()->organization;

        $this->subscriptionService->cancelSubscription($organization);

        return $this->redirect('/account/organization/settings');
    }
}
