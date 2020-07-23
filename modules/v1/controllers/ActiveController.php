<?php

namespace app\modules\v1\controllers;

use app\core\exceptions\InvalidArgumentException;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;
use yii\base\Model;
use yii\filters\Cors;
use yiier\helpers\SearchModel;
use yiier\helpers\Setup;

class ActiveController extends \yii\rest\ActiveController
{
    protected const MAX_PAGE_SIZE = 100;
    protected const DEFAULT_PAGE_SIZE = 20;

    /**
     * 不参与校验的 actions
     * @var array
     */
    public $noAuthActions = [];

    // 序列化输出
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // 跨区请求 必须先删掉 authenticator
        $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ]
        ];
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'optional' => array_merge($this->noAuthActions, ['options']),
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        $modelClass = $this->modelClass;

        $searchModel = new SearchModel(
            [
                'defaultOrder' => ['id' => SORT_DESC],
                'model' => $modelClass,
                'scenario' => 'default',
                'pageSize' => $this->getPageSize()
            ]
        );

        return $searchModel->search(['SearchModel' => Yii::$app->request->queryParams]);
    }

    /**
     * @return int
     */
    protected function getPageSize()
    {
        if ($pageSize = (int)request('pageSize')) {
            if ($pageSize < self::MAX_PAGE_SIZE) {
                return $pageSize;
            }
            return self::MAX_PAGE_SIZE;
        }
        return self::DEFAULT_PAGE_SIZE;
    }


    /**
     * @param Model $model
     * @param array $params
     * @return Model
     * @throws InvalidArgumentException
     */
    public function validate(Model $model, array $params): Model
    {
        $model->load($params, '');
        if (!$model->validate()) {
            throw new InvalidArgumentException(Setup::errorMessage($model->firstErrors));
        }
        return $model;
    }
}
