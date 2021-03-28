<?php

namespace Mischa\Vpicnhtsa\Actions;

use Illuminate\Console\Command;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\Concerns\AsAction;

class SearchVin
{
    use AsAction;

    public function handle(string $vin): string
    {
        return $this->search($vin);
    }

    public function search(string $vin): string
    {
        return collect([
            json_decode($this->searchVpic($vin)),
            json_decode($this->searchExist($vin)),
        ])->toJson();
    }

    public function searchVpic($vin)
    {
        $url = "https://vpic.nhtsa.dot.gov/api/vehicles/decodevinvaluesextended/$vin?format=json&model_year=";
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => '',
            CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:87.0) Gecko/20100101 Firefox/87.0',
            CURLOPT_REFERER => 'https://vpic.nhtsa.dot.gov/api/',
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2,
        ]);
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        return is_string($response) ? $this->parseVpicResponse(trim($response)) : $info;
    }

    public function parseExistResponse($response)
    {
        return optional(json_decode($response, true), function (array $data) {
            return optional($data['result'] ?? null, function (array $vin) {
                return optional($vin['vin'] ?? null, function (array $vinInfo) {
                    return collect($vinInfo)->toJson();
                });
            });
        });
    }

    public function searchExist($vin)
    {
        $url = "https://exist.ua/api/v1/fulltext/search/?query=$vin&short=true";
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => '',
            CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:87.0) Gecko/20100101 Firefox/87.0',
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2,
        ]);
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        return is_string($response) ? $this->parseExistResponse($response) : $info;
    }



    public function parseVpicResponse($response)
    {
        return optional(json_decode($response, true), function (array $data) {
            return optional($data['Results'] ?? null, function (array $results) {
                return collect($results)->map(function (array $result) {
                    return collect($result)->filter(function ($value) {
                        return !empty($value) && $value !== 'Not Applicable';
                    })->toArray();
                })->toJson();
            });
        });
    }

    public $commandSignature = 'search:vin {vin}';
    public $commandDescription = 'Search by VIN';

    public function asCommand(Command $command)
    {
        $vin = $command->argument('vin');
        $command->info("Get results for vin $vin");
        $command->info($this->handle($vin));
        $command->line('Done!');
    }

    public function asController(string $vin): JsonResponse
    {
        return response()->json(json_decode($this->handle($vin)));
    }

    public static function routes(Router $router)
    {
        $router->get('search/vin/{vin}', static::class)->name('search.vin');
    }
}
