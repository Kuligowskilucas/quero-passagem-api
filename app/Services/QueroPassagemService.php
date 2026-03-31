<?php

namespace App\Services;

use App\Exceptions\QueroPassagemException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class QueroPassagemService
{
    private string $baseUrl;
    private string $user;
    private string $pass;
    private string $affiliate;

    public function __construct()
    {
        $this->baseUrl = config('queropassagem.base_url');
        $this->user = config('queropassagem.user');
        $this->pass = config('queropassagem.pass');
        $this->affiliate = config('queropassagem.affiliate');
    }

    private function client()
    {
        return Http::withBasicAuth($this->user, $this->pass)
            ->withoutVerifying()
            ->baseUrl($this->baseUrl)
            ->acceptJson()
            ->timeout(30);
    }

    public function getAllStops(): array
{
    return Cache::remember('all_stops', 3600, function () {
        $response = $this->client()->get('/stops');

        if ($response->failed()) {
            throw QueroPassagemException::failedToFetchStops();
        }

        return $response->json();
    });
}

    public function getStops(): array
    {
        return Cache::remember('stops_sp_pr', 3600, function () {
            $response = $this->client()->get('/stops');

            if ($response->failed()) {
                throw QueroPassagemException::failedToFetchStops();
            }

            $stops = $response->json();
            $allowedStates = ['SP', 'PR'];

            return array_values(array_filter($stops, function ($stop) use ($allowedStates) {
                $name = $stop['name'] ?? '';
                foreach ($allowedStates as $state) {
                    if (str_contains($name, ", {$state} -") || str_ends_with($name, ", {$state}")) {
                        return true;
                    }
                }
                return false;
            }));
        });
    }

    public function searchTravels(string $from, string $to, string $date): array
    {
        $response = $this->client()->post('/new/search', [
            'from' => $from,
            'to' => $to,
            'travelDate' => $date,
            'affiliateCode' => $this->affiliate,
        ]);

        if ($response->failed()) {
            throw QueroPassagemException::failedToSearchTravels();
        }

        return $response->json();
    }

    public function getSeats(string $travelId): array
    {
        $response = $this->client()->post('/new/seats', [
            'travelId' => $travelId,
            'orientation' => 'horizontal',
            'type' => 'matrix',
        ]);

        if ($response->failed()) {
            throw QueroPassagemException::failedToFetchSeats();
        }

        return $response->json();
    }

    public function getCompany(int $id): array
    {
        return Cache::remember("company_{$id}", 3600, function () use ($id) {
            $response = $this->client()->get("/companies/{$id}");

            if ($response->failed()) {
                throw QueroPassagemException::failedToFetchCompany();
            }

            return $response->json();
        });
    }
}