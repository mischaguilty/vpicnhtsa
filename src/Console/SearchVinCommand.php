<?php


namespace Mischa\Vpicnhtsa\Console;


use Illuminate\Support\Str;

class SearchVinCommand extends BaseCommand
{
    protected $signature = 'search:vin {vin}';
    protected $description = 'Search vin info';

    public function __construct($command = 'decodevinvaluesextended')
    {
        parent::__construct();
        $this->vpicCommand = $command;
    }

    public function handle()
    {
        return optional($this->hasArgument('vin') ? $this->argument('vin'): null, function (string $vin) {
            return $this->info($this->search($vin));
        });
    }

    protected function sanitizeVin(string $vin): string
    {
        return optional($vin, function (string $vin) {
            return Str::replaceArray('OIО', [
                'O' => '0',
                'I' => '1',
                'О' => '0',
            ], Str::upper($vin));
        });
    }
}
