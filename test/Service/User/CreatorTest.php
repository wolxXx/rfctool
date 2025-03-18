<?php

declare(strict_types=1);

namespace RfcToolTest\Service\User;

class CreatorTest extends \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $this->assertInstanceOf(expected: \RfcTool\Service\User\Creator::class, actual: new \RfcTool\Service\User\Creator());
    }

    public function testDo()
    {
        $creator = new \RfcTool\Service\User\Creator();
        $name = 'test';
        $role = \RfcTool\Definition\User\Role::user;
        $email = \Faker\Factory::create()->email();
        $password = '<PASSWORD>';

        $group = new \RfcTool\Service\Group\Creator()
            ->do(
                bag: new \RfcTool\Service\Group\Creator\Bag()
                    ->setName('test group')
                ->setDescription('test description')
            )
            ;

        $user = $creator->do(
            bag: new \RfcTool\Service\User\Creator\Bag()
                ->doPersist(true)
                ->setName(name: $name)
                ->setRole($role)
                ->setEmail($email)
                ->setGroups([
                    new \RfcTool\Service\User\Creator\GroupBag()
                    ->setGroup($group)
                    ->setBeginDate(new \DateTime('2020-01-01'))
                ])
                ->setCredentials([
                    new \RfcTool\Service\User\Creator\CredentialBag()
                        ->setPassword($password)
                        ->setType(\RfcTool\Definition\User\CredentialType::password)
                    ,
                ])
        );
        $this->assertInstanceOf(expected: \RfcTool\Entity\User::class, actual: $user);
        $this->assertSame(expected: $name, actual: $user->getName());
        $this->assertSame(expected: $role, actual: $user->getRole());
        $this->assertSame(expected: $email, actual: $user->getEmail());
        $this->assertSame(expected: 1, actual: count($user->getCredentials()));
        $this->assertSame(expected: $password, actual: $user->getCredentials()[0]->getPassword());
        $this->assertSame(expected: \RfcTool\Definition\User\CredentialType::password, actual: $user->getCredentials()[0]->getType());

        $userInGroups = \RfcTool\Entity\UserInGroup::getRepository()
            ->getForUser($user)
        ;
        $this->assertSame(expected: 1, actual: count($userInGroups));
        $this->assertSame(expected: $group->getId(), actual: $userInGroups[0]->getGroup()->getId());
    }
}
