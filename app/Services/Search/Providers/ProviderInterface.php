<?php

namespace App\Services\Search\Providers;

use App\Services\Search\SearchResult;

interface ProviderInterface
{
    /**
     * Perform a search on the searching provider
     *
     * @return SearchResult[]
     */
    public function query(string $query): array;
}
