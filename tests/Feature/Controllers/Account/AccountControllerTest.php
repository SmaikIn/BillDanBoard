<?php

namespace Tests\Feature\Controllers\Account;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Str;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testStoreWithAvatar()
    {
        $file = new UploadedFile(
            base_path('public/vector-users-icon.jpg'),
            'vector-users-icon.jpg',
            'image/jpeg',
            null,
            true
        );

        $data = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'avatar' => $file
        ];

        $headers = [
            'Accept' => 'application/json',
        ];

        $response = $this->withHeaders($headers)->post(route('register'), $data);

        User::where('uuid', $response->getOriginalContent()['data']['id'])->firstOrFail();

        $response->assertStatus(200);
    }

    public function testStoreWithoutAvatar()
    {
        \DB::select('SHOW TABLES');
        $data = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.example@example.com',
            'password' => 'password123',
        ];

        $headers = [
            'Accept' => 'application/json',
        ];

        $response = $this->withHeaders($headers)->post(route('register'), $data);

        User::where('uuid', $response->getOriginalContent()['data']['id'])->firstOrFail();

        $response->assertStatus(200);
    }

    public function testStoreValidation()
    {
        $data = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'invalid-email',
            'password' => 'password123',
        ];

        $headers = [
            'Accept' => 'application/json',
        ];

        $response = $this->withHeaders($headers)->post(route('register'), $data);

        $response->assertStatus(422);
    }

    public function testUpdateWithAvatar()
    {
        $faker = Faker::create();;
        // Создаем пользователя для тестирования
        $user = User::factory()->create([
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

        // Аутентифицируем пользователя
        $this->actingAs($user);

        // Создаем файл для загрузки
        $file = new UploadedFile(
            base_path('public/vector-users-icon.jpg'),
            'vector-users-icon.jpg',
            'image/jpeg',
            null,
            true
        );

        // Данные для обновления
        $data = [
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
        ];

        // Заголовки запроса
        $headers = [
            'Accept' => 'application/json',
        ];

        // Отправляем запрос на обновление
        $response = $this->withHeaders($headers)->put(route('update.account', $user->uuid), $data);

        $response->assertStatus(200);
    }

}