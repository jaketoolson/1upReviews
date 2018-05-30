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

    public static function factory(string $jsonString): OpenedResponse
    {
        $instance = new self();
        $instance->jsonString = $jsonString;
        $responseArray = json_decode($jsonString, true);

        $instance->firstOpen = $responseArray['FirstOpen'];
        $instance->client = $responseArray['Client'];
        $instance->os = $responseArray['OS'];
        $instance->platform = $responseArray['Platform'];
        $instance->userAgent = $responseArray['UserAgent'];
        $instance->readSeconds = $responseArray['ReadSeconds'];
        $instance->geo = $responseArray['Geo'];
        $instance->messageId = $responseArray['MessageID'];
        $instance->receivedAt = Carbon::parse($responseArray['ReceivedAt']);
        $instance->recipient = $responseArray['Recipient'];

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
