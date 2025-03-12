<?php

declare(strict_types = 1);

namespace RfcTool\Service\Proposal\Vote;

final class Bag
{
    private bool                     $persist  = true;

    private ?\DateTime               $voteDate = null;

    private ?bool                    $voice    = null;

    private ?string                  $reason   = null;

    private \RfcTool\Entity\Proposal $proposal;

    private \RfcTool\Entity\User     $user;


    public function shallPersist(): bool
    {
        return $this->persist;
    }

    public function doPersist(bool $persist): Bag
    {
        $this->persist = $persist;

        return $this;
    }

    public function getVoteDate(): ?\DateTime
    {
        return $this->voteDate;
    }

    public function setVoteDate(?\DateTime $voteDate): Bag
    {
        $this->voteDate = $voteDate;

        return $this;
    }

    public function getVoice(): ?bool
    {
        return $this->voice;
    }

    public function setVoice(?bool $voice): Bag
    {
        $this->voice = $voice;

        return $this;
    }

    public function getProposal(): \RfcTool\Entity\Proposal
    {
        return $this->proposal;
    }

    public function setProposal(\RfcTool\Entity\Proposal $proposal): Bag
    {
        $this->proposal = $proposal;

        return $this;
    }

    public function getUser(): \RfcTool\Entity\User
    {
        return $this->user;
    }

    public function setUser(\RfcTool\Entity\User $user): Bag
    {
        $this->user = $user;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): Bag
    {
        $this->reason = $reason;

        return $this;
    }
}