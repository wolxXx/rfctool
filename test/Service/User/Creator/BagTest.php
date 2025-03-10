<?php

namespace RfcToolTest\Service\User\Creator;

class BagTest extends \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $this->assertInstanceOf(expected: \RfcTool\Service\User\Creator\Bag::class, actual: new \RfcTool\Service\User\Creator\Bag());
    }

    public function testPersistFlag()
    {
        $bag = new \RfcTool\Service\User\Creator\Bag();
        $this->assertTrue(condition: $bag->shallPersist(), message: 'test default persist flag');
        $this->assertFalse(condition: $bag->doPersist(persist: false)->shallPersist());
        $this->assertTrue(condition: $bag->doPersist(persist: true)->shallPersist());
    }

    public function testCredentials()
    {
        $bag = new \RfcTool\Service\User\Creator\Bag();
        $credentials = [];
        $credentials[] = new \RfcTool\Service\User\Creator\CredentialBag();
        $credentials[] = new \RfcTool\Service\User\Creator\CredentialBag();
        $bag->setCredentials(credentials: $credentials);
        $this->assertSame(expected: \count($credentials), actual: \count($bag->getCredentials()));
    }
}
