<?php

declare(strict_types=1);

namespace RfcToolTest\Util\View;

class BooleanTest extends \RfcToolTest\TestBase
{
    public function testGetTrue()
    {
        $this->assertSame(expected: 'ja', actual: \RfcTool\Util\View\Boolean::get(value: true));
    }


    public function testGetFalse()
    {
        $this->assertSame(expected: 'nein', actual: \RfcTool\Util\View\Boolean::get(value: false));
    }

    public function testGetFailsWithOtherThanBoolean()
    {
        $this->expectException(exception: \TypeError::class);
        \RfcTool\Util\View\Boolean::get(value: 'asdf');
    }
}