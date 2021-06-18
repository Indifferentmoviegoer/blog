<?php
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
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
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
                'page-<page:\d+>-<per-page:\d+>' => 'site/index',
                '/<action>' => 'site/<action>',
                '<controller>/<action>' => '<controller>/<action>',
//                '<controller>/<action>/<page:\d+>/<per-page:\d+>' => '<controller>/<action>',
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
