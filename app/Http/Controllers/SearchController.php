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
            $results = $response;

            return view('search', compact('query', 'results'));
        }

        return $response;
    }
}
