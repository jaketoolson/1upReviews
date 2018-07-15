<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OneUpReviews\Models\Traits\BelongsToTenants;
use OneUpReviews\Models\Traits\Uuidable;

/**
 * @property int id
 * @property int campaign_id
 * @property int tenant_id
 * @property string name
 * @property string subject
 * @property string body_html
 * @property string body_text
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

    public function htmlToText(string $html): string
    {
        return $html;
    }
}
