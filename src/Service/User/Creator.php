<?php

namespace RfcTool\Service\User;

class Creator {
    public function do(\RfcTool\Service\User\Creator\Bag $bag): \RfcTool\Entity\User
    {
        $newUser = new \RfcTool\Entity\User()
            ->setStatus($bag->getStatus())
            ->setName($bag->getName())
            ->setEmail($bag->getEmail())
            ->setRole($bag->getRole())
            ;
        $newUser::getRepository()->create($newUser);
        foreach ($bag->getCredentials() as $credential) {
            $newCredential = new \RfcTool\Entity\User\Credential()
                ->setType($credential->getType()->value)
                ->
        }
    }
}