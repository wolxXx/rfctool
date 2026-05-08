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
        $code = '123456';
        $codeValidUntil = new \DateTime('2011-11-11 12:34:56');
        $codeUsed = new \DateTime('2001-01-01 12:34:56');
        $this->assertSame(expected: $id, actual: $entity->setId(id: $id)->getId());
        $this->assertSame(expected: $name, actual: $entity->setName(name: $name)->getName());
        $this->assertNull(actual: $entity->getLastLogin());
        $this->assertSame(expected: $date->format(format: 'Y-m-d'), actual: $entity->setLastLogin(lastLogin: $date)->getLastLogin()->format(format: 'Y-m-d'));
        $this->assertSame(expected: $email, actual: $entity->setEmail(email: $email)->getEmail());
        $this->assertSame(expected: $role, actual: $entity->setRole(role: $role)->getRole());
        $this->assertSame(expected: $status, actual: $entity->setStatus(status: $status)->getStatus());

        $this->assertNull($entity->getInvitationCode());
        $this->assertSame(expected: $code, actual: $entity->setInvitationCode(invitationCode: $code)->getInvitationCode());
        $this->assertNull($entity->setInvitationCode(invitationCode: null)->getInvitationCode());

        $this->assertNull($entity->getInvitationCodeValidUntil());
        $this->assertSame(expected: $codeValidUntil->format(format: 'Y-m-d H:i:s'), actual: $entity->setInvitationCodeValidUntil(invitationCodeValidUntil: $codeValidUntil)->getInvitationCodeValidUntil()->format(format: 'Y-m-d H:i:s'));
        $this->assertNull($entity->setInvitationCodeValidUntil(invitationCodeValidUntil: null)->getInvitationCodeValidUntil());
    }
}
