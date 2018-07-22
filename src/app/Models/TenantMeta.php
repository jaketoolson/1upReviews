<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use OneUpReviews\Models\Traits\Uuidable;

/**
 * @property array social_order_default
 * @property int tenant_id
 * @property string|null website_url
 * @property string|null facebook_url
 * @property string|null twitter_url
 * @property string|null google_url
 * @property string|null linkedin_url
 */
class TenantMeta extends BaseEloquentModel
{
    use Uuidable;

    public const SOCIAL_ORDER_DEFAULT = [
        1 => 'yelp',
        2 => 'facebook',
        3 => 'google'
    ];

    protected $table = 'tenant_meta';

    protected $fillable = [
        'social_order_default',
        'tenant_id',
        'website_url',
        'facebook_url',
        'twitter_url',
        'google_url',
        'linkedin_url',
        'instagram_url',
        'youtube_url',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $model->social_order_default = json_encode(self::SOCIAL_ORDER_DEFAULT);
        });
    }

    public function getSocialOrderDefaultAttribute(string $value): array
    {
        return json_decode($value, true);
    }

    public function hasSocialOrder(): bool
    {
        return $this->social_order_default !== null && $this->social_order_default !== '';
    }

    public function getFirstSocialOrder(): ?string
    {
        return $this->hasSocialOrder() ? $this->social_order_default[key($this->social_order_default)]: null;
    }

    public function getSocialUrl(string $social): ?string
    {
        $property = "{$social}_url";

        return $this->$property;
    }
}
