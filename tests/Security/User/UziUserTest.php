<?php

namespace MinVWS\PUZI\AuthBundle\Tests\Security\User;

use MinVWS\PUZI\UziUser;
use PHPUnit\Framework\TestCase;

class UziUserTest extends TestCase
{
    public function testUser()
    {
        $base = new UziUser();
        $base->setGivenName('john');
        $base->setSurName('doe');
        $base->setSubscriberNumber('12345');

        $user = new \MinVWS\PUZI\AuthBundle\Security\User\UziUser($base);
        $this->assertEquals('12345', $user->getUsername());
        $this->assertTrue(in_array('ROLE_USER', $user->getRoles()));
        $this->assertTrue(in_array('ROLE_UZI', $user->getRoles()));

        $this->assertEquals('john', $user->getUziUser()->getGivenName());
    }
}
