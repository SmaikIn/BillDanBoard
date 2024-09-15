<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CompaniesTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            Company::create([
                'uuid' => $faker->unique()->uuid,
                'name' => $faker->company,
                'inn' => $faker->numerify('##########'), // Генерация случайного ИНН
                'kpp' => $faker->optional()->numerify('#########'), // Генерация случайного КПП или null
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->e164PhoneNumber,
                'website' => $faker->optional()->domainName,
                'description' => $faker->text,
            ]);
        }
    }
}
