<?php

namespace App\Services\Search\Providers;

use App\Services\Search\SearchResult;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class GoogleSearchProvider implements ProviderInterface
{
    public function query(string $query): array
    {
        $body = Http::withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:126.0) Gecko/20100101 Firefox/126.0')
            ->get('https://www.google.com/search?q=' . urlencode($query))
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

        $results = $crawler->filter('div.g');

        $results->each(function (Crawler $node) use (&$resultList) {
            $title = $node->filter('h3')->first();

            if (($description = $node->filter('.VwiC3b'))->count() === 0) {
                return;
            }

            $link = $node->filter('a')->attr('href') ?? '';
            $cite = $node->filter('cite');

            $resultList[] = new SearchResult(
                title: $title->innerText(),
                description: $description->html(),
                url: $link,
                path: $cite->text()
            );
        });

        return $resultList;
    }
}
