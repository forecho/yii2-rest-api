<?php

namespace app\core\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

class LoggerBehavior extends Behavior
{
    public function events()
    {
        return [
            Response::EVENT_BEFORE_SEND => 'beforeSend',
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }

    /**
     * @param $event
     * @throws \Exception
     */
    public function beforeSend($event)
    {
        $response = $event->sender;
        if ($response->format != 'html') {
            $request = \Yii::$app->request;
            $requestId = Yii::$app->requestId->id;
            $code = ArrayHelper::getValue($response->data, 'code');
            $message = [
                'request_id' => $requestId,
                'type' => $code === 0 ? 'response_data_success' : 'response_data_error',
                'header' => Json::encode($request->headers),
                'params' => $request->bodyParams,
                'url' => $request->absoluteUrl,
                'response' => Json::encode($response->data)
            ];
            $response->data = ['request_id' => $requestId] + $response->data;
            $code === 0 ? Yii::info($message, 'request') : Yii::error($message, 'request');
        }
    }

    public function beforeAction()
    {
        return Yii::$app->requestId->id;
    }
}
