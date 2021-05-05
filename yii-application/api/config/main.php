<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => 'api\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'advanced-api',
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
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'POST v1/auth/login' => 'v1/auth/login',

                'GET,HEAD v1/collection' => 'v1/collection/index',
                'GET,HEAD v1/collection/<id>' => 'v1/collection/view',
                'PUT,PATCH v1/collection/<id>' => 'v1/collection/update',
                'POST v1/collection' => 'v1/collection/create',
                'DELETE v1/collection/<id>' => 'v1/collection/delete',

                'GET,HEAD v1/image' => 'v1/image/index',
                'GET,HEAD v1/image/<id>' => 'v1/image/view',
                'PUT,PATCH v1/image/<id>' => 'v1/image/update',
                'POST v1/image' => 'v1/image/create',
                'DELETE v1/image/<id>' => 'v1/image/delete',
            ],
        ],
    ],
    'params' => $params,
];
