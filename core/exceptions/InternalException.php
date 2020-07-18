<?php

namespace app\core\exceptions;

use yii\web\HttpException;

class InternalException extends HttpException
{
    /**
     * Constructor.
     * @param string $message error message
     * @param int $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct(
        $message = null,
        $code = ErrorCodes::INTERNAL_ERROR,
        \Exception $previous = null
    ) {
        $message = $message ?: t('app/error', ErrorCodes::INTERNAL_ERROR);
        parent::__construct(200, $message, $code, $previous);
    }
}
