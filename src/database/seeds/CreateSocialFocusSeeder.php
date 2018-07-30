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
            'google' => 'Google',
            'twitter' => 'Twitter',
            'facebook' => 'Facebook',
            'youtube' => 'YouTube',
            'yelp' => 'Yelp',
            'linkedin' => 'LinkedIn',
            'yahoo' => 'Yahoo',
        ];

        foreach ($focii as $focusName => $friendlyName) {
            \OneUpReviews\Models\SocialFocus::create([
                'name' => $focusName,
                'friendly_name' => $friendlyName
            ]);
        }
    }
}
