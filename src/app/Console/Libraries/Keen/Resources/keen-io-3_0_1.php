<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

$data = include (__DIR__ . '/../../../../vendor/keen-io/keen-io/src/Client/Resources/keen-io-3_0.php');

$data['operations']['createAccessKey'] = [
    'uri'         => 'projects/{projectId}/keys',
    'description' => 'Creates a project access key.',
    'httpMethod'  => 'POST',
    'parameters'  => [
        'projectId'        => [
            'location'    => 'uri',
            'type'        => 'string'
        ],
        'masterKey' => [
            'location'    => 'header',
            'description' => 'The Master API Key.',
            'sentAs'      => 'Authorization',
            'pattern'     => '/^([[:alnum:]])+$/',
            'type'        => 'string',
            'required'    => true,
        ],
    ],
    'additionalParameters' => [
        'location' => 'json'
    ]
];

$data['operations']['getAllAccessKeys'] = [
    'uri'         => 'projects/{projectId}/keys',
    'description' => 'Returns all project access keys.',
    'httpMethod'  => 'GET',
    'parameters'  => [
        'projectId'        => [
            'location'    => 'uri',
            'type'        => 'string'
        ],
        'masterKey' => [
            'location'    => 'header',
            'description' => 'The Master API Key.',
            'sentAs'      => 'Authorization',
            'pattern'     => '/^([[:alnum:]])+$/',
            'type'        => 'string',
            'required'    => true,
        ],
    ],
];

$data['operations']['revokeAccessKey'] = [
    'uri'         => 'projects/{projectId}/keys/{key}/revoke',
    'description' => 'Revokes a project access key.',
    'httpMethod'  => 'POST',
    'parameters'  => [
        'projectId'        => [
            'location'    => 'uri',
            'type'        => 'string'
        ],
        'key'      => [
            'location'    => 'uri',
            'type'        => 'string',
            'required'    => true,
        ],
        'masterKey' => [
            'location'    => 'header',
            'description' => 'The Master API Key.',
            'sentAs'      => 'Authorization',
            'pattern'     => '/^([[:alnum:]])+$/',
            'type'        => 'string',
            'required'    => true,
        ],
    ],
];
$data['operations']['getAccessKey'] = [
    'uri'         => 'projects/{projectId}/keys/{key}',
    'description' => 'Returns a project access key.',
    'httpMethod'  => 'GET',
    'parameters'  => [
        'projectId'        => [
            'location'    => 'uri',
            'type'        => 'string'
        ],
        'key'      => [
            'location'    => 'uri',
            'type'        => 'string',
            'required'    => true,
        ],
        'masterKey' => [
            'location'    => 'header',
            'description' => 'The Master API Key.',
            'sentAs'      => 'Authorization',
            'pattern'     => '/^([[:alnum:]])+$/',
            'type'        => 'string',
            'required'    => true,
        ],
    ]
];

return $data;



