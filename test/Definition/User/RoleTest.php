<?php

declare(strict_types=1);

namespace RfcToolTest\Definition\User;

class RoleTest extends \PHPUnit\Framework\TestCase
{
    public function testValues()
    {
        $this->assertEquals(4, \sizeof(\RfcTool\Definition\User\Role::cases()));

        $this->assertSame('guest', \RfcTool\Definition\User\Role::guest->value);
        $this->assertSame('guest', \RfcTool\Definition\User\Role::guest->name);

        $this->assertSame('user', \RfcTool\Definition\User\Role::user->value);
        $this->assertSame('user', \RfcTool\Definition\User\Role::user->name);

        $this->assertSame('manager', \RfcTool\Definition\User\Role::manager->value);
        $this->assertSame('manager', \RfcTool\Definition\User\Role::manager->name);

        $this->assertSame('admin', \RfcTool\Definition\User\Role::admin->value);
        $this->assertSame('admin', \RfcTool\Definition\User\Role::admin->name);

        $this->assertSame([
                              'guest',
                              'user',
                              'manager',
                              'admin',

                          ], \RfcTool\Definition\User\Role::getRoles());
        $this->assertSame([
                              'guest',
                              'user',
                              'manager',
                              'admin',
                          ], \RfcTool\Definition\User\Role::ALL);
    }
}