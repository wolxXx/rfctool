<?php

namespace RfcTool\Service\Group;

class Creator
{
    public function do(\RfcTool\Service\Group\Creator\Bag $bag): \RfcTool\Entity\Group
    {
        $newGroup = new \RfcTool\Entity\Group()
            ->setName(name: $bag->getName())
            ->setDescription(description: $bag->getDescription())
        ;
        $newGroup::getRepository()
                 ->create(entity: $newGroup)
        ;

        foreach ($bag->getUsers() as $user) {
            $userInGroup = new \RfcTool\Entity\UserInGroup()
                ->setGroup(group: $newGroup)
                ->setUser(user: $user->getUser())
                ->setBeginDate(beginDate: $user->getBeginDate())
                ->setEndDate(endDate: $user->getEndDate())
            ;
            $userInGroup::getRepository()
                        ->create($userInGroup)
            ;
        }

        if (true === $bag->shallPersist()) {
            \RfcTool\Util\DependencyContainer::getInstance()
                                             ->getEntityManager()
                                             ->flush()
            ;
        }

        return $newGroup;
    }
}