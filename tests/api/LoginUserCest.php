<?php

namespace app\tests\api;

// @codingStandardsIgnoreLine
use ApiTester;
use app\core\exceptions\ErrorCodes;
use Codeception\Util\HttpCode;

class LoginUserCest
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
     * @param ApiTester $I
     */
    public function userLoginFail(ApiTester $I)
    {
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendPOST('/login', [
            'username' => 'demo',
            'password' => 'pass123456',
        ]);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['code' => ErrorCodes::INVALID_ARGUMENT_ERROR]);
    }


    /**
     * @param ApiTester $I
     * @param CreateUserCest $createUserCest
     */
    public function userLogin(ApiTester $I, CreateUserCest $createUserCest)
    {
        $createUserCest->createUser($I);
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendPOST('/login', [
            'username' => 'demo',
            'password' => 'pass123',
        ]);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['code' => 0]);
        $I->seeResponseJsonMatchesXpath('//data/token');
        $I->seeResponseJsonMatchesXpath('//data/user/username');
    }
}
