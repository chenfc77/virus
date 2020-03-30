<?php

use Swoft\Http\Server\HttpServer;
use Swoft\Task\Swoole\TaskListener;
use Swoft\Task\Swoole\FinishListener;
use Swoft\Server\SwooleEvent;
use Swoft\Db\Database;
use Swoft\Db\Pool;
use Swoft\Redis\RedisDb;
use Gaoding\SwoftLogger\Formatter\AiFormatter as GaodingFormatter;
use Gaoding\SwoftLogger\Handler\AiHandler as GaodingHandler;

return [
    'config'   => [
        'path' => __DIR__ . '/../config',
        'env'  => env('APP_ENV'),
    ],
    'httpServer'        => [
        'class'    => HttpServer::class,
        'port'     => 18308,
        'listener' => [
        ],
        'process'  => [
        ],
        'on'       => [
//            SwooleEvent::TASK   => bean(SyncTaskListener::class),  // Enable sync task
            SwooleEvent::TASK   => bean(TaskListener::class),  // Enable task must task and finish event
            SwooleEvent::FINISH => bean(FinishListener::class)
        ],
        /* @see HttpServer::$setting */
        'setting'  => [
            'worker_num'            => env('WORKER_NUM'),
            'task_worker_num'       => env('TASK_WORKER_NUM'),
            'task_enable_coroutine' => true
        ]
    ],
    'httpDispatcher'    => [
        // Add global http middleware
        'middlewares'      => [
            \App\Http\Middleware\AuthMiddleware::class,
        ],
        'afterMiddlewares' => [
            \Swoft\Http\Server\Middleware\ValidatorMiddleware::class
        ]
    ],
    'db'                => [
        'class'    => Database::class,
        'dsn'      => config('db.dsn'),
        'username' => config('db.username'),
        'password' => config('db.password'),
        'charset'  => config('db.charset'),
    ],
    'db.pool'          => [
        'class'    => Pool::class,
        'database' => bean('db'),
        'minActive'   => config('db.pool_min_active'),
        'maxActive'   => config('db.pool_max_active'),
        'maxWait'     => config('db.pool_max_wait'),
        'maxWaitTime' => config('db.pool_max_wait_time'),
        'maxIdleTime' => config('db.pool_max_idle_time'),
    ],
    'migrationManager'  => [
        'migrationPath' => '@app/Migration',
    ],
    'logger'            => [
        'flushRequest' => false,
        'enable'       => false,
        'json'         => false,
    ],
    'i18n'  => [
        'resoucePath'     => '@resource/language/',
        'defaultLanguage' => 'zh-cn',
        'defualtCategory' => 'default',
    ],

];
