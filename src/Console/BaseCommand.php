<?php


namespace Mischa\Vpicnhtsa\Console;


use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BaseCommand extends Command
{
    public $vpicCommand = null;
    public $baseUrl = 'https://vpic.nhtsa.dot.gov/api/vehicles';

    public $defaultFormat = 'json';

    public function prepareFormat($format = null): string
    {
        return $this->getFormatParameter($format ?? $this->defaultFormat);
    }

    protected function getFormatParameter(string $format): string
    {
        return implode('=', [
            'format',
            $format,
        ]);
    }

    protected function prepareParameters(array $parameters): string
    {
        return collect($parameters)->map(function ($item, $key) {
            return implode('=', [
                Str::slug($key),
                Str::slug($item),
            ]);
        })->add($this->prepareFormat())->implode('&');
    }

    public function buildUrl(string $item = null): string
    {
        return implode('/', [
            $this->baseUrl,
            implode('?', [
                $this->vpicCommand.'/'.$item,
                $this->prepareParameters([

                ]),
            ]),
        ]);
    }

    public function search(string $item = null)
    {
        return $this->getResponse($this->buildUrl($item));
    }

    public function getResponse(string $url): string
    {
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
        return is_string($response) ? trim($response) : $info;
    }
}
