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
     * @var string
     */
    public static $delimiter = '-';

    /**
     * @var string
     */
    public static $requestIdParamName = 'X_REQUEST_ID';

    /**
     * @var string
     */
    public static $requestIdHeaderName = 'X-Request-ID';

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
        $requestId = self::getRequestId();
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

    public function beforeAction()
    {
        return self::getRequestId();
    }

    /**
     * @return string
     */
    public static function getRequestId()
    {
        try {
            $console = Yii::$app instanceof \yii\console\Application;
            if ((!$console) &&
                $requestId = ArrayHelper::getValue(Yii::$app->request->getHeaders(), self::$requestIdHeaderName)
            ) {
                $tmp = explode(self::$delimiter, $requestId);
                if (count($tmp) < 2) {
                    $tmp = self::genRequestId();
                }
                $tmp[1] = (int)$tmp[1] + 1;
                $requestId = sprintf('%s%s%04d', $tmp[0], self::$delimiter, $tmp[1]);
            } elseif (!$requestId = ArrayHelper::getValue(Yii::$app->params, self::$requestIdParamName)) {
                $requestId = self::genRequestId();;
            }
            \Yii::$app->params[self::$requestIdParamName] = $requestId;
        } catch (\Exception $e) {
            Yii::error($e, __FUNCTION__);
            $requestId = null;
        }
        return $requestId;
    }

    /**
     * @return string
     * @throws \Exception
     */
    private static function genRequestId()
    {
        return sprintf('%s%s%04d', Security::generateRealUniqId(20), self::$delimiter, 0);
    }
}
