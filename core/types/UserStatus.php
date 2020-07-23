<?php

namespace app\core\types;

class UserStatus extends BaseType
{
    /** @var int 激活 */
    public const ACTIVE = 1;

    /** @var int 未激活状态 */
    public const UNACTIVATED = 0;

    public static function names(): array
    {
        return [
            self::ACTIVE => 'active',
            self::UNACTIVATED => 'unactivated',
        ];
    }
}
