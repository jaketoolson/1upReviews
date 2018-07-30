<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Cashier\Billable;
use OneUpReviews\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int id
 * @property int social_focus_id
 * @property string name
 * @property int email_campaign_id
 * @property string|null stripe_id
 * @property string|null card_brand
 * @property int|null card_last_four
 * @property string|null trial_ends_at
 *
 * @property SocialFocus socialFocus
 * @property OrganizationMeta meta
 * @property Collection|SocialFocus[] focusHistory
 * @property Collection|CampaignEmail[] campaignEmails
 * @property Collection|User[] users
 */
class Organization extends BaseEloquentModel
{
    use Billable, Uuidable;

    protected $table = 'organizations';

    protected $fillable = [
        'uuid',
        'name',
        'social_focus_id',
        'email_campaign_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'trial_ends_at',
    ];

    protected $with = [
        'subscriptions',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::saving(function(Organization $model){
            $originalFocus = $model->getOriginal('social_focus_id');
            $newFocus = $model->social_focus_id;

            if ($originalFocus && $originalFocus !== $newFocus ) {
                $model->focusHistory()->syncWithoutDetaching($originalFocus);
            }
        });
    }

    public function meta(): HasOne
    {
        return $this->hasOne(OrganizationMeta::class, 'organization_id');
    }

    public function socialFocus(): BelongsTo
    {
        return $this->belongsTo(SocialFocus::class, 'social_focus_id');
    }

    public function focusHistory(): BelongsToMany
    {
        return $this->belongsToMany(
            SocialFocus::class,
            'organization_social_focus_history',
            'organization_id',
            'social_focus_id'
        )->withTimestamps();
    }

    public function campaignEmails(): HasMany
    {
        return $this->hasMany(CampaignEmail::class, 'organization_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'organization_id');
    }

    public function getSocialFocusRedirector(): ?SocialMeta
    {
        $socialFocus = $this->socialFocus;
        $tenantMeta = $this->meta;

        if ($socialFocus && $tenantMeta) {
            $socialName = $socialFocus->name;
            $socialUrl = $tenantMeta->getSocialUrl($socialName);

            if ($socialUrl) {
                return new SocialMeta($socialName, $socialUrl);
            }
        }

        return null;
    }
}
