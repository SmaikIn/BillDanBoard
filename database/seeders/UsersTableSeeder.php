<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 2000) as $index) {
            DB::table('users')->insert([
                'uuid' => $faker->uuid,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'second_name' => $faker->lastName,
                'phone' => $faker->phoneNumber,
                'avatar' => 'avatar.svg',
                'yandex_id' => $faker->numberBetween(1000, 9999),
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
