<?php

namespace RfcTool\Service\Proposal;

class Creator
{
    public function do(\RfcTool\Service\Proposal\Creator\Bag $bag): \RfcTool\Entity\Proposal
    {
        $newProposal = new \RfcTool\Entity\Proposal()
            ->setTitle(title: $bag->getTitle())
            ->setDescription(description: $bag->getDescription())
            ->setStatus(status: $bag->getStatus())
            ->setCalculationBase(calculationBase: $bag->getCalculationBase())
            ->setGroup(group: $bag->getGroup())
            ->setVoteStart(voteStart: $bag->getVoteStart())
            ->setVoteEnd(voteEnd: $bag->getVoteEnd())
        ;
        $newProposal::getRepository()
                ->create(entity: $newProposal)
        ;


        if (true === $bag->shallPersist()) {
            \RfcTool\Util\DependencyContainer::getInstance()
                                             ->getEntityManager()
                                             ->flush()
            ;
        }

        return $newProposal;
    }
}