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
    protected string                                       $title;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'status',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        enumType: \RfcTool\Definition\Proposal\Status::class,
    )]
    protected \RfcTool\Definition\Proposal\Status          $status;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'calculation_base',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        enumType: \RfcTool\Definition\Proposal\CalculationBase::class,
    )]
    protected \RfcTool\Definition\Proposal\CalculationBase $calculationBase;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'vote_start',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime                                   $voteStart = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'vote_end',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime                                   $voteEnd   = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \RfcTool\Entity\Group::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name    : 'group_id',
        nullable: false,
        onDelete: 'CASCADE',
    )]
    protected \RfcTool\Entity\Group                        $group;

    public function __construct() {}


    public static function getRepository(): Proposal\Repository
    {
        return static::getRepositoryByClassName();
    }


    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Proposal
    {
        $this->title = $title;

        return $this;
    }

    public function getCalculationBase(): \RfcTool\Definition\Proposal\CalculationBase
    {
        return $this->calculationBase;
    }

    public function setCalculationBase(\RfcTool\Definition\Proposal\CalculationBase $calculationBase): Proposal
    {
        $this->calculationBase = $calculationBase;

        return $this;
    }

    public function getVoteStart(): ?\DateTime
    {
        return $this->voteStart;
    }

    public function setVoteStart(?\DateTime $voteStart): Proposal
    {
        $this->voteStart = $voteStart;

        return $this;
    }

    public function getVoteEnd(): ?\DateTime
    {
        return $this->voteEnd;
    }

    public function setVoteEnd(?\DateTime $voteEnd): Proposal
    {
        $this->voteEnd = $voteEnd;

        return $this;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function setGroup(Group $group): Proposal
    {
        $this->group = $group;

        return $this;
    }

    public function getStatus(): \RfcTool\Definition\Proposal\Status
    {
        return $this->status;
    }

    public function setStatus(\RfcTool\Definition\Proposal\Status $status): Proposal
    {
        $this->status = $status;

        return $this;
    }
}