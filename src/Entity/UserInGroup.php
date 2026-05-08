<?php

declare(strict_types = 1);

namespace RfcTool\Entity;


#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: UserInGroup\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: \RfcTool\Entity\Share\BaseTable::DEFAULT_OPTIONS,
)]
class UserInGroup
{
    use \RfcTool\Entity\Share\Blame;
    use \RfcTool\Entity\Share\Id;
    use \RfcTool\Entity\Share\Repository;
    use \RfcTool\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'user_in_group';

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'begin_date',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
    )]
    protected \DateTime                                   $beginDate;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'end_date',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime                                   $endDate  = null;


    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \RfcTool\Entity\Group::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name    : 'group_id',
        nullable: false,
        onDelete: 'CASCADE',
    )]
    protected \RfcTool\Entity\Group                       $group;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \RfcTool\Entity\User::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name    : 'user_id',
        nullable: false,
        onDelete: 'CASCADE',
    )]
    protected \RfcTool\Entity\User                       $user;


    public static function getRepository(): UserInGroup\Repository
    {
        return static::getRepositoryByClassName();
    }

    public function getBeginDate(): \DateTime
    {
        return $this->beginDate;
    }

    public function setBeginDate(\DateTime $beginDate): static
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function setGroup(Group $group): static
    {
        $this->group = $group;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }
}