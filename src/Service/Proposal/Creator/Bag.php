<?php

declare(strict_types = 1);

namespace RfcTool\Service\Proposal\Creator;

final class Bag
{
    private bool                                         $persist     = true;

    private string                                       $title;

    private ?string                                      $description = null;

    private \RfcTool\Definition\Proposal\Status          $status;

    private \RfcTool\Definition\Proposal\CalculationBase $calculationBase;

    private ?\DateTime                                   $voteStart   = null;

    private ?\DateTime                                   $voteEnd     = null;

    private ?\RfcTool\Entity\Group                       $group       = null;


    public function shallPersist(): bool
    {
        return $this->persist;
    }

    public function doPersist(bool $persist): Bag
    {
        $this->persist = $persist;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Bag
    {
        $this->title = $title;

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

    public function getStatus(): \RfcTool\Definition\Proposal\Status
    {
        return $this->status;
    }

    public function setStatus(\RfcTool\Definition\Proposal\Status $status): Bag
    {
        $this->status = $status;

        return $this;
    }

    public function getCalculationBase(): \RfcTool\Definition\Proposal\CalculationBase
    {
        return $this->calculationBase;
    }

    public function setCalculationBase(\RfcTool\Definition\Proposal\CalculationBase $calculationBase): Bag
    {
        $this->calculationBase = $calculationBase;

        return $this;
    }

    public function getVoteStart(): ?\DateTime
    {
        return $this->voteStart;
    }

    public function setVoteStart(?\DateTime $voteStart): Bag
    {
        $this->voteStart = $voteStart;

        return $this;
    }

    public function getVoteEnd(): ?\DateTime
    {
        return $this->voteEnd;
    }

    public function setVoteEnd(?\DateTime $voteEnd): Bag
    {
        $this->voteEnd = $voteEnd;

        return $this;
    }

    public function getGroup(): ?\RfcTool\Entity\Group
    {
        return $this->group;
    }

    public function setGroup(?\RfcTool\Entity\Group $group): Bag
    {
        $this->group = $group;

        return $this;
    }
}