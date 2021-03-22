<?php


namespace Mischa\Vpicnhtsa\Console;


use Illuminate\Console\Command;

class SearchVinCommand extends Command
{
    protected $signature = 'search:vin {vin?}';

    protected $description = 'Search vin info';

    protected $vin;

    public function __construct(string $vin)
    {
        parent::__construct();
        $this->vin = $vin;
    }

    public function handle()
    {
        optional($this->vin, function ($vin) {
            dd($vin);
        });
    }
}
