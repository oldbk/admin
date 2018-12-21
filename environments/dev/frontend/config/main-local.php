<?php
$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'baseUrl' => '@web',
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => [
                        'js/jquery-2.1.1.js',
                    ]
                ],
            ],
        ],
        'session' => [
            'name' => 'ADMIN_OLDBK',
            'cookieParams' => [
                //'domain' => '.a.oldbk.com',
            ],
            'savePath' => '/tmp'
        ],
    ],
];

// configuration adjustments for 'dev' environment
$config['bootstrap'][] = 'debug';
$config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
    'allowedIPs' => ['*']
];
$config['bootstrap'][] = 'gii';
$config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
    'allowedIPs' => ['*']
];

return $config;