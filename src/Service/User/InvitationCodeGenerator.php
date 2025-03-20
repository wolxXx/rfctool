<?php

declare(strict_types=1);

namespace RfcTool\Service\User;

class InvitationCodeGenerator
{
    public static function get(): \RfcTool\Service\User\InvitationCodeGenerator\Result
    {
        return new \RfcTool\Service\User\InvitationCodeGenerator\Result()
            ->setCode(\Ramsey\Uuid\Uuid::uuid4()->toString() . '_' . \Ramsey\Uuid\Uuid::uuid4()->toString())
            ->setValidUntil(new \DateTime()->add(new \DateInterval('P3D'))->setTime(23, 59, 59))
        ;
    }
}