<?php

use kartik\datecontrol\Module;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'language'=>'pt-BR',
    'basePath' => dirname(__DIR__),
    'timeZone' => 'America/Manaus',
    'bootstrap' => ['log'],

        'modules' => [
            'datecontrol' =>  [
                    'class' => 'kartik\datecontrol\Module',
             
                    // format settings for displaying each date attribute (ICU format example)
                    'displaySettings' => [
                        Module::FORMAT_DATE => 'dd/MM/yyyy',
                        Module::FORMAT_TIME => 'hh:mm:ss a',
                        Module::FORMAT_DATETIME => 'dd-MM-yyyy hh:mm:ss a', 
                    ],
                    
                    // format settings for saving each date attribute (PHP format example)
                    'saveSettings' => [
                        Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
                        Module::FORMAT_TIME => 'php:H:i:s',
                        Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
                    ],
                     // set your display timezone
                    'displayTimezone' => 'America/Manaus',

                    // set your timezone for date saved to db
                    'saveTimezone' => 'UTC',
                    
                    // automatically use kartik\widgets for each of the above formats
                    'autoWidget' => true,
             
                    // default settings for each widget from kartik\widgets used when autoWidget is true
                    'autoWidgetSettings' => [
                        Module::FORMAT_DATE => ['type'=>2, 'pluginOptions'=>['autoclose'=>true]], // example
                        Module::FORMAT_DATETIME => [], // setup if needed
                        Module::FORMAT_TIME => [], // setup if needed
                    ],

                    'widgetSettings' => [
                                Module::FORMAT_DATE => [
                                    'class' => 'yii\jui\DatePicker', // example
                                    'options' => [
                                        'dateFormat' => 'php:d-M-Y',
                                        'options' => ['class'=>'form-control'],
                                    ]
                                ]
                            ],
                            ],

                'gridview' =>  [
                'class' => '\kartik\grid\Module'
                               ],

                     ],

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'x05jEuD9ypzJe9arXRBtPByltBfUbi96',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
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
        'db' => require(__DIR__ . '/db.php'),
        'db_apl' => require(__DIR__ . '/db_apl.php'),
        'db_rep' => require(__DIR__ . '/db_rep.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => [
    'maskMoneyOptions' => [
        'prefix' => 'R$ ',
        //'suffix' => ' Reais',
        'affixesStay' => true,
        'thousands' => '.',
        'decimal' => ',',
        'precision' => 2, 
        'allowZero' => false,
        'allowNegative' => false,
        ]
    ],

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
