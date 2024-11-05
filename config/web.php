<?php

use app\models\UserProfileSearch;
use kartik\mpdf\Pdf;
use yii\rbac\DbManager;
use yii\rest\UrlRule;
use yii\web\AssetConverter;
use yii\web\JsonParser;
use yii\web\MultipartFormDataParser;
use yii\queue\LogBehavior;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'name' => 'FICPhil',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['queue', 'log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@uploads' => '../web/uploads/',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ivUMghecX8JS9qICac_7S0stuD1mt2Po',
            'parsers' => [
                'application/json' => JsonParser::class,
                'multipart/form-data' => MultipartFormDataParser::class,
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'loginUrl' => ['auth/login'],
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtpout.asia.secureserver.net',
                'username' => 'itdi_dev@ficphil.com',
                'password' => 'fic@12345',
                'port' => '25',
                'encryption' => '',
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
        'db' => $db,
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
            ],
            'converter' => [
                'class' => AssetConverter::class,
                'commands' => [
                    'scss' => ['css', 'C:\Users\DOST-ITDI\AppData\Roaming\npm\sass --style=compressed {from} {to}']
                ]
            ]
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            // 'path' => '@runtime/queue', // only for file queue
            'ttr' => 3 * 60, // Max time for job execution
            'attempts' => 5, // Max number of attempts
            'as log' => LogBehavior::class,
            'db' => 'db',
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class,
        ],
        // 'sass' => [
        //     'class' => '\danxill\sass\SassHandler',
        //     'enableCompass' => true,
        //     'sassCompilePath' => '@web/css-compiled'
        // ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => UrlRule::class,
                    'controller' => [
                        'v1/fic-equipment',
                        // 'v1/equipment-issue',
                        'v1/equipment-issue-repair',
                        'v1/maintenance-checklist-log',
                        'v1/fic-tech-service',
                    ],
                    'tokens' => [
                        // '{id}' => '<id:\\w[\\w,]*>',
                        '{id}' => '<id:[a-zA-Z0-9_\-]+>',
                    ],
                    'pluralize' => false
                ],
                [
                    'class' => UrlRule::class,
                    'controller' => 'v1/equipment-issue',
                    'extraPatterns' => ['POST media' => 'media'],
                    'tokens' => [
                        // '{id}' => '<id:\\w[\\w,]*>',
                        '{id}' => '<id:[a-zA-Z0-9_\-]+>',
                    ],
                    'pluralize' => false
                ],
                [
                    'class' => UrlRule::class,
                    'controller' => 'v1/media',
                    'extraPatterns' => [
                        'POST upload' => 'upload'
                    ]
                ],
            ],
        ],
        'pdf' => [
            'class' => Pdf::class,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
        ],
        'authManager' => [
            'class' => DbManager::class, // yii\rbac\PhpManager or 'yii\rbac\DbManager'
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    //'@app/views' => '@vendor/hail812/yii2-adminlte3/src/views',
                    '@mdm/admin/views' => '@app/views/administrator',
                ],
            ],
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            '*',
            'auth/login',
            'auth/logout',
            'admin/route/*',
            'admin/assignment/*',
            'admin/menu/*'

            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
    'modules' => [
        'debug' => [
            'class' => \yii\debug\Module::class,
            'panels' => [
                'queue' => \yii\queue\debug\Panel::class,
            ]
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    //'userClassName' => 'app\models\User',
                    //'idField' => 'id',
                    'usernameField' => 'username',
                    'fullnameField' => 'userProfile.firstname',
                    'extraColumns' => [
                        [
                            'attribute' => 'userProfile',
                            'label' => 'Designation',
                            'value' => 'userProfile.designation.description'
                            // 'value' => function ($model, $key, $index, $column) {
                            //     return isset($model->userProfile->designation) ? $model->userProfile->designation->description : null;
                            // }
                        ]
                    ],
                    //'searchClass' => UserProfileSearch::class
                ]
            ],
            //'layout' => 'left-menu',
        ],
        'fic-module' => [
            'class' => 'app\modules\ficModule\Module',
        ],
        'supplier-module' => [
            'class' => 'app\modules\supplierModule\Module',
        ],
        'v1' => [
            'class' => 'app\modules\v1\Module',
        ],
        'demo' => [
            'class' => 'app\modules\demo\Module',
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
        //'allowedIPs' => ['*', '127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator', // generator class
                'templates' => [ // setting for our templates
                    'yii2-adminlte3' => '@vendor/hail812/yii2-adminlte3/src/gii/generators/crud/default' // template name => path to template
                ]
            ],
            'job' => [
                'class' => \yii\queue\gii\Generator::class
            ],
        ]
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
