<?php

declare(strict_types=1);

namespace RfcTool\Service\User\Creator;

final class CredentialBag
{
    private ?string                                 $password = null;

    private \RfcTool\Definition\User\CredentialType $type;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): CredentialBag
    {
        $this->password = $password;

        return $this;
    }

    public function getType(): \RfcTool\Definition\User\CredentialType
    {
        return $this->type;
    }

    public function setType(\RfcTool\Definition\User\CredentialType $type): CredentialBag
    {
        $this->type = $type;

        return $this;
    }
}