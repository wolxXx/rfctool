<?php

declare(strict_types=1);

namespace RfcToolTest\Entity;

class UserInGroupTest extends \PHPUnit\Framework\TestCase
{
    public function testGetRepository()
    {
        $this->assertInstanceOf(\RfcTool\Entity\UserInGroup\Repository::class, \RfcTool\Entity\UserInGroup::getRepository());
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(expected: \RfcTool\Entity\UserInGroup::class, actual: new \RfcTool\Entity\UserInGroup());
    }

    public function testProperties()
    {
        $group = new \RfcTool\Entity\Group()->setId(1234);
        $user = new \RfcTool\Entity\User()->setId(1337);
        $entity = new \RfcTool\Entity\UserInGroup();
        $id = 1234;
        $beginDate = new \DateTime('2018-01-01 00:00:00');
        $this->assertSame(expected: $id, actual: $entity->setId(id: $id)->getId());
        $this->assertSame(expected: $beginDate->format('Y-m-d'), actual: $entity->setBeginDate(beginDate: $beginDate)->getBeginDate()->format('Y-m-d'));
        $this->assertNull($entity->getEndDate());
        $this->assertSame(expected: $beginDate->format('Y-m-d'), actual: $entity->setEndDate(endDate: $beginDate)->getEndDate()->format('Y-m-d'));
        $this->assertSame(expected: $group->getId(), actual: $entity->setGroup(group: $group)->getGroup()->getId());
        $this->assertSame(expected: $user->getId(), actual: $entity->setUser(user: $user)->getUser()->getId());
    }
}
