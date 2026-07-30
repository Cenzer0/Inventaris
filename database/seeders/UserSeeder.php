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
        // 1. Superadmin User
        User::create([
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        // 2. Admin Gudang (Operator) User
        User::create([
            'name' => 'Admin Gudang',
            'username' => 'admin_gudang',
            'password' => Hash::make('password'),
            'role' => 'admin_gudang',
        ]);

        // 3. Pimpinan User
        User::create([
            'name' => 'Pimpinan',
            'username' => 'pimpinan',
            'password' => Hash::make('password'),
            'role' => 'pimpinan',
        ]);
    }
}
