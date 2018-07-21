<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OneUpReviews\Models\Traits\BelongsToTenants;
use OneUpReviews\Models\Traits\Uuidable;

/**
 * @property int id
 * @property int tenant_id
 * @property int client_id
 * @property int sent_by
 * @property int email_template_id
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
 * @property EmailTemplate $emailTemplate
 * @property Collection $activities
 */
class CampaignEmail extends BaseEloquentModel
{
    use BelongsToTenants, SoftDeletes, Uuidable;

    protected $table = 'campaign_emails';

    protected $fillable = [
        'uuid',
        'tenant_id',
        'client_id',
        'email_template_id',
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
        'resent_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'resent_at',
    ];

    protected $hidden = [
        'id',
        'tenant_id',
        'client_id',
        'sent_by',
    ];

    public function emailTemplate(): BelongsTo
    {
        return $this->belongsTo(EmailTemplate::class, 'email_template_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(CampaignEmailActivity::class, 'campaign_email_id');
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
        return $this->activities->filter(function (CampaignEmailActivity $activity) {
                return $activity->isDelivered();
            })->count() >= 1;
    }

    public function isOpened(): bool
    {
        return $this->activities->filter(function (CampaignEmailActivity $activity) {
                return $activity->isOpened();
            })->count() >= 1;
    }

    public function isBounced(): bool
    {
        return $this->activities->filter(function (CampaignEmailActivity $activity) {
                return $activity->isBounced();
            })->count() >= 1;
    }
}
