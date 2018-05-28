<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace Tests\Feature\Api\Webhook;

use OneUpReviews\Models\Email;
use Tests\Feature\BaseFeatureTest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class WebhookResponseTest extends BaseFeatureTest
{
    use WithoutMiddleware;

    protected function setUp()
    {
        parent::setUp();
//        $this->withoutMiddleware();
    }

    public function testReturnsErrorWhenDataIsMissing(): void
    {
        $this->expectException(AuthorizationException::class);

        $response = $this->json('POST', route('api.webhook.postmarkapp.bounce.store'), []);

        $response->assertStatus(422);
    }

    public function testBounced(): void
    {
        $email = factory(Email::class)->create();
        $payload = json_decode($this->getJsonFromFile('/tests/Stubs/PostmarkApp/WebhookBounceResponse.json'), true);
        $payload['MessageID'] = $email->provider_message_id;
        $response = $this->json('POST', route('api.webhook.postmarkapp.bounce.store'), $payload);

        $response->assertStatus(200);
    }

    public function testDelivered(): void
    {
        $email = factory(Email::class)->create();
        $payload = json_decode($this->getJsonFromFile('/tests/Stubs/PostmarkApp/WebhookDeliveryResponse.json'), true);
        $payload['MessageID'] = $email->provider_message_id;
        $response = $this->json('POST', route('api.webhook.postmarkapp.delivery.store'), $payload);

        $response->assertStatus(200);
    }

    public function testOpened(): void
    {
        $email = factory(Email::class)->create();
        $payload = json_decode($this->getJsonFromFile('/tests/Stubs/PostmarkApp/WebhookOpenedResponse.json'), true);
        $payload['MessageID'] = $email->provider_message_id;
        $response = $this->json('POST', route('api.webhook.postmarkapp.opens.store'), $payload);

        $response->assertStatus(200);
    }
}
