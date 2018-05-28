<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services\Postmark\WebhookResponses;

use Carbon\Carbon;

class DeliveredResponse
{
    /**
     * @var null|int
     */
    private $serverId;

    /**
     * @var null|string
     */
    private $recipient;

    /**
     * @var null|string
     */
    private $tag;

    /**
     * @var string
     */
    private $messageId;

    /**
     * @var Carbon
     */
    private $deliveredAt;

    /**
     * @var string
     */
    private $details;

    /**
     * @var string
     */
    private $jsonString;

    /**
     * @param string $jsonString
     * @return DeliveredResponse
     */
    public static function factory(string $jsonString): DeliveredResponse
    {
        $instance = new self();
        $instance->jsonString = $jsonString;
        $responseArray = json_decode($jsonString, true);

        $instance->serverId = $responseArray['ServerID'];
        $instance->messageId = $responseArray['MessageID'];
        $instance->recipient = $responseArray['Recipient'];
        $instance->tag = $responseArray['Tag'];
        $instance->details = $responseArray['Details'];
        $instance->deliveredAt = Carbon::parse($responseArray['DeliveredAt']);

        return $instance;
    }

    public function getServerId(): ?int
    {
        return $this->serverId;
    }

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function getDeliveredAt(): Carbon
    {
        return $this->deliveredAt;
    }

    public function getDetails(): string
    {
        return $this->details;
    }

    public function getJsonString(): string
    {
        return $this->jsonString;
    }
}
