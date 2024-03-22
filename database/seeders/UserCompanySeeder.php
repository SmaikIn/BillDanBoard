<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserCompanySeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $company = Company::inRandomOrder()->first();
            $user->companies()->attach($company->uuid);
        }
    }
}
