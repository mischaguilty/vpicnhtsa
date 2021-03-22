<?php


namespace Mischaguilty\Vpicnhtsa\Console;


use Illuminate\Console\Command;

class SearchVinCommand extends Command
{
    protected $signature = 'search:vin {vin?}';

    protected $description = 'Search vin info';

    public function handle()
    {
        $this->info('Search by VIN selected');
        optional($this->argument('vin'), function (string $vin) {
            $this->info(implode(' => ', [
                'You entered',
                $vin,
            ]));

            dd($vin);
        });
    }
}
