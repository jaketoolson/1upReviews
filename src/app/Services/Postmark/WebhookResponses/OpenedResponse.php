<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services\Postmark\WebhookResponses;

use Carbon\Carbon;

class OpenedResponse
{
    /**
     * @var bool
     */
    private $firstOpen;

    /**
     * @var array
     */
    private $client;

    /**
     * @var array
     */
    private $os;

    /**
     * @var string
     */
    private $platform;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * @var null|int
     */
    private $readSeconds;

    /**
     * @var array
     */
    private $geo;

    /**
     * @var string
     */
    private $messageId;

    /**
     * @var Carbon
     */
    private $receivedAt;

    /**
     * @var string
     */
    private $recipient;

    /**
     * @var string
     */
    private $jsonString;

    public static function factory(array $payload): OpenedResponse
    {
        $instance = new self();

        $instance->firstOpen = $payload['FirstOpen'];
        $instance->client = $payload['Client'];
        $instance->os = $payload['OS'];
        $instance->platform = $payload['Platform'];
        $instance->userAgent = $payload['UserAgent'];
        $instance->readSeconds = $payload['ReadSeconds'];
        $instance->geo = $payload['Geo'];
        $instance->messageId = $payload['MessageID'];
        $instance->receivedAt = Carbon::parse($payload['ReceivedAt']);
        $instance->recipient = $payload['Recipient'];
        $instance->jsonString = json_encode($payload);

        return $instance;
    }

    public function isFirstOpen(): bool
    {
        return $this->firstOpen;
    }

    public function getClient(): array
    {
        return $this->client;
    }

    public function getOs(): array
    {
        return $this->os;
    }

    public function getPlatform(): string
    {
        return $this->platform;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function getReadSeconds(): ?int
    {
        return $this->readSeconds;
    }

    public function getGeo(): array
    {
        return $this->geo;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function getReceivedAt(): Carbon
    {
        return $this->receivedAt;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getJsonString(): string
    {
        return $this->jsonString;
    }
}
