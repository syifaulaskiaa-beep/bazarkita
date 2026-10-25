<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin BazarKita',
            'email' => 'admin@bazarkita.test',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
    }
}