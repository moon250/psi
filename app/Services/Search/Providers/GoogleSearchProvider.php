<?php

namespace App\Services\Search\Providers;

use App\Services\FetchService;
use App\Services\Search\SearchResult;
use Symfony\Component\DomCrawler\Crawler;

class GoogleSearchProvider implements SearchProviderInterface
{
    public function query(string $query): array
    {
        return $this->toResult(
            FetchService::fetch('https://www.google.com/search?q=' . urlencode($query))
        );
    }

    /**
     * @return SearchResult[]
     */
    public function toResult(string $page): array
    {
        $crawler = new Crawler($page);
        $resultList = [];

        $results = $crawler->filter('div.g');

        $results->each(function (Crawler $node) use (&$resultList) {
            $title = $node->filter('h3')->first();

            // Used for the case where there is no description
            // Mostly happens when the result is a youtube video
            if (($description = $node->filter('.VwiC3b'))->count() === 0) {
                return;
            }

            $link = $node->filter('a')->attr('href') ?? '';

            $resultList[] = new SearchResult(
                title: $title->innerText(),
                description: $description->html(),
                url: $link,
                provider: 'google'
            );
        });

        return $resultList;
    }
}
