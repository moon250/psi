<?php

namespace App\Services;

use App\Services\Search\Providers\DDGSearchProvider;
use App\Services\Search\Providers\SearchProviderInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;

class FetchService
{
    public static function agent(Pool $pool, string $name): PendingRequest
    {
        return $pool->as($name)
            ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36')
            ->withHeader('accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9')
            ->withHeader('cache-control', 'no-cache')
            ->withHeader('accept-language', 'fr,fr-FR;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6');
    }

    /**
     * Performs an HTTP GET request on given $query URL and returns the response body
     *
     * @return Response In reality it's a PromiseInterface but for PHPStan's sake it'll be a Response...
     */
    public static function fetch(Pool $pool, string $query, SearchProviderInterface $provider)
    {
        /**
         * Quick fix to bypass DDG anti-scraping restrictions.
         * Note : still the same, might work or not
         */
        if ($provider instanceof DDGSearchProvider) {
            self::agent($pool, $provider::name)
                ->asForm()
                ->post('https://html.duckduckgo.com/html/', ['q' => $query, 'b' => '']);
        }

        return self::agent($pool, $provider::name)
            ->get($provider->query($query));
    }
}
