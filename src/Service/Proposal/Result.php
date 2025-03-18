<?php

namespace RfcTool\Service\Proposal;

class Result
{
    protected \RfcTool\Entity\Proposal $proposal;

    protected \RfcTool\Definition\Proposal\Result $result;

    protected int $allowed = 0;

    protected int $notVoted = 0;

    protected int $notVotedQuote = 0;

    protected int $votedQuote = 0;

    protected int $pro = 0;

    protected int $contra = 0;

    protected int $none = 0;

    protected int $proQuote = 0;

    protected int $contraQuote = 0;

    protected int $noneQuote = 0;

    protected int $voteCount = 0;

    public function get(\RfcTool\Entity\Proposal $proposal): static
    {
        $this->proposal = $proposal;
        if (true === $this->isProposalOpen()) {
            $this->result = \RfcTool\Definition\Proposal\Result::OPEN;

            return $this;
        }

        $this->countAllowed();

        if (0 === $this->allowed) {
            $this->result = \RfcTool\Definition\Proposal\Result::ILLEGAL;

            return $this;
        }

        $this->countVotes();

        if (0 === $this->voteCount) {
            $this->result = \RfcTool\Definition\Proposal\Result::REJECTED;

            return $this;
        }

        return $this
            ->grabQuotes()
            ->calculateResult($proposal->getCalculationBase())
            ;
    }


    private function calculateResult(\RfcTool\Definition\Proposal\CalculationBase $calculationBase): static
    {
        return match ($calculationBase) {
            \RfcTool\Definition\Proposal\CalculationBase::ALL => $this->calculateOnAllBase(),
            \RfcTool\Definition\Proposal\CalculationBase::ALL_PRESENT => $this->calculateOnAllPresentBase(),
            \RfcTool\Definition\Proposal\CalculationBase::SIMPLE_MAJORITY => $this->calculateOnSimpleMajorityBase(),
            \RfcTool\Definition\Proposal\CalculationBase::MAJORITY => $this->calculateOnMajorityBase(),
            \RfcTool\Definition\Proposal\CalculationBase::TWO_THIRDS => $this->calculateOnTwoThirdsBase(),
            \RfcTool\Definition\Proposal\CalculationBase::THREE_QUARTERS => $this->calculateOnThreeQuartersBase(),
            default => throw new \InvalidArgumentException('Unknown calculation base: ' . $calculationBase->value)
        };
    }


    protected function isProposalOpen(): bool
    {
        return
                null === $this->proposal->getGroup()
            ||  null === $this->proposal->getVoteStart()
            ||  null === $this->proposal->getVoteEnd()
            ;
    }


    protected function getVotePeriod(): \DatePeriod
    {
        return new \DatePeriod(start: $this->proposal->getVoteStart(), interval: new \DateInterval('P1D'), end: $this->proposal->getVoteEnd(), options: \DatePeriod::INCLUDE_END_DATE);
    }

    /**
     * @return \RfcTool\Entity\Proposal\Vote[]
     */
    protected function getVotes(): array
    {
        return \RfcTool\Entity\Proposal\Vote::getRepository()
            ->createQueryBuilder('vote')
            ->andWhere('vote.proposal = :proposal')
            ->setParameter('proposal', $this->proposal)
            ->getQuery()
            ->execute();
    }

    protected function countVotes(): static
    {
        $votes = $this->getVotes();
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

        return $this;
    }

    protected function grabQuotes(): static
    {
        $this->proQuote = (int)\floor(100 / $this->voteCount) * $this->pro;
        $this->contraQuote = (int)\floor(100 / $this->voteCount) * $this->contra;
        $this->noneQuote = (int)\floor(100 / $this->voteCount) * $this->none;
        $this->notVoted = $this->allowed - $this->voteCount;
        $this->notVotedQuote = (int)\floor(100 / $this->allowed) * ($this->allowed - $this->voteCount);
        $this->votedQuote = (int)\floor(100 / $this->allowed) * $this->voteCount;

        return $this;
    }

    protected function countAllowed(): static
    {
        $usersInGroupRaw = \RfcTool\Entity\UserInGroup::getRepository()->getForGroup($this->proposal->getGroup());
        $usersInGroup = [];
        $votePeriod = $this->getVotePeriod();

        foreach ($usersInGroupRaw as $userInGroup) {
            foreach ($votePeriod as $dayInPeriod) {
                if ($userInGroup->getBeginDate() <= $dayInPeriod && (null === $userInGroup->getEndDate() || $dayInPeriod <= $userInGroup->getEndDate())) {
                    $usersInGroup[$userInGroup->getUser()->getId()] = $userInGroup->getUser();
                    continue 2;
                }
            }
        }

        $this->allowed = \count($usersInGroup);

        return $this;
    }

    protected function calculateOnAllBase(): static
    {
        $this->result = $this->allowed !== $this->pro ? \RfcTool\Definition\Proposal\Result::REJECTED : \RfcTool\Definition\Proposal\Result::ACCEPTED;

        return $this;
    }

    protected function calculateOnAllPresentBase(): static
    {
        $this->result = $this->voteCount !== $this->pro ? \RfcTool\Definition\Proposal\Result::REJECTED : \RfcTool\Definition\Proposal\Result::ACCEPTED;

        return $this;
    }

    protected function calculateOnSimpleMajorityBase(): static
    {
        if ($this->pro === $this->contra) {
            $this->result = \RfcTool\Definition\Proposal\Result::DRAW;

            return $this;
        }

        $this->result = $this->pro > $this->contra ? \RfcTool\Definition\Proposal\Result::ACCEPTED : \RfcTool\Definition\Proposal\Result::REJECTED;

        return $this;
    }

    protected function calculateOnMajorityBase(): static
    {
        $this->result = $this->pro >= 50 ? \RfcTool\Definition\Proposal\Result::ACCEPTED : \RfcTool\Definition\Proposal\Result::REJECTED;

        return $this;
    }

    protected function calculateOnTwoThirdsBase(): static
    {
        $this->result = $this->pro >= 66 ? \RfcTool\Definition\Proposal\Result::ACCEPTED : \RfcTool\Definition\Proposal\Result::REJECTED;

        return $this;
    }

    protected function calculateOnThreeQuartersBase(): static
    {
        $this->result = $this->pro >= 75 ? \RfcTool\Definition\Proposal\Result::ACCEPTED : \RfcTool\Definition\Proposal\Result::REJECTED;

        return $this;
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