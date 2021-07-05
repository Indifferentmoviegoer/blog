<?php

use frontend\modules\v1\Module;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'Новостной блог',
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'v1' => [
            'class' => Module::class,
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => yii\web\JsonParser::class,
                'asArray' => true
            ]
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
                'detail/<id:\d+>' => 'site/detail',
                'gallery/detail/<id:\d+>' => 'gallery/detail',
                'gallery/' => 'gallery/index',
                '/page-<page:\d+>-<per-page:\d+>' => 'site/index',
                'category/<id:\d+>' => 'site/category',
                'gallery/view/id/<id:\d+>' => 'gallery/view',
                '/<action>' => 'site/<action>',

            ],
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
    ],
    'params' => $params,
];
