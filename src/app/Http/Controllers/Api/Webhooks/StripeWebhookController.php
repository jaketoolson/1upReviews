<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Api\Webhooks;

use Exception;
use Illuminate\Http\Request;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Subscription;
use OneUpReviews\Http\Controllers\Controller;
use Stripe\Error\SignatureVerification;
use Stripe\Event as StripeEvent;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request): ?Response
    {
        $payload = $request->getContent();

        // Checks and Validates Webhook Signature
        // @see: https://stripe.com/docs/webhooks/signatures
        try {
            Webhook::constructEvent(
                $payload,
                $_SERVER['HTTP_STRIPE_SIGNATURE'],
                config('services.stripe.webhook.secret')
            );
        } catch (UnexpectedValueException | SignatureVerification $e) {
            return $this->emptyResponse(400);
        }

        $payload = json_decode($payload, true);

        if (! $this->isInTestingEnvironment() && ! $this->eventExistsOnStripe($payload['id'])) {
            return $this->emptyResponse();
        }

        $method = 'handle'.studly_case(str_replace('.', '_', $payload['type']));

        if (method_exists($this, $method)) {
            return $this->{$method}($payload);
        }

        return $this->emptyResponse();
    }

    protected function handleCustomerSubscriptionDeleted(array $payload): Response
    {
        $organization = $this->getOrganizationByStripeId($payload['data']['object']['customer']);

        if ($organization) {
            $organization->subscriptions->filter(function (Subscription $subscription) use ($payload) {
                return $subscription->stripe_id === $payload['data']['object']['id'];
            })->each(function (Subscription $subscription) {
                $subscription->markAsCancelled();
            });
        }

        return new Response('Webhook Handled', 200);
    }

    protected function getOrganizationByStripeId(string $stripeId): ?Billable
    {
        $model = config('services.stripe.model');

        return (new $model)->where('stripe_id', $stripeId)->first();
    }

    protected function eventExistsOnStripe(string $id): bool
    {
        try {
            return ! is_null(StripeEvent::retrieve($id, config('services.stripe.secret')));
        } catch (Exception $e) {
            return false;
        }
    }

    protected function isInTestingEnvironment(): bool
    {
        return getenv('CASHIER_ENV') === 'testing';
    }

    public function emptyResponse(int $status = 200): Response
    {
        return new Response('', $status);
    }
}
