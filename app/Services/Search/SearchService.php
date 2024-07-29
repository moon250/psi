<?php

namespace App\Services\Search;

use App\Services\FetchService;
use App\Services\Search\Providers\DDGSearchProvider;
use App\Services\Search\Providers\GoogleSearchProvider;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SearchService
{
    /**
     * @var string[]
     */
    private array $providers = [
        'google' => GoogleSearchProvider::class,
        'ddg' => DDGSearchProvider::class,
    ];

    public function __construct(
        private readonly BangService $bangService
    ) {}

    /**
     * @return Collection<int, Collection<int, SearchResult>> | RedirectResponse
     */
    public function search(string $query): Collection|RedirectResponse
    {
        if ($bang = $this->bangService->hasBang($query)) {
            return $this->bangService->fireBang($query, $bang);
        }

        $responses = Http::pool(function (Pool $pool) use ($query) {
            return collect($this->providers)
                ->map(fn ($provider) => FetchService::fetch($pool, $query, app($provider)));
        });

        /** @var Collection<int, Collection<int, SearchResult>> $results */
        $results = collect($responses)
            ->map(fn ($response, $provider) => app($this->providers[$provider])->toResult($response->body()))
            ->flatten()
            ->split(2);

        return $results;
    }
}
