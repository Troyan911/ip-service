<?php

namespace App\Services;

use App\Models\IpAddress;

class IpAddressService
{
    public function create(string $ip, array $geo): IpAddress
    {
        return IpAddress::create([
            'ip' => $ip,
            'country' => $geo['country'] ?? null,
            'city' => $geo['city'] ?? null,
        ]);
    }

    public function update(IpAddress $ipAddress, array $data): IpAddress
    {
        $ipAddress->update($data);

        return $ipAddress->refresh();
    }

    public function delete(IpAddress $ipAddress): void
    {
        $ipAddress->delete();
    }
}
