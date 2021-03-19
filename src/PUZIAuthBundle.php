<?php

declare(strict_types=1);

namespace MinVWS\PUZI\AuthBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PUZIAuthBundle extends Bundle
{
    public function getAlias(): string
    {
        return 'puzi_auth';
    }
}
