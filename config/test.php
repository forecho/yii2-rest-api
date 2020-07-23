<?php

use yii\helpers\ArrayHelper;

$common = require(__DIR__ . '/common.php');
$web = require(__DIR__ . '/web.php');
$params = require __DIR__ . '/params.php';


$config = ArrayHelper::merge([
    'id' => 'basic-tests',
], $web);

return ArrayHelper::merge($common, $config);
