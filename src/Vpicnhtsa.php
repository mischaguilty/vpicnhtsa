<?php

namespace Mischaguilty\Vpicnhtsa;

class Vpicnhtsa
{
    private $vin;

    public function __construct()
    {
        $this->vin = '';
    }

    public function getVin(): string
    {
        return $this->vin;
    }
}
