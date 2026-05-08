<?php

declare(strict_types = 1);

namespace RfcTool\Service\Group\Creator;

final class Bag
{
    private bool    $persist     = true;

    private string  $name;

    private ?string $description = null;

    /**
     * @var \RfcTool\Service\Group\Creator\UserBag[]
     */
    private array $users;

    public function __construct()
    {
        $this->users = [];
    }

    public function shallPersist(): bool
    {
        return $this->persist;
    }

    public function doPersist(bool $persist): Bag
    {
        $this->persist = $persist;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Bag
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Bag
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return \RfcTool\Service\Group\Creator\UserBag[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @param \RfcTool\Service\Group\Creator\UserBag[] $users
     */
    public function setUsers(array $users): Bag
    {
        $this->users = [];
        foreach ($users as $user) {
            $this->addUser($user);
        }

        return $this;
    }

    public function addUser(UserBag $bag): Bag
    {
        $this->users[] = $bag;

        return $this;
    }
}