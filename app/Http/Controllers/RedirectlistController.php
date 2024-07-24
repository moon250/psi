<?php

namespace App\Http\Controllers;

use App\Services\RedirectlistService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RedirectlistController extends Controller
{
    public function __construct(private readonly RedirectlistService $service) {}

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
