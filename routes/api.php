<?php

use App\Http\Controllers\StopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TravelController;

Route::get('/stops', [StopController::class, 'index']);
Route::post('/travels/search', [TravelController::class, 'search']);
Route::post('/travels/seats', [TravelController::class, 'seats']);
