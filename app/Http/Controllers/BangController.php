<?php

namespace App\Http\Controllers;

use App\Services\Search\BangService;
use Illuminate\Http\Response;

class BangController extends Controller
{
    public function index(BangService $service): Response
    {
        return response($service->getBangs());
    }
}
