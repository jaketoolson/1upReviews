<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Helpers;

class CreditCardHelper
{
    public static function getAllowedTypes(): array
    {
        return [
            'visa' => 'icon-visa-lg.png',
            'mastercard' => 'icon-mc-lg.png',
            'american_express' => 'icon-amex-lg.png',
            'discover' => 'icon-discover-lg.png',
            'diners_club' => 'icon-dinersclub-lg.png',
            'jcb' => 'icon-jcb-lg.png',
        ];
    }

    public static function getImagePathByName(string $name): string
    {
        $path = '/assets/images/cards/';
        $images = static::getAllowedTypes();
        $name = strtolower(trim(str_replace(' ', '_', $name)));
        if (array_key_exists($name, $images)) {
            return $path . $images[$name];
        }
        return $path . $images['default'];
    }
}
