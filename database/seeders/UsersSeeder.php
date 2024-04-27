<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Gabriel Monteiro',
            'email' => 'gabriel@faeterj.com',
            'password' => Hash::make("password")
        ]);

        User::factory()->create([
            'name' => 'Bruno Williams',
            'email' => 'bruno@faeterj.com',
            'password' => Hash::make("password")
        ]);
    }
}
