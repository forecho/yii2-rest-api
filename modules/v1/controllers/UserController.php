<?php

namespace app\modules\v1\controllers;

use app\core\requests\JoinRequest;
use Yii;

/**
 * User controller for the `v1` module
 */
class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';
    public $noAuthActions = [];

    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['update'], $actions['index'], $actions['delete'], $actions['create']);
        return $actions;
    }

    public function actionJoin()
    {
        $data = Yii::$app->request->bodyParams;
        $this->validate(new JoinRequest(), $data);
        
    }
}
