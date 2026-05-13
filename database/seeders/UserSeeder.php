<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersData = [
            [
                'email' => 'admin@test.com',
                'name' => 'Admin',
                'password' => 'password',
                'role' => RoleEnum::ADMIN->value
            ],
            [
                'email' => 'user@test.com',
                'name' => 'User',
                'password' => 'password',
                'role' => RoleEnum::USER->value
            ]
        ];

        foreach ($usersData as $userData) {
            $user = User::updateOrCreate(
                [
                    'email' => $userData['email'],
                ],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                ]
            );
            $user->assignRole($userData['role']);
        }
    }
}
