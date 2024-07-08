<?php

namespace App\Services\Search\Providers;

use App\Services\Search\SearchResult;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class DDGSearchProvider implements SearchProviderInterface
{
    public function query(string $query): array
    {
        $body = Http::withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:126.0) Gecko/20100101 Firefox/126.0')
            ->get('https://html.duckduckgo.com/html/search?q=' . urlencode($query))
            ->body();

        return $this->toResult($body);
    }

    /**
     * @return SearchResult[]
     */
    public function toResult(string $page): array
    {
        $crawler = new Crawler($page);
        $resultList = [];

        $results = $crawler->filter('div.result');

        $results->each(function (Crawler $node) use (&$resultList) {
            $title = $node->filter('h2 > a')->first();

            // Mind the case where there is no description
            if (($description = $node->filter('.result__snippet'))->count() === 0) {
                return;
            }

            $resultList[] = new SearchResult(
                title: $title->innerText(),
                description: $description->html(),
                url: $title->attr('href') ?? '',
                provider: 'ddg'
            );
        });

        return $resultList;
    }
}
