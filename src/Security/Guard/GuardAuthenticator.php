<?php

declare(strict_types=1);

namespace MinVWS\PUZI\AuthBundle\Security\Guard;

use MinVWS\PUZI\AuthBundle\Security\PUZIService;
use MinVWS\PUZI\AuthBundle\Security\User\UziUser;
use MinVWS\PUZI\Exceptions\UziException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * Class GuardAuthenticator
 * @package MinVWS\PUZI\AuthBundle\Security\Guard
 */
class GuardAuthenticator extends AbstractGuardAuthenticator
{
    /** @var PUZIService */
    protected $puziService;

    /**
     * GuardAuthenticator constructor.
     * @param PUZIService $puziService
     */
    public function __construct(PUZIService $puziService)
    {
        $this->puziService = $puziService;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        return $request->server->get('SSL_CLIENT_CERT', "") != "";
    }

    /**
     * @param Request $request
     * @return array|null
     */
    public function getCredentials(Request $request): ?array
    {
        try {
            $user = $this->puziService->readFromRequest($request);
        } catch (UziException $e) {
            return [];
        }

        return [
            'puzi_user' => $user,
        ];
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        if (!is_array($credentials) || !isset($credentials['puzi_user'])) {
            return null;
        }

        return new UziUser($credentials['puzi_user']);
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        if (!isset($credentials['puzi_user'])) {
            return false;
        }

        return $this->puziService->validate($credentials['puzi_user']);
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse
     */
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

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return JsonResponse
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $responseBody = [
            'message' => 'UZI authentication required.',
        ];

        return new JsonResponse($responseBody, JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @return false
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
