<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
	'modules' => [
		'settings' => [
			'class' => 'frontend\modules\settings\Settings',
		],
		'admin' => [
			'class' => 'frontend\modules\admin\Admin',
		],
		'api' => [
			'class' => 'frontend\modules\api\Api',
		],
	],
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
			'class' => 'frontend\components\UrlManager',
			'showScriptName' => false,
			'enablePrettyUrl' => true,
			'rules' => [
				'<language:([a-zA-Z]{2})>' => '',
				'<language:([a-zA-Z]{2})>/' => 'site/index',
				'/' => 'site/index',

				'<language:([a-zA-Z]{2})>/<action:(contact|login|logout)>' => 'site/<action>',
				'<action:(contact|login|logout)>' => 'site/<action>',

				'<language:([a-zA-Z]{2})>/<module:(settings|admin|api)>' => '<module>/default/index',
				'<module:(settings|admin|api)>' => '<module>/default/index',

				'<language:([a-zA-Z]{2})>/<module:(settings|admin|api)>/<controller:\w+>/<id:\d+>' => '<module>/<controller>/view',
				'<language:([a-zA-Z]{2})>/<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<id:\d+>' => '<controller>/view',

				'<language:([a-zA-Z]{2})>/<module:(settings|admin|api)>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
				'<language:([a-zA-Z]{2})>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',

				'<language:([a-zA-Z]{2})>/<module:(settings|admin|api)>/<controller:\w+>' => '<module>/<controller>/index',
				'<language:([a-zA-Z]{2})>/<controller:\w+>' => '<controller>/index',
				'<controller:\w+>' => '<controller>/index',

				'<language:([a-zA-Z]{2})>/<module:(settings|admin|api)>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
				'<language:([a-zA-Z]{2})>/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
