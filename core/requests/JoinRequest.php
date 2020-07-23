<?php

namespace app\core\requests;

use app\core\models\User;

class JoinRequest extends \yii\base\Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'trim'],
            [['username', 'email'], 'required'],

            [
                'username',
                'match',
                'pattern' => '/^[a-z]\w*$/i',
                'message' => t('app', '{attribute} can only be numbers and letters.')
            ],
            ['username', 'unique', 'targetClass' => User::class],
            ['username', 'string', 'min' => 4, 'max' => 60],

            ['email', 'string', 'min' => 2, 'max' => 120],
            ['email', 'unique', 'targetClass' => User::class],
            ['email', 'email'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => t('app', 'Username'),
            'password' => t('app', 'Password'),
            'email' => t('app', 'Email'),
        ];
    }
}
