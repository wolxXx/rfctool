<?php

declare(strict_types=1);

namespace RfcTool\Service\User\InvitationCodeValidator;

enum Error: int
{
    case INVALID_CODE     = 1;

    case CODE_EXPIRED     = 2;

    case CODE_NOT_FOUND   = 4;

    case USER_NOT_INVITED = 8;
}