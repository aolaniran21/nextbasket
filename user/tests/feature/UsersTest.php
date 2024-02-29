<?php

namespace Tests\Feature;

use CodeIgniter\Test\ControllerTester;
use CodeIgniter\Test\FeatureTestTrait;

class UserTest
{
    // use ControllerTester;
    use FeatureTestTrait;

    public function testCreateUser()
    {
        // Sample user information
        $userInfo = [
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe'
        ];

        // Send POST request with JSON body
        $result = $this->withBodyFormat('json')
            ->post('users', $userInfo);


        // Assert response status code
        $result->assertStatus(200); // Assuming success status code

        // Assert response JSON structure or content as needed
        // $result->assertJSON(['status' => 'success']);
        $result->assertJSONExact(['message' => 'User created successfully']);
    }
}
