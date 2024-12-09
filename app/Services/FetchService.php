<?php

namespace App\Services;

use App\Services\Search\Providers\SearchProviderInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;

class FetchService
{
    /**
     * Performs an HTTP GET request on given $query URL and returns the response body
     *
     * @return Response In reality it's a PromiseInterface but for PHPStan's sake it'll be a Response...
     */
    public static function fetch(Pool $pool, string $query, SearchProviderInterface $provider)
    {
        return $pool->as($provider::name)
            ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0')
            ->withHeader('accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8')
            ->withHeader('cache-control', 'no-cache')
            ->get($provider->query($query));
    }
}
