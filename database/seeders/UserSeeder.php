<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'tier' => 'Tier 3',
            'role' => 'Administrator',
            'start_work' => '2020-01-01',
            'birthday' => '1985-05-15',
            'status' => 'Active',
        ]);

        \App\Models\User::create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
            'tier' => 'Tier 2',
            'role' => 'Management',
            'start_work' => '2021-03-15',
            'birthday' => '1990-08-20',
            'status' => 'Active',
        ]);

        \App\Models\User::create([
            'name' => 'Admin Officer',
            'email' => 'officer@example.com',
            'password' => bcrypt('password'),
            'tier' => 'Tier 1',
            'role' => 'Admin Officer',
            'start_work' => '2022-06-01',
            'birthday' => '1992-12-10',
            'status' => 'Active',
        ]);

        \App\Models\User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'tier' => 'New Born',
            'role' => 'User',
            'start_work' => '2023-01-15',
            'birthday' => '1995-03-25',
            'status' => 'Active',
        ]);

        \App\Models\User::create([
            'name' => 'Client User',
            'email' => 'client@example.com',
            'password' => bcrypt('password'),
            'tier' => 'New Born',
            'role' => 'Client',
            'start_work' => null,
            'birthday' => '1988-11-30',
            'status' => 'Active',
        ]);
    }
}
