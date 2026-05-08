<?php

declare(strict_types=1);

namespace RfcToolTest\Service\Group\Creator;

class UserBagTest extends \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $this->assertInstanceOf(expected: \RfcTool\Service\Group\Creator\UserBag::class, actual: new \RfcTool\Service\Group\Creator\UserBag());
    }


    /**
     * @return void
     */
    public function testBeginDate()
    {
        $bag = new \RfcTool\Service\Group\Creator\UserBag();
        $date = new \DateTime();
        $this->assertSame(expected: $date->format(format: 'Y-m-d'), actual: $bag->setBeginDate($date)->getBeginDate()->format(format: 'Y-m-d'));
    }

    public function testEndDate()
    {
        $bag = new \RfcTool\Service\Group\Creator\UserBag();
        $date = new \DateTime();
        $this->assertNull($bag->getEndDate());
        $this->assertSame(expected: $date->format(format: 'Y-m-d'), actual: $bag->setEndDate($date)->getEndDate()->format(format: 'Y-m-d'));
        $this->assertNull($bag->setEndDate(endDate: null)->getEndDate());
    }

    public function testUser()
    {
        $bag = new \RfcTool\Service\Group\Creator\UserBag();
        $user = new \RfcTool\Entity\User()->setId(id: 1234);
        $this->assertSame(expected: $user->getId(), actual: $bag->setUser(user: $user)->getUser()->getId());
    }
}
