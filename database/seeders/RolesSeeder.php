<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $companies = Company::all();

        foreach ($companies as $company) {
            for ($i = 0; $i < 10; $i++) { // Создаем 10 ролей для каждой компании
                Role::create([
                    'uuid' => $faker->uuid,
                    'company_id' => $company->uuid,
                    'name' => $faker->unique()->jobTitle // Генерируем уникальное название роли
                ]);
            }
        }
    }
}
