<?php

namespace app\core\resources;

use app\core\models\User;

class JoinResource
{
    public function formatter(User $user)
    {
        return [
            'username' => $user->username,
            'email' => $user->email,
            'token' => 'xx',
        ];
    }
}