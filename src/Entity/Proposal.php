<?php

declare(strict_types = 1);

namespace RfcTool\Entity;


#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Proposal\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: \RfcTool\Entity\Share\BaseTable::DEFAULT_OPTIONS,
)]
class Proposal
{
    use \RfcTool\Entity\Share\Blame;
    use \RfcTool\Entity\Share\Id;
    use \RfcTool\Entity\Share\Repository;
    use \RfcTool\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'proposal';


    #[\Doctrine\ORM\Mapping\Column(
        type  : \Doctrine\DBAL\Types\Types::STRING,
        length: 255
    )]
    protected string     $title;

    #[\Doctrine\ORM\Mapping\Column(
        type  : \Doctrine\DBAL\Types\Types::STRING,
        length: 255
    )]
    protected string     $status;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'vote_start',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime $voteStart = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'vote_end',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime $voteEnd = null;



    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \RfcTool\Entity\Group::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'group_id',
        nullable: false,
        onDelete: 'CASCADE',
    )]
    protected \RfcTool\Entity\Group $group {
        get {
            if ($this->modified) {
                return $this->foo . ' (modified)';
            }
            return $this->foo;
        }
        set(\RfcTool\Definition\User\CredentialType $value) {
            $this->foo = strtolower($value->value);
        }
    }

    public function __construct() {
    }


    public static function getRepository(): User\Repository
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTime $lastLogin): static
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getRole(): \RfcTool\Definition\User\Role
    {
        return \RfcTool\Definition\User\Role::from(value: $this->role);
    }

    public function setRole(\RfcTool\Definition\User\Role $role): static
    {
        $this->role = $role->value;

        return $this;
    }

    public function getStatus(): \RfcTool\Definition\User\Status
    {
        return \RfcTool\Definition\User\Status::from(value: $this->status);
    }

    public function setStatus(\RfcTool\Definition\User\Status $status): static
    {
        $this->status = $status->value;

        return $this;
    }
}