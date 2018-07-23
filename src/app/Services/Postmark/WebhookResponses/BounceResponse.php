<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services\Postmark\WebhookResponses;

use Carbon\Carbon;

class BounceResponse
{
    /**
     * @var null|int
     */
    private $id;

    /**
     * @var null|string
     */
    private $name;

    /**
     * @var null|string
     */
    private $tag;

    /**
     * @var string
     */
    private $messageId;

    /**
     * @var int
     */
    private $serverId;

    /**
     * @var string
     */
    private $description;

    /**
     * @var null|string
     */
    private $details;

    /**
     * @var Carbon
     */
    private $bouncedAt;

    /**
     * @var bool
     */
    private $inactive;

    /**
     * @var bool
     */
    private $canActivate;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $jsonString;

    public static function factory(array $payload): BounceResponse
    {
        $instance = new self();

        $instance->id = $payload['ID'];
        $instance->name = $payload['Name'];
        $instance->tag = array_get($payload, 'Tag', null);
        $instance->messageId = $payload['MessageID'];
        $instance->serverId = $payload['ServerID'];
        $instance->description = $payload['Description'];
        $instance->details = $payload['Details'];
        $instance->email = $payload['Email'];
        $instance->bouncedAt = Carbon::parse($payload['BouncedAt']);
        $instance->inactive = $payload['Inactive'];
        $instance->canActivate = $payload['CanActivate'];
        $instance->jsonString = json_encode($payload);

        return $instance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function getServerId(): int
    {
        return $this->serverId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function getBouncedAt(): Carbon
    {
        return $this->bouncedAt;
    }

    public function isInactive(): bool
    {
        return $this->inactive;
    }

    public function canActivate(): bool
    {
        return $this->canActivate;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getJsonString(): ?string
    {
        return $this->jsonString;
    }
}
