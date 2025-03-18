<?php

declare(strict_types=1);

namespace RfcToolTest\Util\View;

class DateTimeTest extends \RfcToolTest\TestBase
{
    public function testGetForNull()
    {
        $this->assertSame(expected: '-', actual: \RfcTool\Util\View\DateTime::getDate(dateTime: null));
    }
    public function testGetForDate()
    {
        $this->assertSame(expected: '<nobr>01.01.2024</nobr>', actual: \RfcTool\Util\View\DateTime::getDate(dateTime: new \DateTime(datetime: '2024-01-01 12:34:56')));
    }
    public function testGetMediumDateMediumTimeForNull()
    {
        $this->assertSame(expected: '-', actual: \RfcTool\Util\View\DateTime::getDateTimeMediumDateMediumTime(dateTime: null));
    }
    public function testGetMediumDateMediumTimeForDate()
    {
        $this->assertSame(expected: '<nobr>01.01.2024, 12:34:56</nobr>', actual: \RfcTool\Util\View\DateTime::getDateTimeMediumDateMediumTime(dateTime: new \DateTime(datetime: '2024-01-01 12:34:56')));
    }
    public function testGetMediumDateShorTimeForNull()
    {
        $this->assertSame(expected: '-', actual: \RfcTool\Util\View\DateTime::getDateTimeMediumDateShortTime(dateTime: null));
    }
    public function testGetMediumDateShortTimeForDate()
    {
        $this->assertSame(expected: '<nobr>01.01.2024, 12:34</nobr>', actual: \RfcTool\Util\View\DateTime::getDateTimeMediumDateShortTime(dateTime: new \DateTime(datetime: '2024-01-01 12:34:56')));
    }
}