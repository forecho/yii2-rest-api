<?php

namespace app\core\resources;

use app\core\exceptions\InvalidArgumentException;
use app\core\models\User;
use yii\web\IdentityInterface;

class LoginResource
{
    /**
     * @param User|IdentityInterface $user
     * @param string $token
     * @return array
     * @throws InvalidArgumentException
     */
    public function formatter(User $user, string $token)
    {
        return [
            'user' => (new UserResource())->formatter($user),
            'token' => $token,
        ];
    }
}