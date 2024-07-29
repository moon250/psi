<?php

namespace App\Services\Search\Providers;

use App\Services\BlacklistService;
use App\Services\Search\SearchResult;
use Symfony\Component\DomCrawler\Crawler;

class DDGSearchProvider implements SearchProviderInterface
{
    public function __construct(
        private readonly BlacklistService $blacklistService
    ) {}

    const string name = 'ddg';

    public function query(string $query): string
    {
        return 'https://html.duckduckgo.com/html/search?q=' . urlencode($query);
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

            $link = $title->attr('href') ?? '';
            /** @var string $host */
            $host = parse_url($link, PHP_URL_HOST);

            if (!$this->blacklistService->exists($host)) {
                $resultList[] = new SearchResult(
                    title: $title->innerText(),
                    description: $description->html(),
                    url: $link,
                    provider: 'ddg',
                    website: $host
                );
            }
        });

        return $resultList;
    }
}
