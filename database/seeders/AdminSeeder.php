<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@store.com'],
            [
                'name'     => 'Store Admin',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'customer@store.com'],
            [
                'name'     => 'Test Customer',
                'password' => Hash::make('customer123'),
                'is_admin' => false,
            ]
        );
    }
}
