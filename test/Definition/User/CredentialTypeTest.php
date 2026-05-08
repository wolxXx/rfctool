<?php

declare(strict_types=1);

namespace RfcToolTest\Definition\User;
class CredentialTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testValues()
    {
        $this->assertEquals(2, \sizeof(\RfcTool\Definition\User\CredentialType::cases()));

        $this->assertSame('password', \RfcTool\Definition\User\CredentialType::password->value);
        $this->assertSame('password', \RfcTool\Definition\User\CredentialType::password->name);

        $this->assertSame('passkey', \RfcTool\Definition\User\CredentialType::passkey->value);
        $this->assertSame('passkey', \RfcTool\Definition\User\CredentialType::passkey->name);
    }
}