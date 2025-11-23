<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'username' => 'Admin BPS',
            'email' => 'bps3376@bps.co.id',
            'password' => Hash::make('bps@3376'),
            'role' => 'super_admin',
            'status' => 'approved',
        ]);
    }
}
