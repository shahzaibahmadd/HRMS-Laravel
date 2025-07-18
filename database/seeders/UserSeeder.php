<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // You can add as many users as you want
        User::create([
            'name' => 'Admin1 User',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'), // Always hash passwords
        ]);

        User::create([
            'name' => 'Test1 User',
            'email' => 'test1@example.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
