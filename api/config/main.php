<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'format' =>  \yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null /*&& !empty(Yii::$app->request->get('suppress_response_code'))*/) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'statusCode' => $response->statusCode,
                        'data' => $response->data,
                    ];
                //  $response->statusCode = 200;
                }
            },
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
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
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'prefix' => 'api/v1',
                    'controller' => [
                        'user',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'login' => 'login',
                        'signup' => 'signup',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'prefix' => 'api/v1',
                    'controller' => [
                        'post',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'prefix' => 'api/v1',
                    'controller' => [
                        'test',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'upload' => 'upload',
                    ]
                ],
                /*
                'api/v1/<controller>/<action>/<id:\d+>' => '<controller>/<action>',
                'api/v1/<controller>/<action>' => '<controller>/<action>',

                'OPTIONS api/v1/user/login' => 'user/login',
                'POST api/v1/user/login' => 'user/login',
                'OPTIONS api/v1/user/signup' => 'user/signup',
                'POST api/v1/user/signup' => 'user/signup',
                */
            ],
        ],
    ],
    'params' => $params,
];
