<?php

declare(strict_types=1);

namespace RfcToolTest\Service\User;

class InvitationCodeValidatorTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $code       = '1234567890';
        $validUntil = new \DateTime('2020-01-01 00:00:00');
        $now        = new \DateTime('2020-01-02 00:00:00');
        $user       = new \RfcTool\Entity\User()
            ->setStatus(\RfcTool\Definition\User\Status::invited)
            ->setInvitationCode($code)
            ->setInvitationCodeValidUntil($validUntil)
        ;
        $this->assertFalse(\RfcTool\Service\User\InvitationCodeValidator::do($user, $code, $now));
        $this->assertNotNull(\RfcTool\Service\User\InvitationCodeValidator::getLastError());
        $this->assertSame(\RfcTool\Service\User\InvitationCodeValidator\Error::CODE_EXPIRED->value, \RfcTool\Service\User\InvitationCodeValidator::getLastError()->value);

        $this->assertFalse(\RfcTool\Service\User\InvitationCodeValidator::do($user, 'another code', $now));
        $this->assertNotNull(\RfcTool\Service\User\InvitationCodeValidator::getLastError());
        $this->assertSame(\RfcTool\Service\User\InvitationCodeValidator\Error::CODE_NOT_FOUND->value, \RfcTool\Service\User\InvitationCodeValidator::getLastError()->value);

        $this->assertFalse(\RfcTool\Service\User\InvitationCodeValidator::do($user, '', $now));
        $this->assertNotNull(\RfcTool\Service\User\InvitationCodeValidator::getLastError());
        $this->assertSame(\RfcTool\Service\User\InvitationCodeValidator\Error::CODE_NOT_FOUND->value, \RfcTool\Service\User\InvitationCodeValidator::getLastError()->value);

        $this->assertFalse(\RfcTool\Service\User\InvitationCodeValidator::do($user, ''. 1234 .'', $now));
        $this->assertNotNull(\RfcTool\Service\User\InvitationCodeValidator::getLastError());
        $this->assertSame(\RfcTool\Service\User\InvitationCodeValidator\Error::CODE_NOT_FOUND->value, \RfcTool\Service\User\InvitationCodeValidator::getLastError()->value);

        $this->assertTrue(\RfcTool\Service\User\InvitationCodeValidator::do($user, $code, $now->sub(new \DateInterval('P3D'))));
        $this->assertNull(\RfcTool\Service\User\InvitationCodeValidator::getLastError());
    }
}