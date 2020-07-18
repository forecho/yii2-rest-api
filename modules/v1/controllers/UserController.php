<?php

namespace app\modules\v1\controllers;

use app\core\exceptions\InternalException;
use app\core\exceptions\InvalidArgumentException;
use app\core\models\User;
use app\core\requests\JoinRequest;
use app\core\resources\JoinResource;
use app\core\services\UserService;
use Yii;
use yii\base\InvalidConfigException;

/**
 * User controller for the `v1` module
 */
class UserController extends ActiveController
{
    public $modelClass = User::class;
    public $noAuthActions = ['join'];
    /**
     * @var UserService
     */
    private $userService;


    public function init()
    {
        parent::init();
    }

    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['update'], $actions['index'], $actions['delete'], $actions['create']);
        return $actions;
    }


    /**
     * @return array
     * @throws InternalException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     */
    public function actionJoin()
    {
        $params = Yii::$app->request->bodyParams;
        $data = $this->validate(new JoinRequest(), $params);
        /** @var JoinRequest $data */
        $user = Yii::createObject(UserService::class)->createUser($data);
        return (new JoinResource())->formatter($user);
    }
}
