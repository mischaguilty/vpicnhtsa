<?php

namespace Mischa\Vpicnhtsa\Actions;

use Illuminate\Console\Command;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\Concerns\AsAction;

class SearchNumber
{
    use AsAction;

    public $commandSignature = 'search:number {number?}';
    public $commandDescription = 'Search by GOV NUMBER';

    public function handle(string $number = null)
    {
        $number = optional($number ?? null, function (string $number) {
            return $this->clearNumber($number);
        });
        return $this->search($number);
    }

    public function asCommand(Command $command)
    {
        $number = optional($command->hasArgument('number') ? $command->argument('number') : null, function (string $number) {
            return $number;
        });
        $command->info("Get results for number $number");
        $command->info($this->handle($number));
        $command->line('Done!');
    }

    public function asController(string $number): JsonResponse
    {
        return response()->json(json_decode($this->handle($number)));
    }

    public static function routes(Router $router)
    {
        $router->get('search/number/{number}', static::class)->name('search.number');
    }

    public function clearNumber(string $number)
    {
        $cyr = mb_str_split('ахествнмікор');
        $lat = mb_str_split('axectbhmikop');
        return strtoupper(str_replace($cyr, $lat, mb_strtolower($number)));
    }

    public function search(string $number)
    {
        $curl = curl_init('https://checkvin.com.ua/gov-number');
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_TCP_FASTOPEN => true,
            CURLOPT_TCP_NODELAY => true,
            CURLOPT_ENCODING => '',
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36',
            CURLOPT_REFERER => 'https://checkvin.com.ua/',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "{\"govNumber\":\"".$number."\"}",

            CURLOPT_HTTPHEADER => [
                'authority: checkvin.com.ua',
                'sec-ch-ua: "Google Chrome";v="89", "Chromium";v="89", ";Not A Brand";v="99"',
                'sec-ch-ua-mobile: ?0',
                'authorization: Bearer null',
                'checkvin: ',
                'content-type: application/json;charset=UTF-8',
                'accept: application/json, text/plain, */*',
                'origin: https://checkvin.com.ua',
                'sec-fetch-site: same-origin',
                'sec-fetch-mode: cors',
                'sec-fetch-dest: empty',
                'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,uk;q=0.6',
            ],
            CURLOPT_SSLVERSION => CURL_SSLVERSION_MAX_TLSv1_2,
        ]);

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);

        return optional($response ?? json_encode($info), function (string $response) {
            return $response;
        });
    }
}
