<?php
/**
 * Copyright (c) 2017. Jake Toolson <jaketoolson@gmail.com>
 */

namespace Orion\OneUpReviews\Libraries\Quicken;

use QuickBooksOnline\API\Core\ServiceContext;

class QuickbooksServiceFactory
{
    /**
     * @var QuickbooksService
     */
    protected static $instance;

    /**
     * TODO: Consider IoC binding for singleton.
     *
     * @param string $accessTokenKey
     * @param string $refreshTokenKey
     * @param string $realmId
     *
     * @return QuickbooksService
     */
    public static function make(string $accessTokenKey, string $refreshTokenKey, string $realmId): QuickbooksService
    {
        if (! self::$instance) {

            $data = [
                'auth_mode' => 'oauth2',
                'ClientID' => config('services.quicken.client_id'),
                'ClientSecret' => config('services.quicken.secret'),
                'accessTokenKey' => $accessTokenKey,
                'refreshTokenKey' => $refreshTokenKey,
                'QBORealmID' => $realmId, // Formerly called "company id"
                'baseUrl' => config('services.quicken.base_url')
            ];

            self::$instance = new QuickbooksService(ServiceContext::ConfigureFromPassedArray($data));
        }

        return self::$instance;
    }

    /**
     * @return null|QuickbooksService
     */
    public static function getInstance(): ?QuickbooksService
    {
        return self::$instance;
    }
}
