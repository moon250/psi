<?php

use App\Http\Controllers\BlacklistController;
use Illuminate\Support\Facades\Route;

Route::post('/blacklist', [BlacklistController::class, 'store']);
Route::delete('/blacklist', [BlacklistController::class, 'remove']);
