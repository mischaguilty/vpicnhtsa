<?php

namespace Mischa\Vpicnhtsa\Tests;

use Orchestra\Testbench\TestCase;
use Mischa\Vpicnhtsa\VpicnhtsaServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [VpicnhtsaServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
