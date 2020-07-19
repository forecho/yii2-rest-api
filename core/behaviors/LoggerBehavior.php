<?php

namespace app\core\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yiier\helpers\Security;

class LoggerBehavior extends Behavior
{
    /**
     * @var mixed
     */
    private $delimiter = '-';

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
        $request = \Yii::$app->request;
        $requestId = $request->getQueryParam('request_id');
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

    /**
     * @throws \Exception
     */
    public function beforeAction()
    {
        Yii::$app->request->setQueryParams(['request_id' => null]);
        if ($requestId = ArrayHelper::getValue(Yii::$app->request->getHeaders(), 'x-request-id')) {
            $tmp = explode($this->delimiter, $requestId);
            if (count($tmp) < 2) {
                $tmp = $this->genRequestId();
            }
            $tmp[1] = (int)$tmp[1] + 1;
            $requestId = sprintf('%s%s%04d', $tmp[0], $this->delimiter, $tmp[1]);
        } else {
            $requestId = $this->genRequestId();
        }
        return Yii::$app->request->setQueryParams(['request_id' => $requestId]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function genRequestId()
    {
        return sprintf('%s%s%04d', Security::generateRealUniqId(), $this->delimiter, 0);
    }

}
