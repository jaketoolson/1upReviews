<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Libraries\Keen;

use GuzzleHttp\Client;
use KeenIO\Client\KeenIOClient;
use GuzzleHttp\Command\Guzzle\Description;

/**
 * @method array createAccessKey(array $args = array()) {@command KeenIO createAccessKey}
 * @method array getAllAccessKeys(array $args = array()) {@command KeenIO getAllAccessKeys}
 * @method array getAccessKey(array $args = array()) {@command KeenIO getAccessKey}
 * @method array updateAccessKey(array $args = array()) {@command KeenIO updateAccessKey}
 * @method array revokeAccessKey(array $args = array()) {@command KeenIO revokeAccessKey}
 * @method array unrevokeAccessKey(array $args = array()) {@command KeenIO unrevokeAccessKey}
 */
class KeenClient extends KeenIOClient
{
    /**
     * Factory to create new KeenIOClient instance.
     *
     * @param array $config
     *
     * @returns \KeenIO\Client\KeenIOClient
     */
    public static function factory($config = [])
    {
        $default = [
            'masterKey' => null,
            'writeKey'  => null,
            'readKey'   => null,
            'projectId' => null,
            'organizationKey' => null,
            'organizationId' => null,
            'version' => '3.0',
            'headers' => [
                'Keen-Sdk' => 'php-' . self::VERSION
            ]
        ];

        // Create client configuration
        $config = self::parseConfig($config, $default);

        $file = 'keen-io-3_0_1.php';

        // Create the new Keen IO Client with our Configuration
        return new self(
            new Client($config),
            new Description(include __DIR__ . "/Resources/{$file}"),
            null,
            function($arg)
            {
                return json_decode($arg->getBody(), true);
            },
            null,
            $config
        );
    }

    /**
     * @param int $tenantId
     * @param string $tenantName
     * @return array
     */
    public function createTenantKey(int $tenantId, string $tenantName): array
    {
        $keyName = $this->makeKeyNameString($tenantId, $tenantName);

        if ($exists = $this->getExistingKeyByCustomer($keyName)) {
            return $exists;
        }

        $schema = [
            'name' => $keyName,
            'is_active' => true,
            'permitted' => [
                    "queries",
                    "saved_queries",
                    "cached_queries",
                    "datasets",
                    "schema"
            ],
            'options' => [
                "datasets" => [
                    'operations' => [
                        'read',
                        'list',
                        'retrieve'
                    ],
                ],
                'queries' => [
                    'filters' => [
                        [
                            'property_name' => 'tenant_id',
                            'operator' => 'eq',
                            'property_value' => $tenantId
                        ]
                    ]
                ],
            ]
        ];

        return $this->createAccessKey($schema);
    }

    /**
     * @param int $tenantId
     * @param string $tenantName
     * @return string
     */
    public function makeKeyNameString(int $tenantId, string $tenantName): string
    {
        return "{$tenantName}-{$tenantId}";
    }

    /**
     * @param string $keyName
     * @return array|null
     */
    public function getExistingKeyByCustomer(string $keyName): ?array
    {
        $existingKeys = collect($this->getAllAccessKeys());
        if ($existingKeys->count() > 0) {
            $existingKey = $existingKeys->where('name', '===', $keyName)->first();
            if ($existingKey) {
                return $existingKey;
            }
        }

        return null;
    }
}
