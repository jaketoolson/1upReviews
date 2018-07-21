<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use OneUpReviews\Models\Traits\BelongsToTenants;
use OneUpReviews\Models\Traits\Uuidable;
use Html2Text\Html2Text;

/**
 * @property int id
 * @property int campaign_id
 * @property int tenant_id
 * @property string name
 * @property string subject
 * @property string body_html
 * @property string body_text
 *
 * @property Collection $campaignEmails
 */
class EmailTemplate extends BaseEloquentModel
{
    use BelongsToTenants, SoftDeletes, Uuidable;

    protected $table = 'email_templates';

    protected $fillable = [
        'uuid',
        'tenant_id',
        'name',
        'subject',
        'body_html',
        'body_text',
    ];

    protected $hidden = [
        'id',
        'tenant_id',
    ];

    public static function boot(): void
    {
        parent::boot();

        self::saving(function(EmailTemplate $model){
            $model->body_text = $model->htmlToText($model->body_html);
        });
    }

    public function campaignEmails(): HasMany
    {
        return $this->hasMany(CampaignEmail::class, 'email_template_id');
    }

    public function htmlToText(string $html): string
    {
        return Html2Text::convert($html);
    }
}
