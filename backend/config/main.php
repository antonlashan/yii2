<?php

$params = array_merge(
	require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
	'id' => 'app-backend',
	'basePath' => dirname(__DIR__),
	'name' => 'Sri Lankan Junior Science Olympiad - Admin',
	'controllerNamespace' => 'backend\controllers',
	'bootstrap' => ['log'],
	'modules' => [],
	'components' => [
		'session' => [
			'name' => 'PHPBACKSESSID',
			'savePath' => sys_get_temp_dir(),
		],
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => '#8555FF&*',
			'csrfParam' => '_backendCSRF',
		],
		'user' => [
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => true,
			'identityCookie' => [
				'name' => '_backendUser', // unique for backend
			]
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
	],
	'params' => $params,
];
