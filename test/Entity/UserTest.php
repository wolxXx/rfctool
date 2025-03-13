<?php

declare(strict_types=1);

namespace RfcToolTest\Entity;

class UserTest extends \PHPUnit\Framework\TestCase
{

    public function testGetRepository()
    {
        $this->assertInstanceOf(\RfcTool\Entity\User\Repository::class, \RfcTool\Entity\User::getRepository());
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf(expected: \RfcTool\Entity\User::class, actual: new \RfcTool\Entity\User());
    }

    public function testProperties()
    {
        $entity = new \RfcTool\Entity\User();
        $id = 1234;
        $name = 'test';
        $email = 'test@test.test';
        $date = new \DateTime('2018-01-01 00:00:00');
        $role = \RfcTool\Definition\User\Role::manager;
        $status = \RfcTool\Definition\User\Status::active;
        $this->assertSame(expected: $id, actual: $entity->setId(id: $id)->getId());
        $this->assertSame(expected: $name, actual: $entity->setName(name: $name)->getName());
        $this->assertNull(actual: $entity->getLastLogin());
        $this->assertSame(expected: $date->format('Y-m-d'), actual: $entity->setLastLogin(lastLogin: $date)->getLastLogin()->format('Y-m-d'));
        $this->assertSame(expected: $email, actual: $entity->setEmail(email: $email)->getEmail());
        $this->assertSame(expected: $role, actual: $entity->setRole(role: $role)->getRole());
        $this->assertSame(expected: $status, actual: $entity->setStatus(status: $status)->getStatus());
    }
}
