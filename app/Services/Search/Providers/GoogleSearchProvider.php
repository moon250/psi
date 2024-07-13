<?php

namespace App\Services\Search\Providers;

use App\Services\BlacklistService;
use App\Services\FetchService;
use App\Services\Search\SearchResult;
use Symfony\Component\DomCrawler\Crawler;

class GoogleSearchProvider implements SearchProviderInterface
{
    public function __construct(
        private readonly BlacklistService $blacklistService
    ) {}

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
            /** @var string $host */
            $host = parse_url($link, PHP_URL_HOST);

            if (!$this->blacklistService->exists($host)) {
                $resultList[] = new SearchResult(
                    title: $title->innerText(),
                    description: $description->html(),
                    url: $link,
                    provider: 'google',
                    website: $host
                );
            }
        });

        return $resultList;
    }
}
