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
        $users = [
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

        foreach ($users as $user) {
            $user = User::updateOrCreate(
                [
                    'email' => $user['email'],
                ],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                ]
            );
            $user->assignRole($user['role']);
        }
    }
}
