<?php

namespace App\Http\Controllers;

use App\Services\Search\SearchService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController
{
    public function index(Request $request, SearchService $service): View|RedirectResponse
    {
        $query = $request->get('q');

        $response = $service->search($query);

        if (is_array($response)) {
            return view('search', [
                'query' => $query,
                'results' => $response,
            ]);
        }

        // The answer is not the result of the providers. It is necessarily a redirection from a bang
        return $response;
    }
}
