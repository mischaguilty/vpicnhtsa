<?php


namespace Mischa\Vpicnhtsa\Console;


use Illuminate\Console\Command;

class SearchVinCommand extends Command
{
    protected $signature = 'search:vin {vin?}';

    protected $description = 'Search vin info';

    protected $vin;

    public function handle()
    {
        dd("!!!");
    }
}
