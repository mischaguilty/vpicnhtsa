<?php

namespace Mischa\Vpicnhtsa;

use Illuminate\Support\Facades\Facade;


class VpicnhtsaFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'vpicnhtsa';
    }
}
