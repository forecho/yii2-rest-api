<?php
/*
 * Yii2 Ide Helper
 * https://github.com/takashiki/yii2-ide-helper
 */

class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication
     */
    public static $app;
}

/**
 * @property Mis\IdeHelper\IdeHelper $ideHelper
 * @property yiier\helpers\RequestId $requestId
 * @property yii\caching\FileCache $cache
 * @property yii\db\Connection $db
 * @property yii\web\Response $response
 * @property sizeg\jwt\Jwt $jwt
 * @property yii\web\User $user
 * @property yii\swiftmailer\Mailer $mailer
 */
abstract class BaseApplication extends \yii\base\Application {}