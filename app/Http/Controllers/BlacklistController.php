<?php

namespace App\Http\Controllers;

use App\Services\BlacklistService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlacklistController extends Controller
{
    public function __construct(private readonly BlacklistService $service) {}

    public function index(): Response
    {
        return response($this->service->get());
    }

    public function store(Request $request): Response
    {
        $website = $request->json('website');

        $this->service->add($website);

        return response()->noContent();
    }

    public function remove(Request $request): Response
    {
        $website = $request->json('website');

        $this->service->remove($website);

        return response()->noContent();
    }
}
