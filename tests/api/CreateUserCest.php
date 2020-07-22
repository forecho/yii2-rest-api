<?php

namespace app\tests\api;

use ApiTester;
use app\core\exceptions\ErrorCodes;
use Codeception\Example;
use Codeception\Util\HttpCode;

class CreateUserCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * @return array
     */
    public function makeValidateFailItems()
    {
        return [
            [
                'data' => [
                    'username' => 'demo',
                    'email' => 'demo',
                    'password' => 'pass123',
                ],
                'code' => ErrorCodes::INVALID_ARGUMENT_ERROR
            ],
        ];
    }

    /**
     * @dataProvider makeValidateFailItems
     * @param ApiTester $I
     * @param Example $example
     */
    public function createUserViaAPIFail(ApiTester $I, Example $example)
    {
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendPOST('/join', $example['data']);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['code' => $example['code']]);
    }

    /**
     * @param ApiTester $I
     */
    public function createUserViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendPOST('/join', [
            'username' => 'demo',
            'email' => 'demo@yii.com',
            'password' => 'pass123',
        ]);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['code' => 0]);
        $I->seeResponseJsonMatchesXpath('//data/username');
    }
}
