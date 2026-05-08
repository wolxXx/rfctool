<?php

declare(strict_types=1);

namespace RfcToolTest\Service\Group\Creator;

class BagTest extends \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $this->assertInstanceOf(expected: \RfcTool\Service\Group\Creator\Bag::class, actual: new \RfcTool\Service\Group\Creator\Bag());
    }

    public function testPersistFlag()
    {
        $bag = new \RfcTool\Service\Group\Creator\Bag();
        $this->assertTrue(condition: $bag->shallPersist(), message: 'test default persist flag');
        $this->assertFalse(condition: $bag->doPersist(persist: false)->shallPersist());
        $this->assertTrue(condition: $bag->doPersist(persist: true)->shallPersist());
    }

    public function testGetSetDescription()
    {
        $description = 'test description';
        $bag = new \RfcTool\Service\Group\Creator\Bag();
        $this->assertNull(actual: $bag->getDescription());
        $this->assertSame(expected: $description, actual: $bag->setDescription(description: $description)->getDescription());
        $this->assertNull(actual: $bag->setDescription(description: null)->getDescription());
    }

    public function testGetSetName()
    {
        $name = 'test name';
        $bag = new \RfcTool\Service\Group\Creator\Bag();
        $this->assertSame(expected: $name, actual: $bag->setName(name: $name)->getName());
    }

    public function testUsers()
    {
        $user1 = new \RfcTool\Entity\User();
        $user2 = new \RfcTool\Entity\User();
        $bag = new \RfcTool\Service\Group\Creator\Bag();
        $this->assertSame(expected: 0, actual: count($bag->getUsers()));

        $this->assertSame(expected: 2, actual: count(
            $bag
                ->addUser(new \RfcTool\Service\Group\Creator\UserBag()->setUser($user1))
                ->addUser(new \RfcTool\Service\Group\Creator\UserBag()->setUser($user2))
                ->getUsers()
        )
        );
        $this->assertSame(expected: 0, actual: count($bag->setUsers([])->getUsers()));


        $this->assertSame(expected: 2, actual: count(
            $bag
                ->setUsers(users: [
                    new \RfcTool\Service\Group\Creator\UserBag()->setUser(user: $user1),
                    new \RfcTool\Service\Group\Creator\UserBag()->setUser(user: $user2),
                ])
                ->getUsers()
        )
        );
    }
}
