<?php

declare(strict_types=1);

namespace RfcTool\Service\User\Creator;

final class Bag
{
    private string                          $name;

    private string                          $email;

    private \RfcTool\Definition\User\Role   $role;

    private \RfcTool\Definition\User\Status $status = \RfcTool\Definition\User\Status::invited;

    /**
     * @var CredentialBag[]
     */
    private array $credentials = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Bag
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Bag
    {
        $this->email = $email;

        return $this;
    }

    public function getRole(): \RfcTool\Definition\User\Role
    {
        return $this->role;
    }

    public function setRole(\RfcTool\Definition\User\Role $role): Bag
    {
        $this->role = $role;

        return $this;
    }

    public function getStatus(): \RfcTool\Definition\User\Status
    {
        return $this->status;
    }

    public function setStatus(\RfcTool\Definition\User\Status $status): Bag
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return CredentialBag[]
     */
    public function getCredentials(): array
    {
        return $this->credentials;
    }

    public function setCredentials(array $credentials): Bag
    {
        $this->credentials = [];
        foreach ($credentials as $credential) {
            $this->addCredential($credential);
        }

        return $this;
    }

    public function addCredentials(array $credentials): Bag
    {
        foreach ($credentials as $credential) {
            $this->addCredential($credential);
        }

        return $this;
    }

    public function addCredential(CredentialBag $bag): Bag
    {
        $this->credentials[] = $bag;

        return $this;
    }
}