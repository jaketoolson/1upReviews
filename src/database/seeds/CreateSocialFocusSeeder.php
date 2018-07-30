<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

use Illuminate\Database\Seeder;

class CreateSocialFocusSeeder extends Seeder
{
    public function run()
    {
        $focii = [
            'google',
            'twitter',
            'facebook',
            'youtube',
            'yelp',
            'linkedin',
            'yahoo',
        ];

        foreach ($focii as $focus) {
            \OneUpReviews\Models\SocialFocus::create([
                'name' => $focus,
            ]);
        }
    }
}
