<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int user_id
 * @property int client_id
 * @property int sent_by
 * @property string recipient_email
 * @property string subject
 * @property string body_html
 * @property string body_text
 * @property string provider_message_id
 * @property string origin_message_id
 * @property bool is_delivered
 * @property bool is_bounced
 * @property bool is_opened
 * @property null|string resent_at
 *
 * @property Client $client
 * @property Collection $activities
 */
class Email extends BaseEloquentModel
{
    use SoftDeletes, Uuidable;

    protected $table = 'emails';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'resent_at',
    ];

    protected $fillable = [
        'uuid',
        'user_id',
        'client_id',
        'sent_by',
        'recipient_email',
        'subject',
        'body_html',
        'body_text',
        'provider_message_id',
        'origin_message_id',
        'provider_response',
        'is_delivered',
        'is_bounced',
        'is_opened',
        'resent_at'
    ];

    protected $hidden = [
        'id',
        'user_id',
        'client_id',
        'sent_by'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(EmailInteraction::class, 'email_id');
    }

    public function hasActivities(): bool
    {
        return $this->activities->count() > 0;
    }

    public function hasNoActivities(): bool
    {
        return $this->activities->count() === 0;
    }

    public function isDelivered(): bool
    {
        return $this->activities->filter(function (EmailActivity $activity) {
            return $activity->isDelivered();
        })->count() >= 1;
    }

    public function isOpened(): bool
    {
        return $this->activities->filter(function (EmailActivity $activity) {
            return $activity->isOpened();
        })->count() >= 1;
    }

    public function isBounced(): bool
    {
        return $this->activities->filter(function (EmailActivity $activity) {
            return $activity->isBounced();
        })->count() >= 1;
    }

    public function getOriginMessageId(): string
    {
        return $this->attributes['origin_message_id'];
    }
}
