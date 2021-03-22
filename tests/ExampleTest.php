<?php

namespace Mischaguilty\Vpicnhtsa\Tests;

use Orchestra\Testbench\TestCase;
use Mischaguilty\Vpicnhtsa\VpicnhtsaServiceProvider;

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
