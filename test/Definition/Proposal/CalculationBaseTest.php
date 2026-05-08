<?php

declare(strict_types=1);

namespace RfcToolTest\Definition\Proposal;
class CalculationBaseTest extends \PHPUnit\Framework\TestCase
{
    public function testValues()
    {
        $this->assertEquals(6, \sizeof(\RfcTool\Definition\Proposal\CalculationBase::cases()));

        $this->assertSame('majority', \RfcTool\Definition\Proposal\CalculationBase::MAJORITY->value);
        $this->assertSame('MAJORITY', \RfcTool\Definition\Proposal\CalculationBase::MAJORITY->name);

        $this->assertSame('two-thirds', \RfcTool\Definition\Proposal\CalculationBase::TWO_THIRDS->value);
        $this->assertSame('TWO_THIRDS', \RfcTool\Definition\Proposal\CalculationBase::TWO_THIRDS->name);

        $this->assertSame('three-quarters', \RfcTool\Definition\Proposal\CalculationBase::THREE_QUARTERS->value);
        $this->assertSame('THREE_QUARTERS', \RfcTool\Definition\Proposal\CalculationBase::THREE_QUARTERS->name);

        $this->assertSame('simple-majority', \RfcTool\Definition\Proposal\CalculationBase::SIMPLE_MAJORITY->value);
        $this->assertSame('SIMPLE_MAJORITY', \RfcTool\Definition\Proposal\CalculationBase::SIMPLE_MAJORITY->name);

        $this->assertSame('all', \RfcTool\Definition\Proposal\CalculationBase::ALL->value);
        $this->assertSame('ALL', \RfcTool\Definition\Proposal\CalculationBase::ALL->name);

        $this->assertSame('all-present', \RfcTool\Definition\Proposal\CalculationBase::ALL_PRESENT->value);
        $this->assertSame('ALL_PRESENT', \RfcTool\Definition\Proposal\CalculationBase::ALL_PRESENT->name);
    }
}