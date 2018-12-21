<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
//$params['mdm.admin.configs']['onlyRegisteredRoute'] = true;

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
	'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'quest' => [
            'class' => 'frontend\modules\quest\Module',
        ],
        'stats' => [
            'class' => 'frontend\modules\stats\Module',
        ],
        'news' => [
            'class' => 'frontend\modules\news\Module',
        ],
        'loto' => [
            'class' => 'frontend\modules\loto\Module',
        ],
        'users' => [
            'class' => 'frontend\modules\users\Module',
        ],
        'item' => [
            'class' => 'frontend\modules\item\Module',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            //'layout' => 'left-menu',
            //'mainLayout' => '@mdm/admin/views/layouts/main.php',
        ],
        'rate' => [
            'class' => 'frontend\modules\rate\Module',
        ],
        'dialog' => [
            'class' => 'frontend\modules\dialog\Module',
        ],
        'settings' => [
            'class' => 'frontend\modules\settings\Module',
        ],
        'recipe' => [
            'class' => 'frontend\modules\recipe\Module',
        ],
        'library' => [
            'class' => 'frontend\modules\library\Module',
        ],
        'gamehelp' => [
            'class' => 'frontend\modules\gamehelp\Module',
        ],
        'wordfilter' => [
            'class' => 'frontend\modules\wordfilter\Module',
        ],
        'usersedit' => [
            'class' => 'frontend\modules\usersedit\Module',
        ],
		'pool' => [
			'class' => 'frontend\modules\pool\Module',
		],
		'export' => [
			'class' => 'frontend\modules\export\Module',
		],
		'ko' => [
			'class' => 'frontend\modules\ko\Module',
		],
		'images' => [
			'class' => 'frontend\modules\images\Module',
		],
		'event' => [
			'class' => 'frontend\modules\event\Module',
		],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            //'admin/*'
        ]
    ],
    'components' => [
    	'formatter' => [
    		'locale' => 'ru-RU'
		],
        'breadcrumbs' => [
            'class' => 'common\components\Breadcrumbs',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => [
                        '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
                    ]
                ],
            ],
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
        'view' => [
            'class' => 'common\components\View',
            'theme' => [
                'class'     => 'common\components\Theme',
                'name'      => 'new',
                'basePath'  => '@frontend/themes/new',
                'baseUrl'   => '@web/themes/new',
                'pathMap'   => [
                    '@frontend/views'   => '@frontend/themes/new',
                    '@frontend/modules' => '@frontend/themes/new/modules',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'suffix' => '.html',
            'rules' => [
                [
                    'pattern'   => '/api/gift-box',
                    'route'     => '/api/gift-box',
                    'suffix'    => '.json'
                ],
                [
                    'pattern'   => '/login',
                    'route'     => '/site/login',
                ],
                [
                    'pattern'   => '/logout',
                    'route'     => '/site/logout',
                ],
                [
                    'pattern'   => '/',
                    'route'     => '/site/index',
                ],
                [
                    'pattern'   => '/<controller>/<action>',
                    'route'     => '/<controller>/<action>',
                ],
                [
                    'pattern'   => '/<module>/<controller>/<action>',
                    'route'     => '/<module>/<controller>/<action>',
                ],
            ],
        ],
    ],
    'params' => $params,
];
