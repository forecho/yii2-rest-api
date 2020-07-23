<?php

/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2019/5/12 4:58 PM
 * description:
 */

namespace app\core\traits;

use app\core\services\UserService;
use Yii;
use yii\base\InvalidConfigException;

/**
 * Trait ServiceTrait
 * @property-read UserService $userService
 */
trait ServiceTrait
{
    /**
     * @return UserService|object
     */
    public function getUserService()
    {
        try {
            return Yii::createObject(UserService::class);
        } catch (InvalidConfigException $e) {
            return new UserService();
        }
    }
}
