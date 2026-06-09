<?php

namespace App\Services;

use App\Contracts\GeoProviderInterface;

class IpManagementService
{
    public function __construct(
        private readonly GeoProviderInterface $geoProvider,
        private readonly IpAddressService     $ipAddressService,
    )
    {
    }

    public function create(string $ip)
    {
        $geo = $this->geoProvider->getGeoData($ip);

        return $this->ipAddressService->create($ip, $geo);
    }
}
