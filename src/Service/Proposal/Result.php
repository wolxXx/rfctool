<?php

namespace RfcTool\Service\Proposal;

class Result
{
    protected \RfcTool\Definition\Proposal\Result $result;

    protected int                                 $allowed       = 0;

    protected int                                 $notVoted      = 0;

    protected int                                 $notVotedQuote = 0;

    protected int                                 $votedQuote    = 0;

    protected int                                 $pro           = 0;

    protected int                                 $contra        = 0;

    protected int                                 $none          = 0;

    protected int                                 $proQuote      = 0;

    protected int                                 $contraQuote   = 0;

    protected int                                 $noneQuote     = 0;

    protected int                                 $voteCount     = 0;

    public function get(\RfcTool\Entity\Proposal $proposal): static
    {
        $group = $proposal->getGroup();
        if (null === $group) {
            $this->result = \RfcTool\Definition\Proposal\Result::OPEN;

            return $this;
        }

        if (null === $proposal->getVoteStart() || null === $proposal->getVoteEnd()) {
            $this->result = \RfcTool\Definition\Proposal\Result::OPEN;

            return $this;
        }

        $usersInGroupRaw = \RfcTool\Entity\UserInGroup::getRepository()->getForGroup($group);
        $usersInGroup    = [];

        $votePeriod = new \DatePeriod(start: $proposal->getVoteStart(), interval: new \DateInterval('P1D'), end: $proposal->getVoteEnd(), options: \DatePeriod::INCLUDE_END_DATE);
        foreach ($usersInGroupRaw as $userInGroup) {
            foreach ($votePeriod as $dayInPeriod) {
                if ($userInGroup->getBeginDate() <= $dayInPeriod && (null === $userInGroup->getEndDate() || $dayInPeriod <= $userInGroup->getEndDate())) {
                    $usersInGroup[$userInGroup->getUser()->getId()] = $userInGroup->getUser();
                    continue 2;
                }
            }
        }

        $this->allowed = \count($usersInGroup);

        if (0 === $this->allowed) {
            $this->result = \RfcTool\Definition\Proposal\Result::ILLEGAL;

            return $this;
        }

        $votes = \RfcTool\Entity\Proposal\Vote::getRepository()
                                              ->createQueryBuilder('vote')
                                              ->andWhere('vote.proposal = :proposal')
                                              ->setParameter('proposal', $proposal)
                                              ->getQuery()
                                              ->execute()
        ;
        foreach ($votes as $vote) {
            $this->voteCount++;
            if (true === $vote->getVoice()) {
                $this->pro++;
                continue;
            }
            if (false === $vote->getVoice()) {
                $this->contra++;
                continue;
            }
            $this->none++;
        }

        if (0 === $this->voteCount) {
            $this->result = \RfcTool\Definition\Proposal\Result::OPEN;

            return $this;
        }

        $this->proQuote      = (int)\floor(100 / $this->voteCount) * $this->pro;
        $this->contraQuote   = (int)\floor(100 / $this->voteCount) * $this->contra;
        $this->noneQuote     = (int)\floor(100 / $this->voteCount) * $this->none;
        $this->notVoted      = $this->allowed - $this->voteCount;
        $this->notVotedQuote = (int)\floor(100 / $this->allowed) * ($this->allowed - $this->voteCount);
        $this->votedQuote    = (int)\floor(100 / $this->allowed) * $this->voteCount;

        switch ($proposal->getCalculationBase()) {
            case \RfcTool\Definition\Proposal\CalculationBase::ALL:
            {
                $this->result = $this->allowed !== $this->pro ? \RfcTool\Definition\Proposal\Result::REJECTED : \RfcTool\Definition\Proposal\Result::ACCEPTED;

                return $this;
            }
            case \RfcTool\Definition\Proposal\CalculationBase::ALL_PRESENT:
            {
                $this->result = $this->voteCount !== $this->pro ? \RfcTool\Definition\Proposal\Result::REJECTED : \RfcTool\Definition\Proposal\Result::ACCEPTED;

                return $this;
            }
            case \RfcTool\Definition\Proposal\CalculationBase::SIMPLE_MAJORITY:
            {
                if ($this->pro === $this->contra) {
                    $this->result = \RfcTool\Definition\Proposal\Result::DRAW;

                    return $this;
                }

                $this->result = $this->pro > $this->contra ? \RfcTool\Definition\Proposal\Result::ACCEPTED : \RfcTool\Definition\Proposal\Result::REJECTED;

                return $this;
            }
            case \RfcTool\Definition\Proposal\CalculationBase::MAJORITY:
            {
                $this->result = $this->pro >= 50 ? \RfcTool\Definition\Proposal\Result::ACCEPTED : \RfcTool\Definition\Proposal\Result::REJECTED;

                return $this;
            }
            case \RfcTool\Definition\Proposal\CalculationBase::TWO_THIRDS:
            {
                $this->result = $this->pro >= 66 ? \RfcTool\Definition\Proposal\Result::ACCEPTED : \RfcTool\Definition\Proposal\Result::REJECTED;

                return $this;
            }
            case \RfcTool\Definition\Proposal\CalculationBase::THREE_QUARTERS:
            {
                $this->result = $this->pro >= 75 ? \RfcTool\Definition\Proposal\Result::ACCEPTED : \RfcTool\Definition\Proposal\Result::REJECTED;

                return $this;
            }
            default:
            {
                throw new \InvalidArgumentException('Unknown calculation base: ' . $proposal->getCalculationBase()->value);
            }
        }
    }

    public function getResult(): \RfcTool\Definition\Proposal\Result
    {
        return $this->result;
    }

    public function getAllowed(): int
    {
        return $this->allowed;
    }

    public function getPro(): int
    {
        return $this->pro;
    }

    public function getContra(): int
    {
        return $this->contra;
    }

    public function getNone(): int
    {
        return $this->none;
    }

    public function getProQuote(): int
    {
        return $this->proQuote;
    }

    public function getContraQuote(): int
    {
        return $this->contraQuote;
    }

    public function getNoneQuote(): int
    {
        return $this->noneQuote;
    }

    public function getVoteCount(): int
    {
        return $this->voteCount;
    }

    public function getNotVoted(): int
    {
        return $this->notVoted;
    }

    public function getNotVotedQuote(): int
    {
        return $this->notVotedQuote;
    }

    public function getVotedQuote(): int
    {
        return $this->votedQuote;
    }
}