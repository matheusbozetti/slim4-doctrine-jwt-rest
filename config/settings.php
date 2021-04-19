<?php

define('APP_ROOT', __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);

return [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => false,
        'doctrine' => [
            'dev_mode' => true,
            'cache_dir' => APP_ROOT.'var/doctrine',
            'metadata_dirs' => [APP_ROOT.'src/Models'],
            'connection' => [
                'driver' => 'pdo_mysql',
                'host' => $_ENV['DB_HOST'],
                'port' => $_ENV['DB_PORT'],
                'dbname' => $_ENV['DB_DATABASE'],
                'user' => $_ENV['DB_USERNAME'],
                'password' => $_ENV['DB_PASSWORD'],
                'charset' => 'utf8mb4',
            ],
        ],
        'error' => [
            'displayErrorDetails' => false,
            'logErrors' => false,
            'logErrorDetails' => false,
        ],
    ],
];
