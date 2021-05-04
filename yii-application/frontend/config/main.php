<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
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
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'POST api/auth/login' => 'api/auth/login',

                'GET,HEAD api/collection' => 'api/collection/index',
                'GET,HEAD api/collection/<id>' => 'api/collection/view',
                'PUT,PATCH api/collection/<id>' => 'api/collection/update',
                'POST api/collection' => 'api/collection/create',
                'DELETE api/collection/<id>' => 'api/collection/delete',

                'GET,HEAD api/image' => 'api/image/index',
                'GET,HEAD api/image/<id>' => 'api/image/view',
                'PUT,PATCH api/image/<id>' => 'api/image/update',
                'POST api/image' => 'api/image/create',
                'DELETE api/image/<id>' => 'api/image/delete',
            ],
        ],
    ],
    'params' => $params,
];
