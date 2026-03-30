<?php

namespace App\Http\Controllers;

use App\Services\QueroPassagemService;
use Exception;

class StopController extends Controller
{
    public function index(QueroPassagemService $service)
    {
        try {
            $stops = $service->getStops();
            return response()->json($stops);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }
}