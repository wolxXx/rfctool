<?php

declare(strict_types=1);

namespace RfcTool\Service\User;

class InvitationCodeValidator
{
    public static function do(\RfcTool\Entity\User $user, string $code, \DateTime|null $now): bool
    {
        if ($user->getInvitationCode() !== $code) {
            return false;
        }
        return false;
    }
}