<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OneUpReviews\Models\Traits\Uuidable;

/**
 * @property int $id
 * @property int organization_id
 * @property int campaign_email_io
 * @property string focus_logged
 */
class CampaignEmailResponse extends BaseEloquentModel
{
    use SoftDeletes, Uuidable;

    protected $table = 'campaign_email_responses';

    protected $fillable = [
        'uuid',
        'organization_id',
        'campaign_email_id',
        'social_focus_id',
        'focus_logged'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
        'organization_id',
        'email_id',
        'social_focus_id'
    ];

    /**
     * @param int    $organizationId
     * @param int    $emailId
     * @param int    $socialFocusId
     * @param array  $focusLogged
     *
     * @return CampaignEmailResponse
     */
    public static function factory(
        int $organizationId,
        int $emailId,
        int $socialFocusId,
        array $focusLogged = []
    ): CampaignEmailResponse
    {
        return self::create([
            'organization_id' => $organizationId,
            'email_id' => $emailId,
            'social_focus_id' => $socialFocusId,
            'focus_logged' => $focusLogged
        ]);
    }
}
