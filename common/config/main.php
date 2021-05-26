<?php

use yii\db\Connection;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => env('DB_CONNECTION') . ':host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'assetManager' => [
            'linkAssets' => false
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
