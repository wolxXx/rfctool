<?php

declare(strict_types=1);

namespace RfcToolTest\Definition\Proposal;
class StatusTest extends \PHPUnit\Framework\TestCase
{
    public function testValues()
    {
        $this->assertEquals(4, \sizeof(\RfcTool\Definition\Proposal\Status::cases()));

        $this->assertSame('prepare', \RfcTool\Definition\Proposal\Status::PREPARE->value);
        $this->assertSame('PREPARE', \RfcTool\Definition\Proposal\Status::PREPARE->name);

        $this->assertSame('ready-to-vote', \RfcTool\Definition\Proposal\Status::READY_TO_VOTE->value);
        $this->assertSame('READY_TO_VOTE', \RfcTool\Definition\Proposal\Status::READY_TO_VOTE->name);

        $this->assertSame('voting', \RfcTool\Definition\Proposal\Status::VOTING->value);
        $this->assertSame('VOTING', \RfcTool\Definition\Proposal\Status::VOTING->name);

        $this->assertSame('finished', \RfcTool\Definition\Proposal\Status::FINISHED->value);
        $this->assertSame('FINISHED', \RfcTool\Definition\Proposal\Status::FINISHED->name);
    }
}