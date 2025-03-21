<?php

declare(strict_types=1);

namespace RfcTool\Service\User;

class InvitationCodeValidator
{
    protected static ?\RfcTool\Service\User\InvitationCodeValidator\Error $lastError = null;

    public static function do(\RfcTool\Entity\User $user, string $code, \DateTime|null $now): bool
    {
        if ($user->getStatus()->value !== \RfcTool\Definition\User\Status::invited->value) {
            static::$lastError = \RfcTool\Service\User\InvitationCodeValidator\Error::USER_NOT_INVITED;

            return false;
        }
        if ($user->getInvitationCode() !== $code) {
            static::$lastError = \RfcTool\Service\User\InvitationCodeValidator\Error::CODE_NOT_FOUND;

            return false;
        }
        if (null === $user->getInvitationCodeValidUntil()) {
            static::$lastError = \RfcTool\Service\User\InvitationCodeValidator\Error::CODE_EXPIRED;

            return false;
        }
        if (null === $now) {
            $now = \Carbon\Carbon::now();
        }
        if ($now > $user->getInvitationCodeValidUntil()) {
            static::$lastError = \RfcTool\Service\User\InvitationCodeValidator\Error::CODE_EXPIRED;

            return false;
        }

        static::$lastError = null;

        return true;
    }

    public static function getLastError(): ?\RfcTool\Service\User\InvitationCodeValidator\Error
    {
        return static::$lastError;
    }
}