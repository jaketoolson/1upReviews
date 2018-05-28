<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int user_id
 * @property int email_id
 * @property int social_focus_id
 * @property array|null focus_logged
 *
 * @property Email email
 */
class EmailInteraction extends BaseEloquentModel
{
    use SoftDeletes, Uuidable;

    protected $table = 'email_interaction';

    protected $fillable = [
        'uuid',
        'user_id',
        'email_id',
        'social_focus_id',
        'focus_logged',
    ];

    protected $hidden = [
        'id',
        'user_id',
        'email_id',
        'social_focus_id',
    ];

    public static function factory(
        int $userId,
        int $emailId,
        int $socialFocusId,
        array $focusLogged = []
    ): EmailInteraction
    {
        return self::create([
            'user_id' => $userId,
            'email_id' => $emailId,
            'social_focus_id' => $socialFocusId,
            'focus_logged' => $focusLogged
        ]);
    }
}
