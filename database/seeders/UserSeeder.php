<?php

namespace Database\Seeders;

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
        User::query()->create([
            'name' => 'User',
            'email' => 'user@elryad.com',
            'phone' => '00201012409123',
            'password' => 'elryad1256!#',
        ]);
    }
}
