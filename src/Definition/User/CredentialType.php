<?php

declare(strict_types=1);

namespace RfcTool\Definition\User;

enum CredentialType: string
{
    case password = 'password';

    case passkey  = 'passkey';
}