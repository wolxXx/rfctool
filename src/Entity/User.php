<?php

declare(strict_types=1);

namespace RfcTool\Entity;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: User\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: \RfcTool\Entity\Share\BaseTable::DEFAULT_OPTIONS,
)]
class User
{
    use \RfcTool\Entity\Share\Blame;
    use \RfcTool\Entity\Share\Id;
    use \RfcTool\Entity\Share\Repository;
    use \RfcTool\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'user';

    #[\Doctrine\ORM\Mapping\Column(
        type  : \Doctrine\DBAL\Types\Types::STRING,
        length: 255
    )]
    protected string                          $role;

    #[\Doctrine\ORM\Mapping\Column(
        type  : \Doctrine\DBAL\Types\Types::STRING,
        length: 255
    )]
    protected string                          $name;

    #[\Doctrine\ORM\Mapping\Column(
        type  : \Doctrine\DBAL\Types\Types::STRING,
        length: 255,
        unique: true
    )]
    protected string                          $email;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'status',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        enumType: \RfcTool\Definition\User\Status::class,
    )]
    protected \RfcTool\Definition\User\Status $status;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'last_login',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime                      $lastLogin = null;


    #[\Doctrine\ORM\Mapping\Column(
        name: 'invitation_code',
        type: \Doctrine\DBAL\Types\Types::STRING,
        length: 255,
        nullable: true
    )]
    protected string $invitationCode;

    #[\Doctrine\ORM\Mapping\Column(
        name: 'invitation_code_valid_until',
        type: \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime $invitationCodeValidUntil = null;

    #[\Doctrine\ORM\Mapping\OneToMany(
        targetEntity: \RfcTool\Entity\User\Credential::class,
        mappedBy: 'user'
    )]
    protected \Doctrine\Common\Collections\Collection $credentials;

    public function __construct()
    {
        $this->credentials = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public static function getRepository(): User\Repository
    {
        return static::getRepositoryByClassName();
    }


    /**
     * @return \RfcTool\Entity\User\Credential[]
     */
    public function getCredentials(): array
    {
        return $this
            ->credentials
            ->toArray();
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
        return $this->status;
    }

    public function setStatus(\RfcTool\Definition\User\Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getInvitationCode(): string
    {
        return $this->invitationCode;
    }

    public function setInvitationCode(string $invitationCode): static
    {
        $this->invitationCode = $invitationCode;

        return $this;
    }

    public function getInvitationCodeValidUntil(): ?\DateTime
    {
        return $this->invitationCodeValidUntil;
    }

    public function setInvitationCodeValidUntil(?\DateTime $invitationCodeValidUntil): static
    {
        $this->invitationCodeValidUntil = $invitationCodeValidUntil;

        return $this;
    }
}