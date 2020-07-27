<?php

return [
    'timeZone' => env('APP_TIME_ZONE'),
    'language' => env('APP_LANGUAGE'),
    'name' => env('APP_NAME'),
    'bootstrap' => ['log', 'ideHelper', \app\core\EventBootstrap::class],
    'components' => [
        'ideHelper' => [
            'class' => 'Mis\IdeHelper\IdeHelper',
            'configFiles' => [
                'config/web.php',
                'config/common.php',
                'config/console.php',
            ],
        ],
        'requestId' => [
            'class' => \yiier\helpers\RequestId::class,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => 'utf8mb4',
            'enableSchemaCache' => YII_ENV_PROD,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/core/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'exception.php',
                    ],
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                /**
                 * 错误级别日志：当某些需要立马解决的致命问题发生的时候，调用此方法记录相关信息。
                 * 使用方法：Yii::error()
                 */
                [
                    'class' => 'yiier\helpers\FileTarget',
                    // 日志等级
                    'levels' => ['error'],
                    // 被收集记录的额外数据
                    'logVars' => ['_GET', '_POST', '_FILES', '_COOKIE', '_SESSION'],
                    // 指定日志保存的文件名
                    'logFile' => '@app/runtime/logs/error/app.log',
                    // 是否开启日志 (@app/runtime/logs/error/20151223_app.log)
                    'enableDatePrefix' => true,
                ],
                /**
                 * 警告级别日志：当某些期望之外的事情发生的时候，使用该方法。
                 * 使用方法：Yii::warning()
                 */
                [
                    'class' => 'yiier\helpers\FileTarget',
                    // 日志等级
                    'levels' => ['warning'],
                    // 被收集记录的额外数据
                    'logVars' => ['_GET', '_POST', '_FILES', '_COOKIE', '_SESSION'],
                    // 指定日志保存的文件名
                    'logFile' => '@app/runtime/logs/warning/app.log',
                    // 是否开启日志 (@app/runtime/logs/warning/20151223_app.log)
                    'enableDatePrefix' => true,
                ],
                [
                    'class' => 'yiier\helpers\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['request'],
                    'logVars' => [],
                    'maxFileSize' => 1024,
                    'logFile' => '@app/runtime/logs/request/app.log',
                    'enableDatePrefix' => true
                ],
                [
                    'class' => 'yiier\helpers\FileTarget',
                    'levels' => ['warning'],
                    'categories' => ['debug'],
                    'logVars' => [],
                    'maxFileSize' => 1024,
                    'logFile' => '@app/runtime/logs/debug/app.log',
                    'enableDatePrefix' => true
                ],
            ],
        ],
    ],
];
