<?php
/**
 * Configuration file with environment variable support for Railway deployment
 */
return [
    'admin' => [
        'username' => getenv('ADMIN_USERNAME') ?: 'admin',
        'password' => getenv('ADMIN_PASSWORD') ?: 'change-this-password'
    ],
    'site' => [
        'title' => getenv('SITE_TITLE') ?: 'Kirill Miller'
    ],
    'app' => [
        'env' => getenv('APP_ENV') ?: 'production',
        'debug' => getenv('APP_DEBUG') === 'true'
    ]
];
