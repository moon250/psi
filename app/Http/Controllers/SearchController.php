<?php

namespace App\Http\Controllers;

use App\Services\RedirectlistService;
use App\Services\Search\SearchService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class SearchController
{
    public function index(Request $request, SearchService $service, RedirectlistService $redirectlistService): View|RedirectResponse
    {
        $query = $request->get('q');

        if ($redirectlistService->exists($query)) {
            return new RedirectResponse("https://$query");
        }

        $response = $service->search($query);

        if ($response instanceof Collection) {
            return view('search', [
                'query' => $query,
                'results' => $response,
            ]);
        }

        // The answer is not the result of the providers. It is necessarily a redirection from a bang
        return $response;
    }
}
