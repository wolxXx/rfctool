<?php

declare(strict_types=1);

namespace RfcToolTest\Service\Group;

class CreatorTest extends \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $this->assertInstanceOf(expected: \RfcTool\Service\Group\Creator::class, actual: new \RfcTool\Service\Group\Creator());
    }

    public function testNoUsers()
    {
        $name = 'test group';
        $description = 'test description';
        $group = new \RfcTool\Service\Group\Creator()
            ->do(
                bag: new \RfcTool\Service\Group\Creator\Bag()
                    ->doPersist(true)
                    ->setName($name)
                    ->setDescription($description)
            );

        $this->assertSame(expected: $name, actual: $group->getName());
        $this->assertSame(expected: $description, actual: $group->getDescription());
        $this->assertSame(expected: 1, actual: $group->getId());
    }

    public function testWithUsers()
    {
        $user1 = new \RfcTool\Service\User\Creator()
            ->do(
                bag: new \RfcTool\Service\User\Creator\Bag()
                    ->doPersist(true)
                    ->setName('user1')
                    ->setEmail(\Faker\Factory::create()->email())
                    ->setRole(\RfcTool\Definition\User\Role::user)
            )
            ;
        $name = 'test group';
        $description = 'test description';
        $group = new \RfcTool\Service\Group\Creator()
            ->do(
                bag: new \RfcTool\Service\Group\Creator\Bag()
                    ->doPersist(true)
                    ->setName($name)
                    ->setDescription($description)
                    ->addUser(
                        new \RfcTool\Service\Group\Creator\UserBag()
                            ->setUser($user1)
                            ->setBeginDate(new \DateTime('2020-01-01'))
                    )
            );

        $usersInGroup = \RfcTool\Entity\UserInGroup::getRepository()->getForGroup($group);
        $this->assertSame(expected: 1, actual: count($usersInGroup));
        $this->assertSame(expected: $user1->getName(), actual: $usersInGroup[0]->getUser()->getName());
    }
}
