<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services;

use Laravel\Cashier\Subscription;
use OneUpReviews\Exceptions\AlreadySubscribedException;
use OneUpReviews\Exceptions\CardNotOnFileException;
use OneUpReviews\Models\CreditCardParams;
use OneUpReviews\Models\Organization;
use Stripe\Token;
use OneUpReviews\Models\Subscribables;

class SubscriptionService
{
    /**
     * @param Organization $organization
     * @return Subscription
     * @throws AlreadySubscribedException
     * @throws CardNotOnFileException
     */
    public function addSubscription(Organization $organization): Subscription
    {
        if ($organization->subscribedToPlan(Subscribables::MONTHLY_PRICING_PLAN)) {
            throw new AlreadySubscribedException("Organization {$organization->id} already subscribed.");
        }

        if (! $organization->hasCardOnFile()) {
            throw new CardNotOnFileException("Organization {$organization->id} has no card on file.");
        }

        return $organization->newSubscription('main', Subscribables::MONTHLY_PRICING_PLAN)->create();
    }

    public function addCard(Organization $organization, CreditCardParams $creditCardParams): Organization
    {
        $month = $creditCardParams->getExpirationMonth();
        $year = $creditCardParams->getExpirationYear();
        $number = $creditCardParams->getNumber();
        $cvc = $creditCardParams->getCVC();

        // If organization already has a stripe account associated to them,
        // simple add this card to their account.
        if ($organization->hasStripeId()) {
            $organization->asStripeCustomer()->sources->create([
                'source' => [
                    'object' => 'card',
                    'exp_month' => $month,
                    'exp_year' => $year,
                    'number' => $number,
                    'currency' => 'usd',
                    'cvc' => $cvc
                ]
            ]);
        } else {
            $token = Token::create([
                'card[exp_month]' => $month,
                'card[exp_year]' => $year,
                'card[number]' => $number,
                'card[currency]' => 'usd',
                'card[cvc]' => $cvc
            ], ['api_key' => config('services.stripe.secret')]);

            $organization->createAsStripeCustomer($token->id);
        }

        return $organization->fresh();
    }

    public function cancelSubscription(Organization $organization)
    {
        // $organization->subscription('')->cancelNow();
    }
}
