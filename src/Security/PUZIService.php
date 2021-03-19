<?php

declare(strict_types=1);

namespace MinVWS\PUZI\AuthBundle\Security;

use MinVWS\PUZI\UziReader;
use MinVWS\PUZI\UziUser;
use MinVWS\PUZI\UziValidator;
use Symfony\Component\HttpFoundation\Request;

class PUZIService
{

    /**
     * @var UziReader
     */
    protected $reader;

    /**
     * @var UziValidator
     */
    protected $validator;

    public function __construct(UziReader $reader, UziValidator $validator)
    {
        $this->reader = $reader;
        $this->validator = $validator;
    }

    public function readFromRequest(Request $request): UziUser
    {
        return $this->reader->getDataFromRequest($request);
    }

    public function validate(UziUser $user): bool
    {
        return $this->validator->isValid($user);
    }
}
