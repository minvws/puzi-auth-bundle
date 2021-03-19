<?php

declare(strict_types=1);

namespace MinVWS\PUZI\AuthBundle\Security\User;

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

    /**
     * @return void
     */
    public function eraseCredentials()
    {
    }

    public function getUziUser(): \MinVWS\PUZI\UziUser
    {
        return $this->uzi;
    }
}
