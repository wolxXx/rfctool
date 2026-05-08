<?php

declare(strict_types=1);

namespace RfcToolTest\Entity;

class ProposalTest extends \PHPUnit\Framework\TestCase
{
    public function testGetRepository()
    {
        $this->assertInstanceOf(\RfcTool\Entity\Proposal\Repository::class, \RfcTool\Entity\Proposal::getRepository());
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(expected: \RfcTool\Entity\Proposal::class, actual: new \RfcTool\Entity\Proposal());
    }

    public function testProperties()
    {
        $entity = new \RfcTool\Entity\Proposal();
        $id = 1234;
        $title = 'test';
        $description = 'test description';
        $date = new \DateTime('2018-01-01 00:00:00');
        $status = \RfcTool\Definition\Proposal\Status::PREPARE;
        $group = new \RfcTool\Entity\Group()->setId(1337);
        $calculationBase = \RfcTool\Definition\Proposal\CalculationBase::ALL_PRESENT;
        $this->assertSame(expected: $id, actual: $entity->setId(id: $id)->getId());
        $this->assertSame(expected: $title, actual: $entity->setTitle(title: $title)->getTitle());
        $this->assertNull($entity->getDescription());
        $this->assertSame(expected: $description, actual: $entity->setDescription(description: $description)->getDescription());
        $this->assertNull(actual: $entity->getVoteStart());
        $this->assertSame(expected: $date->format(format: 'Y-m-d'), actual: $entity->setVoteStart(voteStart: $date)->getVoteStart()->format(format: 'Y-m-d'));
        $this->assertNull(actual: $entity->getVoteEnd());
        $this->assertSame(expected: $date->format(format: 'Y-m-d'), actual: $entity->setVoteEnd(voteEnd: $date)->getVoteStart()->format(format: 'Y-m-d'));
        $this->assertSame(expected: $status, actual: $entity->setStatus(status: $status)->getStatus());
        $this->assertNull($entity->getGroup());
        $this->assertSame(expected: $group->getId(), actual: $entity->setGroup(group: $group)->getGroup()->getId());
        $this->assertSame(expected: $calculationBase, actual: $entity->setCalculationBase(calculationBase: $calculationBase)->getCalculationBase());
    }
}
