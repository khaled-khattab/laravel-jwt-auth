<?php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * Test user registration
     */
    public function testUserRegister(){
        $response = $this->json('POST', 'api/user/register', ['name' => 'Khaled', 'email'=> 'khaled1@gmail.com', 'password'=> '123456']);
        $response->assertStatus(201);
    }

    public function testUserLogin(){
        $response = $this->json('POST', 'api/user/login', ['email'=> 'khaled1@gmail.com', 'password'=> '123456']);
        $response->assertStatus(200);
    }

    public function testUserMe(){
        $response = $this->json('POST', 'api/user/login', ['email'=> 'khaled1@gmail.com', 'password'=> '123456'], ['Authorization'=> 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjExLCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjMwMDAvYXBpL3VzZXIvbG9naW4iLCJpYXQiOjE1NDU5OTE0NTIsImV4cCI6MTU0NTk5NTA1MiwibmJmIjoxNTQ1OTkxNDUyLCJqdGkiOiJWaVljZzJnWnIwUDJvUjRRIn0.PWmKqWRUeyKKfBPVjCZysbZiBUYt3glA3uBjKnRTjN0']);
        $response->assertStatus(200);
    }
}
