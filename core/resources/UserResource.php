<?php

namespace app\core\resources;

use app\core\exceptions\InvalidArgumentException;
use app\core\models\User;
use app\core\types\UserStatus;
use yiier\helpers\DateHelper;

class UserResource
{
    /**
     * @param User $user
     * @return array
     * @throws InvalidArgumentException
     */
    public function formatter(User $user)
    {
        return [
            'username' => $user->username,
            'email' => $user->email,
            'status' => UserStatus::getName($user->status),
            'created_at' => DateHelper::datetimeToIso8601($user->created_at),
            'updated_at' => DateHelper::datetimeToIso8601($user->updated_at),
        ];
    }
}