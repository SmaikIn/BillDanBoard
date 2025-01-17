<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DepartmentsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $companies = Company::all();

        foreach ($companies as $company) {
            for ($i = 0; $i < rand(1, 10); $i++) { // Создаем 5 отделов для каждой компании
                Department::create([
                    'company_uuid' => $company->uuid,
                    'name' => $faker->unique()->word // Генерируем уникальное название отдела
                ]);
            }
        }
    }
}
