<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use OneUpReviews\Models\Traits\Uuidable;

/**
 * @property string name
 * @property int order
 * @property string case_sensitive_name
 */
class SocialFocus extends BaseEloquentModel
{
   use Uuidable;

   protected $table = 'social_focus';

   protected $fillable = [
       'uuid',
       'name',
       'order',
       'friendly_name',
   ];

   protected $hidden = [
       'id',
   ];
}
