<?php

namespace MinVWS\PUZI\AuthBundle\Tests;

use MinVWS\PUZI\AuthBundle\PUZIAuthBundle;
use PHPUnit\Framework\TestCase;

class PUZIAuthBundleTest extends TestCase
{
    public function testBuild()
    {
        $bundle = new PUZIAuthBundle();

        $this->assertEquals('puzi_auth', $bundle->getAlias());
    }
}
