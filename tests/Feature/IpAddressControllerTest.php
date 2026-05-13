<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\IpAddress;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IpAddressControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesSeeder::class);
    }
    private function admin()
    {
        $user = User::factory()->create();
        $user->assignRole(RoleEnum::ADMIN->value);

        return $user;
    }

    private function user()
    {
        return User::factory()->create();
    }

    public function test_admin_can_create_ip(): void
    {
        $user = $this->admin();

        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson('/api/ips', [
            'ip' => '8.8.8.8',
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'ip',
                    'country',
                    'city',
                ]
            ]);

        $this->assertDatabaseHas('ip_addresses', [
            'ip' => '8.8.8.8',
        ]);
    }

    public function test_user_can_view_ips(): void
    {
        $user = $this->user();

        Sanctum::actingAs($user, ['*']);

        IpAddress::factory()->count(3)->create();

        $response = $this->getJson('/api/ips');

        $response->assertOk();

        $response->assertJsonCount(3, 'data');
    }

    public function test_export_returns_file(): void
    {
        $user = $this->admin();

        Sanctum::actingAs($user, ['*']);

        $response = $this->get('/api/ips-export');

        $response->assertOk();

        $response->assertHeader(
            'content-type',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
    }
}
