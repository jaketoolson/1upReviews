<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace Tests\Unit\Services\Postmark;

use Carbon\Carbon;
use OneUpReviews\Services\Postmark\WebhookResponses\DeliveredResponse;

class DeliveredResponseTest extends BaseResponseAbstract
{
    public function setUp()
    {
        parent::setUp();

        $this->jsonResponseString = $this->getJsonFromFile('/tests/Stubs/PostmarkApp/WebhookDeliveryResponse.json');
    }

    public function testDeliveredResponse()
    {
        $json = $this->jsonResponseString;
        $dataArray = json_decode($json, true);

        /** @var DeliveredResponse $response */
        $response = DeliveredResponse::factory($json);

        $this->assertEquals($dataArray['ServerID'], $response->getServerId());
        $this->assertEquals($dataArray['MessageID'], $response->getMessageId());
        $this->assertEquals($dataArray['Recipient'], $response->getRecipient());
        $this->assertEquals($dataArray['Tag'], $response->getTag());
        $this->assertEquals($dataArray['Details'], $response->getDetails());
        $this->assertTrue($response->getDeliveredAt() instanceof Carbon);
        $this->assertEquals($json, $response->getJsonString());
    }
}
