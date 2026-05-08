<?php

declare(strict_types=1);

namespace RfcTool\Definition\User;

enum Status: string
{
    case invited  = 'invited';

    case active   = 'active';

    case blocked  = 'blocked';

    case archived = 'archived';
}