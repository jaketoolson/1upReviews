<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OneUpReviews\Models\Traits\BelongsToTenants;
use OneUpReviews\Models\Traits\Uuidable;

/**
 * @property int id
 * @property int email_id
 * @property string type
 * @property string raw_json
 */
class CampaignEmailActivity extends BaseEloquentModel implements EmailActivityInterface
{
    use SoftDeletes, Uuidable;

    protected $table = 'campaign_email_activities';

    protected $dates = [
        'created_at',
        'updated_at',
        'activity_date',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'campaign_email_id',
        'raw_json',
        'type',
    ];

    protected $hidden = [
        'id',
        'email_id',
    ];

    public function email(): BelongsTo
    {
        return $this->belongsTo(CampaignEmail::class, 'email_id');
    }

    public function getRawJsonAttribute($value): ?string
    {
        return json_decode($value, true);
    }

    public function getEmailType(): string
    {
        return $this->type;
    }

    public function isBounced(): bool
    {
        return $this->getEmailType() === self::TYPE_BOUNCED;
    }

    public function isDelivered(): bool
    {
        return $this->getEmailType() === self::TYPE_DELIVERED;
    }

    public function isOpened(): bool
    {
        return $this->getEmailType() === self::TYPE_OPENED;
    }
}
