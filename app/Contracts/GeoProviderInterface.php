<?php

namespace App\Contracts;

interface GeoProviderInterface
{
    public function getGeoData(string $ip): array;
}
