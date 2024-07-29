<?php

use App\Http\Controllers\SearchController;
use App\Http\Middleware\EnsureSearchIsNotEmpty;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/search', [SearchController::class, 'index'])
    ->middleware(EnsureSearchIsNotEmpty::class);
