<?php

namespace App\Http\Controllers;

use App\Services\QueroPassagemService;
use Exception;

class CompanyController extends Controller
{
    public function show(int $id, QueroPassagemService $service)
    {
        try {
            $company = $service->getCompany($id);
            return response()->json($company);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }
}