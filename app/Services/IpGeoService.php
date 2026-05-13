<?php

namespace App\Services;

use App\Exceptions\GeoServiceException;
use Illuminate\Support\Facades\Http;

class IpGeoService
{
    public function getGeoData(string $ip): array
    {
        $response = Http::timeout(3)->get(getenv('GEO_SERVICE_URL') . "/json/{$ip}");

        if (! $response->successful()) {
            throw new GeoServiceException("Geo service unavailable");
        }

        $data = $response->json();

        if (($data['status'] ?? null) !== 'success') {
            throw new GeoServiceException("Invalid geo response");
        }

        return $data;
    }
}
