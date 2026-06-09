<?php

namespace App\Adapters;

use App\Contracts\GeoProviderInterface;
use App\Exceptions\GeoServiceException;
use Illuminate\Support\Facades\Http;

class IpApiGeoProvider implements GeoProviderInterface
{
    public function getGeoData(string $ip): array
    {
        $baseUrl = config('geo.url');
        $response = Http::timeout(3)
            ->get("{$baseUrl}/{$ip}");

        if (!$response->successful()) {
            throw new GeoServiceException('Geo service unavailable');
        }

        $data = $response->json();

        return [
            'country' => $data['country'] ?? null,
            'city' => $data['city'] ?? null,
        ];
    }
}
