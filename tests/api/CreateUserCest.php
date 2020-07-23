<?php

namespace app\tests\api;

use ApiTester;
use app\core\exceptions\ErrorCodes;
use Codeception\Example;
use Codeception\Util\HttpCode;

class CreateUserCest
{
    /**
     * @codingStandardsIgnoreStart
     * @param ApiTester $I
     */
    public function _before(ApiTester $I)
    {
        // @codingStandardsIgnoreEnd
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
            [
                'data' => [
                    'username' => 'demo-sdsdkj',
                    'email' => 'demo@yii.com',
                    'password' => 'pass123',
                ],
                'code' => ErrorCodes::INVALID_ARGUMENT_ERROR
            ],
            [
                'data' => [
                    'username' => 'demo-sdsdkj',
                    'email' => 'demo@yii.com',
                    'password' => 'pass1',
                ],
                'code' => ErrorCodes::INVALID_ARGUMENT_ERROR
            ],
            [
                'data' => [
                    'username' => 'demo-sdsdkj',
                    'password' => 'pass1',
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
    public function createUser(ApiTester $I)
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
