<?php

declare(strict_types=1);

namespace RfcToolTest\Service\User;

class InvitationCodeGeneratorTest extends \PHPUnit\Framework\TestCase
{
    public function testGetData()
    {
        $result = \RfcTool\Service\User\InvitationCodeGenerator::get();
        $this->assertNotNull(actual: $result->getCode());
        $this->assertNotNull(actual: $result->getValidUntil());
    }
}