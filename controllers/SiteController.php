<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use yii\rest\Controller;

class SiteController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return 'hello yii';
    }

    /**
     * @return string
     */
    public function actionHealthCheck()
    {
        return 'OK';
    }

    /**
     * @return array
     */
    public function actionError(): array
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            Yii::error([
                'request_id' => Yii::$app->requestId->id,
                'exception' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 'response_data_error');
            return ['code' => $exception->getCode(), 'message' => $exception->getMessage()];
        }
        return [];
    }
}
