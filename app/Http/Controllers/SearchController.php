<?php

namespace App\Http\Controllers;

use App\Services\Search\SearchService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController
{
    public function index(Request $request, SearchService $service): View
    {
        $query = $request->get('q');

        $results = $service->search($query);

        return view('search', compact('query', 'results'));
    }
}
