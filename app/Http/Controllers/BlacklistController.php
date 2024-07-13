<?php

namespace App\Http\Controllers;

use App\Services\BlacklistService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlacklistController extends Controller
{
    public function store(Request $request, BlacklistService $service): Response
    {
        $website = $request->json('website');

        $service->add($website);

        return response()->noContent();
    }

    public function remove(Request $request, BlacklistService $service): Response
    {
        $website = $request->json('website');

        $service->remove($website);

        return response()->noContent();
    }
}
