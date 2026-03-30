<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchTravelRequest;
use App\Http\Requests\GetSeatsRequest;
use App\Services\QueroPassagemService;
use Exception;

class TravelController extends Controller
{
    public function search(SearchTravelRequest $request, QueroPassagemService $service)
    {
        try {
            $travels = $service->searchTravels(
                $request->input('from'),
                $request->input('to'),
                $request->input('travelDate')
            );

            if (isset($travels['errors'])) {
                return response()->json($travels, 400);
            }

            usort($travels, function ($a, $b) {
                return strcmp($a['departure']['time'] ?? '', $b['departure']['time'] ?? '');
            });

            return response()->json($travels);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function seats(GetSeatsRequest $request, QueroPassagemService $service)
    {
        try {
            $seats = $service->getSeats($request->input('travelId'));

            if (isset($seats['errors'])) {
                return response()->json($seats, 400);
            }

            return response()->json($seats);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }
}