<?php

namespace app\modules\v1\controllers;

use app\core\exceptions\InternalException;
use app\core\exceptions\InvalidArgumentException;
use app\core\models\User;
use app\core\requests\JoinRequest;
use app\core\requests\LoginRequest;
use app\core\traits\ServiceTrait;
use Yii;

/**
 * User controller for the `v1` module
 */
class UserController extends ActiveController
{
    use ServiceTrait;

    public $modelClass = User::class;
    public $noAuthActions = ['join', 'login'];

    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['update'], $actions['index'], $actions['delete'], $actions['create']);
        return $actions;
    }

    /**
     * @return User
     * @throws InternalException
     * @throws InvalidArgumentException
     */
    public function actionJoin()
    {
        $params = Yii::$app->request->bodyParams;
        $data = $this->validate(new JoinRequest(), $params);

        /** @var JoinRequest $data */
        return $this->userService->createUser($data);
    }

    /**
     * @return string[]
     * @throws InvalidArgumentException|\Throwable
     */
    public function actionLogin()
    {
        $params = Yii::$app->request->bodyParams;
        $this->validate(new LoginRequest(), $params);
        $token = $this->userService->getToken();
        $user = Yii::$app->user->identity;

        return [
            'user' => $user,
            'token' => (string)$token,
        ];
    }

    public function actionRefreshToken()
    {
        $user = Yii::$app->user->identity;
        $token = $this->userService->getToken();
        return [
            'user' => $user,
            'token' => (string)$token,
        ];
    }
}
