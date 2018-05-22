<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int email_id
 * @property string type
 * @property string activity_date
 * @property string raw_json
 */
class CampaignEmailActivity extends BaseEloquentModel
{
    use SoftDeletes, Uuidable;

    public const TYPE_BOUNCED = 'bounced';
    public const TYPE_OPENED = 'opened';
    public const TYPE_DELIVERED = 'delivered';
    public const TYPES = [
        self::TYPE_BOUNCED,
        self::TYPE_OPENED,
        self::TYPE_DELIVERED
    ];

    protected $table = 'campaign_email_activities';

    protected $dates = [
        'created_at',
        'updated_at',
        'activity_date',
        'deleted_at'
    ];

    protected $fillable = [
        'uuid',
        'email_id',
        'raw_json',
        'type',
        'activity_date',
    ];

    protected $hidden = [
        'id',
        'email_id'
    ];

    public function email(): BelongsTo
    {
        return $this->belongsTo(CampaignEmail::class, 'email_id');
    }

    public function getRawJsonAttribute($value): ?string
    {
        return json_decode($value, true);
    }

    public function isBounced(): bool
    {
        return $this->type === self::TYPE_BOUNCED;
    }

    public function isDelivered(): bool
    {
        return $this->type === self::TYPE_DELIVERED;
    }

    public function isOpened(): bool
    {
        return $this->type === self::TYPE_OPENED;
    }
}
