<?php

declare(strict_types = 1);

namespace RfcTool\Entity\Proposal;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Vote\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: \RfcTool\Entity\Share\BaseTable::DEFAULT_OPTIONS,
)]
#[\Doctrine\ORM\Mapping\UniqueConstraint(
    name   : 'proposal_user_unique',
    columns: [
        'proposal_id',
        'user_id',
    ],
)]
class Vote
{
    use \RfcTool\Entity\Share\Blame;
    use \RfcTool\Entity\Share\Id;
    use \RfcTool\Entity\Share\Repository;
    use \RfcTool\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'proposal_vote';

    #[\Doctrine\ORM\Mapping\Column(
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: true,
    )]
    protected ?bool                    $voice  = null;

    #[\Doctrine\ORM\Mapping\Column(
        type    : \Doctrine\DBAL\Types\Types::TEXT,
        length  : 255,
        nullable: true
    )]
    protected ?string                  $reason = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \RfcTool\Entity\User::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: false,
        onDelete: 'RESTRICT',
    )]
    protected \RfcTool\Entity\User     $user;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \RfcTool\Entity\Proposal::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: false,
        onDelete: 'CASCADE',
    )]
    protected \RfcTool\Entity\Proposal $proposal;

    public static function getRepository(): Vote\Repository
    {
        return static::getRepositoryByClassName();
    }

    public function getVoice(): ?bool
    {
        return $this->voice;
    }

    public function setVoice(?bool $voice): static
    {
        $this->voice = $voice;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): static
    {
        $this->reason = $reason;

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

    public function getProposal(): \RfcTool\Entity\Proposal
    {
        return $this->proposal;
    }

    public function setProposal(\RfcTool\Entity\Proposal $proposal): static
    {
        $this->proposal = $proposal;

        return $this;
    }
}