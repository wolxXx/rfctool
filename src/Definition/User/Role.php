<?php

declare(strict_types=1);

namespace RfcTool\Definition\User;


enum Role: string
{
    case guest = 'guest';

    case user = 'user';

    case manager = 'manager';

    case admin = 'admin';

    public const array ALL = [
        self::guest->value,
        self::user->value,
        self::manager->value,
        self::admin->value,
    ];

    public static function getRoles(): array
    {
        return [
            self::guest->value,
            self::user->value,
            self::manager->value,
            self::admin->value,
        ];
    }
}