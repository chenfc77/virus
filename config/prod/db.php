<?php
return [
    'dsn'      => env('DB_DSN'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'charset'  => env('DB_CHARSET'),

    'pool_min_active'     => env('DB_POOL_MIN_ACTIVE',5),
    'pool_max_active'     => env('DB_POOL_MAX_ACTIVE',10),
    'pool_max_wait'       => env('DB_POOL_MAX_WAIT',0),
    'pool_max_wait_time'  => env('DB_POOL_MAX_WAIT_TIME',0),
    'pool_max_idle_time'  => env('DB_POOL_MAX_IDLE_TIME',60),
];
