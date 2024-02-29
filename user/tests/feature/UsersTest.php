<?php

namespace Tests\Feature;

use CodeIgniter\Test\ControllerTester;
use CodeIgniter\Test\FeatureTestCase;

class UserTest extends FeatureTestCase
{
    use ControllerTester;

    public function testCreateUser()
    {
        // Sample user information
        $userInfo = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            // Add more fields as needed
        ];

        // Send POST request with JSON body
        $result = $this->withBodyFormat('json')
            ->post('users', $userInfo);

        // Assert response status code
        $result->assertStatus(200); // Assuming success status code

        // Assert response JSON structure or content as needed
        // $result->assertJSON(['status' => 'success']);
    }
}
