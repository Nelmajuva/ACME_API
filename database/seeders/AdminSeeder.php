<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::Create([
            'email' => env('ADMIN_EMAIL'),
            'names' => 'Admin',
            'surnames' => 'ACME',
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);
    }
}
