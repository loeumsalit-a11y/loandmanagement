<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default users for each role
        \App\Models\User::factory()->create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Loan Officer',
            'email' => 'officer@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            'role' => 'loan_officer',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Cashier User',
            'email' => 'cashier@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            'role' => 'cashier',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            'role' => 'customer',
        ]);

        $this->call(CustomerSeeder::class);
    }
}
