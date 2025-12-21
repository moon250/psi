<?php

namespace App\Services\Search\Providers;

use App\Services\BlacklistService;
use App\Services\Search\SearchResult;
use Symfony\Component\DomCrawler\Crawler;

class BraveSearchProvider implements SearchProviderInterface
{
    public function __construct(
        private readonly BlacklistService $blacklistService
    ) {}

    const string name = 'brave';

    public function query(string $query): string
    {
        return 'https://search.brave.com/search?q=' . urlencode($query);
    }

    /**
     * @return SearchResult[]
     */
    public function toResult(string $page): array
    {
        $crawler = new Crawler($page);
        $resultList = [];

        $results = $crawler->filter('div.snippet:not(.standalone)');

        $results->each(function (Crawler $node) use (&$resultList) {
            $title = $node->filter('.title')->first();

            // Mind the case where there is no description
            if (($description = $node->filter('.content'))->count() !== 1 || $description->text() === '') {
                return;
            }

            $link = $node->filter('a')->first()->attr('href') ?? '';

            /** @var string $host */
            $host = parse_url($link, PHP_URL_HOST);

            if (!$this->blacklistService->exists($host)) {
                $resultList[] = new SearchResult(
                    title: $title->text(),
                    description: $description->text(),
                    url: $link,
                    provider: self::name,
                    website: $host
                );
            }
        });

        return $resultList;
    }
}
