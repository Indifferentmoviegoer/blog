<?php

use yii2mod\comments\Module;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'language' => 'ru',
    'name' => 'Новостной блог',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
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
        'request' => [
            'baseUrl' => '/backend',
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/<page:\d+>/<per-page:\d+>' => '/site/index',
                '<controller>/<page:\d+>/<per-page:\d+>' => '<controller>/index',
                '<controller>/<action>/<page:\d+>/<per-page:\d+>' => '<controller>/<action>',
                '<controller>' => '<controller>/index',
            ],
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
    'params' => $params,
];
