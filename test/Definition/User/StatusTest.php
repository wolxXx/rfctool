<?php

declare(strict_types=1);

namespace RfcToolTest\Definition\User;

class StatusTest extends \PHPUnit\Framework\TestCase
{
    public function testValues()
    {
        $this->assertEquals(4, \sizeof(\RfcTool\Definition\User\Status::cases()));

        $this->assertSame('invited', \RfcTool\Definition\User\Status::invited->value);
        $this->assertSame('invited', \RfcTool\Definition\User\Status::invited->name);

        $this->assertSame('active', \RfcTool\Definition\User\Status::active->value);
        $this->assertSame('active', \RfcTool\Definition\User\Status::active->name);

        $this->assertSame('blocked', \RfcTool\Definition\User\Status::blocked->value);
        $this->assertSame('blocked', \RfcTool\Definition\User\Status::blocked->name);

        $this->assertSame('archived', \RfcTool\Definition\User\Status::archived->value);
        $this->assertSame('archived', \RfcTool\Definition\User\Status::archived->name);
    }
}