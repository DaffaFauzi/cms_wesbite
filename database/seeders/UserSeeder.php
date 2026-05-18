<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@cms.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'company_id' => null,
        ]);

        $apg = Company::where('slug', 'apg')->first();

        User::create([
            'name' => 'Admin APG',
            'email' => 'admin@apg.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'company_id' => $apg?->id,
        ]);
    }
}