<?php

declare(strict_types=1);

namespace Auth0\JWTAuthBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

class UziUser implements UserInterface
{
    /** @var \MinVWS\PUZI\UziUser */
    protected $uzi;

    /**
     * UziUser constructor.
     *
     * @param \MinVWS\PUZI\UziUser $uzi
     */
    public function __construct(\MinVWS\PUZI\UziUser $uzi)
    {
        $this->uzi = $uzi;
    }

    public function getRoles()
    {
        return ["ROLE_USER", "ROLE_UZI"];
    }

    public function getPassword()
    {
        return "";
    }

    public function getSalt()
    {
        return "";
    }

    public function getUsername()
    {
        return $this->uzi->getSubscriberNumber();
    }

    public function eraseCredentials()
    {
    }

    public function GetUziUser(): \MinVWS\PUZI\UziUser
    {
        return $this->uzi;
    }

}
