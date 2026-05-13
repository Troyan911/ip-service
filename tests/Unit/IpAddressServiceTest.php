<?php

namespace Tests\Unit;

use App\Services\IpAddressService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IpAddressServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_ip_address()
    {
        $service = new IpAddressService();

        $ip = $service->create('1.1.1.1', [
            'country' => 'US',
            'city' => 'LA',
        ]);

        $this->assertEquals('1.1.1.1', $ip->ip);
        $this->assertEquals('US', $ip->country);
        $this->assertEquals('LA', $ip->city);

        $this->assertDatabaseHas('ip_addresses', [
            'ip' => '1.1.1.1',
        ]);
    }
}
