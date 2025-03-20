<?php

declare(strict_types=1);

namespace RfcTool\Service\User\InvitationCodeGenerator;

class Result
{
    protected string    $code;

    protected \DateTime $validUntil;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getValidUntil(): \DateTime
    {
        return $this->validUntil;
    }

    public function setValidUntil(\DateTime $validUntil): static
    {
        $this->validUntil = $validUntil;

        return $this;
    }
}