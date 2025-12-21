<?php

namespace App\Services\Search;

use App\Services\FetchService;
use App\Services\Search\Providers\BraveSearchProvider;
use App\Services\Search\Providers\DDGSearchProvider;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SearchService
{
    /**
     * @var string[]
     */
    private array $providers = [
        // 'google' => GoogleSearchProvider::class, // Remove Google provider as it doesn't work anymore (since january 2025)
        'ddg' => DDGSearchProvider::class,
        'brave' => BraveSearchProvider::class,
    ];

    public function __construct(
        private readonly BangService $bangService
    ) {}

    /**
     * @return Collection<int, Collection<int, SearchResult>> | Collection<int, array{}> | RedirectResponse
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
            ->whereInstanceOf(Response::class)
            ->map(fn ($response, $provider) => app($this->providers[$provider])->toResult($response->body()))
            ->flatten()
            ->split(2);

        if ($results->isEmpty()) {
            $results = collect([[], []]);
        }

        return $results;
    }
}
