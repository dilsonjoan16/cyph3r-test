<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@localhost',
                'role' => Role::ADMINISTRATOR
            ],
            [
                'name' => 'User',
                'email' => 'user@localhost',
                'role' => Role::USER
            ]
        ];

        foreach ($users as $user) {
            $userCreated = User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
            ]);

            $userCreated->roles()->attach($user['role']->value);
        }
    }
}
