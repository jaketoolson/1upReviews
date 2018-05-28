<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace Tests\Unit\Services\Postmark;

use Carbon\Carbon;
use OneUpReviews\Services\Postmark\WebhookResponses\OpenedResponse;

class OpenedResponseTest extends BaseResponseAbstract
{
    public function setUp()
    {
        parent::setUp();

        $this->jsonResponseString = $this->getJsonFromFile('/tests/Stubs/PostmarkApp/WebhookOpenedResponse.json');
    }

    public function testDeliveredResponse()
    {
        $json = $this->jsonResponseString;
        $dataArray = json_decode($json, true);

        /** @var OpenedResponse $response */
        $response = OpenedResponse::factory($json);

        $this->assertEquals($dataArray['Client'], $response->getClient());
        $this->assertEquals($dataArray['MessageID'], $response->getMessageId());
        $this->assertEquals($dataArray['OS'], $response->getOs());
        $this->assertEquals($dataArray['Platform'], $response->getPlatform());
        $this->assertEquals($dataArray['UserAgent'], $response->getUserAgent());
        $this->assertEquals($dataArray['ReadSeconds'], $response->getReadSeconds());
        $this->assertEquals($dataArray['Geo'], $response->getGeo());
        $this->assertEquals($dataArray['Recipient'], $response->getRecipient());
        $this->assertTrue($response->getReceivedAt() instanceof Carbon);
        $this->assertEquals($json, $response->getJsonString());
    }
}
