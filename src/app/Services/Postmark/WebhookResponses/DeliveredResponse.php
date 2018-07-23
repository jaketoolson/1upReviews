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

    public static function factory(array $payload): DeliveredResponse
    {
        $instance = new self();

        $instance->serverId = $payload['ServerID'];
        $instance->messageId = $payload['MessageID'];
        $instance->recipient = $payload['Recipient'];
        $instance->tag = $payload['Tag'];
        $instance->details = $payload['Details'];
        $instance->deliveredAt = Carbon::parse($payload['DeliveredAt']);
        $instance->jsonString = json_encode($payload);

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
