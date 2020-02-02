<?php

return [
    'defaults' => [
        'guard' => 'anyone'
    ],

    'guards' => [
        'anyone' => [
            'driver' => 'session',
            'provider' => 'user',
            'hash' => true
        ],
        'web' => [
            'driver' => 'session',
            'provider' => 'user',
            'hash' => true
        ],
        'api' => [
            'driver' => 'token',
            'provider' => 'user',
            'hash' => false
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admin',
            'hash' => true
        ]
    ],

    'providers' => [
        'user' => [
            'driver' => 'eloquent',
            'model' => App\Model\User::class,
        ],
        'admin' => [
            'driver' => 'eloquent',
            'model' => App\Model\Admin::class,
        ]
    ],
    'passwords' => [
        'user' => [
            'provider' => 'user',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'admin' => [
            'provider' => 'admin',
            'table' => 'admin',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
