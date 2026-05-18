<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            ['name' => 'APG', 'slug' => 'apg'],
            ['name' => 'BPR', 'slug' => 'bpr'],
            ['name' => 'DWP', 'slug' => 'dwp'],
            ['name' => 'CARAKA', 'slug' => 'caraka'],
            ['name' => 'PRADA', 'slug' => 'prada'],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}