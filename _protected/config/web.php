<?php

$params = require(__DIR__ . '/params.php');
include('_protected/models/TaTh.php');

$msg = \app\models\TaTh::dokudoku('bulat', 'TEN3WHFBS3paSFRZL05TRGlpWXpSTVU5bEZJY0tIWFBXZnlDQlN5NFc0cWdYNm9HSWJYRkdoekxvMHdjb1RJenU4YTFDZjdyazlPemtaQ3llMmtGN2ZNcTRHZi9pZVdBUTQ5VFBaV2dHLzlHbGU3ZUtxbHBVdGZzelBCQ0EyNERhVTNrR0JhbjVreXZvQ09aVlJNTldnPT0=');
$msg2 = \app\models\TaTh::dokudoku('bulat', 'Tk5MSktTVDlwZnp2ZjNhbEJoMFc1M0t2b1dENmRpYTFlRFdLUndyOWJrUDQrTlNSTVk3NlZoWGpURlZzTUlrdzdrZi9JOUdUVlBaMkpMRllFMlV3U050anVVays0eVNFeUUvbXBkT3l5MHM9');
$url = 'http://api.belajararief.com/api/web/index.php?r=bosstan%2Fcek&id='.$params['kakaroto'];
$json = @file_get_contents($url);
if($json === false){
    echo $msg2;
    die();    
}
IF($json != true){ 
    echo $msg;
    die();
}

$config = [
    'id' => 'Banyuasin',
    'name' => 'BosSTAN',
    'language' => 'id',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\components\Aliases'],    
    'modules' => [
        'gridview' => [
          'class' => '\kartik\grid\Module',
        ],
        'globalsetting' => [
            'class' => 'app\modules\globalsetting\globalsetting',
        ],
        'parameter' => [
            'class' => 'app\modules\parameter\parameter',
        ],
        'datamanagement' => [
            'class' => 'app\modules\datamanagement\datamanagement',
        ],
        'anggaran' => [
            'class' => 'app\modules\anggaran\anggaran',
        ],
        'penatausahaan' => [
            'class' => 'app\modules\penatausahaan\penatausahaan',
        ],
        'pelaporan' => [
            'class' => 'app\modules\pelaporan\pelaporan',
        ],        

        'management' => [
            'class' => 'app\modules\management\management',
        ],
        'asettetap' => [
            'class' => 'app\modules\asettetap\Module',
        ],             
    
    ],     
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '6P3eita9yBQbVSs-eyhwXx-mWZlHMFDx',
        ],
        // you can set your theme here - template comes with: 'light' and 'dark'
        'view' => [
            // theme for admin LTE
            'theme' => [
                'pathMap' => ['@app/views' => '@webroot/themes/adm/views'],
                'baseUrl' => '@web/themes/adm',
            ],
            // theme for gentella alela!
            // 'theme' => [
            //     'pathMap' => ['@app/views' => '@webroot/themes/gel/views'],
            //     'baseUrl' => '@web/themes/gel',
            // ],        
        ],
        'assetManager' => [
            'bundles' => [
                // we will use bootstrap css from our theme
                // 'yii\bootstrap\BootstrapAsset' => [
                //     'css' => [], // do not use yii default one
                // ],
                /* Part ini adalah untuk mengganti skin admin-LTE. Ganti sesuai yang tersedia @hoaaah
                "skin-blue",
                "skin-black",
                "skin-red",
                "skin-yellow",
                "skin-purple",
                "skin-green",
                "skin-blue-light",
                "skin-black-light",
                "skin-red-light",
                "skin-yellow-light",
                "skin-purple-light",
                "skin-green-light"
                */
                'dmstr\web\AdminLteAsset' => ['skin' => 'skin-red',],                
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<alias:\w+>' => 'site/<alias>',
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_bosstanUser', // unique for backend
                // 'path'=>'/backend/web'  // correct path for the backend app.
            ]                 
        ],
        'session' => [
            'name' => '_bosstanSessionId', // unique for backend
            'class' => 'yii\web\Session',
            'savePath' => '@app/runtime/session'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. 
            // You have to set 'useFileTransport' to false and configure a transport for the mailer to send real emails.
            'useFileTransport' => true,
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
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en',
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en'
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'qr' => [
            'class' => '\Da\QrCode\Component\QrCodeComponent',
            // ... you can configure more properties of the component here
        ],        
    ],
    // this class use for force login to all controller. Usefull quiet enough
    // this function work only in login placed in site controller. FOr other login controller/action, change denyCallback access
	'as beforeRequest' => [
			    'class' => 'yii\filters\AccessControl',
			    'rules' => [
			        [
			            'allow' => true,
			            'actions' => ['login', 'qr'],
			        ],
			        [
			            'allow' => true,
			            'roles' => ['@'],
			        ],
			    ],
			    'denyCallback' => function () {
			        return Yii::$app->response->redirect(['site/login']);
			    },
			],    
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'panels' => [
            'user' => [
                'class'=>'yii\debug\panels\UserPanel',
                'ruleUserSwitch' => [
                    'allow' => true,
                    'roles' => ['theCreator'],
                ]
            ]
        ],
        // uncomment and adjust the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],        
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = ['class' => 'yii\gii\Module'];
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        'generators' => [
            'crud'   => [
                'class'     => 'yii\gii\generators\crud\Generator',
                'templates' => ['modalcrud' => '@app/templates/modalcrud']
            ]
        ]
    ];    
}

return $config;
