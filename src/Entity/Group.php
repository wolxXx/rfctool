<?php

declare(strict_types=1);

namespace RfcTool\Entity;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Group\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: \RfcTool\Entity\Share\BaseTable::DEFAULT_OPTIONS,
)]
class Group
{
    use \RfcTool\Entity\Share\Id;
    use \RfcTool\Entity\Share\Repository;

    public const string TABLE_NAME = 'group';

    #[\Doctrine\ORM\Mapping\Column(
        type  : \Doctrine\DBAL\Types\Types::STRING,
        length: 255
    )]
    protected string  $name;

    #[\Doctrine\ORM\Mapping\Column(
        type    : \Doctrine\DBAL\Types\Types::TEXT,
        length  : 255,
        nullable: true
    )]
    protected ?string $description = null;

    /**
     * Many Users have Many Groups.
     *
     * @var \Doctrine\Common\Collections\Collection<int, Group>
     */
    #[\Doctrine\ORM\Mapping\ManyToMany(targetEntity: User::class, inversedBy: 'groups')]
    #[\Doctrine\ORM\Mapping\JoinTable(name: 'users_groups')]
    private \Doctrine\Common\Collections\Collection $users;

    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public static function getRepository(): Group\Repository
    {
        return static::getRepositoryByClassName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }
}