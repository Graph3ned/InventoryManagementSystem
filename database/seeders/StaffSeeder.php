<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Staff',
            'email' => 'staff@tindahan.ph',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Jane Staff',
            'email' => 'jane@tindahan.ph',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'status' => 'active',
        ]);
    }
}
