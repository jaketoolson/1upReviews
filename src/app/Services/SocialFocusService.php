<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services;

use OneUpReviews\Models\SocialFocus;

class SocialFocusService
{
    public function getAll(): array
    {
        return SocialFocus::orderBy('name')->get()->all();
    }
}
