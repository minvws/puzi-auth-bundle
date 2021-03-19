<?php

namespace MinVWS\PUZI\AuthBundle\Tests\Security\Guard;

use MinVWS\PUZI\AuthBundle\Security\Guard\GuardAuthenticator;
use MinVWS\PUZI\AuthBundle\Security\PUZIService;
use MinVWS\PUZI\Exceptions\UziException;
use MinVWS\PUZI\UziUser;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GuardAuthenticatorTest extends TestCase
{
    public function testSupports()
    {
        $mockService = Mockery::mock(PUZIService::class);
        $guard = new GuardAuthenticator($mockService);

        $request = new Request();
        $this->assertFalse($guard->supports($request));

        $request->server->set('SSL_CLIENT_CERT', 'foobar');
        $this->assertTrue($guard->supports($request));
    }

    public function testGetCredentials()
    {
        $mockService = Mockery::mock(PUZIService::class);
        $guard = new GuardAuthenticator($mockService);

        $uziUser = new UziUser();
        $uziUser->setSubscriberNumber('12345');
        $mockService->shouldReceive('readFromRequest')->andReturn($uziUser);

        $request = new Request();
        $resp = $guard->getCredentials($request);
        $this->assertEquals($resp['puzi_user'], $uziUser);
    }

    public function testGetCredentialsWithException()
    {
        $mockService = Mockery::mock(PUZIService::class);
        $mockService->shouldReceive('readFromRequest')->andThrows(new UziException());
        $guard = new GuardAuthenticator($mockService);

        $request = new Request();
        $resp = $guard->getCredentials($request);
        $this->assertCount(0, $resp);
    }

    public function testGetUserWithInvalidData()
    {
        $mockService = Mockery::mock(PUZIService::class);
        $guard = new GuardAuthenticator($mockService);

        $mockProvider = Mockery::mock(UserProviderInterface::class);
        $this->assertNull($guard->getUser(null, $mockProvider));
        $this->assertNull($guard->getUser([], $mockProvider));
        $this->assertNull($guard->getUser("foobar", $mockProvider));

        $this->expectException(\TypeError::class);
        $guard->getUser(['puzi_user' => 'foobar'], $mockProvider);
    }

    public function testRememberMe()
    {
        $mockService = Mockery::mock(PUZIService::class);
        $guard = new GuardAuthenticator($mockService);

        $this->assertFalse($guard->supportsRememberMe());
    }
}
