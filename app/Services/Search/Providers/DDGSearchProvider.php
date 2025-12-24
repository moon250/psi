<?php

namespace App\Services\Search\Providers;

use App\Services\BlacklistService;
use App\Services\Search\SearchResult;
use Symfony\Component\DomCrawler\Crawler;
use Uri\Rfc3986\Uri;

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
            // Remove ddg proxy thing (allows for easier favicon retrieving)
            $link = str_replace('//duckduckgo.com/l/?uddg=', '', $link);
            $link = new Uri($link);

            /** @var string $host */
            $host = $link->getHost();

            if ($this->blacklistService->exists($host)) {
                return;
            }

            $resultList[] = new SearchResult(
                title: $title->innerText(),
                description: $description->html(),
                url: $link->toString(),
                provider: 'ddg',
                website: $host
            );
        });

        return $resultList;
    }
}
