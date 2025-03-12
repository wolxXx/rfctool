<?php

namespace RfcTool\Service\Proposal;

class Vote
{
    public function set(\RfcTool\Service\Proposal\Vote\Bag $bag): \RfcTool\Entity\Proposal\Vote
    {
        $proposal = $bag->getProposal();
        $group    = $proposal->getGroup();
        $user     = $bag->getUser();
        if (null === $group) {
            throw new \RfcTool\Exception\VoteNotAllowedDueTimeSlot();
        }

        $now = $bag->getVoteDate() ?? \Carbon\Carbon::now();

        $isMember = \RfcTool\Entity\UserInGroup::getRepository()
                                               ->isMember(user: $user, group: $group, now: $now)
        ;
        if (false === $isMember) {
            throw new \RfcTool\Exception\VoteNotAllowedDueGroupMembership();
        }
        if (null !== $proposal->getVoteStart() || $proposal->getVoteEnd()) {
            throw new \RfcTool\Exception\VoteNotAllowedDueTimeSlot();
        }
        if ($proposal->getVoteStart() > $now || $proposal->getVoteEnd() < $now) {
            throw new \RfcTool\Exception\VoteNotAllowedDueTimeSlot();
        }

        $existingVote = \RfcTool\Entity\Proposal\Vote::getRepository()
                                                     ->findForUserAndProposal(user: $user, proposal: $proposal)
        ;
        if (true === $existingVote instanceof \RfcTool\Entity\Proposal\Vote) {
            $existingVote
                ->setVoice($bag->getVoice())
                ->setReason($bag->getReason())
            ;
            $existingVote::getRepository()
                         ->update(entity: $existingVote)
            ;
            if (true === $bag->shallPersist()) {
                \RfcTool\Util\DependencyContainer::getInstance()
                                                 ->getEntityManager()
                                                 ->flush()
                ;
            }

            return $existingVote;
        }

        $newVote = new \RfcTool\Entity\Proposal\Vote()
            ->setProposal(proposal: $proposal)
            ->setUser(user: $user)
            ->setVoice($bag->getVoice())
            ->setReason($bag->getReason())
        ;
        $newVote::getRepository()
                ->create($newVote)
        ;
        if (true === $bag->shallPersist()) {
            \RfcTool\Util\DependencyContainer::getInstance()
                                             ->getEntityManager()
                                             ->flush()
            ;
        }


        return $newVote;
    }
}