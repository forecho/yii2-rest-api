<?php

namespace app\core\services;

use app\core\exceptions\InternalException;
use app\core\models\User;
use app\core\requests\JoinRequest;
use app\core\types\UserStatus;
use Exception;
use sizeg\jwt\Jwt;
use Yii;
use yii\db\ActiveRecord;
use yiier\helpers\Setup;

class UserService
{
    /**
     * @param JoinRequest $request
     * @return User
     * @throws InternalException
     */
    public function createUser(JoinRequest $request): User
    {
        $user = new User();
        try {
            $user->username = $request->username;
            $user->email = $request->email;
            $user->setPassword($request->password);
            $user->generateAuthKey();
            if (!$user->save()) {
                throw new \yii\db\Exception(Setup::errorMessage($user->firstErrors));
            }
        } catch (Exception $e) {
            Yii::error(
                ['request_id' => Yii::$app->requestId->id, $user->attributes, $user->errors, (string)$e],
                __FUNCTION__
            );
            throw new InternalException($e->getMessage());
        }
        return $user;
    }


    /**
     * @return string
     * @throws \Throwable
     */
    public function getToken(): string
    {
        /** @var Jwt $jwt */
        $jwt = Yii::$app->jwt;
        if (!$jwt->key) {
            throw new InternalException(t('app', 'The JWT secret must be configured first.'));
        }
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();
        return (string)$jwt->getBuilder()
            ->issuedBy(params('appUrl'))
            ->identifiedBy(Yii::$app->name, true)
            ->issuedAt($time)
            ->expiresAt($time + 3600 * 72)
            ->withClaim('username', \user('username'))
            ->withClaim('id', \user('id'))
            ->getToken($signer, $key);
    }


    /**
     * @param string $value
     * @return User|ActiveRecord|null
     */
    public static function getUserByUsernameOrEmail(string $value)
    {
        $condition = strpos($value, '@') ? ['email' => $value] : ['username' => $value];
        return User::find()->where(['status' => UserStatus::ACTIVE])
            ->andWhere($condition)
            ->one();
    }
}
