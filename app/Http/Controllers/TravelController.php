<?php

namespace App\Http\Controllers;

use App\Services\QueroPassagemService;
use Illuminate\Http\Request;
use Exception;

class TravelController extends Controller
{
    public function search(Request $request, QueroPassagemService $service)
    {
        $request->validate([
            'from' => 'required|string',
            'to' => 'required|string',
            'travelDate' => 'required|date_format:Y-m-d',
        ]);

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

    public function seats(Request $request, QueroPassagemService $service)
    {
        $request->validate([
            'travelId' => 'required|string',
        ]);

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