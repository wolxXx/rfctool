<?php

namespace RfcTool\Service\User;

class Creator
{
    public function do(\RfcTool\Service\User\Creator\Bag $bag): \RfcTool\Entity\User
    {
        $newUser = new \RfcTool\Entity\User()
            ->setStatus(status: $bag->getStatus())
            ->setName(name: $bag->getName())
            ->setEmail(email: $bag->getEmail())
            ->setRole(role: $bag->getRole())
        ;
        $newUser::getRepository()
                ->create(entity: $newUser)
        ;
        foreach ($bag->getCredentials() as $credential) {
            $newCredential = new \RfcTool\Entity\User\Credential()
                ->setUser(user: $newUser)
                ->setType(type: $credential->getType())
                ->setPassword(password: $credential->getPassword())
                ->setName(name: $credential->getType()->value)
            ;
            $newCredential::getRepository()
                          ->create($newCredential)
            ;
        }

        if (true === $bag->shallPersist()) {
            \RfcTool\Util\DependencyContainer::getInstance()
                                             ->getEntityManager()
                                             ->flush()
            ;
        }

        return $newUser;
    }
}