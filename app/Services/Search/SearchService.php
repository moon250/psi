<?php

namespace App\Services\Search;

use App\Services\Search\Providers\GoogleSearchProvider;

class SearchService
{
    /**
     * @var string[]
     */
    private array $providers = [
        GoogleSearchProvider::class,
    ];

    /**
     * @return array<int, SearchResult[]>
     */
    public function search(string $query): array
    {
        $results = [];

        foreach ($this->providers as $provider) {
            $provider = app($provider);

            $results[] = $provider->query($query);
        }

        return $results;
    }
}
