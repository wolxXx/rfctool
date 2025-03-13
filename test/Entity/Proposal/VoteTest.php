<?php

declare(strict_types=1);

namespace RfcToolTest\Entity\Proposal;

class VoteTest extends \PHPUnit\Framework\TestCase
{
    public function testGetRepository()
    {
        $this->assertInstanceOf(\RfcTool\Entity\Proposal\Vote\Repository::class, \RfcTool\Entity\Proposal\Vote::getRepository());
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(expected: \RfcTool\Entity\Proposal\Vote::class, actual: new \RfcTool\Entity\Proposal\Vote());
    }

    public function testProperties()
    {
        $entity = new \RfcTool\Entity\Proposal\Vote();
        $id = 1234;
        $reason = 'test';
        $user = new \RfcTool\Entity\User()->setId(id: 1337);
        $proposal = new \RfcTool\Entity\Proposal()->setId(id: 42);

        $this->assertSame(expected: $id, actual: $entity->setId(id: $id)->getId());
        $this->assertSame(expected: null, actual: $entity->setVoice(voice: null)->getVoice());
        $this->assertTrue(condition: $entity->setVoice(voice: true)->getVoice());
        $this->assertFalse(condition: $entity->setVoice(voice: false)->getVoice());

        $this->assertNull($entity->getReason());
        $this->assertSame(expected: $reason, actual: $entity->setReason(reason: $reason)->getReason());

        $this->assertSame(expected: $user->getId(), actual: $entity->setUser(user: $user)->getUser()->getId());
        $this->assertSame(expected: $proposal->getId(), actual: $entity->setProposal(proposal: $proposal)->getProposal()->getId());
    }
}
