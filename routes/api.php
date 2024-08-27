<?php

use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\RedirectlistController;
use Illuminate\Support\Facades\Route;

Route::post('/blacklist', [BlacklistController::class, 'store']);
Route::delete('/blacklist', [BlacklistController::class, 'remove']);

Route::get('/redirectlist', [RedirectlistController::class, 'index']);
Route::post('/redirectlist', [RedirectlistController::class, 'store']);
Route::delete('/redirectlist', [RedirectlistController::class, 'remove']);
