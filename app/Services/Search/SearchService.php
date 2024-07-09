<?php

namespace App\Services\Search;

use App\Services\Search\Providers\DDGSearchProvider;
use App\Services\Search\Providers\GoogleSearchProvider;
use Illuminate\Http\RedirectResponse;

class SearchService
{
    /**
     * @var string[]
     */
    private array $providers = [
        GoogleSearchProvider::class,
        DDGSearchProvider::class,
    ];

    public function __construct(
        private readonly BangService $bangService
    ) {}

    /**
     * @return array<int, SearchResult[]> | RedirectResponse
     */
    public function search(string $query): array|RedirectResponse
    {
        $results = [];

        if ($bang = $this->bangService->hasBang($query)) {
            return $this->bangService->fireBang($query, $bang);
        }

        foreach ($this->providers as $provider) {
            $provider = app($provider);

            $results = array_merge($results, $provider->query($query));
        }

        return $this->splitArray($results);
    }

    /**
     * @param  mixed[]  $array
     * @return mixed[]
     */
    private function splitArray(array $array): array
    {
        $length = count($array);
        /** @var positive-int $half */
        $half = ceil($length / 2);

        return array_chunk($array, $half);
    }
}
