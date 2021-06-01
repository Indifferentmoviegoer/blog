<?php

use yii\db\Connection;
use yii2mod\comments\Module;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'comment' => [
            'class' => Module::class,
            'controllerMap' => [
                'default' => [
                    'class' => 'yii2mod\comments\controllers\DefaultController',
                    'on beforeCreate' => function ($event) {
                        $event->getCommentModel();

                    },
                    'on afterCreate' => function ($event) {
                        $event->getCommentModel();
                    },
                    'on beforeDelete' => function ($event) {
                        $event->getCommentModel();
                    },
                    'on afterDelete' => function ($event) {
                        $event->getCommentModel();
                    },
                ]
            ]
        ],
    ],
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => env('DB_CONNECTION') . ':host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => [env('adminEmail') => env('adminName')],
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => env('host'),
                'username' => env('adminEmail'),
                'password' => env('adminPassword'),
                'port' => env('port'),
                'encryption' => env('encryption'),
            ],
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
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
            ],
        ],
    ],
];
