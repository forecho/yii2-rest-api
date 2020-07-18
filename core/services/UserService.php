<?php

namespace app\core\services;

use app\core\exceptions\InternalException;
use app\core\models\User;
use app\core\requests\JoinRequest;
use Exception;
use yiier\helpers\Setup;

class UserService
{
    /**
     * @param JoinRequest $request
     * @return User
     * @throws InternalException
     */
    public function createUser(JoinRequest $request)
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
            throw new InternalException($e->getMessage());
        }
        return $user;
    }
}