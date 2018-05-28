<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace Tests\Unit\Services\Postmark;

use Carbon\Carbon;
use OneUpReviews\Services\Postmark\WebhookResponses\BounceResponse;

class BounceResponseTest extends BaseResponseAbstract
{
    public function setUp()
    {
        parent::setUp();

        $this->jsonResponseString = $this->getJsonFromFile('/tests/Stubs/PostmarkApp/WebhookBounceResponse.json');
    }

    public function testBounceResponse()
    {
        $json = $this->jsonResponseString;
        $dataArray = json_decode($json, true);

        /** @var BounceResponse $response */
        $response = BounceResponse::factory($json);

        $this->assertEquals($dataArray['ID'], $response->getId());
        $this->assertEquals($dataArray['Name'], $response->getName());
        $this->assertEquals($dataArray['Tag'], $response->getTag());
        $this->assertEquals($dataArray['MessageID'], $response->getMessageId());
        $this->assertEquals($dataArray['ServerID'], $response->getServerId());
        $this->assertEquals($dataArray['Description'], $response->getDescription());
        $this->assertEquals($dataArray['Details'], $response->getDetails());
        $this->assertEquals($dataArray['Inactive'], $response->isInactive());
        $this->assertEquals($dataArray['CanActivate'], $response->canActivate());
        $this->assertEquals($dataArray['Email'], $response->getEmail());
        $this->assertTrue($response->getBouncedAt() instanceof Carbon);
        $this->assertEquals($json, $response->getJsonString());
    }
}
