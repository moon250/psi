<?php

namespace App\Services\Search\Providers;

use App\Services\Search\SearchResult;

interface SearchProviderInterface
{
    const string name = '';

    /**
     * Returns the url querying the query on the provider
     */
    public function query(string $query): string;

    /**
     * @return SearchResult[]
     */
    public function toResult(string $page): array;
}
