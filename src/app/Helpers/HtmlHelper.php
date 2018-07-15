<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Helpers;

class HtmlHelper
{
    /**
     * Accepts an array of key/value pairs, and implodes them as data attributes that can be used in html
     * Example: ['class' => 'some-class', 'id' => 'some-id']
     * Output: class="some-class" id="some-id"
     *
     * @param array $attributes
     * @return string
     */
    public static function mapsToAttributes(array $attributes = []): string
    {
        return implode(' ',
            array_map(
                function ($k, $v) {
                    return $k .'="'. htmlspecialchars($v) .'"';
                },
                array_keys($attributes),
                $attributes
            )
        );
    }
}
