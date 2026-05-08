<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

#tidyup
{
    foreach (\RfcTool\Entity\Proposal::getRepository()->findBy(criteria: ['title' => 'test proposal 1']) as $proposal) {
        $proposal::getRepository()->delete($proposal);
    }
    $user1 = \RfcTool\Entity\User::getRepository()
                                 ->findByEmail(email: 'user1@rfc.tool')
    ;
    if (true === $user1 instanceof \RfcTool\Entity\User) {
        $user1::getRepository()
              ->delete($user1)
        ;
    }
    $user2 = \RfcTool\Entity\User::getRepository()
                                 ->findByEmail(email: 'user2@rfc.tool')
    ;
    if (true === $user2 instanceof \RfcTool\Entity\User) {
        $user2::getRepository()
              ->delete($user2)
        ;
    }
    $user3 = \RfcTool\Entity\User::getRepository()
                                 ->findByEmail(email: 'user3@rfc.tool')
    ;
    if (true === $user3 instanceof \RfcTool\Entity\User) {
        $user3::getRepository()
              ->delete($user3)
        ;
    }

    foreach (\RfcTool\Entity\Group::getRepository()->findBy(criteria: ['name' => 'playGroup']) as $group) {
        $group::getRepository()->delete($group);
    }

    \RfcTool\Util\DependencyContainer::getInstance()
                                     ->getEntityManager()
                                     ->flush()
    ;
}

$user1Invitation = \RfcTool\Service\User\InvitationCodeGenerator::get();
$user1           = new \RfcTool\Service\User\Creator()
    ->do(
        bag: new \RfcTool\Service\User\Creator\Bag()
                 ->doPersist(true)
                 ->setRole(role: \RfcTool\Definition\User\Role::user)
                 ->setEmail(email: 'user1@rfc.tool')
                 ->setName(name: 'user1 11')
                 ->setInvitationCode(invitationCode: $user1Invitation->getCode())
                 ->setInvitationCodeValidUntil(invitationCodeValidUntil: $user1Invitation->getValidUntil())
        ,
    )
;

$user2 = new \RfcTool\Service\User\Creator()
    ->do(
        bag: new \RfcTool\Service\User\Creator\Bag()
                 ->doPersist(true)
                 ->setRole(role: \RfcTool\Definition\User\Role::user)
                 ->setEmail(email: 'user2@rfc.tool')
                 ->setName(name: 'user2')
        ,
    )
;

$user3 = new \RfcTool\Service\User\Creator()
    ->do(
        bag: new \RfcTool\Service\User\Creator\Bag()
                 ->doPersist(true)
                 ->setRole(role: \RfcTool\Definition\User\Role::user)
                 ->setEmail(email: 'user3@rfc.tool')
                 ->setName(name: 'user3')
        ,
    )
;
\RfcTool\Util\DependencyContainer::getInstance()
                                 ->getEntityManager()
                                 ->flush()
;

$group = new \RfcTool\Service\Group\Creator()
    ->do(
        bag: new \RfcTool\Service\Group\Creator\Bag()
                 ->doPersist(persist: true)
                 ->setName(name: 'playGroup')
                 ->setDescription(description: 'playGroup')
                 ->setUsers([
                                new \RfcTool\Service\Group\Creator\UserBag()
                                    ->setUser($user1)
                                    ->setBeginDate(new \DateTime('2020-01-01')),
                                new \RfcTool\Service\Group\Creator\UserBag()
                                    ->setUser($user2)
                                    ->setBeginDate(new \DateTime('2020-01-01'))
                                    ->setEndDate(new \DateTime('2020-12-31')),
                                new \RfcTool\Service\Group\Creator\UserBag()
                                    ->setUser($user3)
                                    ->setBeginDate(new \DateTime('2020-01-01'))
                                    ->setEndDate(new \DateTime('2020-12-31')),
                                new \RfcTool\Service\Group\Creator\UserBag()
                                    ->setUser($user3)
                                    ->setBeginDate(new \DateTime('2021-01-01')),
                            ])

        ,
    )
;

$proposal1 = new \RfcTool\Service\Proposal\Creator()
    ->do(
        bag: new \RfcTool\Service\Proposal\Creator\Bag()
                 ->doPersist(persist: true)
                 ->setStatus(status: \RfcTool\Definition\Proposal\Status::PREPARE)
                 ->setDescription(description: 'test proposal 1')
                 ->setTitle(title: 'test proposal 1')
                 ->setCalculationBase(calculationBase: \RfcTool\Definition\Proposal\CalculationBase::SIMPLE_MAJORITY)
                 ->setGroup(group: $group)
                 ->setVoteStart(voteStart: new \DateTime('2020-01-01'))
                 ->setVoteEnd(voteEnd: new \DateTime('2020-01-15'))
    )
;
$vote      = new \RfcTool\Service\Proposal\Vote()
    ->set(
        bag: new \RfcTool\Service\Proposal\Vote\Bag()
                 ->setProposal(proposal: $proposal1)
                 ->setUser($user1)
                 ->setVoice(true)
                 ->setReason('test reason')
                 ->setVoteDate(voteDate: new \DateTime('2020-01-10'))
    )
;

$vote = new \RfcTool\Service\Proposal\Vote()
    ->set(
        bag: new \RfcTool\Service\Proposal\Vote\Bag()
                 ->setProposal(proposal: $proposal1)
                 ->setUser($user2)
                 ->setVoice(false)
                 ->setReason('test reason 2')
                 ->setVoteDate(voteDate: new \DateTime('2020-01-10'))
    )
;
$vote = new \RfcTool\Service\Proposal\Vote()
    ->set(
        bag: new \RfcTool\Service\Proposal\Vote\Bag()
                 ->setProposal(proposal: $proposal1)
                 ->setUser($user2)
                 ->setVoice(null)
                 ->setReason('test reason 2')
                 ->setVoteDate(voteDate: new \DateTime('2020-01-10'))
    )
;
