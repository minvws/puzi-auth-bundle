<?php

declare(strict_types=1);

namespace MinVWS\AuthBundle\Security\Guard;

use Auth0\JWTAuthBundle\Security\User\UziUser;
use MinVWS\PUZI\AuthBundle\Security\PUZIService;
use MinVWS\PUZI\Exceptions\UziException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class GuardAuthenticator extends AbstractGuardAuthenticator
{
    /** @var PUZIService */
    protected $puziService;

    public function __construct(PUZIService $puziService)
    {
        $this->puziService = $puziService;
    }

    public function supports(Request $request)
    {
        return true;
    }

    public function getCredentials(Request $request): ?array
    {
        try {
            $user = $this->puziService->readFromRequest($request);
        } catch (UziException $e) {
            return null;
        }

        return [
            'puzi_user' => $user,
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        try {
            $uziUser = $this->puziService->readFromRequest($request);
        } catch (UziException $e) {
            return null;
        }

        return new UziUser($uziUser);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $responseBody = [
            'message' => sprintf(
                'Authentication failed: %s.',
                rtrim($exception->getMessage(), '.')
            ),
        ];

        return new JsonResponse($responseBody, JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $responseBody = [
            'message' => 'UZI authentication required.',
        ];

        return new JsonResponse($responseBody, JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
