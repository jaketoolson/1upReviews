<?php

namespace OneUpReviews\Models;

interface EmailActivityInterface
{
    public const TYPE_BOUNCED = 'bounced';
    public const TYPE_OPENED = 'opened';
    public const TYPE_DELIVERED = 'delivered';
    public const TYPES = [
        self::TYPE_BOUNCED,
        self::TYPE_OPENED,
        self::TYPE_DELIVERED
    ];

    public function getEmailType(): string;
}
