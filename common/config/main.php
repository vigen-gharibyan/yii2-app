<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'authManager' => [
			'class' => 'yii\rbac\PhpManager',
			//здесь прописываем роли
			'defaultRoles' => [
				'user',
				'worker',
				'moderator',
				'admin',
			],
			//зададим куда будут сохраняться наши файлы конфигураций RBAC
			'itemFile' => '@common/components/rbac/items.php',
			'assignmentFile' => '@common/components/rbac/assignments.php',
			'ruleFile' => '@common/components/rbac/rules.php',
		],
		'urlManagerLive' => [
			'class' => 'yii\web\urlManager',
			'baseUrl' => 'http://35.165.105.102',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
		],
		'urlManagerFrontend' => [
			'class' => 'yii\web\urlManager',
			'baseUrl' => 'http://yii2site.local',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
		],
		'urlManagerBackend' => [
			'class' => 'yii\web\urlManager',
			'baseUrl' => 'http://admin.yii2site.local',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
		],
		'urlManagerApi' => [
			'class' => 'yii\web\urlManager',
			'baseUrl' => 'http://yii2api.local',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
		],
		'i18n' => [
			'translations' => [
				'app*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@common/messages',
				],
				/*
				'frontend*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@common/messages',
				],
				'backend*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@common/messages',
				],
				*/
			],
		],
    ],
	'modules' => [
        'gii-mongo' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'mongoDbModel' => [
                    'class' => 'yii\mongodb\gii\model\Generator'
                ],
            ],
        ],
    ],
	'timeZone' => 'Asia/Yerevan',
];
