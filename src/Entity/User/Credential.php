<?php

declare(strict_types=1);

namespace RfcTool\Entity\User;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Credential\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: \RfcTool\Entity\Share\BaseTable::DEFAULT_OPTIONS,
)]
class Credential
{
    use \RfcTool\Entity\Share\Id;
    use \RfcTool\Entity\Share\Repository;

    public const string TABLE_NAME = 'user_credential';

    #[\Doctrine\ORM\Mapping\Column(
        type  : \Doctrine\DBAL\Types\Types::STRING,
        length: 255
    )]
    protected string                                  $name;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'type',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        enumType: \RfcTool\Definition\User\CredentialType::class,
    )]
    protected \RfcTool\Definition\User\CredentialType $type;

    #[\Doctrine\ORM\Mapping\Column(
        type    : \Doctrine\DBAL\Types\Types::TEXT,
        length  : 255,
        nullable: true
    )]
    protected ?string              $note     = null;

    #[\Doctrine\ORM\Mapping\Column(
        type    : \Doctrine\DBAL\Types\Types::TEXT,
        length  : 255,
        nullable: true
    )]
    protected ?string              $password = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'last_used',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime           $lastUsed = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \RfcTool\Entity\User::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: false,
        onDelete: 'CASCADE',
    )]
    protected \RfcTool\Entity\User $user;

    public static function getRepository(): Credential\Repository
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

    public function getType(): \RfcTool\Definition\User\CredentialType
    {
        return $this->type;
    }

    public function setType(\RfcTool\Definition\User\CredentialType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getUser(): \RfcTool\Entity\User
    {
        return $this->user;
    }

    public function setUser(\RfcTool\Entity\User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getLastUsed(): ?\DateTime
    {
        return $this->lastUsed;
    }

    public function setLastUsed(?\DateTime $lastUsed): static
    {
        $this->lastUsed = $lastUsed;

        return $this;
    }
}