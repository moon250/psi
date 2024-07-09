<?php

namespace App\Services\Search\Providers;

use App\Services\FetchService;
use App\Services\Search\SearchResult;
use Symfony\Component\DomCrawler\Crawler;

class DDGSearchProvider implements SearchProviderInterface
{
    public function query(string $query): array
    {
        return $this->toResult(
            FetchService::fetch('https://html.duckduckgo.com/html/search?q=' . urlencode($query))
        );
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
