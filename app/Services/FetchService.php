<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FetchService
{
    /**
     * Performs an HTTP GET request on given $query URL and returns the response body
     */
    public static function fetch(string $query): string
    {
        return Http::withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:127.0) Gecko/20100101 Firefox/127.0')
            ->withHeader('accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8')
            ->withHeader('cache-control', 'no-cache')
            ->get($query)
            ->body();
    }
}
