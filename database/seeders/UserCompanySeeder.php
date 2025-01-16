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
            $q = rand(1, 4);
            $i = 0;
            foreach (Company::inRandomOrder()->get() as $company) {
                $user->companies()->attach($company->uuid);
                $i++;
                if ($i == $q) {
                    break;
                }
            }
        }
    }
}
