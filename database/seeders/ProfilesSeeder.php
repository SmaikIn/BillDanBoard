<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $faker = Faker::create();

        foreach ($users as $user) {
            $companies = $user->companies;
            foreach ($companies as $company) {
                Profile::create([
                    'uuid' => $faker->uuid,
                    'first_name' => $user->firstName,
                    'last_name' => $user->lastName,
                    'second_name' => $user->second_name,
                    'phone' => $user->phone,
                    'avatar' => $user->avatar,
                    'birthday' => $user->birthday,
                    'email' => $user->email,
                    'position' => $faker->jobTitle,
                    'description' => $faker->sentence,
                    'company_id' => $company->uuid,
                    'department_id' => $company->roles()->inRandomOrder()->first(),
                    'role_id' => $company->department()->inRandomOrder()->first(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

}
