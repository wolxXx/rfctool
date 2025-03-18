<?php

declare(strict_types=1);

namespace RfcToolTest\Util;


class ErrorStoreTest extends \RfcToolTest\TestBase
{
    public function testInstantiation()
    {
        $this->assertSame(expected: \get_class(object: new \RfcTool\Util\ErrorStore()), actual: \RfcTool\Util\ErrorStore::class);
    }

    public function testHasError()
    {
        $store = new \RfcTool\Util\ErrorStore();
        $this->assertFalse($store->hasError('key'));
        $store->addError('key', 'value');
        $this->assertTrue($store->hasError('key'));
    }

    public function testGetErrors()
    {
        $store = new \RfcTool\Util\ErrorStore();
        $this->assertSame(expected: [], actual: $store->getErrors('key'));
        $store->addError('key', 'value');
        $this->assertSame(expected: ['value'], actual: $store->getErrors('key'));
    }

    #[\PHPUnit\Framework\Attributes\After]
    public function testGetAllErrors()
    {
        $store = new \RfcTool\Util\ErrorStore();
        $this->assertSame(expected: [], actual: $store->getAllErrors());
        $store->addError('key1', 'value1');
        $store->addError('key2', 'value2');
        $this->assertSame(expected: ['key1' => ['value1'], 'key2' => ['value2']], actual: $store->getAllErrors());
    }
}