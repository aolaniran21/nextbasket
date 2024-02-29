<?php

namespace Tests\Controllers;

use App\Controllers\Users;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTester;
use CodeIgniter\HTTP\IncomingRequest;


class UsersTest extends CIUnitTestCase
{
    use ControllerTester;

    public function setUp(): void
    {
        parent::setUp();
        // Load the controller you want to test
        $this->controller(Users::class);
    }

    public function testIndex()
    {
        // Mock the request data
        $data = [
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe'
        ];

        // Set up the request
        // $request = new IncomingRequest(new \Config\App(), new \CodeIgniter\HTTP\URI('localhost:9000/users'), null, new \CodeIgniter\HTTP\UserAgent());
        // $request->setJSON($data);

        // Call the controller method with the request
        $this->withBody(json_encode($data))
            ->controller(\App\Controllers\Users::class)
            ->execute('index')
            ->assertJSONExact(['message' => 'User created successfully'])
            ->assertResponseStatus(201);

        // Assert that the data submission is handled
        $this->assertFileExists(WRITEPATH . 'logs/data_submission.log');
        // You can add more assertions as needed
    }

    public function testIndexValidationError()
    {
        // Mock the request data with missing fields to trigger validation error
        $data = [
            'email' => 'test@example.com'
            // 'firstName' => 'John',
            // 'lastName' => 'Doe'
        ];

        // Set up the request with invalid data to trigger validation error
        $this->withBody(json_encode($data))
            ->controller(\App\Controllers\Users::class)
            ->execute('index')
            ->assertJSONExact([
                "error" => 400,
                "messages" => [
                    "error" => "Email, firstName, and lastName are required."
                ],
                "status" => 400
            ]);

        // Assert that the data submission is not handled due to validation error
        $this->assertFileExists(WRITEPATH . 'logs/data_submission.log');
        // You can add more assertions as needed
    }
}
