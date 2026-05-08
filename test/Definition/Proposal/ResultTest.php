<?php

declare(strict_types=1);

namespace RfcToolTest\Definition\Proposal;
class ResultTest extends \PHPUnit\Framework\TestCase
{
    public function testValues()
    {
        $this->assertEquals(5, \sizeof(\RfcTool\Definition\Proposal\Result::cases()));

        $this->assertSame('open', \RfcTool\Definition\Proposal\Result::OPEN->value);
        $this->assertSame('OPEN', \RfcTool\Definition\Proposal\Result::OPEN->name);

        $this->assertSame('accepted', \RfcTool\Definition\Proposal\Result::ACCEPTED->value);
        $this->assertSame('ACCEPTED', \RfcTool\Definition\Proposal\Result::ACCEPTED->name);

        $this->assertSame('rejected', \RfcTool\Definition\Proposal\Result::REJECTED->value);
        $this->assertSame('REJECTED', \RfcTool\Definition\Proposal\Result::REJECTED->name);

        $this->assertSame('draw', \RfcTool\Definition\Proposal\Result::DRAW->value);
        $this->assertSame('DRAW', \RfcTool\Definition\Proposal\Result::DRAW->name);

        $this->assertSame('illegal', \RfcTool\Definition\Proposal\Result::ILLEGAL->value);
        $this->assertSame('ILLEGAL', \RfcTool\Definition\Proposal\Result::ILLEGAL->name);
    }
}