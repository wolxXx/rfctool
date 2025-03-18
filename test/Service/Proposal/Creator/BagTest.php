<?php

declare(strict_types = 1);

namespace RfcToolTest\Service\Proposal\Creator;

class BagTest extends
    \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $this->assertInstanceOf(expected: \RfcTool\Service\Proposal\Creator\Bag::class, actual: new \RfcTool\Service\Proposal\Creator\Bag());
    }

    public function testPersistFlag()
    {
        $bag = new \RfcTool\Service\Proposal\Creator\Bag();
        $this->assertTrue(condition: $bag->shallPersist(), message: 'test default persist flag');
        $this->assertFalse(condition: $bag
                                          ->doPersist(persist: false)
                                          ->shallPersist());
        $this->assertTrue(condition: $bag
                                         ->doPersist(persist: true)
                                         ->shallPersist());
    }

    public function testGetSetTitle()
    {
        $bag = new \RfcTool\Service\Proposal\Creator\Bag();
        $title = 'test title';
        $this->assertSame(expected: $title, actual: $bag->setTitle(title: $title)->getTitle());
    }

    public function testGetSetDescription()
    {
        $bag = new \RfcTool\Service\Proposal\Creator\Bag();
        $description = 'test description';
        $this->assertNull(actual: $bag->getDescription());
        $this->assertSame(expected: $description, actual: $bag->setTitle(title: $description)->getTitle());
        $this->assertNull(actual: $bag->setDescription(description: null)->getDescription());
    }

    public function testGetSetStatus()
    {
        $bag = new \RfcTool\Service\Proposal\Creator\Bag();
        $status = \RfcTool\Definition\Proposal\Status::FINISHED;
        $this->assertSame(expected: $status->value, actual: $bag->setStatus(status: $status)->getStatus()->value);
    }

    public function testGetSetCalculationBase()
    {
        $bag = new \RfcTool\Service\Proposal\Creator\Bag();
        $calculationBase = \RfcTool\Definition\Proposal\CalculationBase::SIMPLE_MAJORITY;
        $this->assertSame(expected: $calculationBase->value, actual: $bag->setCalculationBase(calculationBase: $calculationBase)->getCalculationBase()->value);
    }


    public function testGetSetVoteStart()
    {
        $bag = new \RfcTool\Service\Proposal\Creator\Bag();
        $voteStart = new \DateTime(datetime: '2018-01-01 00:00:00');
        $this->assertNull(actual: $bag->getVoteStart());
        $this->assertSame(expected: $voteStart->format(format: 'Y-m-d H:i:s'), actual: $bag->setVoteStart(voteStart: $voteStart)->getVoteStart()->format(format: 'Y-m-d H:i:s'));
        $this->assertNull(actual: $bag->setVoteStart(voteStart: null)->getVoteStart());
    }


    public function testGetSetVoteEnd()
    {
        $bag = new \RfcTool\Service\Proposal\Creator\Bag();
        $voteEnd = new \DateTime(datetime: '2018-01-01 00:00:00');
        $this->assertNull(actual: $bag->getVoteEnd());
        $this->assertSame(expected: $voteEnd->format(format: 'Y-m-d H:i:s'), actual: $bag->setVoteEnd(voteEnd: $voteEnd)->getVoteEnd()->format(format: 'Y-m-d H:i:s'));
        $this->assertNull(actual: $bag->setVoteEnd(voteEnd: null)->getVoteEnd());
    }

}
