<?php

namespace RfcToolTest\Service\User\Creator;

class BagTest extends \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $this->assertInstanceOf(\RfcTool\Service\User\Creator\Bag::class, new \RfcTool\Service\User\Creator\Bag());
    }

    public function testPersistFlag()
    {
        $bag = new \RfcTool\Service\User\Creator\Bag();
        $this->assertTrue($bag->shallPersist(), 'test default persist flag');
        $this->assertFalse($bag->doPersist(false)->shallPersist());
        $this->assertTrue($bag->doPersist(true)->shallPersist());
    }

    public function testCredentials()
    {
        $bag = new \RfcTool\Service\User\Creator\Bag();
        $credentials = new \RfcTool\Service\User\Creator\CredentialList()
            ->push(new \RfcTool\Service\User\Creator\CredentialBag())
            ->push(new \RfcTool\Service\User\Creator\CredentialBag())
        ;
        $bag->setCredentials($credentials);
        $this->assertSame($credentials->count(), $bag->getCredentials()->count());
    }
}
