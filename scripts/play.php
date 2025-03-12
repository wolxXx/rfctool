<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

#tidyup
{
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

    \RfcTool\Util\DependencyContainer::getInstance()
                                     ->getEntityManager()
                                     ->flush()
    ;
}

$user1 = new \RfcTool\Service\User\Creator()
    ->do(
        bag: new \RfcTool\Service\User\Creator\Bag()
                 ->doPersist(true)
                 ->setRole(role: \RfcTool\Definition\User\Role::user)
                 ->setEmail(email: 'user1@rfc.tool')
                 ->setName(name: 'user1')
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
                                    ->setBeginDate(new \DateTime('2021-01-01'))
                            ])

        ,
    )
;


$proposal1 = new \RfcTool\Entity\Proposal();
$proposal2 = new \RfcTool\Entity\Proposal();
$proposal3 = new \RfcTool\Entity\Proposal();
