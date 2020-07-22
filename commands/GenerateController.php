<?php

namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;
use yiier\helpers\Security;

class GenerateController extends Controller
{
    public function actionKey(string $filename = '.env')
    {
        $environmentFilePath = \Yii::getAlias('@app/' . $filename);
        foreach (['COOKIE_VALIDATION_KEY', 'JWT_SECRET'] as $item) {
            $escaped = preg_quote('=' . env($item), '/');
            $keyReplacementPattern = "/^{$item}{$escaped}/m";
            $key = Security::generateRealUniqId(32);
            file_put_contents($environmentFilePath, preg_replace(
                $keyReplacementPattern,
                "{$item}={$key}",
                file_get_contents($environmentFilePath)
            ));
            $this->stdout("{$item} key [{$key}] set successfully.\n", Console::FG_GREEN);
        }
    }
}
