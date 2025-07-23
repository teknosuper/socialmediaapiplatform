<?php

$params = require __DIR__ . '/params.php';
$db = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/db.php'),
    require(__DIR__ . '/db-local.php')
);

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'session'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '55ccc03303dc9eff69883a8dbc39e9b089911de0b392cdfdf495222be228b84a',
            'enableCsrfValidation' => true,
            'enableCsrfCookie' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'cookieParams' => ['httponly' => true, 'sameSite' => yii\web\Cookie::SAME_SITE_LAX],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'enableSession' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => ['api/ig' => 'api/instagram'], 'patterns' => [
                    'GET profilesearch' => 'profilesearch',
                    'GET profiledetail/<username>' => 'profiledetail',
                    'GET mediafeeds/<accountid>' => 'mediafeeds',
                    'GET getfollowers/<accountid>' => 'getfollowers',
                    'GET getfollowing/<accountid>' => 'getfollowing',
                    'POST setcookie' => 'setcookie',
                    'GET getcookie/<username>' => 'getcookie',
                ]],
                'documentation' => 'documentation/index',
                ['class' => 'yii\rest\UrlRule', 'controller' => ['administrator/api/cookies' => 'administrator/api-cookies'], 'pluralize' => false],
                'api' => 'api/index',
                'administrator/cookies' => 'administrator/cookies/index',
                'administrator/cookies/<action:view|create|update|delete>' => 'administrator/cookies/<action>',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
            ],
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'charset' => 'UTF-8',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'default' => '@vendor/yiisoft/yii2-gii/src/generators/crud/default',
                ]
            ]
        ],
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
