<?php

namespace Tests\Feature\Controllers\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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
}